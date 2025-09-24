<?php
$PAGE_TITLE = "Book a Table";
$ACTIVE_PAGE = "book.php";
include __DIR__ . "/includes/header.php";
?>

<div class="card">
  <h2>Book a Table</h2>
  <p>This is the skeleton form. In Stage 2, it will POST to a PHP handler that inserts into MySQL.</p>
  <form method="post" action="#" onsubmit="event.preventDefault(); alert('Stage 1: no backend yet.');">
    <div class="form-row">
      <div>
        <label for="full_name">Full Name</label>
        <input id="full_name" name="full_name" class="input" required>
      </div>
      <div>
        <label for="phone">Phone</label>
        <input id="phone" name="phone" class="input" required>
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" class="input" required>
      </div>
      <div>
        <label for="party_size">Party Size</label>
        <select id="party_size" name="party_size" class="input">
          <?php for ($i=1; $i<=12; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div>
        <label for="date">Date</label>
        <input id="date" name="date" type="date" class="input" required>
      </div>
      <div>
        <label for="time">Time</label>
        <input id="time" name="time" type="time" class="input" required>
      </div>
    </div>
    <div class="mt-1">
      <label for="note">Notes</label>
      <textarea id="note" name="note" rows="3" class="input" placeholder="Allergies, seating preference, etc."></textarea>
    </div>
    <div class="form-actions">
      <button class="btn" type="submit">Submit (disabled in Stage 1)</button>
      <a href="index.php" class="btn btn-secondary">Back Home</a>
    </div>
  </form>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>