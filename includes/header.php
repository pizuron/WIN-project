<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo isset($PAGE_TITLE) ? "GIANI — " . $PAGE_TITLE : "GIANI — Italian Dining"; ?></title>
  <meta name="description" content="GIANI — minimal, elegant Italian dining in Canberra. Reservations, menu, private dining."/>
  <!-- Fonts to match the reference vibe: refined serif for headings/brand, clean sans for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="nav">
    <div class="wrap nav__inner">
      <a class="brand" href="index.php" aria-label="GIANI home">GIANI</a>
      <button class="hamburger" aria-label="Open menu" aria-controls="primaryNav" aria-expanded="false"><span></span></button>
      <nav class="menu" id="primaryNav" aria-label="Primary">
        <a class="cta" href="#book" data-open="book">Reservations</a>
        <a href="index.php" class="<?php echo (isset($ACTIVE_PAGE) && $ACTIVE_PAGE==='index.php') ? 'is-active' : ''; ?>">Home</a>
        <a href="about.php" class="<?php echo (isset($ACTIVE_PAGE) && $ACTIVE_PAGE==='about.php') ? 'is-active' : ''; ?>">About</a>
        <a href="menu.php" class="<?php echo (isset($ACTIVE_PAGE) && $ACTIVE_PAGE==='menu.php') ? 'is-active' : ''; ?>">Menu</a>
        <a href="contact.php" class="<?php echo (isset($ACTIVE_PAGE) && $ACTIVE_PAGE==='contact.php') ? 'is-active' : ''; ?>">Contact</a>
        <a href="#book" data-open="book" class="cta-mobile">Reservations</a>
      </nav>
    </div>
  </header>

  <main class="wrap front">