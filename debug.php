<?php
// Debug page for GIANI Restaurant database
// This page helps troubleshoot database connection and data issues

echo "<h1>GIANI Restaurant Database Debug</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f3; }
.debug-section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.success { color: green; }
.error { color: red; }
.warning { color: orange; }
.info { color: blue; }
pre { background: #f8f8f8; padding: 10px; border-radius: 4px; overflow-x: auto; }
</style>";

// Include database configuration
require_once __DIR__ . "/database/db_config.php";

echo "<div class='debug-section'>";
echo "<h2>Database Connection Status</h2>";

try {
    $connected = checkDatabaseConnection();
    if ($connected) {
        echo "<p class='success'>✅ Database connection successful</p>";
        echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
        echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
        echo "<p><strong>User:</strong> " . DB_USER . "</p>";
    } else {
        echo "<p class='error'>❌ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Database connection error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>Database Initialization Status</h2>";

try {
    $initialized = isDatabaseInitialized();
    if ($initialized) {
        echo "<p class='success'>✅ Database is initialized</p>";
        echo "<p class='info'>menu_items table exists</p>";
    } else {
        echo "<p class='error'>❌ Database is not initialized</p>";
        echo "<p class='warning'>menu_items table does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Initialization check error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

if (isDatabaseInitialized()) {
    echo "<div class='debug-section'>";
    echo "<h2>Menu Items Count</h2>";
    
    try {
        $totalItems = getSingleRow("SELECT COUNT(*) as count FROM menu_items");
        echo "<p class='info'>Total menu items: <strong>" . $totalItems['count'] . "</strong></p>";
        
        if ($totalItems['count'] == 0) {
            echo "<p class='warning'>⚠️ No menu items found in database</p>";
            echo "<p>You may need to run the database setup script.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error counting menu items: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";

    echo "<div class='debug-section'>";
    echo "<h2>Menu Categories</h2>";
    
    try {
        $categories = getMenuCategories();
        echo "<p class='info'>Categories found: <strong>" . count($categories) . "</strong></p>";
        
        if (count($categories) > 0) {
            echo "<h3>Category List:</h3>";
            echo "<ul>";
            foreach ($categories as $category) {
                echo "<li>" . htmlspecialchars($category['category']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='warning'>⚠️ No categories found</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error getting categories: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";

    echo "<div class='debug-section'>";
    echo "<h2>Sample Menu Items</h2>";
    
    try {
        $sampleItems = getMultipleRows("SELECT * FROM menu_items LIMIT 5");
        echo "<p class='info'>Sample items (first 5):</p>";
        
        if (count($sampleItems) > 0) {
            echo "<pre>" . htmlspecialchars(print_r($sampleItems, true)) . "</pre>";
        } else {
            echo "<p class='warning'>⚠️ No sample items found</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error getting sample items: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";

    echo "<div class='debug-section'>";
    echo "<h2>Items by Category</h2>";
    
    try {
        $categories = getMenuCategories();
        foreach ($categories as $categoryData) {
            $category = $categoryData['category'];
            $items = getMenuItemsByCategory($category);
            echo "<h3>" . htmlspecialchars($category) . " (" . count($items) . " items)</h3>";
            
            if (count($items) > 0) {
                echo "<ul>";
                foreach (array_slice($items, 0, 3) as $item) { // Show first 3 items
                    echo "<li>" . htmlspecialchars($item['item_name']) . " - $" . $item['price'] . "</li>";
                }
                if (count($items) > 3) {
                    echo "<li>... and " . (count($items) - 3) . " more</li>";
                }
                echo "</ul>";
            } else {
                echo "<p class='warning'>No items in this category</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error getting items by category: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    echo "</div>";
}

echo "<div class='debug-section'>";
echo "<h2>Database Tables</h2>";

try {
    $tables = getMultipleRows("SHOW TABLES");
    echo "<p class='info'>Tables in database:</p>";
    echo "<ul>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "<li>" . htmlspecialchars($tableName) . "</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "<p class='error'>❌ Error getting tables: " . htmlspecialchars($e->getMessage()) . "</p>";
}
echo "</div>";

echo "<div class='debug-section'>";
echo "<h2>Next Steps</h2>";

if (!checkDatabaseConnection()) {
    echo "<p class='error'>1. Fix database connection issues</p>";
    echo "<p>- Check if MySQL server is running</p>";
    echo "<p>- Verify database credentials in db_config.php</p>";
    echo "<p>- Ensure database 'Giani' exists</p>";
} elseif (!isDatabaseInitialized()) {
    echo "<p class='warning'>2. Initialize database</p>";
    echo "<p><a href='database/setup.php'>Run Database Setup</a></p>";
} else {
    $totalItems = getSingleRow("SELECT COUNT(*) as count FROM menu_items");
    if ($totalItems['count'] == 0) {
        echo "<p class='warning'>3. Add menu data</p>";
        echo "<p><a href='database/setup.php'>Run Database Setup</a> to add sample menu data</p>";
    } else {
        echo "<p class='success'>✅ Database is ready!</p>";
        echo "<p><a href='menu.php'>View Menu Page</a></p>";
    }
}

echo "<p><a href='index.php'>Back to Homepage</a></p>";
echo "</div>";
?>
