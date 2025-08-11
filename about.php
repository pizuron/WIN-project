<?php
$PAGE_TITLE = "About";
$ACTIVE_PAGE = "about.php";
include __DIR__ . "/partials/header.php";
?>
<article class="card">
  <h2>About Briscola</h2>
  <p>We are a Canberra restaurant prototype for an assignment MVP. This site shows how to structure a small web-information system using PHP includes and semantic HTML.</p>
  <p>In later stages, we'll add MySQL tables (customers, bookings, staff) and PHP handlers for CRUD operations.</p>
</article>
<section class="grid cols-3" style="margin-top:1rem;">
  <div class="card"><h3>Hours</h3><p>Mon–Sun: 11:30–22:00</p></div>
  <div class="card"><h3>Location</h3><p>120 Bunda St, Canberra ACT</p></div>
  <div class="card"><h3>Contact</h3><p>(02) 0000 0000 · hello@briscola.example</p></div>
</section>
<?php include __DIR__ . "/partials/footer.php"; ?>