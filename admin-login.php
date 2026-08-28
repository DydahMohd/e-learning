<?php
declare(strict_types=1);
$adminLoginError = '';
$adminLoginSession = null;
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_once __DIR__ . '/api/config.php';
    require_once __DIR__ . '/api/Database.php';
    header('Content-Type: text/html; charset=UTF-8');
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');
    try {
        $statement = Database::connect()->prepare('SELECT id,email,password,fullName,role,organization FROM users WHERE email=? LIMIT 1');
        $statement->execute([$email]);
        $admin = $statement->fetch();
        if (!$admin || !password_verify($password, (string)$admin['password'])) {
            $adminLoginError = 'Invalid administrator email or password.';
        } elseif (($admin['role'] ?? '') !== 'admin') {
            $adminLoginError = 'This account does not have administrator privileges.';
        } else {
            $userId = (int)$admin['id'];
            Database::connect()->prepare('UPDATE users SET lastLoginAt=NOW() WHERE id=?')->execute([$userId]);
            $user = ['id'=>$userId,'fullName'=>$admin['fullName'],'email'=>$admin['email'],'role'=>$admin['role'],'organization'=>$admin['organization']];
            $adminLoginSession = ['token'=>createToken($userId, (string)$admin['email'], 'admin'),'user'=>$user];
        }
    } catch (Throwable $error) {
        error_log('Administrator login failed: ' . $error->getMessage());
        $adminLoginError = 'Administrator sign in is temporarily unavailable.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrator Sign In — EAC Statistics e-Learning</title>
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
    <link rel="stylesheet" href="assets/css/main.css?v=<?= (int)filemtime(__DIR__ . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="assets/css/pages/admin-login.css?v=<?= (int)filemtime(__DIR__ . '/assets/css/pages/admin-login.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php $basePath = ''; $activePage = 'admin-login'; $headerVariant = 'auth'; include __DIR__ . '/includes/header.php'; ?>
<main class="admin-auth">
    <section class="admin-card">
        <img class="crest" src="images/eac-crest.png" alt="East African Community">
        <h1>Administrator Access</h1>
        <p class="sub">EAC Statistics e-Learning Administration</p>
        <form id="adminForm" action="admin-login.php" method="post">
            <div class="field"><label for="email">Administrator email</label><input id="email" name="email" type="email" required autocomplete="username" value="<?= htmlspecialchars((string)($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"></div>
            <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
            <div class="admin-error" id="error"<?= $adminLoginError !== '' ? ' style="display:block"' : '' ?>><?= htmlspecialchars($adminLoginError, ENT_QUOTES, 'UTF-8') ?></div>
            <button class="btn btn-primary page-inline-1" type="submit"><i class="fas fa-shield-halved"></i> Sign in as administrator</button>
        </form>
        <p class="admin-note"><a href="index.php">Return to learner portal</a></p>
    </section>
</main>
<?php if ($adminLoginSession): ?>
<script>
localStorage.setItem('authToken', <?= json_encode($adminLoginSession['token']) ?>);
localStorage.setItem('user', <?= json_encode(json_encode($adminLoginSession['user'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>);
window.location.replace('admin.php');
</script>
<?php endif; ?>
<?php $basePath = ''; include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
