<?php
// partials/header.php
require_once __DIR__ . "/../config.php";
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($SITE_NAME . (isset($PAGE_TITLE) ? " — " . $PAGE_TITLE : "")); ?></title>
    <meta name="description" content="First-stage PHP site (no DB yet) for <?php echo htmlspecialchars($SITE_NAME); ?>">
    <link rel="stylesheet" href="/assets/style.css">
    <script defer src="/assets/app.js"></script>
  </head>
  <body>
    <header class="site-header">
      <div class="container header-inner">
        <div class="brand">
          <a href="/index.php" class="brand-title"><?php echo htmlspecialchars($SITE_NAME); ?></a>
          <div class="brand-tagline"><?php echo htmlspecialchars($SITE_TAGLINE); ?></div>
        </div>
        <?php include __DIR__ . "/nav.php"; ?>
      </div>
    </header>
    <main class="container">
