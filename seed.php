<?php

declare(strict_types=1);

if ((getenv('APP_ENV') ?: 'development') === 'production') {
    fwrite(STDERR, "Refusing to seed demo data in production.\n");
    exit(1);
}

require_once __DIR__ . '/api/config.php';
require_once __DIR__ . '/api/Database.php';

try {

    $db = Database::connect();

    echo "Connected to MariaDB successfully.\n\n";


    /* =========================================================
       COURSES
    ========================================================= */

    $courses = [

        [
            'fns',
            'Food and Nutrition Security',
            'Statistical methods for agriculture and food security analysis across EAC partner states.',
            'Agriculture',
            'Intermediate',
            '4 weeks',
            'courses/agriculture.php',
            'fa-seedling'
        ],

        [
            'fsi',
            'Financial Sector Indicators',
            'Core indicators for monitoring financial sector stability and development in the EAC region.',
            'Finance',
            'Advanced',
            '4 weeks',
            'courses/fsi.php',
            'fa-chart-line'
        ],

        [
            'gfs',
            'Government Finance Statistics',
            'Compilation and analysis of government revenue, expenditure, and fiscal balances.',
            'Public Finance',
            'Intermediate',
            '5 weeks',
            'courses/gfs.php',
            'fa-landmark'
        ],

        [
            'psds',
            'Public Sector Debt Statistics',
            'Standards and practices for measuring and reporting public sector debt.',
            'Public Finance',
            'Advanced',
            '4 weeks',
            'courses/psds.php',
            'fa-file-invoice-dollar'
        ],

        [
            'mfs',
            'Monetary and Financial Statistics',
            'Framework for monetary aggregates, credit, and financial market statistics.',
            'Finance',
            'Intermediate',
            '5 weeks',
            'courses/mfs.php',
            'fa-coins'
        ],

        [
            'poverty',
            'Poverty Statistics',
            'Methodologies for poverty measurement, inequality analysis, and social indicators.',
            'Social Statistics',
            'Beginner',
            '4 weeks',
            'courses/poverty.php',
            'fa-users'
        ],

        [
            'ess',
            'External Sector Statistics',
            'Balance of payments, international investment position, and trade statistics.',
            'International Trade',
            'Advanced',
            '5 weeks',
            'courses/ess.php',
            'fa-globe-africa'
        ]

    ];


    $courseStatement = $db->prepare("
        INSERT INTO courses
        (
            slug,
            title,
            description,
            category,
            difficulty,
            duration,
            contentPath,
            icon
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            title = VALUES(title),
            description = VALUES(description),
            category = VALUES(category),
            difficulty = VALUES(difficulty),
            duration = VALUES(duration),
            contentPath = VALUES(contentPath),
            icon = VALUES(icon)
    ");


    foreach ($courses as $course) {

        $courseStatement->execute($course);

    }


    echo "Courses seeded successfully.\n";


    /* =========================================================
       DEMO STUDENT
    ========================================================= */

    $userStatement = $db->prepare("
        SELECT id
        FROM users
        WHERE email = ?
        LIMIT 1
    ");

    $userStatement->execute([
        'demo@eac.org'
    ]);

    $demoUser = $userStatement->fetch();


    if (!$demoUser) {

        $password = password_hash(
            'demo123',
            PASSWORD_DEFAULT
        );

        $insertUser = $db->prepare("
            INSERT INTO users
            (
                email,
                password,
                fullName,
                role,
                organization
            )
            VALUES (?, ?, ?, ?, ?)
        ");

        $insertUser->execute([
            'demo@eac.org',
            $password,
            'Demo Student',
            'student',
            'EAC Secretariat'
        ]);

        $demoUserId =
            (int) $db->lastInsertId();

        echo "Demo student created.\n";

    } else {

        $demoUserId =
            (int) $demoUser['id'];

        echo "Demo student already exists.\n";

    }


    /* =========================================================
       DEMO STUDENT STREAK
    ========================================================= */

    $streakStatement = $db->prepare("
        INSERT INTO learning_streaks
        (
            userId,
            currentStreak,
            maxStreak,
            totalPoints
        )
        VALUES (?, 3, 3, 150)
        ON DUPLICATE KEY UPDATE
            currentStreak = VALUES(currentStreak),
            maxStreak = VALUES(maxStreak),
            totalPoints = VALUES(totalPoints)
    ");

    $streakStatement->execute([
        $demoUserId
    ]);


    /* =========================================================
       DEMO ENROLLMENTS
    ========================================================= */

    $enrollmentStatement = $db->prepare("
        INSERT INTO enrollments
        (
            userId,
            courseId,
            progress,
            status
        )
        VALUES (?, ?, ?, 'active')
        ON DUPLICATE KEY UPDATE
            progress = VALUES(progress),
            status = VALUES(status)
    ");


    $enrollmentStatement->execute([
        $demoUserId,
        1,
        45
    ]);


    $enrollmentStatement->execute([
        $demoUserId,
        3,
        20
    ]);


    echo "Demo enrollments created.\n";


    /* =========================================================
       ADMIN
    ========================================================= */

    $adminStatement = $db->prepare("
        SELECT id
        FROM users
        WHERE email = ?
        LIMIT 1
    ");

    $adminStatement->execute([
        'admin@eac.org'
    ]);

    $adminUser = $adminStatement->fetch();


    if (!$adminUser) {

        $password = password_hash(
            'admin123',
            PASSWORD_DEFAULT
        );

        $insertAdmin = $db->prepare("
            INSERT INTO users
            (
                email,
                password,
                fullName,
                role,
                organization
            )
            VALUES (?, ?, ?, ?, ?)
        ");

        $insertAdmin->execute([
            'admin@eac.org',
            $password,
            'Admin User',
            'admin',
            'IT Department'
        ]);

        $adminUserId =
            (int) $db->lastInsertId();

        echo "Admin user created.\n";

    } else {

        $adminUserId =
            (int) $adminUser['id'];

        echo "Admin user already exists.\n";

    }


    /* =========================================================
       ADMIN STREAK
    ========================================================= */

    $adminStreak = $db->prepare("
        INSERT INTO learning_streaks
        (
            userId,
            currentStreak,
            maxStreak,
            totalPoints
        )
        VALUES (?, 0, 0, 0)
        ON DUPLICATE KEY UPDATE
            userId = userId
    ");

    $adminStreak->execute([
        $adminUserId
    ]);


    echo "\n";
    echo "=====================================\n";
    echo "SEEDING COMPLETED SUCCESSFULLY\n";
    echo "=====================================\n";

} catch (Throwable $e) {

    echo "\n";
    echo "SEEDING FAILED\n";
    echo "--------------\n";
    echo $e->getMessage();
    echo "\n";

    exit(1);
}
