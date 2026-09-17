<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/register.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register for your certificate — EAC Statistics e-Learning</title>
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>
    </head>
<body>
<?php $basePath = ""; $activePage = "register"; $headerVariant = "standard"; include __DIR__ . "/includes/header.php"; ?>

<main class="page">
<section class="card">
    <div class="intro">
        <h1>Register for your certificate</h1>
        <p>Registration is optional to browse the modules, but required to take the final assessment and receive a certificate. Fields marked * are required.</p>
    </div>

    <form id="registrationForm" autocomplete="on" novalidate>
        <div class="grid">
            <div>
                <label for="firstName">First name *</label>
                <input id="firstName" name="firstName" type="text" required autocomplete="given-name" spellcheck="false">
            </div>
            <div>
                <label for="middleName">Middle name <small>optional</small></label>
                <input id="middleName" name="middleName" type="text" autocomplete="additional-name" spellcheck="false">
            </div>
            <div>
                <label for="surname">Surname *</label>
                <input id="surname" name="surname" type="text" required autocomplete="family-name" spellcheck="false">
            </div>
            <div>
                <label for="sex">Sex *</label>
                <select id="sex" name="sex" required>
                    <option value="">Select…</option><option value="Female">Female</option><option value="Male">Male</option>
                </select>
            </div>
            <div>
                <label for="email">Email address *</label>
                <input id="email" name="email" type="email" required placeholder="name@example.org" autocomplete="email" spellcheck="false">
            </div>
            <div>
                <label for="organization">Organisation *</label>
                <input id="organization" name="organization" type="text" required autocomplete="organization" spellcheck="false">
            </div>
            <div>
                <label for="sector">Sector *</label>
                <select id="sector" name="sector" required>
                    <option value="">Select…</option>
                    <option>National Statistics Office</option><option>Central Bank</option>
                    <option>Ministry of Finance</option><option>Ministry of Agriculture</option>
                    <option>Other government</option><option>EAC organ/institution</option>
                    <option>Development partner</option><option>Private sector</option>
                    <option>Academia/research</option><option>Civil society/NGO</option>
                    <option>Media</option><option>Other</option>
                </select>
            </div>
            <div>
                <label for="country">Country *</label>
                <select id="country" name="country" required>
                    <option value="">Select…</option>
                    <option value="Burundi">Republic of Burundi</option><option value="Kenya">Republic of Kenya</option>
                    <option value="Rwanda">Republic of Rwanda</option><option value="Uganda">Republic of Uganda</option>
                    <option value="Tanzania">United Republic of Tanzania</option><option value="South Sudan">Republic of South Sudan</option>
                    <option value="Somalia">Federal Republic of Somalia</option><option value="DRC">Democratic Republic of the Congo</option>
                </select>
            </div>
            <div class="full">
                <label for="jobTitle">Role / job title <small>optional</small></label>
                <input id="jobTitle" name="jobTitle" type="text" autocomplete="organization-title" spellcheck="false">
            </div>
            <div>
                <label for="password">Password *</label>
                <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password">
            </div>
            <div>
                <label for="confirmPassword">Confirm password *</label>
                <input id="confirmPassword" name="confirmPassword" type="password" minlength="8" required autocomplete="new-password">
            </div>
        </div>

        <div id="registrationError" class="error" role="alert"></div>

        <div class="actions">
            <a href="index.php" class="btn back">← Back</a>
            <button id="registerButton" class="btn submit" type="submit">Submit</button>
        </div>
    </form>
    <p class="note">Your details are used only to personalise your experience and certificate within this session.</p>
</section>
</main>

<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
<script>
(function () {
    'use strict';

    const form = document.getElementById('registrationForm');
    const errorBox = document.getElementById('registrationError');
    const submitButton = document.getElementById('registerButton');

    // Keep typing inside registration fields. This prevents a Space key from
    // reaching page-level shortcuts or an accidentally focused control.
    function keepTypingInsideRegistrationForm(event) {
        const field = event.target;
        if (!field || !field.matches || !field.matches('input, textarea, select')) return;
        if (event.key === ' ' || event.code === 'Space') event.stopPropagation();
    }
    form.addEventListener('keydown', keepTypingInsideRegistrationForm);
    form.addEventListener('keypress', keepTypingInsideRegistrationForm);

    function showError(message) {
        errorBox.textContent = message || 'Registration failed.';
        errorBox.classList.add('show');
        submitButton.disabled = false;
        submitButton.textContent = 'Submit';
    }

    function value(id) {
        return document.getElementById(id).value.trim();
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        errorBox.classList.remove('show');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            showError('Passwords do not match.');
            return;
        }

        const firstName = value('firstName');
        const middleName = value('middleName');
        const surname = value('surname');
        const email = value('email');
        const organization = value('organization');
        const sex = document.getElementById('sex').value;
        const sector = document.getElementById('sector').value;
        const country = document.getElementById('country').value;
        const jobTitle = value('jobTitle');
        const fullName = [firstName, middleName, surname].filter(Boolean).join(' ');

        submitButton.disabled = true;
        submitButton.textContent = 'Creating account…';

        try {
            const data = await api.register(
                email,
                password,
                fullName,
                organization,
                { firstName, middleName, surname, sex, sector, country, jobTitle }
            );
            if (!data.success) throw new Error('Registration failed.');
            const pendingCourseId = Number(localStorage.getItem('pendingEnrollmentCourseId') || 0);

            if (pendingCourseId) {
                try {
                    await api.enrollCourse(pendingCourseId);
                    localStorage.removeItem('pendingEnrollmentCourseId');
                } catch (enrollmentError) {
                    console.warn('Enrollment will be retried after sign-in:', enrollmentError);
                }
            }

            window.location.href = pendingCourseId
                ? 'index.php?openCourse=' + encodeURIComponent(pendingCourseId)
                : 'index.php';

        } catch (err) {
            showError(err.message);
        }
    });
})();
</script>
<?php $basePath = ""; include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
