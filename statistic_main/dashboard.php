<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/pages/dashboard.css">


    <meta charset="UTF-8">

    <?php $faviconBasePath = ''; include __DIR__ . '/includes/favicon.php'; ?>

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard — EAC Statistics e-Learning
    </title>

    <meta
        name="description"
        content="EAC Statistics e-Learning learner dashboard"
    >

    <meta
        name="theme-color"
        content="#0c2340"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <!-- Main stylesheet -->
    </head>


<body>
<?php $basePath = ""; $activePage = "dashboard"; $headerVariant = "standard"; include __DIR__ . "/includes/header.php"; ?>



<!-- ==================================================
     HEADER
=================================================== -->

<!-- ==================================================
     MAIN PAGE
=================================================== -->

<main class="page-container">


    <!-- PAGE HEADER -->

    <div class="dashboard-header">

        <div class="dashboard-header-text">

            <h1 id="dashboardTitle">
                Learning Dashboard
            </h1>

            <p id="dashboardSubtitle">
                Track your courses, progress, certificates and learning activity.
            </p>

        </div>

    </div>


    <!-- ==================================================
         STATISTICS
    =================================================== -->

    <section
        class="stats-row"
        id="statsRow"
        aria-label="Learning statistics"
    >

        <div class="stat-card">

            <div class="stat-card-icon">
                <i class="fas fa-book-open"></i>
            </div>

            <div class="label">
                Active Courses
            </div>

            <div
                class="value"
                id="statEnrolled"
            >
                —
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-card-icon">
                <i class="fas fa-circle-check"></i>
            </div>

            <div class="label">
                Completed
            </div>

            <div
                class="value"
                id="statCompleted"
            >
                —
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-card-icon">
                <i class="fas fa-fire"></i>
            </div>

            <div class="label">
                Learning Streak
            </div>

            <div
                class="value"
                id="statStreak"
            >
                —
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-card-icon">
                <i class="fas fa-star"></i>
            </div>

            <div class="label">
                Total Points
            </div>

            <div
                class="value"
                id="statPoints"
            >
                —
            </div>

        </div>

    </section>


    <!-- ==================================================
         ENROLLED COURSES
    =================================================== -->

    <section class="panel dashboard-panel">

        <div class="dashboard-panel-header">

            <h2>
                <i class="fas fa-book-open"></i>
                My Enrolled Courses
            </h2>

        </div>


        <div id="enrolledList">

            <div class="dashboard-loading">

                <i class="fas fa-spinner fa-spin"></i>

                Loading your courses...

            </div>

        </div>

    </section>


    <!-- ==================================================
         CERTIFICATES
    =================================================== -->

    <section class="panel dashboard-panel">

        <div class="dashboard-panel-header">

            <h2>
                <i class="fas fa-certificate"></i>
                Certificates
            </h2>

        </div>


        <div id="certList">

            <div class="dashboard-loading">

                <i class="fas fa-spinner fa-spin"></i>

                Loading certificates...

            </div>

        </div>

    </section>


    <section class="panel dashboard-panel">
        <div class="dashboard-panel-header"><h2><i class="fas fa-bell"></i> Notifications</h2></div>
        <div id="notifications" class="dashboard-state">Loading notifications...</div>
    </section>

    <section class="panel dashboard-panel">
        <div class="dashboard-panel-header"><h2><i class="fas fa-award"></i> Achievements</h2></div>
        <div id="achievements" class="certificate-list"><div class="dashboard-loading">Loading achievements...</div></div>
    </section>

    <!-- ==================================================
         LEADERBOARD
    =================================================== -->

    <section class="panel dashboard-panel">

        <div class="dashboard-panel-header">

            <h2>
                <i class="fas fa-ranking-star"></i>
                Community Leaderboard
            </h2>

        </div>


        <div
            id="leaderboard"
            class="leaderboard-wrapper"
        >

            <div class="dashboard-loading">

                <i class="fas fa-spinner fa-spin"></i>

                Loading leaderboard...

            </div>

        </div>

    </section>

</main>


<!-- ==================================================
     API
=================================================== -->

<script src="assets/js/api.js?v=<?= (int) filemtime(__DIR__ . '/assets/js/api.js') ?>"></script>


<script>

    /* ==================================================
       AUTHENTICATION
    ================================================== */

    // requireAuth() is now part of the global api.js and will handle showing the login modal
    // if the user is not authenticated. It's called on DOMContentLoaded.
    if (typeof api === "undefined" || !api.isAuthenticated()) {
        window.location.href = "index.php"; // Redirect to the main application page
    }


    /* ==================================================
       SECURITY
       Escape API data before using innerHTML.
    ================================================== */

    function escapeHTML(value) {

        return String(value ?? "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    }


    /* ==================================================
       DOM READY
    ================================================== */

    document.addEventListener(
        "DOMContentLoaded",
        async function() {

            const user =
                api.getUser();


            /* ==========================================
               USER INFORMATION
            ========================================== */

            if (user) {

                const firstName =
                    (user.fullName || "User")
                    .trim()
                    .split(/\s+/)[0];

                const avatar =
                    firstName
                        .charAt(0)
                        .toUpperCase() || "U";


                document.getElementById(
                    "userName"
                ).textContent =
                    firstName;


                document.getElementById(
                    "userAvatar"
                ).textContent =
                    avatar;


                document.getElementById(
                    "dashboardTitle"
                ).textContent =
                    `Welcome back, ${firstName}`;


                document.getElementById(
                    "dashboardSubtitle"
                ).textContent =
                    "Track your learning progress, courses and achievements.";

            }


            /* ==========================================
               DASHBOARD STATISTICS
            ========================================== */

            try {

                const stats =
                    await api.getDashboardStats();


                document.getElementById(
                    "statEnrolled"
                ).textContent =
                    stats.enrolledCourses ?? 0;


                document.getElementById(
                    "statCompleted"
                ).textContent =
                    stats.completedCourses ?? 0;


                document.getElementById(
                    "statStreak"
                ).textContent =
                    `${stats.currentStreak ?? 0} days`;


                document.getElementById(
                    "statPoints"
                ).textContent =
                    Number(
                        stats.totalPoints ?? 0
                    ).toLocaleString();


                /* ======================================
                   LEADERBOARD RANK
                ====================================== */

                if (
                    stats.leaderboardRank
                ) {

                    const rankCard =
                        document.createElement(
                            "div"
                        );

                    rankCard.className =
                        "stat-card";


                    rankCard.innerHTML = `

                        <div class="stat-card-icon">
                            <i class="fas fa-ranking-star"></i>
                        </div>

                        <div class="label">
                            Leaderboard Rank
                        </div>

                        <div
                            class="value"
                            id="statRank"
                        >
                            #${escapeHTML(
                                stats.leaderboardRank
                            )}
                        </div>

                    `;


                    document
                        .getElementById("statsRow")
                        .appendChild(rankCard);


                    const currentRank =
                        Number(
                            stats.leaderboardRank
                        );


                    const storageKey =
                        user
                            ? `prevRank_${user.id}`
                            : null;


                    const previousRank =
                        storageKey
                            ? localStorage.getItem(
                                storageKey
                            )
                            : null;


                    if (
                        previousRank &&
                        Number(previousRank) !== currentRank
                    ) {

                        const change =
                            Number(previousRank)
                            - currentRank;


                        const rankElement =
                            document.getElementById(
                                "statRank"
                            );


                        const indicator =
                            document.createElement(
                                "span"
                            );


                        indicator.className =
                            change > 0
                                ? "rank-change up"
                                : "rank-change down";


                        indicator.title =
                            change > 0
                                ? `Improved by ${change} position(s)`
                                : `Dropped by ${Math.abs(change)} position(s)`;


                        indicator.innerHTML =
                            change > 0
                                ? '<i class="fas fa-arrow-up"></i>'
                                : '<i class="fas fa-arrow-down"></i>';


                        rankElement.appendChild(
                            indicator
                        );

                    }


                    if (storageKey) {

                        localStorage.setItem(
                            storageKey,
                            currentRank
                        );

                    }

                }

            } catch (error) {

                console.error(
                    "Dashboard statistics error:",
                    error
                );

            }


            /* ==========================================
               ENROLLED COURSES
            ========================================== */

            try {

                const enrolled =
                    await api.getEnrolledCourses();


                const list =
                    document.getElementById(
                        "enrolledList"
                    );


                if (
                    !Array.isArray(enrolled) ||
                    enrolled.length === 0
                ) {

                    list.innerHTML = `

                        <div class="dashboard-state">

                            <i class="fas fa-book-open"></i>

                            <p>
                                No enrolled courses yet.
                            </p>

                            <p>
                                <a
                                    href="index.php"
                                    class="btn btn-sm btn-primary"
                                >
                                    Browse Courses
                                </a>
                            </p>

                        </div>

                    `;

                } else {

                    list.innerHTML =
                        enrolled.map(course => {

                            const progress =
                                Math.min(
                                    100,
                                    Math.max(
                                        0,
                                        Number(
                                            course.progress ?? 0
                                        )
                                    )
                                );


                            return `

                                <article
                                    class="dashboard-course-item"
                                >

                                    <div
                                        class="dashboard-course-info"
                                    >

                                        <h4>
                                            ${escapeHTML(
                                                course.title
                                            )}
                                        </h4>

                                        <div
                                            class="dashboard-course-meta"
                                        >

                                            <span>
                                                ${escapeHTML(
                                                    course.category
                                                    || "General"
                                                )}
                                            </span>

                                            <span>
                                                ·
                                            </span>

                                            <span>
                                                ${escapeHTML(
                                                    course.duration
                                                    || "Self-paced"
                                                )}
                                            </span>

                                        </div>

                                    </div>


                                    <div
                                        class="dashboard-course-action"
                                    >

                                        <div
                                            class="dashboard-progress"
                                            role="progressbar"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                            aria-valuenow="${progress}"
                                            aria-label="Course progress"
                                        >

                                            <div
                                                class="dashboard-progress-fill page-inline-1"
                                            ></div>

                                        </div>


                                        <span
                                            class="dashboard-progress-value"
                                        >
                                            ${progress}%
                                        </span>


                                        <a
                                            href="index.php?openCourse=${encodeURIComponent(course.id)}&resume=1"
                                            class="btn btn-sm btn-primary"
                                            data-course-id="${escapeHTML(
                                                course.id
                                            )}"
                                        >
                                            Continue
                                        </a>

                                    </div>

                                </article>

                            `;

                        }).join("");



                    /* Save selected course */
                    list
                        .querySelectorAll(
                            "[data-course-id]"
                        )
                        .forEach(button => {

                            button.addEventListener(
                                "click",
                                function() {

                                    localStorage.setItem(
                                        "openCourseId",
                                        this.dataset.courseId
                                    );

                                }
                            );

                        });

                }

            } catch (error) {

                console.error(
                    "Enrolled courses error:",
                    error
                );


                document.getElementById(
                    "enrolledList"
                ).innerHTML = `

                    <div class="dashboard-state dashboard-error">

                        <i class="fas fa-circle-exclamation"></i>

                        <p>
                            Unable to load your courses.
                        </p>

                        <p>
                            Please try again later.
                        </p>

                    </div>

                `;

            }


            window.downloadLearnerCertificate = async function(certificateId, certificateNumber) {
                try {
                    const blob = await api.downloadCertificatePdf(certificateId);
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'EAC_Certificate_' + String(certificateNumber || 'certificate').replace(/[^a-z0-9._-]+/gi, '_') + '.pdf';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    setTimeout(() => URL.revokeObjectURL(url), 2000);
                } catch (error) {
                    console.error('Certificate download error:', error);
                    alert(error.message || 'Could not download certificate.');
                }
            };

            /* ==========================================
               CERTIFICATES
            ========================================== */

            try {

                const certificates =
                    await api.getCertificates();


                const list =
                    document.getElementById(
                        "certList"
                    );


                if (
                    !Array.isArray(certificates) ||
                    certificates.length === 0
                ) {

                    list.innerHTML = `

                        <div class="dashboard-state">

                            <i class="fas fa-certificate"></i>

                            <p>
                                You have not earned any certificates yet.
                            </p>

                            <p>
                                Complete a course to earn your first certificate.
                            </p>

                        </div>

                    `;

                } else {

                    list.innerHTML = `

                        <div class="certificate-list">

                            ${certificates.map(
                                certificate => `

                                    <article
                                        class="certificate-card"
                                    >

                                        <div
                                            class="certificate-icon"
                                        >
                                            <i class="fas fa-certificate"></i>
                                        </div>

                                        <h4>
                                            ${escapeHTML(
                                                certificate.courseName
                                            )}
                                        </h4>

                                        <p
                                            class="certificate-number"
                                        >
                                            ${escapeHTML(
                                                certificate.certificateNumber
                                            )}
                                        </p>

                                        <p
                                            class="certificate-date"
                                        >
                                            Issued
                                            ${certificate.issuedAt
                                                ? new Date(
                                                    certificate.issuedAt
                                                ).toLocaleDateString()
                                                : "—"
                                            }
                                        </p>
                                        <button class="btn btn-outline btn-sm" type="button" onclick="downloadLearnerCertificate(${Number(certificate.id)}, '${escapeHTML(certificate.certificateNumber)}')">
                                            <i class="fas fa-download"></i> Download PDF
                                        </button>

                                    </article>

                                `
                            ).join("")}

                        </div>

                    `;

                }

            } catch (error) {

                console.error(
                    "Certificate loading error:",
                    error
                );


                document.getElementById(
                    "certList"
                ).innerHTML = `

                    <div class="dashboard-state dashboard-error">

                        <i class="fas fa-circle-exclamation"></i>

                        <p>
                            Unable to load certificates.
                        </p>

                    </div>

                `;

            }


            /* ==========================================
               LEADERBOARD
            ========================================== */

            try {

                const board =
                    await api.getLeaderboard();


                const element =
                    document.getElementById(
                        "leaderboard"
                    );


                if (
                    !Array.isArray(board) ||
                    board.length === 0
                ) {

                    element.innerHTML = `

                        <div class="dashboard-state">

                            <i class="fas fa-ranking-star"></i>

                            <p>
                                No leaderboard data yet.
                            </p>

                        </div>

                    `;

                } else {

                    element.innerHTML = `

                        <table
                            class="leaderboard-table"
                        >

                            <thead>

                                <tr>

                                    <th scope="col">
                                        Rank
                                    </th>

                                    <th scope="col">
                                        Learner
                                    </th>

                                    <th scope="col">
                                        Points
                                    </th>

                                    <th scope="col">
                                        Completed
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                ${board.map(
                                    (entry, index) => {

                                        const rank =
                                            Number(entry.rank || index + 1);


                                        const isCurrentUser =
                                            user &&
                                            entry.id &&
                                            String(
                                                entry.id
                                            ) === String(
                                                user.id
                                            );


                                        return `

                                            <tr
                                                class="${
                                                    isCurrentUser
                                                        ? "current-user"
                                                        : ""
                                                }"
                                            >

                                                <td>

                                                    <span
                                                        class="
                                                            rank-badge
                                                            ${
                                                                rank <= 3
                                                                    ? `rank-${rank}`
                                                                    : ""
                                                            }
                                                        "
                                                    >
                                                        ${rank}
                                                    </span>

                                                </td>


                                                <td>

                                                    ${escapeHTML(
                                                        entry.fullName
                                                    )}

                                                    ${
                                                        isCurrentUser
                                                            ? " (You)"
                                                            : ""
                                                    }

                                                </td>


                                                <td>

                                                    ${Number(
                                                        entry.totalPoints
                                                        || 0
                                                    ).toLocaleString()}

                                                </td>


                                                <td>

                                                    ${Number(
                                                        entry.coursesCompleted
                                                        || 0
                                                    )}

                                                </td>

                                            </tr>

                                        `;

                                    }
                                ).join("")}

                            </tbody>

                        </table>

                    `;

                }

            } catch (error) {

                console.error(
                    "Leaderboard loading error:",
                    error
                );


                document.getElementById(
                    "leaderboard"
                ).innerHTML = `

                    <div class="dashboard-state dashboard-error">

                        <i class="fas fa-circle-exclamation"></i>

                        <p>
                            Unable to load leaderboard.
                        </p>

                    </div>

                `;

            }

        });

</script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const esc = value => String(value ?? '').replace(/[&<>"']/g, ch => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[ch]));
    try {
        const [n, a] = await Promise.all([api.getNotifications(), api.getAchievements()]);
        const notifications = n.notifications || [];
        document.getElementById('notifications').innerHTML = notifications.length ? notifications.map(item => `<article class="dashboard-course-item"><div><strong>${esc(item.title)}</strong><p>${esc(item.message)}</p><small>${esc(item.createdAt)}</small></div>${item.readAt ? '' : `<button class="btn btn-outline btn-sm" onclick="api.markNotificationRead(${Number(item.id)}).then(()=>this.remove())">Mark read</button>`}</article>`).join('') : '<p>No new notifications.</p>';
        const achievements = Array.isArray(a) ? a : (a.achievements || []);
        document.getElementById('achievements').innerHTML = achievements.length ? achievements.map(item => `<article class="certificate-card"><div class="certificate-icon"><i class="fas fa-award"></i></div><h4>${esc(item.badgeName)}</h4><p>${esc(item.description || '')}</p><small>${esc(item.unlockedAt || '')}</small></article>`).join('') : '<div class="dashboard-state">Complete quizzes and courses to unlock badges.</div>';
    } catch (error) { document.getElementById('notifications').textContent = 'Notifications are unavailable until the platform database upgrade is run.'; }
});
</script>

<?php $basePath = ""; include __DIR__ . "/includes/footer.php"; ?>
</body>

</html>
