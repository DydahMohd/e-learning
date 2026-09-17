<?php
$basePath = $basePath ?? '';
$activePage = $activePage ?? '';
$headerVariant = $headerVariant ?? 'standard';
?>
<?php if ($headerVariant === 'auth'): ?>
<header class="eac-login-topbar">
    <a class="eac-login-brand-link" href="<?= htmlspecialchars($basePath) ?>index.php" aria-label="EAC Statistics e-Learning Home">
        <img src="<?= htmlspecialchars($basePath) ?>images/eac-crest.png" alt="East African Community Logo">
        <span class="eac-login-brand"><strong>EAC E-Learning</strong><span>STATISTICS PORTAL</span></span>
    </a>
    <div class="spacer"></div>
    <a class="eac-login-back" href="<?= htmlspecialchars($basePath) ?>index.php"><i class="fas fa-book-open"></i> Course catalogue</a>
    <a class="eac-login-back" href="<?= htmlspecialchars($basePath) ?>dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
</header>
<?php else: ?>
<header class="site-header <?= $activePage === 'admin' ? 'site-header-admin' : '' ?>" <?= $activePage === 'dashboard' ? 'data-auth-required="true"' : '' ?>>
    <button type="button" class="btn-icon menu-toggle" id="menuToggle" aria-label="Toggle course menu">
        <i class="fas fa-bars"></i>
    </button>
    <a href="<?= htmlspecialchars($basePath) ?>index.php" class="header-brand" aria-label="EAC Statistics e-Learning Home">
        <div class="brand-mark">
            <img src="<?= htmlspecialchars($basePath) ?>images/eac-crest.png" alt="East African Community Logo">
        </div>
        <div class="brand-text">
            <h1>EAC E-Learning</h1>
            <span><?= $activePage === 'admin' ? 'Administration' : 'Statistics Portal' ?></span>
        </div>
    </a>
    <nav class="header-nav" aria-label="Main navigation">
        <a href="<?= htmlspecialchars($basePath) ?>index.php" class="nav-link <?= $activePage === 'courses' ? 'active' : '' ?>" id="platformHomeLink" data-platform-home <?= $activePage === 'courses' ? 'aria-current="page"' : '' ?>>
            <i class="fas fa-house"></i> <span>Home</span>
        </a>

        <div class="nav-dropdown" id="courseNavDropdown">
            <button type="button" class="nav-link nav-dropdown-toggle" id="courseNavToggle" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-book-open"></i> <span>Course</span> <i class="fas fa-chevron-down nav-dropdown-chevron" aria-hidden="true"></i>
            </button>
            <div class="nav-dropdown-menu" id="courseNavMenu" role="menu" aria-label="Course navigation">
                <a href="<?= htmlspecialchars($basePath) ?>index.php" class="nav-dropdown-item" role="menuitem" data-course-action="catalogue">
                    <i class="fas fa-table-cells-large"></i><span>All Courses</span>
                </a>
                <button type="button" class="nav-dropdown-item course-context-item" role="menuitem" data-course-action="modules" disabled>
                    <i class="fas fa-list-check"></i><span>Modules</span>
                </button>
                <button type="button" class="nav-dropdown-item course-context-item" role="menuitem" data-course-action="assessment" disabled>
                    <i class="fas fa-clipboard-check"></i><span>Assessment</span>
                </button>
                <button type="button" class="nav-dropdown-item course-context-item" role="menuitem" data-course-action="resources" disabled>
                    <i class="fas fa-folder-open"></i><span>Resources</span>
                </button>
            </div>
        </div>

        <a href="<?= htmlspecialchars($basePath) ?>dashboard.php" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>" data-auth-required>
            <i class="fas fa-chart-line"></i> <span data-i18n="dashboard">Dashboard</span>
        </a>
        <a href="<?= htmlspecialchars($basePath) ?>forum.php" class="nav-link <?= $activePage === 'forum' ? 'active' : '' ?>">
            <i class="fas fa-comments"></i> <span data-i18n="forum">Forum</span>
        </a>
        <a href="<?= htmlspecialchars($basePath) ?>admin.php" class="nav-link <?= $activePage === 'admin' ? 'active' : '' ?> hidden" data-admin-only>
            <i class="fas fa-shield-halved"></i> Admin
        </a>
    </nav>
    <div class="header-actions">
        <label class="sr-only" for="languageSelect">Language</label>
        <select id="languageSelect" data-language aria-label="Choose language" class="language-select">
            <option value="en">EN</option><option value="sw">SW</option><option value="fr">FR</option>
        </select>
        <button type="button" class="btn-icon theme-toggle" id="themeToggle" aria-label="Switch to dark mode"><i class="fas fa-moon" aria-hidden="true"></i><span>Eye comfort</span></button>
        <div class="user-chip" id="userChip">
            <div class="user-avatar" id="userAvatar" aria-hidden="true">U</div>
            <span id="userName">User</span>
        </div>
        <a class="btn btn-ghost-white btn-sm hidden" href="<?= htmlspecialchars($basePath) ?>admin.php" data-admin-only id="adminDashboardBtn">
            <i class="fas fa-shield-halved"></i> Admin Dashboard
        </a>
        <button type="button" class="btn btn-ghost-white btn-sm" id="authBtn">Sign In</button>
        <a class="btn btn-gold btn-sm" href="<?= htmlspecialchars($basePath) ?>register.php" data-guest-only>Register</a>
        <button type="button" class="btn btn-ghost-white btn-sm hidden" id="logoutBtn"><i class="fas fa-right-from-bracket"></i> Sign Out</button>
    </div>
</header>
<?php endif; ?>
