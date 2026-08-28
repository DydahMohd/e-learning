<?php
declare(strict_types=1);
$courseKey = $courseKey ?? 'fsi';
$courseDataKey = $courseDataKey ?? $courseKey;
$contentFile = __DIR__ . '/../courses/data/' . $courseDataKey . '.php';
$dataJs = 'data/' . $courseDataKey . '.js';
$dataJsFile = __DIR__ . '/../courses/' . $dataJs;
$courseRuntimeFile = __DIR__ . '/../assets/js/course.js';
$sharedApiFile = __DIR__ . '/../assets/js/api.js';
$mainCssFile = __DIR__ . '/../assets/css/main.css';
$courseCssFile = __DIR__ . '/../assets/css/course.css';
$isEmbedded = isset($_GET['embed']) && $_GET['embed'] === '1';
$courseUnavailable = false;

// The catalogue API hides Draft and Archived courses. Apply the same rule to a
// direct course URL so an unpublished course cannot be opened accidentally.
if (isset($courseId)) {
    try {
        require_once __DIR__ . '/../api/config.php';
        require_once __DIR__ . '/../api/Database.php';
        $statement = Database::connect()->prepare('SELECT publicationStatus FROM courses WHERE id=? LIMIT 1');
        $statement->execute([(int)$courseId]);
        $courseRecord = $statement->fetch();
        $status = strtolower(trim((string)($courseRecord['publicationStatus'] ?? 'published')));
        $courseUnavailable = !$courseRecord || $status !== 'published';
    } catch (Throwable $error) {
        // Allow the static course template to remain usable while the database
        // is unavailable or before the migration has been applied.
        error_log('Course publication status lookup failed: ' . $error->getMessage());
    }
}

if ($courseUnavailable) {
    http_response_code(404);
    header('Content-Type: text/html; charset=UTF-8');
    exit('This course is not currently available.');
}

if (!is_file($contentFile)) { http_response_code(404); exit('Course content not found.'); }
$courseContentMarkup = (string)file_get_contents($contentFile);
$needsAssessmentScreen = stripos($courseContentMarkup, 'id="screen-assessment"') === false
    && stripos($courseContentMarkup, "id='screen-assessment'") === false;
$needsCertificateScreen = stripos($courseContentMarkup, 'id="screen-certificate"') === false
    && stripos($courseContentMarkup, "id='screen-certificate'") === false;

// api/config.php is also used by the JSON API front controller and therefore
// sets an application/json response header. These course entry points render
// HTML, so override that header before any markup is sent. Without this, modern
// browsers can treat the course as JSON/plain text and the module JavaScript
// (including Previous/Next navigation) never runs.
header('Content-Type: text/html; charset=UTF-8');
$dataVersion = is_file($dataJsFile) ? (string) filemtime($dataJsFile) : '1';
$runtimeVersion = is_file($courseRuntimeFile) ? (string) filemtime($courseRuntimeFile) : '1';
$apiVersion = is_file($sharedApiFile) ? (string) filemtime($sharedApiFile) : '1';
$mainCssVersion = is_file($mainCssFile) ? (string) filemtime($mainCssFile) : '1';
$courseCssVersion = is_file($courseCssFile) ? (string) filemtime($courseCssFile) : '1';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($courseTitle ?? 'EAC Statistics E-Learning', ENT_QUOTES, 'UTF-8') ?></title>
<?php $faviconBasePath = '../'; include __DIR__ . '/favicon.php'; ?>
<link rel="stylesheet" href="../assets/css/main.css?v=<?= $mainCssVersion ?>">
<link rel="stylesheet" href="../assets/css/course.css?v=<?= $courseCssVersion ?>">
<?php if (!$isEmbedded): ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<?php endif; ?>
</head>
<body class="course-page">
<?php if (!$isEmbedded): ?>
<?php $basePath = '../'; $activePage = 'courses'; $headerVariant = 'standard'; include __DIR__ . '/header.php'; ?>
<?php endif; ?>
<main class="course-shell">
<?php include $contentFile; ?>
<?php if ($needsAssessmentScreen || $needsCertificateScreen): ?>
<?php include __DIR__ . '/course-runtime-screens.php'; ?>
<?php endif; ?>
</main>
<script>
window.COURSE = window.COURSE || <?= json_encode([
    'id' => (int)($courseId ?? 0),
    'title' => (string)($courseTitle ?? 'EAC Statistics E-Learning Course'),
    'short' => (string)($courseTitle ?? 'Course'),
    'code' => strtoupper((string)($courseKey ?? 'CRS')),
    'year' => (int)date('Y'),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<?php if (is_file($dataJsFile)): ?>
<script src="<?= htmlspecialchars($dataJs, ENT_QUOTES, 'UTF-8') ?>?v=<?= $dataVersion ?>"></script>
<?php endif; ?>
<script src="../assets/js/course.js?v=<?= $runtimeVersion ?>"></script>
<?php if (!$isEmbedded): ?>
<script>window.openModal = window.openModal || function(){ window.location.href = '../login.php'; };</script>
<script src="../assets/js/api.js?v=<?= $apiVersion ?>"></script>
<?php $basePath = '../'; include __DIR__ . '/footer.php'; ?>
<?php endif; ?>
</body>
</html>
