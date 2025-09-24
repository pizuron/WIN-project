<?php
$PAGE_TITLE = "Menu";
$ACTIVE_PAGE = "menu.php";
include __DIR__ . "/includes/header.php";

// Include database configuration
require_once __DIR__ . "/database/db_config.php";

// Get all menu categories
$categories = getMenuCategories();
?>

<div class="menu-search">
  <label for="menuSearch" class="sr-only">Search menu</label>
  <input id="menuSearch" type="search" placeholder="Search dishes, notes, tags…" autocomplete="off" />
</div>

<div class="menu-container">


  <?php if (isDatabaseInitialized()): ?>
    <?php foreach ($categories as $categoryData): 
      $category = $categoryData['category'];
      $menuItems = getMenuItemsByCategory($category);
      
      if (empty($menuItems)) continue;
      
      // Check if this is a special category that should be in a callout box
      $isSpecial = in_array(strtolower($category), ['seasonal seafood', 'specials', 'chef\'s selection']);
    ?>
      <div class="menu-section<?php echo $isSpecial ? ' special' : ''; ?>" data-category="<?php echo htmlspecialchars($category); ?>">
        <h2 class="menu-category-title"><?php echo htmlspecialchars($category); ?></h2>
        <div class="menu-items">
          <?php 
          // Group similar items by name
          $groupedItems = [];
          foreach ($menuItems as $item) {
            $key = $item['item_name'];
            if (!isset($groupedItems[$key])) {
              $groupedItems[$key] = [
                'name' => $item['item_name'],
                'description' => $item['description'],
                'dietary_tags' => $item['dietary_tags'],
                'notes' => $item['notes'],
                'variants' => []
              ];
            }
            $groupedItems[$key]['variants'][] = [
              'variant' => $item['variant'],
              'price' => $item['price']
            ];
          }
          
          foreach ($groupedItems as $item): 
          ?>
            <div class="menu-item">
              <div class="menu-item-content">
                <h3 class="menu-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                
                <?php if (!empty($item['description'])): ?>
                  <p class="menu-item-description"><?php echo htmlspecialchars($item['description']); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($item['dietary_tags'])): ?>
                  <div class="menu-item-tags">
                    <?php 
                    $tags = formatDietaryTags($item['dietary_tags']);
                    $tagArray = explode(', ', $tags);
                    foreach ($tagArray as $tag): 
                      if (!empty(trim($tag))):
                    ?>
                      <span class="dietary-tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                    <?php 
                      endif;
                    endforeach; 
                    ?>
                  </div>
                <?php endif; ?>
                
                <?php if (!empty($item['notes'])): ?>
                  <div class="menu-item-notes"><?php echo htmlspecialchars($item['notes']); ?></div>
                <?php endif; ?>
              </div>
              
              <div class="menu-item-prices">
                <?php
                $prices = array_map(function($variant) {
                  return '$' . round($variant['price']);
                }, $item['variants']);
                ?>
                <span class="menu-item-price"><?php echo implode(' / ', $prices); ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="menu-error">
      <h3>Menu Temporarily Unavailable</h3>
      <p>We're updating our menu. Please check back soon or call us at (02) 6248 5444 for current offerings.</p>
    </div>
  <?php endif; ?>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
<script>
  (function(){
    const input = document.getElementById('menuSearch');
    if(!input) return;
    const sections = Array.from(document.querySelectorAll('.menu-section'));
    const normalize = (s) => (s||'').toLowerCase();

    input.addEventListener('input', () => {
      const q = normalize(input.value.trim());
      sections.forEach(sec => {
        const items = Array.from(sec.querySelectorAll('.menu-item'));
        let visibleCount = 0;
        items.forEach(it => {
          const name = normalize(it.querySelector('.menu-item-name')?.textContent);
          const desc = normalize(it.querySelector('.menu-item-description')?.textContent);
          const tags = Array.from(it.querySelectorAll('.dietary-tag')).map(e=>normalize(e.textContent)).join(' ');
          const hay = [name, desc, tags].join(' ');
          const show = q === '' || hay.includes(q);
          it.style.display = show ? '' : 'none';
          if (show) visibleCount++;
        });
        sec.style.display = visibleCount === 0 ? 'none' : '';
      });
    });
  })();
</script>
