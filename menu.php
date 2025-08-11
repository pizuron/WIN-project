<?php
$PAGE_TITLE = "Menu";
$ACTIVE_PAGE = "menu.php";
include __DIR__ . "/partials/header.php";
?>
<section class="card">
  <h2>Menu & Specials</h2>
  <div class="grid cols-3">
    <div>
      <h4>Starters</h4>
      <ul>
        <li>Garlic Bread</li>
        <li>Bruschetta</li>
        <li>Calamari</li>
      </ul>
    </div>
    <div>
      <h4>Mains</h4>
      <ul>
        <li>Margherita Pizza</li>
        <li>Pasta Carbonara</li>
        <li>Grilled Chicken</li>
      </ul>
    </div>
    <div>
      <h4>Desserts</h4>
      <ul>
        <li>Tiramisu</li>
        <li>Panna Cotta</li>
        <li>Gelato</li>
      </ul>
    </div>
  </div>
</section>
<?php include __DIR__ . "/partials/footer.php"; ?>
