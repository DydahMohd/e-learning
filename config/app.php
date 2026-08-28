<?php
declare(strict_types=1);

/**
 * Central application bootstrap.
 * Loads a simple .env file when present, without requiring a third-party package.
 */
if (!function_exists('eac_load_env')) {
    function eac_load_env(string $file): void {
        if (!is_file($file)) return;
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') continue;
            $pos = strpos($line, '=');
            if ($pos === false) continue;
            $key = trim(substr($line, 0, $pos));
            $value = trim(substr($line, $pos + 1));
            if ($key === '') continue;
            if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                $value = substr($value, 1, -1);
            }
            if (getenv($key) === false) {
                putenv($key . '=' . $value);
            }
        }
    }
}
eac_load_env(dirname(__DIR__) . '/.env');

$appTimeZone = getenv('APP_TIMEZONE') ?: 'Africa/Dar_es_Salaam';
try {
    $timeZone = new DateTimeZone($appTimeZone);
} catch (Throwable) {
    http_response_code(500);
    exit('Server configuration error.');
}
date_default_timezone_set($timeZone->getName());
define('APP_TIMEZONE', $timeZone->getName());

$databaseTimeZone = getenv('DB_TIME_ZONE') ?: date('P');
if (!preg_match('/^[+-](?:0\d|1[0-4]):[0-5]\d$/', $databaseTimeZone)) {
    http_response_code(500);
    exit('Server configuration error.');
}
define('DB_TIME_ZONE', $databaseTimeZone);

define('EAC_ROOT', dirname(__DIR__));
define('EAC_CONFIG_LOADED', true);
