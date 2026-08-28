<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choose a new password — EAC Statistics e-Learning</title>
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<?php $basePath = ''; $activePage = 'auth'; $headerVariant = 'auth'; include __DIR__ . '/includes/header.php'; ?>

<main class="eac-login-page">
    <section class="eac-login-hero">
        <div class="eac-login-intro">
            <div class="eac-login-kicker">East African Community</div>
            <h1>Choose a new<br><span>secure password.</span></h1>
            <p>This password-reset link is valid for 30 minutes and can only be used once.</p>
        </div>
        <section class="eac-login-card" aria-labelledby="resetHeading">
            <h2 id="resetHeading">Reset your password</h2>
            <p>Use at least eight characters. After saving, sign in with your new password.</p>
            <form class="eac-login-form" id="resetPasswordForm">
                <label for="newPassword">New password</label>
                <input id="newPassword" type="password" minlength="8" required autocomplete="new-password">
                <label for="confirmPassword">Confirm new password</label>
                <input id="confirmPassword" type="password" minlength="8" required autocomplete="new-password">
                <div class="eac-login-error" id="resetError" role="alert"></div>
                <div id="resetStatus" class="eac-reset-status" role="status"></div>
                <button class="btn eac-login-submit" type="submit" id="resetSubmit">Save new password</button>
            </form>
            <div class="eac-login-footer"><a href="login.php">Back to sign in</a></div>
        </section>
    </section>
</main>

<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
<script>
(() => {
    const token = new URLSearchParams(window.location.search).get('token') || '';
    const form = document.getElementById('resetPasswordForm');
    const error = document.getElementById('resetError');
    const status = document.getElementById('resetStatus');
    const submit = document.getElementById('resetSubmit');

    const showError = message => {
        error.textContent = message;
        error.classList.add('show');
    };

    if (!/^[a-f0-9]{64}$/i.test(token)) {
        showError('This password-reset link is invalid or incomplete. Request a new link from the sign-in page.');
        form.querySelectorAll('input, button').forEach(element => { element.disabled = true; });
        return;
    }

    form.addEventListener('submit', async event => {
        event.preventDefault();
        error.classList.remove('show');
        status.className = 'eac-reset-status';
        const password = document.getElementById('newPassword').value;
        const confirmation = document.getElementById('confirmPassword').value;
        if (password.length < 8) {
            showError('Your new password must contain at least eight characters.');
            return;
        }
        if (password !== confirmation) {
            showError('The password confirmation does not match.');
            return;
        }
        submit.disabled = true;
        try {
            const result = await api.resetPassword(token, password);
            status.textContent = result.message || 'Password updated successfully. Redirecting to sign in…';
            status.className = 'eac-reset-status success';
            form.reset();
            window.setTimeout(() => window.location.replace('login.php'), 1400);
        } catch (requestError) {
            showError(requestError.message || 'Unable to update the password. Request a new reset link and try again.');
        } finally {
            submit.disabled = false;
        }
    });
})();
</script>
<?php $basePath = ''; include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
