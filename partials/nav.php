<?php
// partials/nav.php
$nav = [
  "index.php"  => "Home",
  "about.php"  => "About",
  "menu.php"   => "Menu",
  "book.php"   => "Book a Table",
  "contact.php"=> "Contact"
];
?>
<nav class="nav">
  <button class="nav-toggle" aria-expanded="false" aria-controls="nav-list">Menu</button>
  <ul id="nav-list" class="nav-list">
    <?php foreach ($nav as $href => $label): 
      $isActive = (isset($ACTIVE_PAGE) && $ACTIVE_PAGE === $href);
    ?>
      <li><a href="/<?php echo $href; ?>" class="<?php echo $isActive ? 'active' : ''; ?>"><?php echo htmlspecialchars($label); ?></a></li>
    <?php endforeach; ?>
  </ul>
</nav>
