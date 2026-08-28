<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/login.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — EAC Statistics e-Learning</title>
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
<body>
<?php $basePath = ""; $activePage = "auth"; $headerVariant = "auth"; include __DIR__ . "/includes/header.php"; ?>

<main class="eac-login-page">
    <section class="eac-login-hero">
        <div class="eac-login-intro">
            <div class="eac-login-kicker">East African Community</div>
            <h1>Learn. Apply.<br><span>Strengthen statistics.</span></h1>
            <p>Sign in to continue your self-paced learning journey across EAC official statistics courses. Track progress, complete assessments and access your certificates in one place.</p>
            <div class="eac-login-points"><span><i class="fas fa-unlock"></i> Open learning</span><span><i class="fas fa-chart-line"></i> Track progress</span><span><i class="fas fa-certificate"></i> EAC certificates</span></div>
        </div>
        <section class="eac-login-card" aria-labelledby="loginHeading">
            <h2 id="loginHeading">Welcome back</h2><p>Sign in to access your learner dashboard and continue where you left off.</p>
            <form class="eac-login-form" id="loginPageForm">
                <label for="email">Email address</label><input id="email" type="email" required autocomplete="email" placeholder="name@example.org">
                <label for="password">Password</label><input id="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
                <div class="eac-login-error" id="error" role="alert"></div>
                <button class="btn eac-login-submit" type="submit"><i class="fas fa-right-to-bracket"></i> Sign in</button>
            </form>
            <div class="eac-login-help"><button type="button" class="btn btn-outline btn-sm" id="forgotPasswordLink"><i class="fas fa-key"></i> Reset password</button><a href="register.php">Create an account</a></div>
            <div id="resetPanel" class="eac-reset-panel" hidden><h3>Reset your password</h3><p>Enter your registered email address and we will send reset instructions if the account exists.</p><form id="resetForm"><label for="resetEmail">Email address</label><input id="resetEmail" type="email" required placeholder="name@example.org"><div id="resetStatus" class="eac-reset-status" role="status"></div><div class="eac-reset-actions"><button type="button" class="btn btn-outline btn-sm" id="cancelReset">Cancel</button><button type="submit" class="btn btn-primary btn-sm">Send reset link</button></div></form></div>
            <div class="eac-login-footer">Administrator? <a href="admin-login.php">Sign in to administration</a></div>
        </section>
    </section>
</main>
<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
<script>
document.getElementById('loginPageForm').addEventListener('submit',async event=>{event.preventDefault();const error=document.getElementById('error');error.classList.remove('show');try{const result=await api.login(document.getElementById('email').value.trim(),document.getElementById('password').value);location.href=result.user?.role==='admin'?'admin.php':'index.php';}catch(e){error.textContent=e.message||'Sign in failed.';error.classList.add('show');}});
document.getElementById('forgotPasswordLink').addEventListener('click',()=>{const panel=document.getElementById('resetPanel');panel.hidden=false;document.getElementById('resetEmail').value=document.getElementById('email').value.trim();document.getElementById('resetEmail').focus();});document.getElementById('cancelReset').addEventListener('click',()=>{document.getElementById('resetPanel').hidden=true;});document.getElementById('resetForm').addEventListener('submit',async event=>{event.preventDefault();const status=document.getElementById('resetStatus');status.className='eac-reset-status';try{const result=await api.requestPasswordReset(document.getElementById('resetEmail').value.trim());status.textContent=result.message||'If the account exists, reset instructions will be sent.';status.className='eac-reset-status success';}catch(e){status.textContent=e.message||'Unable to request password reset.';status.className='eac-reset-status error';}});
</script>
<?php $basePath = ""; include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
