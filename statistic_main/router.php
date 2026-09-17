<?php
declare(strict_types=1);

// Router for PHP's local development server. Production Apache uses .htaccess.
$uriPath = (string)(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$decodedPath = rawurldecode($uriPath);

// Match the access restrictions in .htaccess while developing locally.
if (
    preg_match('#^/(?:config|data|includes|legacy_courses|legacy_pages|maintenance|storage)(?:/|$)#i', $decodedPath) ||
    preg_match('#^/courses/data/.*\.php$#i', $decodedPath) ||
    preg_match('#/(?:\.|[^/]*\.(?:sql|db|sqlite|bak|bat|md|env|log))$#i', $decodedPath) ||
    preg_match('#^/(?:seed|test[^/]*)\.php$#i', $decodedPath)
) {
    http_response_code(403);
    exit('Forbidden');
}

if ($decodedPath === '/api' || str_starts_with($decodedPath, '/api/')) {
    require __DIR__ . '/api/index.php';
    return true;
}

$candidate = realpath(__DIR__ . DIRECTORY_SEPARATOR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $decodedPath), DIRECTORY_SEPARATOR));
if ($decodedPath !== '/' && $candidate && str_starts_with($candidate, __DIR__ . DIRECTORY_SEPARATOR) && is_file($candidate)) {
    return false;
}

if ($decodedPath === '/') {
    require __DIR__ . '/index.php';
    return true;
}

http_response_code(404);
require __DIR__ . '/index.php';
return true;
