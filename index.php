<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/main.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="assets/css/pages/index.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/pages/index.css') ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAC Statistics e-Learning</title>
    <meta name="description" content="The official e-learning platform for the East African Community, offering courses on statistics and data analysis.">
    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main Stylesheet -->
    </head>
<body>
<?php $basePath = ""; $activePage = "courses"; $headerVariant = "standard"; include __DIR__ . "/includes/header.php"; ?>


    <!-- App Header -->
    <!-- Main App Layout -->
    <div class="app-layout">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay"></div>

        <!-- Sidebar for Course Navigation -->
        <aside class="sidebar" id="sidebar">
            <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-controls="sidebar" aria-expanded="true" aria-label="Collapse course menu" title="Collapse course menu">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                <span class="sr-only">Collapse course menu</span>
            </button>
            <div class="sidebar-section">
                <h3><i class="fas fa-book"></i> All Courses</h3>
                <nav id="sidebarNav" aria-label="Course list">
                    <!-- Course links will be dynamically inserted here by app.js -->
                    <p class="sidebar-empty">Loading courses...</p>
                </nav>
            </div>
        </aside>

        <!-- Resizer -->
        <div class="sidebar-resizer" id="sidebarResizer" title="Drag to resize"></div>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Welcome Panel / Course Grid -->
            <div class="welcome-panel" id="welcomePanel">
                <div class="welcome-inner">
                    <header class="welcome-hero">
                        <h2>Welcome to the EAC e-Learning Portal</h2>
                        <p>Select a course from the sidebar to begin your learning journey, or browse available courses below.</p>
                    </header>
                    <div class="course-search" role="search">
                        <label for="courseSearch"><i class="fas fa-search"></i> Search courses</label>
                        <input id="courseSearch" type="search" placeholder="Search by title, topic or category" autocomplete="off">
                    </div>
                    <div class="course-grid" id="courseGrid">
                        <!-- Course cards will be dynamically inserted here by app.js -->
                    </div>
                </div> 
            </div>

            <!-- Course Content Toolbar -->
            <div class="content-toolbar hidden" id="contentToolbar">
                <h2 id="activeCourseTitle">Course Title</h2>
                <div class="content-toolbar-actions">
                    <button type="button" class="btn btn-primary btn-sm toolbar-module-read hidden" id="markCurrentModuleReadBtn" title="Mark the current module as read">
                        <i class="fas fa-check" aria-hidden="true"></i> Mark as read
                    </button>
                    <button type="button" class="btn btn-outline btn-sm toolbar-mark-all-read hidden" id="markAllModulesReadBtn" title="Mark all modules as read and open the final assessment">
                        <i class="fas fa-check-double" aria-hidden="true"></i> Mark all modules as read
                    </button>
                    <div class="progress-track" role="progressbar" aria-label="Course progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-fill page-inline-2" id="courseProgress"></div>
                    </div>
                </div>
            </div>

            <!-- Iframe for Course Content -->
            <div class="content-frame-wrap hidden" id="contentFrameWrap">
                <iframe id="contentFrame" name="contentFrame" title="Course Content" src="about:blank" scrolling="no"></iframe>
            </div>
        </main>
    </div>

    <!-- Login Modal -->
    <div class="modal-overlay" id="loginModal" hidden aria-hidden="true">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="loginHeading">
            <div class="modal-header">
                <h3 id="loginHeading">Sign In</h3>
                <button class="modal-close" onclick="closeModal('loginModal')" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" name="email" required autocomplete="username" inputmode="email">
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-error" id="loginError"></div>
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </form>
                <div class="form-footer">
                    Don't have an account? <a href="register.php">Register</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container"></div>

    <!-- Core Scripts -->
    <script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>
    <script src="assets/js/app.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/app.js') ?>"></script>

<?php $basePath = ""; include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
