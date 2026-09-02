<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/CertificatePdf.php';
// Legacy rollback source (disabled):
// $ASSESSMENT_BANK = require __DIR__ . '/assessment_bank.php';
// Final assessment questions now come exclusively from MariaDB.

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

// Remove any deployment prefix while matching only a real /api path segment.
// For example, /elearning/api/auth/me becomes /api/auth/me.
if (preg_match('#/api(?:/|$)#', $uri, $apiPathMatch, PREG_OFFSET_CAPTURE)) {
    $uri = substr($uri, (int)$apiPathMatch[0][1]);
}
$uri = rtrim($uri, '/') ?: '/';

function userId(): int { return (int)(requireAuth()['userId'] ?? 0); }
function courseById(int $id): ?array {
    $s = db()->prepare('SELECT id, slug, title, description, category, difficulty, duration, contentPath, icon, rating, studentCount, publicationStatus, createdAt FROM courses WHERE id = ? LIMIT 1');
    $s->execute([$id]);
    $r = $s->fetch();
    return $r ?: null;
}

function coursePublicationStatus(array $course): string {
    $status = strtolower(trim((string)($course['publicationStatus'] ?? $course['status'] ?? 'published')));
    return in_array($status, ['draft', 'published', 'archived'], true) ? $status : 'draft';
}

function requirePublishedCourse(array $course): void {
    if (coursePublicationStatus($course) !== 'published') {
        jsonError('This course is not currently available to learners.', 403);
    }
}


function courseContentSourcePath(int $courseId, string $contentPath): ?string {
    $root = realpath(__DIR__ . '/..');
    if (!$root) return null;

    // Built-in courses use the shared template for launch, while their
    // assessment/module markup lives in courses/data/*.php.
    $builtIn = [
        1 => 'courses/data/fns.php',
        2 => 'courses/data/fsi.php',
        3 => 'courses/data/gfs.php',
        4 => 'courses/data/psds.php',
        5 => 'courses/data/mfs.php',
        6 => 'courses/data/poverty.php',
        7 => 'courses/data/ess.php',
    ];
    $candidate = $builtIn[$courseId] ?? $contentPath;
    if (!isset($builtIn[$courseId]) && preg_match('#^courses/([a-z0-9-]+)\.php$#', str_replace('\\', '/', $contentPath), $match)) {
        $managedDataPath = 'courses/data/' . $match[1] . '.php';
        if (is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $managedDataPath))) {
            $candidate = $managedDataPath;
        }
    }
    $file = realpath($root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $candidate));
    if (!$file || !str_starts_with($file, $root . DIRECTORY_SEPARATOR) || !is_readable($file)) {
        return null;
    }
    return $file;
}

function courseAssessment(int $courseId): array {
    $course = courseById($courseId);
    if (!$course || empty($course['contentPath'])) return ['modules' => 0, 'questions' => []];
    $file = courseContentSourcePath($courseId, (string)$course['contentPath']);
    if (!$file) return ['modules' => 0, 'questions' => []];
    $html = file_get_contents($file);
    preg_match_all('/data-mid="([^"]+)"/i', $html ?: '', $moduleMatches);
    $moduleIds = array_values(array_unique($moduleMatches[1] ?? []));
    $databaseAssessment = databaseAssessment($courseId, 'final');
    return array_merge(['modules' => count($moduleIds), 'moduleIds' => $moduleIds], $databaseAssessment);
}

function databaseAssessment(int $courseId, string $type = 'final'): array {
    try {
        $settings = ['questionsPerAttempt' => 20, 'passMark' => 80, 'minutes' => 20, 'intro' => ''];
        $s = db()->prepare('SELECT questionsPerAttempt,passMark,minutes,intro FROM assessment_settings WHERE courseId=? LIMIT 1');
        $s->execute([$courseId]);
        $settings = array_merge($settings, $s->fetch() ?: []);
        $q = db()->prepare('SELECT id,moduleId,quizKey,title,questionText,explanation,sortOrder FROM assessment_questions WHERE courseId=? AND questionType=? AND isActive=1 ORDER BY sortOrder,id');
        $q->execute([$courseId, $type]);
        $rows = $q->fetchAll();
        if (!$rows) return ['questions'=>[], 'ask'=>(int)$settings['questionsPerAttempt'], 'passMark'=>(float)$settings['passMark'], 'minutes'=>(int)$settings['minutes'], 'intro'=>(string)$settings['intro']];
        $ids = array_column($rows, 'id');
        $marks = implode(',', array_fill(0, count($ids), '?'));
        $o = db()->prepare("SELECT id,questionId,optionText,isCorrect,sortOrder FROM assessment_options WHERE questionId IN ($marks) ORDER BY sortOrder,id");
        $o->execute($ids);
        $options = [];
        foreach ($o->fetchAll() as $option) $options[(int)$option['questionId']][] = ['id'=>(int)$option['id'],'text'=>$option['optionText'],'correct'=>(bool)$option['isCorrect']];
        $questions = [];
        foreach ($rows as $row) $questions[] = ['id'=>(int)$row['id'],'moduleId'=>$row['moduleId'],'quizKey'=>$row['quizKey'],'title'=>$row['title'],'q'=>$row['questionText'],'explain'=>$row['explanation'] ?? '','options'=>$options[(int)$row['id']] ?? []];
        return ['questions'=>$questions,'ask'=>min(count($questions),max(1,(int)$settings['questionsPerAttempt'])),'passMark'=>max(0,min(100,(float)$settings['passMark'])),'minutes'=>max(1,(int)$settings['minutes']),'intro'=>(string)$settings['intro']];
    } catch (PDOException $e) {
        // Keep upgraded code usable until the new migration has been installed.
        if (in_array((int)($e->errorInfo[1] ?? 0), [1146], true)) return ['questions'=>[]];
        throw $e;
    }
}

function validateAssessmentQuestion(array $data): array {
    $type = (string)($data['questionType'] ?? 'module_quiz');
    if (!in_array($type, ['module_quiz','final'], true)) jsonError('Invalid question type.');
    $text = trim((string)($data['questionText'] ?? ''));
    $options = is_array($data['options'] ?? null) ? array_values($data['options']) : [];
    if ($text === '') jsonError('Question text is required.');
    if (count($options) < 2 || count($options) > 10) jsonError('A question requires between 2 and 10 options.');
    $clean = []; $correct = 0;
    foreach ($options as $index => $option) {
        if (!is_array($option) || trim((string)($option['text'] ?? '')) === '') jsonError('Every option requires text.');
        $isCorrect = !empty($option['correct']); if ($isCorrect) $correct++;
        $clean[] = ['text'=>trim((string)$option['text']), 'correct'=>$isCorrect, 'sortOrder'=>$index];
    }
    if ($correct !== 1) jsonError('Select exactly one correct answer.');
    return ['questionType'=>$type,'moduleId'=>trim((string)($data['moduleId']??'')) ?: null,'quizKey'=>trim((string)($data['quizKey']??'')) ?: null,'title'=>trim((string)($data['title']??'')) ?: null,'questionText'=>$text,'explanation'=>trim((string)($data['explanation']??'')) ?: null,'sortOrder'=>(int)($data['sortOrder']??0),'isActive'=>array_key_exists('isActive',$data)?(int)(bool)$data['isActive']:1,'options'=>$clean];
}

function courseModuleOverview(int $courseId): array {
    $course = courseById($courseId);
    if (!$course) return [];
    $assessment = courseAssessment($courseId);
    $file = courseContentSourcePath($courseId, (string)($course['contentPath'] ?? ''));
    $html = $file ? (string)file_get_contents($file) : '';
    $titles = [];

    if ($html !== '' && preg_match_all('/<div\b(?=[^>]*class="[^"]*\bmod-bar\b[^"]*")(?=[^>]*data-mid="([^"]+)")[^>]*>.*?<h3[^>]*>(.*?)<\/h3>/is', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $id = trim((string)($match[1] ?? ''));
            $title = trim((string)preg_replace('/\s+/', ' ', strip_tags(html_entity_decode((string)($match[2] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'))));
            if ($id !== '' && $title !== '') $titles[$id] = $title;
        }
    }

    $modules = [];
    foreach (($assessment['moduleIds'] ?? []) as $index => $id) {
        $modules[] = [
            'id' => (string)$id,
            'title' => $titles[$id] ?? ('Module ' . ($index + 1)),
        ];
    }
    return $modules;
}

function certificateDownloadRecord(int $certificateId, ?int $ownerId = null): ?array {
    $sql = 'SELECT ce.id,ce.userId,ce.courseId,ce.certificateNumber,ce.issuedAt,u.fullName,c.title courseName
        FROM certificates ce
        JOIN users u ON u.id=ce.userId
        JOIN courses c ON c.id=ce.courseId
        WHERE ce.id=?';
    $params = [$certificateId];
    if ($ownerId !== null) {
        $sql .= ' AND ce.userId=?';
        $params[] = $ownerId;
    }
    $sql .= ' LIMIT 1';
    $statement = db()->prepare($sql);
    $statement->execute($params);
    $record = $statement->fetch();
    return $record ?: null;
}

function certificateDownloadFilename(array $certificate): string {
    $number = (string)($certificate['certificateNumber'] ?? 'certificate');
    $safe = preg_replace('/[^A-Za-z0-9._-]+/', '_', $number);
    $safe = trim((string)$safe, '._-');
    return 'EAC_Certificate_' . ($safe !== '' ? $safe : 'certificate') . '.pdf';
}

function certificateVerificationUrl(string $certificateNumber): string {
    $https = (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off')
        || (string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
    $scheme = $https ? 'https' : 'http';
    $host = trim((string)($_SERVER['HTTP_HOST'] ?? ''));
    $script = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? '/api/index.php'));
    $rootPath = rtrim(str_replace('\\', '/', dirname(dirname($script))), '/.');
    $relative = ($rootPath !== '' ? $rootPath : '') . '/verify-certificate.php?number=' . rawurlencode($certificateNumber);
    return $host !== '' ? $scheme . '://' . $host . $relative : $relative;
}

function outputCertificatePdf(array $certificate): void {
    $certificate['verificationUrl'] = certificateVerificationUrl((string)($certificate['certificateNumber'] ?? ''));
    $pdf = eac_build_certificate_pdf($certificate);
    header_remove('Content-Type');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . certificateDownloadFilename($certificate) . '"');
    header('Content-Length: ' . strlen($pdf));
    header('Cache-Control: private, no-store, max-age=0');
    header('Pragma: no-cache');
    header('X-Content-Type-Options: nosniff');
    echo $pdf;
    exit;
}

function completedModuleCount(int $userId, int $courseId, array $allowedIds = []): int {
    $s = db()->prepare('SELECT completedModules FROM course_progress WHERE userId=? AND courseId=? LIMIT 1');
    $s->execute([$userId, $courseId]);
    $state = $s->fetch();
    $completed = json_decode((string)($state['completedModules'] ?? '{}'), true);
    if (!is_array($completed)) return 0;
    if ($allowedIds) $completed = array_intersect_key($completed, array_flip($allowedIds));
    return count(array_filter($completed, static fn($v) => (bool)$v));
}
function createAssessmentToken(int $userId, int $courseId, array $questions, int $minutes): string {
    $ids=[];
    foreach($questions as $q){ $ids[]=hash('sha256',trim((string)($q['q']??$q['question']??''))); }
    $expiresAt=time()+(max(1,$minutes)*60);
    $payload=base64urlEncode(json_encode(['uid'=>$userId,'cid'=>$courseId,'exp'=>$expiresAt,'q'=>$ids,'jti'=>bin2hex(random_bytes(32))],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
    $token=$payload.'.'.hash_hmac('sha256',$payload,JWT_SECRET);
    $db=db();
    $db->prepare('DELETE FROM assessment_attempts WHERE userId=? AND courseId=? AND submittedAt IS NULL')->execute([$userId,$courseId]);
    $db->prepare('INSERT INTO assessment_attempts (userId,courseId,tokenHash,expiresAt) VALUES (?,?,?,?)')->execute([$userId,$courseId,hash('sha256',$token),date('Y-m-d H:i:s',$expiresAt)]);
    return $token;
}
function verifyAssessmentToken(string $token,int $userId,int $courseId): ?array {
    $parts=explode('.',$token,2); if(count($parts)!==2)return null;
    [$payload,$sig]=$parts; if(!hash_equals(hash_hmac('sha256',$payload,JWT_SECRET),$sig))return null;
    $decoded=base64urlDecode($payload); if($decoded===false)return null;
    $data=json_decode($decoded,true); if(!is_array($data))return null;
    if((int)($data['uid']??0)!==$userId || (int)($data['cid']??0)!==$courseId || (int)($data['exp']??0)<time() || !is_array($data['q']??null) || !preg_match('/^[a-f0-9]{64}$/',(string)($data['jti']??'')))return null;
    return $data;
}
function publicAssessmentQuestion(array $q): array {
    $options=[]; foreach(($q['options']??[]) as $o){ $options[]=['text'=>(string)($o['text']??'')]; }
    return ['q'=>(string)($q['q']??$q['question']??''),'explain'=>(string)($q['explain']??''),'options'=>$options];
}
function notifyForumByEmail(int $userId, int $courseId, string $text, ?int $parentId): void {
    $s = db()->prepare('SELECT u.fullName, u.email, c.title FROM users u JOIN courses c ON c.id = ? WHERE u.id = ? LIMIT 1');
    $s->execute([$courseId, $userId]);
    $info = $s->fetch();
    if (!$info || !filter_var(FORUM_NOTIFY_EMAIL, FILTER_VALIDATE_EMAIL) || BREVO_API_KEY === '' || !filter_var(BREVO_SENDER_EMAIL, FILTER_VALIDATE_EMAIL)) return;
    $kind = $parentId ? 'New forum reply' : 'New forum discussion';
    $subject = '[' . $kind . '] ' . $info['title'];
    $body = "A new forum contribution was posted on the EAC Statistics e-Learning platform.\n\n"
        . "Course: " . $info['title'] . "\n"
        . "Author: " . $info['fullName'] . " (" . $info['email'] . ")\n"
        . "Type: " . ($parentId ? 'Reply' : 'Discussion') . "\n\n"
        . $text . "\n";
    $payload = json_encode([
        'sender' => ['email' => BREVO_SENDER_EMAIL, 'name' => BREVO_SENDER_NAME],
        'to' => [['email' => FORUM_NOTIFY_EMAIL, 'name' => 'Forum moderator']],
        'replyTo' => ['email' => $info['email'], 'name' => $info['fullName']],
        'subject' => $subject,
        'htmlContent' => '<p>' . nl2br(htmlspecialchars($body, ENT_QUOTES, 'UTF-8')) . '</p>',
        'textContent' => $body,
        'tags' => ['forum-notification']
    ]);
    $ch = curl_init('https://api.brevo.com/v3/smtp/email');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ['accept: application/json', 'api-key: ' . BREVO_API_KEY, 'content-type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
    ]);
    $response = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($response === false || $status < 200 || $status >= 300) error_log('Brevo forum notification failed: HTTP ' . $status . ' ' . curl_error($ch));
    curl_close($ch);
}
function courseContentVersion(array $course): int {
    $root = realpath(__DIR__ . '/..');
    if (!$root) return 0;

    $contentPath = (string)($course['contentPath'] ?? '');
    $entry = realpath($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $contentPath));
    if (!$entry || !str_starts_with($entry, $root . DIRECTORY_SEPARATOR)) {
        $entry = false;
    }
    $source = courseContentSourcePath((int)($course['id'] ?? 0), $contentPath);
    $dataScript = $source
        ? dirname($source) . DIRECTORY_SEPARATOR . pathinfo($source, PATHINFO_FILENAME) . '.js'
        : false;
    $files = [
        $entry,
        $source,
        $dataScript,
        $root . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'course-template.php',
        $root . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'course.js',
    ];
    $version = 0;
    foreach ($files as $file) {
        if (is_string($file) && is_file($file)) {
            $version = max($version, (int)filemtime($file));
        }
    }
    return $version;
}
function passwordResetEmailConfigured(): bool {
    return function_exists('curl_init')
        && BREVO_API_KEY !== ''
        && filter_var(BREVO_SENDER_EMAIL, FILTER_VALIDATE_EMAIL);
}
function sendPasswordResetEmail(string $email, string $fullName, string $token): bool {
    if (!passwordResetEmailConfigured()) return false;

    $resetUrl = rtrim(APP_ORIGIN, '/') . '/reset-password.php?token=' . rawurlencode($token);
    $safeName = htmlspecialchars($fullName !== '' ? $fullName : 'Learner', ENT_QUOTES, 'UTF-8');
    $safeUrl = htmlspecialchars($resetUrl, ENT_QUOTES, 'UTF-8');
    $text = "A password-reset request was made for your EAC Statistics e-Learning account.\n\n"
        . "Open this link within 30 minutes to choose a new password:\n" . $resetUrl
        . "\n\nIf you did not request this, you can ignore this email.";
    $payload = json_encode([
        'sender' => ['email' => BREVO_SENDER_EMAIL, 'name' => BREVO_SENDER_NAME],
        'to' => [['email' => $email, 'name' => $fullName !== '' ? $fullName : 'Learner']],
        'subject' => 'Reset your EAC Statistics e-Learning password',
        'htmlContent' => '<p>Hello ' . $safeName . ',</p><p>A password-reset request was made for your EAC Statistics e-Learning account.</p><p><a href="' . $safeUrl . '">Choose a new password</a></p><p>This link expires in 30 minutes. If you did not request this, you can ignore this email.</p>',
        'textContent' => $text,
        'tags' => ['password-reset']
    ]);
    if ($payload === false) return false;

    try {
        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        if ($ch === false) return false;
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['accept: application/json', 'api-key: ' . BREVO_API_KEY, 'content-type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);
        $response = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($response === false || $status < 200 || $status >= 300) {
            error_log('Brevo password-reset email failed: HTTP ' . $status . ' ' . $error);
            return false;
        }
        return true;
    } catch (Throwable $e) {
        error_log('Brevo password-reset email failed: ' . $e->getMessage());
        return false;
    }
}
function normaliseCourse(array $c): array {
    $c['id'] = (int)$c['id'];
    $c['rating'] = $c['rating'] !== null ? (float)$c['rating'] : null;
    $c['studentCount'] = (int)($c['studentCount'] ?? 0);
    $c['status'] = coursePublicationStatus($c);
    unset($c['publicationStatus']);
    $c['contentVersion'] = courseContentVersion($c);
    return $c;
}
function courseSlugFromTitle(string $title): string {
    return strtolower(trim((string)preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));
}
function validateCourseSlug(string $slug): string {
    $slug = strtolower(trim($slug));
    if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
        jsonError('Course slug may contain only lowercase letters, numbers and hyphens.', 422);
    }
    return $slug;
}
function validateCourseContentPath(mixed $value): string {
    $path = strtolower(trim(str_replace('\\', '/', (string)$value)));
    $path = preg_replace('#^(?:\./|/)+#', '', $path) ?? $path;

    // Accept the common admin-entry formats, but always store the canonical
    // public course entry path (courses/<slug>.php).
    if (preg_match('#^[a-z0-9-]+\.php$#', $path)) {
        $path = 'courses/' . $path;
    } elseif (preg_match('#^courses/data/([a-z0-9-]+\.php)$#', $path, $matches)) {
        $path = 'courses/' . $matches[1];
    }

    // The Food and Nutrition source is fns.php, while its learner-facing
    // course entry is agriculture.php.
    $entryAliases = [
        'courses/fns.php' => 'courses/agriculture.php',
    ];
    $path = $entryAliases[$path] ?? $path;

    if (!preg_match('#^courses/[a-z0-9-]+\.php$#', $path)) {
        jsonError('Course content path must be like courses/fsi.php.', 422);
    }
    $root = realpath(__DIR__ . '/..');
    $courseDir = $root ? realpath($root . '/courses') : false;
    $file = $root ? realpath($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path)) : false;
    if (!$file || !$courseDir || !is_file($file) || !str_starts_with($file, $courseDir . DIRECTORY_SEPARATOR)) {
        jsonError('The selected course content file does not exist.', 422);
    }
    return $path;
}

function sanitiseManagedCourseContent(string $content): string {
    if (strlen($content) > 5 * 1024 * 1024) jsonError('Course content file must not exceed 5 MB.', 422);
    $content = preg_replace('/<\?(?:php|=)?[\s\S]*?\?>/i', '', $content) ?? '';
    $content = preg_replace('#<script\b[^>]*>[\s\S]*?</script>#i', '', $content) ?? '';
    $content = preg_replace('#<style\b[^>]*>[\s\S]*?</style>#i', '', $content) ?? '';
    if (preg_match('#<body\b[^>]*>([\s\S]*?)</body>#i', $content, $body)) $content = $body[1];
    $allowed = '<p><h2><h3><h4><h5><ul><ol><li><strong><b><em><i><blockquote><table><thead><tbody><tr><th><td><a><br><hr>';
    $content = strip_tags($content, $allowed);
    $content = preg_replace('/\s+on[a-z]+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $content) ?? $content;
    $content = preg_replace('/\s+(?:style|srcdoc)\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $content) ?? $content;
    $content = preg_replace('/\s+(href)\s*=\s*(["\'])\s*(?:javascript|data):[^"\']*\2/i', '', $content) ?? $content;
    $content = trim($content);
    if ($content === '') jsonError('The uploaded course content is empty.', 422);
    return $content;
}

function sanitiseStructuredCourseContent(string $content): ?string {
    if (!preg_match('/id=["\']screen-hub["\']/i', $content) || !preg_match('/id=["\']screen-module["\']/i', $content)) return null;
    $content = preg_replace('/<\?(?:php|=)?[\s\S]*?\?>/i', '', $content) ?? '';
    $content = preg_replace('#<script\b[^>]*>[\s\S]*?</script>#i', '', $content) ?? '';
    $content = preg_replace('#<style\b[^>]*>[\s\S]*?</style>#i', '', $content) ?? '';
    $content = preg_replace('#<(?:iframe|object|embed)\b[^>]*>[\s\S]*?</(?:iframe|object|embed)>#i', '', $content) ?? '';
    if (preg_match('#<body\b[^>]*>([\s\S]*?)</body>#i', $content, $body)) $content = $body[1];
    $firstSection = stripos($content, '<section');
    $lastSection = strripos($content, '</section>');
    if ($firstSection === false || $lastSection === false) return null;
    $content = substr($content, $firstSection, $lastSection + strlen('</section>') - $firstSection);
    $content = preg_replace('/\s+on[a-z]+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $content) ?? $content;
    $content = preg_replace('/\s+(?:style|srcdoc)\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $content) ?? $content;
    $content = preg_replace('/\s+(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '', $content) ?? $content;
    return trim($content) ?: null;
}

function createManagedCourseFiles(int $courseId, string $slug, string $title, array $modules): string {
    $root = realpath(__DIR__ . '/..');
    $coursesDir = $root ? realpath($root . '/courses') : false;
    $dataDir = $root ? realpath($root . '/courses/data') : false;
    if (!$root || !$coursesDir || !$dataDir || !is_writable($coursesDir) || !is_writable($dataDir)) {
        throw new RuntimeException('Course storage is not writable.');
    }
    $entryFile = $coursesDir . DIRECTORY_SEPARATOR . $slug . '.php';
    $dataFile = $dataDir . DIRECTORY_SEPARATOR . $slug . '.php';
    if (file_exists($entryFile) || file_exists($dataFile)) jsonError('A course content file already uses this slug.', 409);

    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $structuredContent = count($modules) === 1 && !empty($modules[0]['structured'])
        ? trim((string)($modules[0]['content'] ?? ''))
        : '';
    $bars = '';
    $decks = '';
    foreach ($modules as $index => $uploadedModule) {
        $number = $index + 1;
        $moduleId = 'm' . $number;
        $moduleTitle = htmlspecialchars((string)($uploadedModule['title'] ?? ('Module ' . $number)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $moduleContent = (string)($uploadedModule['content'] ?? '');
        $bars .= '<div class="mod-bar" data-mid="' . $moduleId . '" data-openmod="' . $moduleId . '"><div class="mod-num"><small>Module</small><b>' . $number . '</b></div><div class="mod-info"><h3>' . $moduleTitle . '</h3><p>Open this module and mark it as read when finished.</p></div><div class="mod-go"><span class="mod-status">Start →</span><span class="chev">›</span></div></div>';
        $decks .= '<div class="deck" data-mid="' . $moduleId . '" data-n="1" id="deck-' . $moduleId . '"><div class="slide active" data-i="0"><div class="slide-inner"><div class="slide-head"><div class="sn">' . $number . '</div><h3>' . $moduleTitle . '</h3></div>' . $moduleContent . '</div></div></div>';
    }
    $moduleCount = count($modules);
    $module = $structuredContent !== ''
        ? $structuredContent
        : '<section class="screen" id="screen-hub"><div class="hub-head"><div class="wrap"><div><h2>Course content</h2><p>' . $safeTitle . '</p></div><div class="hub-prog"><b><span id="hubDone">0</span>/<span id="hubTotal">' . $moduleCount . '</span></b><small>modules completed</small></div></div></div><div class="hub-body"><div class="wrap">' . $bars . '</div></div></section><section class="screen" id="screen-module"><div class="decks">' . $decks . '</div></section>';
    $entry = "<?php\ndeclare(strict_types=1);\n\$courseKey = " . var_export($slug, true) . ";\n\$courseDataKey = " . var_export($slug, true) . ";\n\$courseId = " . $courseId . ";\n\$courseTitle = " . var_export($title, true) . ";\nrequire __DIR__ . '/../includes/course-template.php';\n";
    if (file_put_contents($dataFile, $module, LOCK_EX) === false || file_put_contents($entryFile, $entry, LOCK_EX) === false) {
        if (is_file($dataFile)) unlink($dataFile);
        if (is_file($entryFile)) unlink($entryFile);
        throw new RuntimeException('Could not create the course content files.');
    }
    return 'courses/' . $slug . '.php';
}
function validateCoursePublicationStatus(mixed $value): string {
    $status = strtolower(trim((string)$value));
    if (!in_array($status, ['draft', 'published', 'archived'], true)) {
        jsonError('Course status must be Draft, Published, or Archived.', 422);
    }
    return $status;
}
function requireMethod(string $expected): void {
    global $method;
    if ($method !== $expected) jsonError("Method $method not allowed.", 405);
}
function audit(string $action, ?string $entityType = null, ?int $entityId = null, ?array $details = null): void {
    try {
        $auth = verifyToken(authorizationHeader());
        db()->prepare('INSERT INTO audit_logs (userId,action,entityType,entityId,details) VALUES (?,?,?,?,?)')
            ->execute([$auth['userId'] ?? null, $action, $entityType, $entityId, $details ? json_encode($details, JSON_UNESCAPED_UNICODE) : null]);
    } catch (Throwable $ignored) { /* audit logging must not break the primary action */ }
}

try {
    // Health / diagnostics
    if ($uri === '/api/health') {
        db()->query('SELECT 1');
        jsonResponse(['status'=>'ok','database'=>['status'=>'connected'],'timestamp'=>date('c')]);
    }

    // ---------- AUTH ----------
    if ($uri === '/api/auth/register') {
        requireMethod('POST');
        $d = getJsonBody();
        $name = trim((string)($d['fullName'] ?? ''));
        $firstName = trim((string)($d['firstName'] ?? ''));
        $middleName = trim((string)($d['middleName'] ?? ''));
        $surname = trim((string)($d['surname'] ?? ''));
        $sex = trim((string)($d['sex'] ?? ''));
        $email = strtolower(trim((string)($d['email'] ?? '')));
        $password = (string)($d['password'] ?? '');
        if (!DEMO_ACCOUNTS_ENABLED && in_array($email, ['demo@eac.org','admin@eac.org'], true)) jsonError('This development account is disabled.', 403);
        $org = trim((string)($d['organization'] ?? ''));
        $sector = trim((string)($d['sector'] ?? ''));
        $country = trim((string)($d['country'] ?? ''));
        $jobTitle = trim((string)($d['jobTitle'] ?? ''));
        if ($name === '' && $firstName !== '' && $surname !== '') $name = trim($firstName.' '.($middleName ? $middleName.' ' : '').$surname);
        if ($firstName === '' && $name !== '') { $parts=preg_split('/\s+/', $name); $firstName=(string)($parts[0]??''); $surname=(string)($parts[count($parts)-1]??''); }
        $detailedRegistration = $firstName !== '' || $middleName !== '' || $surname !== '' || $sex !== '' || $sector !== '' || $country !== '' || $jobTitle !== '';
        if (($detailedRegistration && ($firstName === '' || $surname === '' || $sex === '' || $org === '' || $sector === '' || $country === '')) || (!$detailedRegistration && ($name === '' || $org === '')) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            jsonError('First name, surname, sex, email, organisation, sector, country and a password of at least 8 characters are required.');
        }
        $db = db();
        $s = $db->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $s->execute([$email]);
        if ($s->fetch()) jsonError('An account with this email already exists.', 409);

        /*
         * Registration depends on the profile columns added by
         * upgrade_platform_features.sql. Make the failure explicit if
         * an old database was installed without that migration, instead
         * of returning a vague 500 after the user submits the form.
         */
        $requiredColumns = ['firstName','middleName','surname','sex','sector','country','jobTitle'];
        $existingColumns = [];
        $cols = $db->query("SHOW COLUMNS FROM users")->fetchAll();
        foreach ($cols as $col) $existingColumns[(string)$col['Field']] = true;
        $missing = array_values(array_filter($requiredColumns, fn($col) => !isset($existingColumns[$col])));
        if ($missing) {
            jsonError('The database is missing the registration profile fields. Run data\upgrade_platform_features.sql, then try again.', 500);
        }

        try {
            $db->beginTransaction();
            $s = $db->prepare('INSERT INTO users (email,password,fullName,firstName,middleName,surname,sex,role,organization,sector,country,jobTitle) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
            $s->execute([$email,password_hash($password,PASSWORD_DEFAULT),$name,$firstName,$middleName?:null,$surname,$sex,'student',$org,$sector,$country,$jobTitle?:null]);
            $id = (int)$db->lastInsertId();
            $db->prepare('INSERT INTO learning_streaks (userId) VALUES (?)')->execute([$id]);
            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            if ($e instanceof PDOException && (int)($e->errorInfo[1] ?? 0) === 1062) {
                jsonError('An account with this email already exists.', 409);
            }
            throw $e;
        }
        $user = ['id'=>$id,'fullName'=>$name,'firstName'=>$firstName,'middleName'=>$middleName?:null,'surname'=>$surname,'sex'=>$sex,'email'=>$email,'role'=>'student','organization'=>$org,'sector'=>$sector,'country'=>$country,'jobTitle'=>$jobTitle?:null];
        jsonResponse(['success'=>true,'user'=>$user,'token'=>createToken($id,$email,'student')], 201);
    }

    if ($uri === '/api/auth/login') {
        requireMethod('POST');
        $d = getJsonBody();
        $email = strtolower(trim((string)($d['email'] ?? '')));
        $password = (string)($d['password'] ?? '');
        if (!DEMO_ACCOUNTS_ENABLED && in_array($email, ['demo@eac.org','admin@eac.org'], true)) jsonError('This development account is disabled.', 403);
        if ($email === '' || $password === '') jsonError('Email and password are required.');
        $s = db()->prepare('SELECT id,email,password,fullName,role,organization FROM users WHERE email=? LIMIT 1');
        $s->execute([$email]);
        $r = $s->fetch();
        if (!$r || !password_verify($password,$r['password'])) jsonError('Invalid email or password.',401);
        $userId = (int)$r['id'];
        db()->prepare('UPDATE users SET lastLoginAt = NOW() WHERE id = ?')->execute([$userId]);
        $user = ['id'=>$userId,'fullName'=>$r['fullName'],'email'=>$r['email'],'role'=>$r['role'],'organization'=>$r['organization']];
        jsonResponse(['success'=>true,'user'=>$user,'token'=>createToken($userId,$r['email'],$r['role'])]);
    }

    if ($uri === '/api/auth/logout') {
        requireMethod('POST');
        revokeCurrentSession();
        jsonResponse(['success'=>true,'message'=>'Signed out successfully.']);
    }

    if ($uri === '/api/auth/forgot-password') {
        requireMethod('POST');
        if (!passwordResetEmailConfigured()) {
            jsonError('Password-reset email is not configured. Please contact the platform administrator.', 503);
        }
        $email = strtolower(trim((string)(getJsonBody()['email'] ?? '')));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $s = db()->prepare('SELECT id,email,fullName FROM users WHERE email=? LIMIT 1'); $s->execute([$email]);
            if ($u = $s->fetch()) {
                $token = bin2hex(random_bytes(32));
                $db = db();
                $db->beginTransaction();
                try {
                    $db->prepare('UPDATE password_resets SET usedAt=NOW() WHERE userId=? AND usedAt IS NULL')->execute([(int)$u['id']]);
                    $db->prepare('INSERT INTO password_resets (userId,tokenHash,expiresAt) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 30 MINUTE))')->execute([(int)$u['id'], hash('sha256',$token)]);
                    $db->commit();
                } catch (Throwable $e) {
                    if ($db->inTransaction()) $db->rollBack();
                    throw $e;
                }
                audit('password_reset_requested','user',(int)$u['id']);
                sendPasswordResetEmail((string)$u['email'], (string)($u['fullName'] ?? ''), $token);
            }
        }
        jsonResponse(['success'=>true,'message'=>'If that email exists, password reset instructions will be sent.']);
    }

    if ($uri === '/api/auth/reset-password') {
        requireMethod('POST'); $d=getJsonBody(); $token=(string)($d['token']??''); $password=(string)($d['password']??'');
        if (strlen($token)!==64 || strlen($password)<8) jsonError('A valid reset token and password of at least 8 characters are required.');
        $db = db();
        $db->beginTransaction();
        try {
            $s=$db->prepare('SELECT id,userId FROM password_resets WHERE tokenHash=? AND usedAt IS NULL AND expiresAt>NOW() LIMIT 1'); $s->execute([hash('sha256',$token)]); $r=$s->fetch();
            if (!$r) {
                $db->rollBack();
                jsonError('This reset link is invalid or has expired.', 400);
            }
            $used = $db->prepare('UPDATE password_resets SET usedAt=NOW() WHERE id=? AND usedAt IS NULL AND expiresAt>NOW()');
            $used->execute([(int)$r['id']]);
            if ($used->rowCount() !== 1) {
                $db->rollBack();
                jsonError('This reset link is invalid or has expired.', 400);
            }
            $db->prepare('UPDATE users SET password=? WHERE id=?')->execute([password_hash($password,PASSWORD_DEFAULT),(int)$r['userId']]);
            revokeAllUserSessions((int)$r['userId']);
            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            throw $e;
        }
        audit('password_reset_completed','user',(int)$r['userId']);
        jsonResponse(['success'=>true,'message'=>'Password updated successfully.']);
    }

    // ---------- COURSES ----------
    if ($uri === '/api/courses' && $method === 'GET') {
        $search=trim((string)($_GET['search']??'')); $category=trim((string)($_GET['category']??'')); $difficulty=trim((string)($_GET['difficulty']??''));
        $sql='SELECT id,slug,title,description,category,difficulty,duration,contentPath,icon,rating,studentCount,publicationStatus,createdAt FROM courses WHERE publicationStatus=\'published\''; $p=[];
        if($search!==''){ $sql.=' AND (title LIKE ? OR description LIKE ? OR category LIKE ?)'; $term='%'.$search.'%'; $p=[$term,$term,$term]; }
        if($category!==''){ $sql.=' AND category=?'; $p[]=$category; } if($difficulty!==''){ $sql.=' AND difficulty=?'; $p[]=$difficulty; }
        $sql.=" ORDER BY CASE slug WHEN 'fsi' THEN 1 WHEN 'mfs' THEN 2 WHEN 'gfs' THEN 3 WHEN 'psds' THEN 4 WHEN 'fns' THEN 5 WHEN 'poverty' THEN 6 WHEN 'ess' THEN 7 ELSE 99 END, title ASC"; $s=db()->prepare($sql); $s->execute($p); $rows=$s->fetchAll();
        jsonResponse(['success'=>true,'courses'=>array_map('normaliseCourse',$rows)]);
    }

    if (preg_match('#^/api/courses/(\d+)$#',$uri,$m)) {
        requireMethod('GET');
        $c = courseById((int)$m[1]);
        if (!$c) jsonError('Course not found.',404);
        requirePublishedCourse($c);
        jsonResponse(['success'=>true,'course'=>normaliseCourse($c)]);
    }


    // Persist learner position and server-owned module completion.
    if (preg_match('#^/api/courses/(\d+)/learning-state$#',$uri,$m)) {
        $cid=(int)$m[1]; $uid=userId();
        $course=courseById($cid);
        if (!$course) jsonError('Course not found.',404);
        requirePublishedCourse($course);
        $assessment=courseAssessment($cid);
        if ($method === 'GET') {
            $s=db()->prepare('SELECT completedModules,currentPosition,assessmentPassed,assessmentScore,progress,updatedAt FROM course_progress WHERE userId=? AND courseId=? LIMIT 1');
            $s->execute([$uid,$cid]); $state=$s->fetch();
            if (!$state) jsonResponse(['success'=>true,'state'=>null]);
            $state['completedModules']=json_decode((string)$state['completedModules'],true) ?: [];
            $state['currentPosition']=json_decode((string)$state['currentPosition'],true);
            $state['assessmentPassed']=(bool)$state['assessmentPassed'];
            $state['assessmentScore']=$state['assessmentScore']===null?null:(float)$state['assessmentScore'];
            $state['progress']=(int)$state['progress'];
            jsonResponse(['success'=>true,'state'=>$state]);
        }
        if ($method !== 'PUT') jsonError("Method $method not allowed.",405);
        $d=getJsonBody();
        $position=is_array($d['currentPosition']??null)?$d['currentPosition']:null;
        if ($position !== null) {
            $positionModule=trim((string)($position['mid']??''));
            $positionIndex=$position['i']??null;
            $isIndex=is_int($positionIndex)
                || (is_string($positionIndex) && ctype_digit($positionIndex));
            if (
                !in_array($positionModule,$assessment['moduleIds']??[],true)
                || !$isIndex
                || (int)$positionIndex < 0
            ) {
                jsonError('Invalid saved course position.',422);
            }
            $position=['mid'=>$positionModule,'i'=>(int)$positionIndex];
        }
        $existing = db()->prepare('SELECT completedModules,currentPosition,assessmentPassed,assessmentScore FROM course_progress WHERE userId=? AND courseId=? LIMIT 1');
        $existing->execute([$uid,$cid]);
        $existingState=$existing->fetch() ?: [];
        $storedCompleted=json_decode((string)($existingState['completedModules']??'{}'),true);
        if (!is_array($storedCompleted)) $storedCompleted=[];
        $moduleToComplete=trim((string)($d['completedModuleId']??''));
        if ($moduleToComplete !== '') {
            $allowed=$assessment['moduleIds']??[];
            if (!in_array($moduleToComplete,$allowed,true)) jsonError('Invalid course module.',422);
            $storedCompleted[$moduleToComplete]=true;
            $position=null;
        }
        $passed=(bool)($existingState['assessmentPassed']??false);
        $score=$existingState['assessmentScore']??null;
        $validCompleted=array_intersect_key($storedCompleted,array_flip($assessment['moduleIds']??[]));
        $completedCount=count(array_filter($validCompleted,static fn($v)=>(bool)$v));
        $moduleTotal=count($assessment['moduleIds']??[]);
        $progress=$moduleTotal>0?min(99,(int)floor(($completedCount/$moduleTotal)*100)):0;
        if ($passed) $progress=100;
        $jsonCompleted=json_encode($storedCompleted,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $jsonPosition=$position===null?null:json_encode($position,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        db()->prepare('INSERT INTO course_progress (userId,courseId,completedModules,currentPosition,assessmentPassed,assessmentScore,progress) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE completedModules=VALUES(completedModules),currentPosition=VALUES(currentPosition),assessmentPassed=VALUES(assessmentPassed),assessmentScore=VALUES(assessmentScore),progress=VALUES(progress)')->execute([$uid,$cid,$jsonCompleted,$jsonPosition,$passed?1:0,$score,$progress]);
        $s=db()->prepare('SELECT id FROM enrollments WHERE userId=? AND courseId=? LIMIT 1'); $s->execute([$uid,$cid]); $e=$s->fetch();
        if(!$e){ db()->prepare("INSERT INTO enrollments (userId,courseId,progress,status) VALUES (?,?,?,'active')")->execute([$uid,$cid,$progress]); db()->prepare('UPDATE courses SET studentCount=studentCount+1 WHERE id=?')->execute([$cid]); }
        else { $status=$progress>=100?'completed':'active'; $completedAt=$progress>=100?date('Y-m-d H:i:s'):null; db()->prepare('UPDATE enrollments SET progress=?,status=?,completedAt=? WHERE id=?')->execute([$progress,$status,$completedAt,(int)$e['id']]); }
        jsonResponse(['success'=>true,'progress'=>$progress,'assessmentPassed'=>$passed,'completedModules'=>$storedCompleted]);
    }

    if (preg_match('#^/api/courses/(\d+)/enroll$#',$uri,$m)) {
        $cid = (int)$m[1]; $uid = userId();
        $course = courseById($cid);
        if (!$course) jsonError('Course not found.',404);
        requirePublishedCourse($course);
        requireMethod('POST');
        $s = db()->prepare('SELECT id,progress,status FROM enrollments WHERE userId=? AND courseId=? LIMIT 1');
        $s->execute([$uid,$cid]); $existing=$s->fetch();
        if (!$existing) {
            db()->prepare("INSERT INTO enrollments (userId,courseId,progress,status) VALUES (?,?,0,'active')")->execute([$uid,$cid]);
            db()->prepare('UPDATE courses SET studentCount=studentCount+1 WHERE id=?')->execute([$cid]);
        } elseif ($existing['status'] === 'dropped') {
            db()->prepare("UPDATE enrollments SET status='active' WHERE id=?")->execute([(int)$existing['id']]);
        }
        jsonResponse(['success'=>true,'message'=>'Enrollment successful.','courseId'=>$cid]);
    }

    if (preg_match('#^/api/courses/(\d+)/progress$#',$uri,$m)) {
        userId();
        jsonError('Client-provided progress is no longer accepted. Complete course modules to update progress.',410);
    }

    if ($uri === '/api/courses/enrolled') {
        requireMethod('GET'); $uid=userId();
        // A saved learning-state record is also enough to recognise a course as
        // in-progress. This keeps Continue Learning correct even if an older
        // session saved progress before an enrollment row was created.
        $s=db()->prepare("SELECT c.id,c.slug,c.title,c.description,c.category,c.difficulty,c.duration,c.contentPath,c.icon,c.rating,c.studentCount,c.publicationStatus,c.createdAt,
            GREATEST(COALESCE(e.progress,0),COALESCE(cp.progress,0)) progress,
            CASE WHEN COALESCE(cp.progress,0)>=100 OR COALESCE(e.progress,0)>=100 THEN 'completed' ELSE COALESCE(e.status,'active') END learningStatus,
            COALESCE(e.enrolledAt,cp.updatedAt) enrolledAt,e.completedAt,cp.updatedAt lastProgressSaved
            FROM courses c
            LEFT JOIN enrollments e ON e.courseId=c.id AND e.userId=?
            LEFT JOIN course_progress cp ON cp.courseId=c.id AND cp.userId=?
            WHERE c.publicationStatus='published' AND ((e.id IS NOT NULL AND e.status<>'dropped') OR cp.id IS NOT NULL)
            ORDER BY COALESCE(cp.updatedAt,e.enrolledAt) DESC");
        $s->execute([$uid,$uid]); $rows=$s->fetchAll();
        foreach($rows as &$r){
            $learningStatus=(string)($r['learningStatus']??'active');
            $r=normaliseCourse($r);
            $r['status']=$learningStatus;
            unset($r['learningStatus']);
            $r['progress']=(int)$r['progress'];
        }
        unset($r);
        jsonResponse($rows);
    }

    // ---------- DASHBOARD ----------
    if ($uri === '/api/analytics/dashboard') {
        $uid=userId();
        $s=db()->prepare("SELECT COUNT(*) enrolledCourses,SUM(status='completed') completedCourses FROM enrollments WHERE userId=? AND status<>'dropped'"); $s->execute([$uid]); $stats=$s->fetch() ?: [];
        $s=db()->prepare('SELECT currentStreak,totalPoints FROM learning_streaks WHERE userId=? LIMIT 1'); $s->execute([$uid]); $st=$s->fetch() ?: ['currentStreak'=>0,'totalPoints'=>0];
        $s=db()->prepare('SELECT COUNT(*) rank FROM learning_streaks WHERE totalPoints > (SELECT totalPoints FROM learning_streaks WHERE userId=?)'); $s->execute([$uid]); $rank=1+(int)($s->fetch()['rank'] ?? 0);
        jsonResponse(['enrolledCourses'=>(int)($stats['enrolledCourses']??0),'completedCourses'=>(int)($stats['completedCourses']??0),'currentStreak'=>(int)$st['currentStreak'],'totalPoints'=>(int)$st['totalPoints'],'leaderboardRank'=>$rank]);
    }

    if ($uri === '/api/streak' || $uri === '/api/streak/update') {
        $uid=userId();
        if ($uri === '/api/streak/update') {
            requireMethod('POST');
            $s=db()->prepare('SELECT currentStreak,maxStreak,lastActivityDate,totalPoints FROM learning_streaks WHERE userId=? LIMIT 1'); $s->execute([$uid]); $st=$s->fetch();
            if (!$st) { db()->prepare('INSERT INTO learning_streaks (userId,currentStreak,maxStreak,lastActivityDate,totalPoints) VALUES (?,1,1,CURDATE(),0)')->execute([$uid]); }
            else {
                $today=new DateTimeImmutable('today'); $last=$st['lastActivityDate']?new DateTimeImmutable($st['lastActivityDate']):null;
                $current=(int)$st['currentStreak'];
                if (!$last || $last->format('Y-m-d') !== $today->format('Y-m-d')) { $current=($last && $last->modify('+1 day')->format('Y-m-d')===$today->format('Y-m-d'))?$current+1:1; $max=max((int)$st['maxStreak'],$current); db()->prepare('UPDATE learning_streaks SET currentStreak=?,maxStreak=?,lastActivityDate=? WHERE userId=?')->execute([$current,$max,$today->format('Y-m-d'),$uid]); }
            }
        }
        $s=db()->prepare('SELECT currentStreak,maxStreak,lastActivityDate,totalPoints FROM learning_streaks WHERE userId=? LIMIT 1');$s->execute([$uid]);$st=$s->fetch() ?: ['currentStreak'=>0,'maxStreak'=>0,'lastActivityDate'=>null,'totalPoints'=>0];
        jsonResponse($st);
    }

    // ---------- DATABASE-AUTHORED MODULE QUIZZES ----------
    if (preg_match('#^/api/courses/(\d+)/questions$#',$uri,$m)) {
        requireMethod('GET');
        $cid=(int)$m[1]; $course=courseById($cid);
        if(!$course) jsonError('Course not found.',404);
        requirePublishedCourse($course);
        $assessment=databaseAssessment($cid,'module_quiz');
        $questions=[];
        foreach(($assessment['questions']??[]) as $question){
            $questions[]=['id'=>$question['quizKey'] ?: ('db-'.$question['id']),'databaseId'=>$question['id'],'moduleId'=>$question['moduleId'],'title'=>$question['title'] ?: 'Knowledge Check','question'=>$question['q'],'options'=>array_map(fn($o)=>['text'=>$o['text'],'correct'=>(bool)$o['correct']],$question['options']),'feedbackCorrect'=>$question['explain'] ?: 'Correct!','feedbackIncorrect'=>'Not quite. The correct answer is highlighted.'];
        }
        jsonResponse(['success'=>true,'questions'=>$questions]);
    }

    // ---------- QUIZZES ----------
    if ($uri === '/api/quizzes/start') {
        requireMethod('POST'); $uid=userId(); $d=getJsonBody(); $cid=(int)($d['courseId']??0); $course=courseById($cid); if(!$course) jsonError('Course not found.',404); requirePublishedCourse($course);
        $assessment=courseAssessment($cid);
        if (!$assessment['questions']) jsonError('This course has no server assessment configured.',422);
        if ($assessment['modules'] > 0 && completedModuleCount($uid,$cid,$assessment['moduleIds']??[]) < $assessment['modules']) jsonError('Complete all course modules before starting the final assessment.',409);
        $questions=$assessment['questions']; shuffle($questions); $questions=array_slice($questions,0,$assessment['ask']);
        $token=createAssessmentToken($uid,$cid,$questions,(int)$assessment['minutes']);
        jsonResponse(['success'=>true,'token'=>$token,'minutes'=>$assessment['minutes'],'passMark'=>$assessment['passMark'],'questions'=>array_map('publicAssessmentQuestion',$questions)]);
    }
    if ($uri === '/api/quizzes/submit') {
        requireMethod('POST'); $uid=userId(); $d=getJsonBody(); $cid=(int)($d['courseId']??0); $course=courseById($cid); if(!$course) jsonError('Course not found.',404); requirePublishedCourse($course);
        $assessment=courseAssessment($cid);
        if (!$assessment['questions']) jsonError('This course has no server assessment configured.',422);
        if ($assessment['modules'] > 0 && completedModuleCount($uid,$cid,$assessment['moduleIds']??[]) < $assessment['modules']) jsonError('Complete all course modules before submitting the final assessment.',409);
        $challenge=verifyAssessmentToken((string)($d['assessmentToken']??''),$uid,$cid);
        if (!$challenge) jsonError('Assessment session is invalid or expired. Start the assessment again.',409);
        $answers=is_array($d['answers']??null)?$d['answers']:[];
        $expected=count($challenge['q']);
        if (count($answers) !== $expected) jsonError("The final assessment requires exactly $expected answered questions.",422);
        $questionMap=[];
        foreach($assessment['questions'] as $q){
            $prompt=trim((string)($q['q']??$q['question']??''));
            if($prompt==='') continue;
            $correct=[];
            foreach(($q['options']??[]) as $option){ if(!empty($option['correct'])) $correct[]=(string)($option['text']??''); }
            $questionMap[$prompt]=$correct;
        }
        $seen=[]; $correct=0; $review=[];
        foreach($answers as $answer){
            if(!is_array($answer)) jsonError('Invalid assessment answer.',422);
            $question=trim((string)($answer['question']??'')); $selected=(string)($answer['answer']??'');
            $questionHash=hash('sha256',$question);
            if($question==='' || !array_key_exists($question,$questionMap) || !in_array($questionHash,$challenge['q'],true) || isset($seen[$question])) jsonError('Invalid or duplicate assessment question.',422);
            $validOptions=[];
            foreach($assessment['questions'] as $q){ if((string)($q['q']??$q['question']??'')===$question){ foreach(($q['options']??[]) as $o){$validOptions[]=(string)($o['text']??'');} break; } }
            if($selected!=='' && !in_array($selected,$validOptions,true)) jsonError('Invalid answer option.',422);
            $isCorrect=$selected!=='' && in_array($selected,$questionMap[$question],true);
            if($isCorrect) $correct++;
            $correctText=$questionMap[$question][0]??'';
            $explain='';
            foreach($assessment['questions'] as $aq){ if((string)($aq['q']??$aq['question']??'')===$question){ $explain=(string)($aq['explain']??''); break; } }
            $review[]=['question'=>$question,'selected'=>$selected,'correct'=>$isCorrect,'correctAnswer'=>$correctText,'explain'=>$explain];
            $seen[$question]=true;
        }
        if(count($seen)!==$expected || count(array_unique($challenge['q']))!==$expected) jsonError('The assessment contains invalid or duplicate questions.',422);
        $score=round($correct/$expected*100,2); $qid=isset($d['quizId'])?(int)$d['quizId']:null;
        $passed=$score >= (float)$assessment['passMark'];
        $points=max(0,$correct*10);
        $db=db();
        try {
            $db->beginTransaction();
            $consume=$db->prepare('UPDATE assessment_attempts SET submittedAt=NOW() WHERE tokenHash=? AND userId=? AND courseId=? AND submittedAt IS NULL AND expiresAt>=NOW()');
            $consume->execute([hash('sha256',(string)($d['assessmentToken']??'')),$uid,$cid]);
            if($consume->rowCount()!==1){
                $db->rollBack();
                jsonError('Assessment session has already been submitted, expired or replaced. Start the assessment again.',409);
            }
            $db->prepare('INSERT INTO quiz_attempts (userId,courseId,quizId,score,totalQuestions,correctAnswers) VALUES (?,?,?,?,?,?)')->execute([$uid,$cid,$qid,$score,$expected,$correct]);
            if($score>=80){$s=$db->prepare("SELECT id FROM achievements WHERE userId=? AND badgeType='QuizMaster' LIMIT 1");$s->execute([$uid]);if(!$s->fetch()) $db->prepare("INSERT INTO achievements (userId,badgeType,badgeName,description) VALUES (?,'QuizMaster','Quiz Master','Scored 80% or higher on a quiz')")->execute([$uid]);}
            $db->prepare('INSERT INTO learning_streaks (userId,totalPoints) VALUES (?,?) ON DUPLICATE KEY UPDATE totalPoints=totalPoints+VALUES(totalPoints)')->execute([$uid,$points]);
            if ($passed) {
                $db->prepare('INSERT INTO course_progress (userId,courseId,completedModules,currentPosition,assessmentPassed,assessmentScore,progress) VALUES (?,?,?,NULL,1,?,100) ON DUPLICATE KEY UPDATE assessmentPassed=1,assessmentScore=VALUES(assessmentScore),progress=100')->execute([$uid,$cid,json_encode(array_fill_keys($assessment['moduleIds']??[],true)),$score]);
                $db->prepare("UPDATE enrollments SET progress=100,status='completed',completedAt=NOW() WHERE userId=? AND courseId=?")->execute([$uid,$cid]);
            }
            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) $db->rollBack();
            throw $e;
        }
        jsonResponse(['success'=>true,'score'=>$score,'passed'=>$passed,'correctAnswers'=>$correct,'totalQuestions'=>$expected,'pointsAwarded'=>$points,'review'=>$review]);
    }
    if ($uri === '/api/quizzes/history') { $uid=userId(); $s=db()->prepare('SELECT * FROM quiz_attempts WHERE userId=? ORDER BY attemptedAt DESC');$s->execute([$uid]);jsonResponse($s->fetchAll()); }

    if ($uri === '/api/achievements') { $uid=userId();$s=db()->prepare('SELECT * FROM achievements WHERE userId=? ORDER BY unlockedAt DESC');$s->execute([$uid]);jsonResponse($s->fetchAll()); }

    // ---------- CERTIFICATES ----------
    if (preg_match('#^/api/certificates/(\d+)/download$#',$uri,$m)) {
        requireMethod('GET');
        $uid=userId();
        $certificate=certificateDownloadRecord((int)$m[1],$uid);
        if(!$certificate) jsonError('Certificate not found.',404);
        audit('certificate_downloaded','certificate',(int)$certificate['id']);
        outputCertificatePdf($certificate);
    }
    if ($uri === '/api/certificates/verify' && $method === 'GET') { $number=trim((string)($_GET['number']??'')); if($number==='') jsonError('Certificate number is required.'); $s=db()->prepare('SELECT ce.certificateNumber,ce.issuedAt,u.fullName,c.title courseName FROM certificates ce JOIN users u ON u.id=ce.userId JOIN courses c ON c.id=ce.courseId WHERE ce.certificateNumber=? LIMIT 1');$s->execute([$number]);$cert=$s->fetch();if(!$cert)jsonError('Certificate not found.',404);jsonResponse(['success'=>true,'valid'=>true,'certificate'=>$cert]); }
    if ($uri === '/api/certificates') { $uid=userId();$s=db()->prepare('SELECT ce.id,ce.courseId,c.title courseName,ce.certificateNumber,ce.issuedAt FROM certificates ce JOIN courses c ON c.id=ce.courseId WHERE ce.userId=? ORDER BY ce.issuedAt DESC');$s->execute([$uid]);jsonResponse($s->fetchAll()); }
    if ($uri === '/api/certificates/issue') { requireMethod('POST');$uid=userId();$d=getJsonBody();$cid=(int)($d['courseId']??0);$s=db()->prepare("SELECT id,progress,status FROM enrollments WHERE userId=? AND courseId=? LIMIT 1");$s->execute([$uid,$cid]);$e=$s->fetch();$s=db()->prepare('SELECT assessmentPassed FROM course_progress WHERE userId=? AND courseId=? LIMIT 1');$s->execute([$uid,$cid]);$state=$s->fetch();if(!$e||$e['progress']<100||empty($state['assessmentPassed'])) jsonError('Complete all modules and pass the assessment before requesting a certificate.',409);$s=db()->prepare('SELECT id,certificateNumber,issuedAt FROM certificates WHERE userId=? AND courseId=? LIMIT 1');$s->execute([$uid,$cid]);$cert=$s->fetch();if(!$cert){$number='EAC-'.date('Y').'-'.$uid.'-'.$cid.'-'.strtoupper(bin2hex(random_bytes(3)));db()->prepare('INSERT INTO certificates (userId,courseId,certificateNumber) VALUES (?,?,?)')->execute([$uid,$cid,$number]);$cert=['id'=>(int)db()->lastInsertId(),'certificateNumber'=>$number,'issuedAt'=>date('Y-m-d H:i:s')];}jsonResponse(['success'=>true,'certificate'=>$cert]); }

    // ---------- LEADERBOARD ----------
    if ($uri === '/api/leaderboard') { $s=db()->query("SELECT u.id,u.fullName,u.organization,ls.totalPoints,ls.currentStreak,(SELECT COUNT(*) FROM enrollments e WHERE e.userId=u.id AND e.status='completed') AS coursesCompleted,RANK() OVER (ORDER BY ls.totalPoints DESC) AS rank FROM learning_streaks ls JOIN users u ON u.id=ls.userId ORDER BY ls.totalPoints DESC, u.fullName ASC LIMIT 50");jsonResponse($s->fetchAll()); }
    if ($uri === '/api/leaderboard/rank') { $uid=userId();$s=db()->prepare('SELECT totalPoints FROM learning_streaks WHERE userId=?');$s->execute([$uid]);$points=(int)($s->fetch()['totalPoints']??0);$s=db()->prepare('SELECT COUNT(*) n FROM learning_streaks WHERE totalPoints>?');$s->execute([$points]);jsonResponse(['rank'=>1+(int)$s->fetch()['n'],'totalPoints'=>$points]); }

    // ---------- FORUM ----------
    if ($uri === '/api/comments' && $method === 'GET') { $cid=isset($_GET['courseId'])?(int)$_GET['courseId']:0; $sql='SELECT cm.id,cm.courseId,cm.commentText,cm.likes,cm.parentId,cm.createdAt,u.id userId,u.fullName userName FROM comments cm JOIN users u ON u.id=cm.userId';$params=[];if($cid){$sql.=' WHERE cm.courseId=?';$params[]=$cid;}$sql.=' ORDER BY cm.createdAt ASC';$s=db()->prepare($sql);$s->execute($params);jsonResponse($s->fetchAll()); }
    if ($uri === '/api/comments' && $method === 'POST') {
        $uid=userId(); $d=getJsonBody(); $cid=(int)($d['courseId']??0);
        $text=trim((string)($d['commentText']??''));
        $parent=isset($d['parentId'])&&$d['parentId']!==null?(int)$d['parentId']:null;
        if(!$cid||!courseById($cid)||$text==='') jsonError('Course and comment text are required.');
        if(strlen($text)>5000) jsonError('Comment must be 5,000 characters or fewer.',422);
        if($parent){
            $s=db()->prepare('SELECT id FROM comments WHERE id=? AND courseId=? LIMIT 1');
            $s->execute([$parent,$cid]);
            if(!$s->fetch()) jsonError('Parent discussion not found.',404);
        }
        db()->prepare('INSERT INTO comments (userId,courseId,commentText,parentId) VALUES (?,?,?,?)')->execute([$uid,$cid,$text,$parent]);
        notifyForumByEmail($uid,$cid,$text,$parent);
        jsonResponse(['success'=>true,'id'=>(int)db()->lastInsertId()],201);
    }
    if (preg_match('#^/api/comments/(\d+)/like$#',$uri,$m)) { requireMethod('POST');$uid=userId();$cid=(int)$m[1];$s=db()->prepare('SELECT id FROM comment_likes WHERE userId=? AND commentId=? LIMIT 1');$s->execute([$uid,$cid]);$like=$s->fetch();if($like){db()->prepare('DELETE FROM comment_likes WHERE id=?')->execute([(int)$like['id']]);db()->prepare('UPDATE comments SET likes=GREATEST(likes-1,0) WHERE id=?')->execute([$cid]);$liked=false;}else{db()->prepare('INSERT INTO comment_likes (userId,commentId) VALUES (?,?)')->execute([$uid,$cid]);db()->prepare('UPDATE comments SET likes=likes+1 WHERE id=?')->execute([$cid]);$liked=true;}jsonResponse(['success'=>true,'liked'=>$liked]); }

    // ---------- NOTIFICATIONS / FEEDBACK ----------
    if ($uri === '/api/notifications') { $uid=userId(); $s=db()->prepare('SELECT id,title,message,type,readAt,createdAt FROM notifications WHERE userId=? ORDER BY createdAt DESC LIMIT 50'); $s->execute([$uid]); jsonResponse(['success'=>true,'notifications'=>$s->fetchAll()]); }
    if (preg_match('#^/api/notifications/(\d+)/read$#',$uri,$m)) { requireMethod('POST'); $uid=userId(); db()->prepare('UPDATE notifications SET readAt=NOW() WHERE id=? AND userId=?')->execute([(int)$m[1],$uid]); jsonResponse(['success'=>true]); }
    if ($uri === '/api/feedback') { requireMethod('POST'); $uid=userId(); $d=getJsonBody(); $cid=(int)($d['courseId']??0); $rating=(int)($d['rating']??0); $comment=trim((string)($d['comment']??'')); if(!$cid||!courseById($cid)||$rating<1||$rating>5) jsonError('Course and a rating from 1 to 5 are required.'); db()->prepare('INSERT INTO course_feedback (userId,courseId,rating,comment) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE rating=VALUES(rating),comment=VALUES(comment)')->execute([$uid,$cid,$rating,$comment?:null]); audit('feedback_submitted','course',$cid,['rating'=>$rating]); jsonResponse(['success'=>true]); }

    // ---------- ADMIN ----------
    if ($uri === '/api/admin/users') { requireAdmin();$s=db()->query('SELECT id,email,fullName,role,organization,sector,country,jobTitle,createdAt FROM users ORDER BY createdAt DESC');jsonResponse($s->fetchAll()); }
    if ($uri === '/api/admin/learners' && $method === 'GET') {
        requireAdmin();
        $search=trim((string)($_GET['search']??'')); $params=[];
        $sql="SELECT u.id,u.email,u.fullName,u.role,u.organization,u.sector,u.country,u.jobTitle,u.createdAt,
            COUNT(DISTINCT e.id) enrolledCourses,
            COALESCE(SUM(e.status='completed'),0) completedCourses,
            COALESCE(ROUND(AVG(e.progress),1),0) averageProgress,
             MAX(e.enrolledAt) lastEnrollment,
             MAX(cp.updatedAt) lastProgressSaved
             FROM users u LEFT JOIN enrollments e ON e.userId=u.id LEFT JOIN course_progress cp ON cp.userId=u.id WHERE u.role='student'";
        if($search!==''){ $sql.=' AND (u.fullName LIKE ? OR u.email LIKE ? OR u.organization LIKE ? OR u.country LIKE ?)'; $term='%'.$search.'%'; $params=[$term,$term,$term,$term]; }
        $sql.=' GROUP BY u.id ORDER BY u.createdAt DESC LIMIT 250'; $s=db()->prepare($sql);$s->execute($params);$rows=$s->fetchAll();
        foreach($rows as &$row){$row['id']=(int)$row['id'];$row['enrolledCourses']=(int)$row['enrolledCourses'];$row['completedCourses']=(int)$row['completedCourses'];$row['averageProgress']=(float)$row['averageProgress'];}unset($row);
        jsonResponse(['success'=>true,'learners'=>$rows]);
    }
    if (preg_match('#^/api/admin/learners/(\d+)$#',$uri,$m) && $method === 'GET') {
        requireAdmin(); $id=(int)$m[1];
        $s=db()->prepare("SELECT id,email,fullName,firstName,middleName,surname,sex,organization,sector,country,jobTitle,createdAt FROM users WHERE id=? AND role='student' LIMIT 1");$s->execute([$id]);$user=$s->fetch();if(!$user)jsonError('Learner not found.',404);
        $s=db()->prepare('SELECT c.title courseName,e.progress,e.status,e.enrolledAt,e.completedAt,cp.updatedAt lastProgressSaved FROM enrollments e JOIN courses c ON c.id=e.courseId LEFT JOIN course_progress cp ON cp.userId=e.userId AND cp.courseId=e.courseId WHERE e.userId=? ORDER BY e.enrolledAt DESC');$s->execute([$id]);$courses=$s->fetchAll();
        $s=db()->prepare('SELECT courseId,score,totalQuestions,correctAnswers,attemptedAt FROM quiz_attempts WHERE userId=? ORDER BY attemptedAt DESC LIMIT 50');$s->execute([$id]);$quizzes=$s->fetchAll();
        jsonResponse(['success'=>true,'user'=>$user,'courses'=>$courses,'quizzes'=>$quizzes]);
    }
    if ($uri === '/api/admin/audit-logs' && $method === 'GET') { requireAdmin();$limit=max(1,min(200,(int)($_GET['limit']??100)));$s=db()->query("SELECT a.id,a.action,a.entityType,a.entityId,a.details,a.createdAt,u.fullName userName,u.email FROM audit_logs a LEFT JOIN users u ON u.id=a.userId ORDER BY a.createdAt DESC LIMIT $limit");jsonResponse(['success'=>true,'logs'=>$s->fetchAll()]); }
    if ($uri === '/api/admin/feedback' && $method === 'GET') { requireAdmin();$s=db()->query("SELECT f.id,f.rating,f.comment,f.createdAt,u.fullName userName,u.email,c.title courseName,c.difficulty FROM course_feedback f JOIN users u ON u.id=f.userId JOIN courses c ON c.id=f.courseId ORDER BY f.createdAt DESC LIMIT 250");jsonResponse(['success'=>true,'feedback'=>$s->fetchAll()]); }
    if ($uri === '/api/admin/export/learners.csv' && $method === 'GET') { requireAdmin();$s=db()->query("SELECT u.fullName,u.email,u.organization,u.sector,u.country,COUNT(DISTINCT e.id) enrolledCourses,COALESCE(SUM(e.status='completed'),0) completedCourses,COALESCE(ROUND(AVG(e.progress),1),0) averageProgress,u.createdAt FROM users u LEFT JOIN enrollments e ON e.userId=u.id WHERE u.role='student' GROUP BY u.id ORDER BY u.createdAt DESC");header_remove('Content-Type');header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename=eac-learners.csv');$out=fopen('php://output','w');fputcsv($out,['Name','Email','Organisation','Sector','Country','Enrolled courses','Completed courses','Average progress','Registered']);foreach($s as $row)fputcsv($out,$row);fclose($out);exit; }
    if ($uri === '/api/admin/certificates' && $method === 'GET') {
        requireAdmin();
        $search=trim((string)($_GET['search']??''));
        $params=[];
        $sql='SELECT ce.id,ce.certificateNumber,ce.issuedAt,u.fullName userName,u.email,u.organization,c.title courseName,c.publicationStatus courseStatus FROM certificates ce JOIN users u ON u.id=ce.userId JOIN courses c ON c.id=ce.courseId WHERE 1=1';
        if($search!==''){
            $term='%'.$search.'%';
            $sql.=' AND (ce.certificateNumber LIKE ? OR u.fullName LIKE ? OR u.email LIKE ? OR c.title LIKE ?)';
            $params=[$term,$term,$term,$term];
        }
        $sql.=' ORDER BY ce.issuedAt DESC LIMIT 500';
        $s=db()->prepare($sql);$s->execute($params);$rows=$s->fetchAll();
        foreach($rows as &$row){$row['id']=(int)$row['id'];$row['courseStatus']=coursePublicationStatus(['publicationStatus'=>$row['courseStatus']??'published']);}unset($row);
        jsonResponse(['success'=>true,'certificates'=>$rows]);
    }
    if (preg_match('#^/api/admin/certificates/(\d+)/download$#',$uri,$m)) {
        requireMethod('GET');
        requireAdmin();
        $certificate=certificateDownloadRecord((int)$m[1]);
        if(!$certificate) jsonError('Certificate not found.',404);
        audit('admin_certificate_downloaded','certificate',(int)$certificate['id'],['userId'=>(int)$certificate['userId']]);
        outputCertificatePdf($certificate);
    }
    if ($uri === '/api/admin/export/certificates.csv' && $method === 'GET') {
        requireAdmin();
        $s=db()->query('SELECT ce.certificateNumber,u.fullName,u.email,u.organization,c.title,ce.issuedAt FROM certificates ce JOIN users u ON u.id=ce.userId JOIN courses c ON c.id=ce.courseId ORDER BY ce.issuedAt DESC');
        header_remove('Content-Type');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=eac-certificates.csv');
        $out=fopen('php://output','w');
        fputcsv($out,['Certificate number','Learner','Email','Organisation','Course','Issued']);
        foreach($s as $row)fputcsv($out,$row);
        fclose($out);
        exit;
    }
    if (preg_match('#^/api/admin/users/(\d+)/role$#',$uri,$m)) { requireMethod('PUT');$auth=requireAdmin();$id=(int)$m[1];$d=getJsonBody();$role=(string)($d['role']??'');if(!in_array($role,['student','instructor','admin'],true))jsonError('Invalid role.');if($id===(int)$auth['userId'])jsonError('You cannot change your own role.',403);$s=db()->prepare('UPDATE users SET role=? WHERE id=?');$s->execute([$role,$id]);jsonResponse(['success'=>true]); }
    if ($uri === '/api/admin/courses') {
        requireAdmin();
        if ($method === 'GET') {
            $s=db()->query('SELECT id,slug,title,description,category,difficulty,duration,contentPath,icon,rating,studentCount,publicationStatus,createdAt FROM courses ORDER BY CASE publicationStatus WHEN \'draft\' THEN 1 WHEN \'published\' THEN 2 ELSE 3 END, title ASC');
            jsonResponse(['success'=>true,'courses'=>array_map('normaliseCourse',$s->fetchAll())]);
        }
        requireMethod('POST'); $d=getJsonBody();
        $title=trim((string)($d['title']??''));
        if ($title==='') jsonError('Course title is required.');
        $slugInput=trim((string)($d['slug']??''));
        $slug=validateCourseSlug($slugInput!=='' ? $slugInput : courseSlugFromTitle($title));
        $uploadedModules=null;
        if (array_key_exists('contentFiles',$d)) {
            if (!is_array($d['contentFiles']) || count($d['contentFiles']) < 1 || count($d['contentFiles']) > 50) jsonError('Upload between 1 and 50 module files.',422);
            $uploadedModules=[];
            $totalUploadBytes=0;
            foreach (array_values($d['contentFiles']) as $index => $uploadedFile) {
                if (!is_array($uploadedFile)) jsonError('Invalid course module upload.',422);
                $uploadName=trim((string)($uploadedFile['name']??''));
                $uploadExtension=strtolower(pathinfo($uploadName, PATHINFO_EXTENSION));
                if (!in_array($uploadExtension,['html','htm','txt'],true)) jsonError('Upload HTML or text module files only.',422);
                $rawContent=(string)($uploadedFile['content']??'');
                $totalUploadBytes+=strlen($rawContent);
                if ($totalUploadBytes > 5 * 1024 * 1024) jsonError('All course module files together must not exceed 5 MB.',422);
                $structured=sanitiseStructuredCourseContent($rawContent);
                if ($structured !== null) {
                    if (count($d['contentFiles']) !== 1) jsonError('Upload a complete structured course by itself, or upload separate module files.',422);
                    $uploadedModules[]=['title'=>$title,'content'=>$structured,'structured'=>true];
                    continue;
                }
                $moduleTitle=trim((string)pathinfo($uploadName, PATHINFO_FILENAME));
                $moduleTitle=preg_replace('/^[0-9]+[-_. ]*/','',$moduleTitle) ?? $moduleTitle;
                $moduleTitle=trim(str_replace(['-','_'], ' ', $moduleTitle)) ?: ('Module '.($index+1));
                $uploadedModules[]=['title'=>ucwords($moduleTitle),'content'=>sanitiseManagedCourseContent($rawContent)];
            }
        }
        $contentPath=$uploadedModules !== null ? 'courses/'.$slug.'.php' : validateCourseContentPath($d['contentPath']??'');
        $publicationStatus=validateCoursePublicationStatus($d['status']??'draft');
        $s=db()->prepare('INSERT INTO courses (slug,title,description,category,difficulty,duration,contentPath,icon,rating,studentCount,publicationStatus) VALUES (?,?,?,?,?,?,?, ?,4.50,0,?)');
        $createdEntry = null;
        try {
            $s->execute([$slug,$title,$d['description']??null,$d['category']??null,$d['difficulty']??'Beginner',$d['duration']??null,$contentPath,$d['icon']??'book',$publicationStatus]);
            $id=(int)db()->lastInsertId();
            if ($uploadedModules !== null) {
                $contentPath=createManagedCourseFiles($id,$slug,$title,$uploadedModules);
                $createdEntry=$contentPath;
            }
            db()->prepare('INSERT INTO assessment_settings (courseId,questionsPerAttempt,passMark,minutes,intro) VALUES (?,20,80,20,?) ON DUPLICATE KEY UPDATE courseId=VALUES(courseId)')->execute([$id,'']);
        } catch (PDOException $e) {
            if ((int)($e->errorInfo[1] ?? 0)===1062) jsonError('That course slug is already in use.',409);
            throw $e;
        } catch (Throwable $e) {
            if (isset($id) && $id > 0) db()->prepare('DELETE FROM courses WHERE id=?')->execute([$id]);
            throw $e;
        }
        audit('course_created','course',$id,['status'=>$publicationStatus,'managedContent'=>$createdEntry!==null]); jsonResponse(['success'=>true,'id'=>$id,'contentPath'=>$contentPath],201);
    }
    if (preg_match('#^/api/admin/courses/(\d+)/assessment-settings$#',$uri,$m)) {
        requireAdmin(); $cid=(int)$m[1]; if(!courseById($cid)) jsonError('Course not found.',404);
        if($method==='GET') { $a=databaseAssessment($cid,'final'); jsonResponse(['success'=>true,'settings'=>['questionsPerAttempt'=>(int)($a['ask']??20),'passMark'=>(float)($a['passMark']??80),'minutes'=>(int)($a['minutes']??20),'intro'=>$a['intro']??'']]); }
        requireMethod('PUT'); $d=getJsonBody(); $ask=max(1,min(200,(int)($d['questionsPerAttempt']??20))); $pass=max(0,min(100,(float)($d['passMark']??80))); $minutes=max(1,min(480,(int)($d['minutes']??20))); $intro=trim((string)($d['intro']??''));
        db()->prepare('INSERT INTO assessment_settings (courseId,questionsPerAttempt,passMark,minutes,intro) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE questionsPerAttempt=VALUES(questionsPerAttempt),passMark=VALUES(passMark),minutes=VALUES(minutes),intro=VALUES(intro)')->execute([$cid,$ask,$pass,$minutes,$intro]);
        audit('assessment_settings_updated','course',$cid); jsonResponse(['success'=>true]);
    }
    if (preg_match('#^/api/admin/courses/(\d+)/questions$#',$uri,$m)) {
        requireAdmin(); $cid=(int)$m[1]; if(!courseById($cid)) jsonError('Course not found.',404);
        if($method==='GET') { $type=(string)($_GET['type']??''); $all=[]; foreach(['module_quiz','final'] as $kind){if($type!==''&&$type!==$kind)continue;$a=databaseAssessment($cid,$kind);foreach(($a['questions']??[]) as $q){$q['questionType']=$kind;$all[]=$q;}} jsonResponse(['success'=>true,'questions'=>$all]); }
        requireMethod('POST'); $d=validateAssessmentQuestion(getJsonBody()); if($d['questionType']==='module_quiz'){if(!$d['moduleId'])jsonError('Select a Module ID for a module quiz.',422);$moduleIds=courseAssessment($cid)['moduleIds']??[];if(!in_array($d['moduleId'],$moduleIds,true))jsonError('That Module ID does not exist in this course.',422);} $db=db(); $db->beginTransaction(); try{$s=$db->prepare('INSERT INTO assessment_questions (courseId,questionType,moduleId,quizKey,title,questionText,explanation,sortOrder,isActive) VALUES (?,?,?,?,?,?,?,?,?)');$s->execute([$cid,$d['questionType'],$d['moduleId'],$d['quizKey'],$d['title'],$d['questionText'],$d['explanation'],$d['sortOrder'],$d['isActive']]);$id=(int)$db->lastInsertId();$o=$db->prepare('INSERT INTO assessment_options (questionId,optionText,isCorrect,sortOrder) VALUES (?,?,?,?)');foreach($d['options'] as $option)$o->execute([$id,$option['text'],(int)$option['correct'],$option['sortOrder']]);$verify=$db->prepare('SELECT COUNT(*) total FROM assessment_options WHERE questionId=?');$verify->execute([$id]);if((int)($verify->fetch()['total']??0)!==count($d['options']))throw new RuntimeException('Question options were not fully persisted.');$db->commit();}catch(Throwable $e){if($db->inTransaction())$db->rollBack();throw $e;} audit('assessment_question_created','assessment_question',$id,['courseId'=>$cid,'type'=>$d['questionType']]);jsonResponse(['success'=>true,'id'=>$id,'persisted'=>true,'courseId'=>$cid],201);
    }
    if (preg_match('#^/api/admin/questions/(\d+)$#',$uri,$m)) {
        requireAdmin(); $id=(int)$m[1]; $s=db()->prepare('SELECT id,courseId FROM assessment_questions WHERE id=?');$s->execute([$id]);$existing=$s->fetch();if(!$existing)jsonError('Question not found.',404);
        if($method==='DELETE'){db()->prepare('DELETE FROM assessment_questions WHERE id=?')->execute([$id]);audit('assessment_question_deleted','assessment_question',$id,['courseId'=>(int)$existing['courseId']]);jsonResponse(['success'=>true]);}
        requireMethod('PUT');$d=validateAssessmentQuestion(getJsonBody());$db=db();$db->beginTransaction();try{$db->prepare('UPDATE assessment_questions SET questionType=?,moduleId=?,quizKey=?,title=?,questionText=?,explanation=?,sortOrder=?,isActive=? WHERE id=?')->execute([$d['questionType'],$d['moduleId'],$d['quizKey'],$d['title'],$d['questionText'],$d['explanation'],$d['sortOrder'],$d['isActive'],$id]);$db->prepare('DELETE FROM assessment_options WHERE questionId=?')->execute([$id]);$o=$db->prepare('INSERT INTO assessment_options (questionId,optionText,isCorrect,sortOrder) VALUES (?,?,?,?)');foreach($d['options'] as $option)$o->execute([$id,$option['text'],(int)$option['correct'],$option['sortOrder']]);$db->commit();}catch(Throwable $e){if($db->inTransaction())$db->rollBack();throw $e;}audit('assessment_question_updated','assessment_question',$id,['courseId'=>(int)$existing['courseId']]);jsonResponse(['success'=>true,'id'=>$id]);
    }
    if (preg_match('#^/api/admin/courses/(\d+)/status$#',$uri,$m)) {
        requireAdmin();
        requireMethod('PUT');
        $cid=(int)$m[1];
        $course=courseById($cid);
        if(!$course) jsonError('Course not found.',404);
        $d=getJsonBody();
        $status=validateCoursePublicationStatus($d['status']??'');
        if($status==='published' && count(courseAssessment($cid)['moduleIds']??[])<1) jsonError('A course must contain at least one valid module before publishing.',422);
        db()->prepare('UPDATE courses SET publicationStatus=? WHERE id=?')->execute([$status,$cid]);
        audit('course_status_updated','course',$cid,['from'=>coursePublicationStatus($course),'to'=>$status]);
        jsonResponse(['success'=>true,'id'=>$cid,'status'=>$status]);
    }
    if (preg_match('#^/api/admin/courses/(\d+)/overview$#',$uri,$m) && $method === 'GET') {
        requireAdmin();
        $cid=(int)$m[1];
        $course=courseById($cid);
        if(!$course) jsonError('Course not found.',404);
        $assessment=courseAssessment($cid);
        $s=db()->prepare("SELECT COUNT(*) enrolledLearners, SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) completedLearners, COALESCE(ROUND(AVG(progress),1),0) averageProgress FROM enrollments WHERE courseId=?");
        $s->execute([$cid]);
        $learnerStats=$s->fetch() ?: [];
        jsonResponse([
            'success'=>true,
            'course'=>normaliseCourse($course),
            'modules'=>courseModuleOverview($cid),
            'assessment'=>[
                'questionBank'=>(int)count($assessment['questions']??[]),
                'questionsPerAttempt'=>(int)($assessment['ask']??0),
                'passMark'=>(float)($assessment['passMark']??0),
                'minutes'=>(int)($assessment['minutes']??0),
            ],
            'learners'=>[
                'enrolled'=>(int)($learnerStats['enrolledLearners']??0),
                'completed'=>(int)($learnerStats['completedLearners']??0),
                'averageProgress'=>(float)($learnerStats['averageProgress']??0),
            ],
        ]);
    }
    if (preg_match('#^/api/admin/courses/(\d+)$#',$uri,$m)) {
        requireAdmin(); $cid=(int)$m[1]; $s=db()->prepare('SELECT id,slug,difficulty,publicationStatus FROM courses WHERE id=? LIMIT 1'); $s->execute([$cid]); $existing=$s->fetch(); if(!$existing) jsonError('Course not found.',404);
        if($method==='GET') {
            $course=courseById($cid);
            jsonResponse(['success'=>true,'course'=>normaliseCourse($course ?: $existing)]);
        }
        if($method==='PUT') {
            $d=getJsonBody(); $title=trim((string)($d['title']??''));
            if($title==='') jsonError('Course title is required.');
            $slugInput=trim((string)($d['slug']??''));
            $slug=validateCourseSlug($slugInput!=='' ? $slugInput : (string)$existing['slug']);
            $contentPath=validateCourseContentPath($d['contentPath']??'');
            $difficulty=array_key_exists('difficulty',$d) ? (string)$d['difficulty'] : (string)$existing['difficulty'];
            $publicationStatus=array_key_exists('status',$d) ? validateCoursePublicationStatus($d['status']) : coursePublicationStatus($existing);
            $s=db()->prepare('UPDATE courses SET slug=?,title=?,description=?,category=?,difficulty=?,duration=?,contentPath=?,icon=?,publicationStatus=? WHERE id=?');
            try{$s->execute([$slug,$title,$d['description']??null,$d['category']??null,$difficulty,$d['duration']??null,$contentPath,$d['icon']??'book',$publicationStatus,$cid]);}
            catch(PDOException $e){if((int)$e->errorInfo[1]===1062)jsonError('That course slug is already in use.',409);throw $e;}
            audit('course_updated','course',$cid,['status'=>$publicationStatus]); jsonResponse(['success'=>true,'id'=>$cid,'status'=>$publicationStatus]);
        }
        if($method==='DELETE') { $s=db()->prepare('SELECT COUNT(*) total FROM enrollments WHERE courseId=?'); $s->execute([$cid]); $enrolled=(int)$s->fetch()['total']; if($enrolled>0 && empty($_GET['force'])) jsonError('This course has learner records. Confirm deletion with force=1.',409); db()->prepare('DELETE FROM courses WHERE id=?')->execute([$cid]); audit('course_deleted','course',$cid,['enrollments'=>$enrolled]); jsonResponse(['success'=>true,'deletedId'=>$cid]); }
        jsonError("Method $method not allowed.",405);
    }
    if ($uri === '/api/admin/analytics') {
        requireAdmin();
        $q=db()->query("SELECT COUNT(*) users FROM users WHERE role='student'")->fetch();
        $c=db()->query("SELECT COUNT(*) courses, SUM(publicationStatus='draft') draftCourses, SUM(publicationStatus='published') publishedCourses, SUM(publicationStatus='archived') archivedCourses FROM courses")->fetch();
        $e=db()->query("SELECT COUNT(*) enrollments, SUM(status='completed') completedEnrollments, ROUND(AVG(progress),1) averageProgress FROM enrollments")->fetch();
        $a=db()->query('SELECT COUNT(*) quizAttempts, ROUND(AVG(score),1) averageQuizScore FROM quiz_attempts')->fetch();
        jsonResponse([
            'success'=>true,
            'users'=>(int)$q['users'],
            'courses'=>(int)$c['courses'],
            'draftCourses'=>(int)($c['draftCourses']??0),
            'publishedCourses'=>(int)($c['publishedCourses']??0),
            'archivedCourses'=>(int)($c['archivedCourses']??0),
            'enrollments'=>(int)($e['enrollments']??0),
            'completedEnrollments'=>(int)($e['completedEnrollments']??0),
            'averageProgress'=>(float)($e['averageProgress']??0),
            'quizAttempts'=>(int)($a['quizAttempts']??0),
            'averageQuizScore'=>(float)($a['averageQuizScore']??0),
        ]);
    }

    jsonError('API endpoint not found.',404);
} catch (Throwable $e) {
    $message = '[EAC API] '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();
    error_log($message);
    $logDir = dirname(__DIR__) . '/storage/logs';
    if (is_dir($logDir) && is_writable($logDir)) {
        error_log(date('c').' '.$message.PHP_EOL, 3, $logDir.'/app.log');
    }
    jsonError('An unexpected server error occurred. Please try again later.',500);
}
