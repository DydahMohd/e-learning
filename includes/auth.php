<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../api/config.php';
require_once __DIR__ . '/../api/Database.php';

function eac_current_user(): ?array {
    static $loaded = false;
    static $user = null;
    if ($loaded) return $user;
    $loaded = true;

    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!is_string($header) || $header === '') return null;

    $payload = verifyToken($header);
    if (!$payload || empty($payload['userId'])) return null;

    try {
        $stmt = Database::connect()->prepare(
            'SELECT id,email,fullName,firstName,middleName,surname,sex,role,organization,sector,country,jobTitle,profilePicture,bio
             FROM users WHERE id = ? LIMIT 1'
        );
        $stmt->execute([(int)$payload['userId']]);
        $user = $stmt->fetch() ?: null;
    } catch (Throwable $e) {
        error_log('Auth lookup failed: ' . $e->getMessage());
        $user = null;
    }
    return $user;
}

function eac_require_login(): array {
    $user = eac_current_user();
    if (!$user) {
        header('Location: /login.php');
        exit;
    }
    return $user;
}

function eac_require_admin(): array {
    $user = eac_require_login();
    if (($user['role'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Forbidden');
    }
    return $user;
}

function eac_is_logged_in(): bool {
    return eac_current_user() !== null;
}
