<?php
$PAGE_TITLE = "Contact";
$ACTIVE_PAGE = "contact.php";
include __DIR__ . "/partials/header.php";
?>
<section class="card">
  <h2>Contact Us</h2>
  <p>Have questions? Reach out using the form below. In Stage 2 we will wire this up to a PHP mailer or store messages in the DB.</p>
  <form method="post" action="#" onsubmit="event.preventDefault(); alert('Stage 1: no backend yet.');">
    <div class="form-row">
      <div>
        <label for="name">Your Name</label>
        <input id="name" name="name" class="input" required>
      </div>
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" class="input" required>
      </div>
    </div>
    <div style="margin-top:1rem;">
      <label for="message">Message</label>
      <textarea id="message" name="message" rows="4" class="input" required></textarea>
    </div>
    <div class="form-actions">
      <button class="btn" type="submit">Send (disabled in Stage 1)</button>
    </div>
  </form>
</section>
<?php include __DIR__ . "/partials/footer.php"; ?>
