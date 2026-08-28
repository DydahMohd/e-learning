<?php
/**
 * Shared browser-tab identity for every public EAC Statistics e-Learning page.
 * Pages outside the site root (course pages) set $faviconBasePath to '../'.
 */
$faviconBasePath = isset($faviconBasePath) && is_string($faviconBasePath) ? $faviconBasePath : '';
$faviconAsset = __DIR__ . '/../images/eac-crest.png';
$faviconVersion = is_file($faviconAsset) ? (string) filemtime($faviconAsset) : '1';
$faviconHref = $faviconBasePath . 'images/eac-crest.png?v=' . rawurlencode($faviconVersion);
$manifestHref = $faviconBasePath . 'manifest.json?v=' . rawurlencode($faviconVersion);
?>
<link rel="icon" type="image/png" href="<?= htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8') ?>">
<link rel="shortcut icon" type="image/png" href="<?= htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8') ?>">
<link rel="apple-touch-icon" href="<?= htmlspecialchars($faviconHref, ENT_QUOTES, 'UTF-8') ?>">
<link rel="manifest" href="<?= htmlspecialchars($manifestHref, ENT_QUOTES, 'UTF-8') ?>">
