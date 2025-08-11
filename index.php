<?php
$PAGE_TITLE = "Home";
$ACTIVE_PAGE = "index.php";
include __DIR__ . "/partials/header.php";
?>
<section class="hero card">
  <div>
    <p class="brand-tagline">Welcome to</p>
    <h1>Briscola Bookings & Roster</h1>
    <p>First-stage prototype with 5 PHP pages. No database yet—just structure and content.</p>
    <a href="/book.php" class="btn">Book a Table</a>
  </div>
  <div>
    <div class="card">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="/menu.php">View Menu</a></li>
        <li><a href="/about.php">About Us</a></li>
        <li><a href="/contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
</section>
<section style="margin-top:1rem;" class="grid cols-3">
  <div class="card"><h3>Fast</h3><p>Clean PHP includes for header, navigation, and footer.</p></div>
  <div class="card"><h3>Responsive</h3><p>Simple CSS grid and mobile-friendly menu.</p></div>
  <div class="card"><h3>Ready to Extend</h3><p>Drop-in DB logic later without changing page structure.</p></div>
</section>
<?php include __DIR__ . "/partials/footer.php"; ?>
