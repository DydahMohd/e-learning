<?php
declare(strict_types=1);

/**
 * Run daily from cron/Task Scheduler if the database Event Scheduler
 * is unavailable. Example Windows Task Scheduler:
 *   php C:\path\to\statistic_main\maintenance\cleanup_inactive_accounts.php
 */
require_once __DIR__ . '/../api/config.php';
require_once __DIR__ . '/../api/Database.php';

$db = Database::connect();

$stmt = $db->prepare(
    "DELETE FROM users
     WHERE role = 'student'
       AND COALESCE(lastLoginAt, createdAt) < (NOW() - INTERVAL 31 DAY)"
);
$stmt->execute();

$deleted = $stmt->rowCount();

$db->prepare(
    "DELETE FROM user_sessions
     WHERE revokedAt IS NOT NULL
       AND revokedAt < (NOW() - INTERVAL 31 DAY)"
)->execute();

echo "Inactive accounts deleted: {$deleted}\n";
