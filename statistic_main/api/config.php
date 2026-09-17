<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config/app.php';

/*
 * EAC Statistics e-Learning Platform
 * MariaDB Database Configuration
 */


/* =========================================================
   APPLICATION
========================================================= */

define('APP_ENV', getenv('APP_ENV') ?: 'development');

$jwtSecret = getenv('JWT_SECRET') ?: '';
if (APP_ENV === 'production' && strlen($jwtSecret) < 32) {
    http_response_code(500);
    exit('Server configuration error.');
}
if ($jwtSecret === '') {
    $jwtSecret = hash('sha256', __FILE__ . php_uname());
}
define('JWT_SECRET', $jwtSecret);

// Demo credentials must be enabled deliberately, even in development.
define('DEMO_ACCOUNTS_ENABLED', APP_ENV !== 'production' && filter_var(getenv('DEMO_ACCOUNTS_ENABLED') ?: '0', FILTER_VALIDATE_BOOLEAN));
define('APP_ORIGIN', getenv('APP_ORIGIN') ?: 'http://localhost:8081');

define(
    'FORUM_NOTIFY_EMAIL',
    getenv('FORUM_NOTIFY_EMAIL') ?: ''
);

define(
    'BREVO_API_KEY',
    getenv('BREVO_API_KEY') ?: ''
);

define(
    'BREVO_SENDER_EMAIL',
    getenv('BREVO_SENDER_EMAIL') ?: ''
);

define(
    'BREVO_SENDER_NAME',
    getenv('BREVO_SENDER_NAME') ?: 'EAC Statistics e-Learning'
);


/* =========================================================
   MARIADB DATABASE CONFIGURATION
========================================================= */

define(
    'DB_HOST',
    getenv('DB_HOST') ?: '127.0.0.1'
);

define(
    'DB_PORT',
    getenv('DB_PORT') ?: '3306'
);

define(
    'DB_NAME',
    getenv('DB_NAME') ?: 'eac_academy'
);

define(
    'DB_USER',
    getenv('DB_USER') ?: 'root'
);

define(
    'DB_PASSWORD',
    getenv('DB_PASSWORD') ?: ''
);


/* =========================================================
   CORS
========================================================= */

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin !== '' && hash_equals(APP_ORIGIN, $origin)) {
    header('Access-Control-Allow-Origin: ' . APP_ORIGIN);
    header('Access-Control-Allow-Credentials: true');
}
header('Vary: Origin');

header(
    'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'
);

header(
    'Access-Control-Allow-Headers: Content-Type, Authorization'
);

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

header(
    'Content-Type: application/json; charset=utf-8'
);


/* =========================================================
   CORS PREFLIGHT
========================================================= */

if (
    isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER['REQUEST_METHOD'] === 'OPTIONS'
) {
    http_response_code(204);
    exit;
}


/* =========================================================
   JSON RESPONSE
========================================================= */

function jsonResponse(
    mixed $data,
    int $code = 200
): never {

    http_response_code($code);
    

    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit;
}


/* =========================================================
   JSON ERROR RESPONSE
========================================================= */

function jsonError(
    string $message,
    int $code = 400
): never {

    jsonResponse(
        [
            'success' => false,
            'error'   => $message
        ],
        $code
    );
}


/* =========================================================
   READ JSON REQUEST BODY
========================================================= */

function getJsonBody(): array
{
    $raw = file_get_contents(
        'php://input'
    );

    if (!$raw) {
        return [];
    }

    $data = json_decode(
        $raw,
        true
    );

    return is_array($data)
        ? $data
        : [];
}


/* =========================================================
   AUTHENTICATION SESSIONS
========================================================= */

/*
 * Sessions are intentionally NOT time-limited.
 * A session remains valid until:
 *   1. the user explicitly signs out,
 *   2. the session is revoked, or
 *   3. the account is deleted by the 31-day inactivity policy.
 *
 * The database session row makes manual logout enforceable server-side.
 */

function createToken(
    int $userId,
    string $email,
    string $role
): string {
    $jti = bin2hex(random_bytes(24));

    $payload = base64urlEncode(json_encode([
        'userId' => $userId,
        'email'  => $email,
        'role'   => $role,
        'iat'    => time(),
        'jti'    => $jti,
    ], JSON_UNESCAPED_SLASHES));

    $signature = hash_hmac('sha256', $payload, JWT_SECRET);
    $token = $payload . '.' . $signature;

    // The database table is the server-side source of truth for session validity.
    $stmt = db()->prepare(
        'INSERT INTO user_sessions (userId, tokenHash, createdAt, lastActivityAt)
         VALUES (?, ?, NOW(), NOW())'
    );
    $stmt->execute([$userId, hash('sha256', $token)]);

    return $token;
}

function base64urlEncode(string $value): string
{
    return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
}

function base64urlDecode(string $value): string|false
{
    return base64_decode(
        strtr($value, '-_', '+/') . str_repeat('=', (4 - strlen($value) % 4) % 4),
        true
    );
}

function verifyToken(?string $authHeader): ?array
{
    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        return null;
    }

    $token = substr($authHeader, 7);
    $parts = explode('.', $token, 2);

    if (count($parts) !== 2) {
        return null;
    }

    [$payload, $signature] = $parts;
    $expectedSignature = hash_hmac('sha256', $payload, JWT_SECRET);

    if (!hash_equals($expectedSignature, $signature)) {
        return null;
    }

    $decoded = base64urlDecode($payload);
    if ($decoded === false) {
        return null;
    }

    $data = json_decode($decoded, true);
    if (!is_array($data) || empty($data['userId']) || empty($data['jti'])) {
        return null;
    }

    // No JWT expiry check by design. Manual logout/revocation is authoritative.
    try {
        $stmt = db()->prepare(
            'SELECT s.id, s.userId, s.createdAt, s.lastActivityAt, s.revokedAt,
                    u.email, u.role
             FROM user_sessions s
             INNER JOIN users u ON u.id = s.userId
             WHERE s.tokenHash = ? AND s.revokedAt IS NULL
             LIMIT 1'
        );
        $stmt->execute([hash('sha256', $token)]);
        $session = $stmt->fetch();

        if (!$session) {
            return null;
        }

        // Any authenticated use counts as account activity and keeps the account alive.
        $update = db()->prepare(
            'UPDATE user_sessions SET lastActivityAt = NOW() WHERE id = ?'
        );
        $update->execute([(int)$session['id']]);

        $lastLogin = db()->prepare(
            'UPDATE users SET lastLoginAt = NOW() WHERE id = ?'
        );
        $lastLogin->execute([(int)$session['userId']]);

        $data['userId'] = (int)$session['userId'];
        $data['email'] = $session['email'];
        $data['role'] = $session['role'];

        return $data;
    } catch (Throwable $e) {
        error_log('Session verification failed: ' . $e->getMessage());
        return null;
    }
}

function revokeCurrentSession(): void
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!is_string($header) || !str_starts_with($header, 'Bearer ')) {
        return;
    }

    $token = substr($header, 7);

    try {
        $stmt = db()->prepare(
            'UPDATE user_sessions SET revokedAt = NOW()
             WHERE tokenHash = ? AND revokedAt IS NULL'
        );
        $stmt->execute([hash('sha256', $token)]);
    } catch (Throwable $e) {
        error_log('Session revocation failed: ' . $e->getMessage());
    }
}

function revokeAllUserSessions(int $userId): void
{
    $stmt = db()->prepare(
        'UPDATE user_sessions SET revokedAt = NOW()
         WHERE userId = ? AND revokedAt IS NULL'
    );
    $stmt->execute([$userId]);
}

/* =========================================================
   REQUIRE AUTHENTICATED USER
========================================================= */

function requireAuth(): array
{
    $user = verifyToken(
        $_SERVER['HTTP_AUTHORIZATION'] ?? null
    );

    if (!$user) {
        jsonError(
            'Unauthorized',
            401
        );
    }

    return $user;
}


/* =========================================================
   REQUIRE ADMIN
========================================================= */

function requireAdmin(): array
{
    $auth = requireAuth();

    if (
        !isset($auth['role']) || $auth['role'] !== 'admin') {
        jsonError('Access denied. Admin privileges required.', 403);
    }

    // Re-read the role from the database so a stale JWT cannot retain
    // administrator access after the account has been demoted.
    $stmt = db()->prepare('SELECT id, email, role FROM users WHERE id=? LIMIT 1');
    $stmt->execute([(int)$auth['userId']]);
    $current = $stmt->fetch();
    if (!$current || $current['role'] !== 'admin') {
        jsonError('Access denied. Admin privileges required.', 403);
    }
    $auth['role'] = $current['role'];
    $auth['email'] = $current['email'];
    return $auth;
}
