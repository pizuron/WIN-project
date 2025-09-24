<?php
// Database setup script for GIANI Restaurant
// Run this file once to set up the database

// Include database configuration
require_once __DIR__ . '/db_config.php';

// Get PDO connection
$pdo = getDB();

// Check if database is already initialized
if (isDatabaseInitialized()) {
    echo "<h2>Database Setup Status</h2>";
    echo "<p style='color: green;'>✅ Database is already initialized and ready to use!</p>";
    echo "<p><strong>Menu items found:</strong> " . getDatabaseStatus()['menu_items_count'] . "</p>";
    echo "<p><a href='../menu.php'>View Menu</a> | <a href='../index.php'>Go to Homepage</a></p>";
    exit;
}

// Check database connection
if (!checkDatabaseConnection()) {
    echo "<h2>Database Setup Error</h2>";
    echo "<p style='color: red;'>❌ Cannot connect to database. Please check your database configuration in db_config.php</p>";
    echo "<p>Make sure:</p>";
    echo "<ul>";
    echo "<li>MySQL server is running</li>";
    echo "<li>Database credentials are correct</li>";
    echo "<li>Database 'Giani' exists</li>";
    echo "</ul>";
    exit;
}

// Read and execute SQL file
$sqlFile = __DIR__ . '/briscola_menu.sql';
if (!file_exists($sqlFile)) {
    echo "<h2>Setup Error</h2>";
    echo "<p style='color: red;'>❌ SQL file not found: $sqlFile</p>";
    exit;
}

try {
    // Read SQL file
    $sql = file_get_contents($sqlFile);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    echo "<h2>Setting up GIANI Restaurant Database</h2>";
    echo "<p>Executing database setup...</p>";
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement) || strpos($statement, '--') === 0) {
            continue; // Skip empty statements and comments
        }
        
        try {
            $pdo->exec($statement);
            $successCount++;
        } catch (PDOException $e) {
            $errorCount++;
            echo "<p style='color: orange;'>⚠️ Warning: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    
    echo "<h3>Setup Complete!</h3>";
    echo "<p style='color: green;'>✅ Successfully executed $successCount statements</p>";
    
    if ($errorCount > 0) {
        echo "<p style='color: orange;'>⚠️ $errorCount warnings (this is normal for some statements)</p>";
    }
    
    // Verify setup
    if (isDatabaseInitialized()) {
        echo "<p style='color: green;'>✅ Database is properly initialized!</p>";
        echo "<h3>What's been created:</h3>";
        echo "<ul>";
        echo "<li>📋 Menu items table with authentic Italian menu data</li>";
        echo "<li>🍝 Categories: Pane, Starters, Pasta, Risotto, Secondi, Contorni, Dolci, Combos, Kids, After Dinner, Non-Alcoholic</li>";
        echo "<li>💰 Realistic pricing in AUD</li>";
        echo "<li>🏷️ Dietary tags and allergen information</li>";
        echo "<li>📝 Item descriptions and variants</li>";
        echo "</ul>";
        
        echo "<h3>Sample Data Included:</h3>";
        echo "<ul>";
        echo "<li>🍞 Pane (Bread) - 12 items with different sizes</li>";
        echo "<li>🥗 Starters - 7 authentic Italian appetizers</li>";
        echo "<li>🍝 Pasta - 8 traditional pasta dishes</li>";
        echo "<li>🍚 Risotto - 3 gluten-free risotto options</li>";
        echo "<li>🥩 Secondi - 6 main courses</li>";
        echo "<li>🥬 Contorni - 4 sides and salads</li>";
        echo "<li>🍰 Dolci - 8 desserts including gelato and tiramisu</li>";
        echo "<li>🍽️ Combos, Kids meals, After Dinner drinks, and Non-Alcoholic options</li>";
        echo "</ul>";
        
        echo "<p><strong>Next Steps:</strong></p>";
        echo "<ol>";
        echo "<li>Visit the <a href='../menu.php'>Menu Page</a> to see your beautiful menu</li>";
        echo "<li>Test the responsive design on different devices</li>";
        echo "<li>Customize menu items and pricing as needed</li>";
        echo "</ol>";
        
        echo "<p><a href='../menu.php' style='background: #3a3a3a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;'>View Menu</a>";
        echo "<a href='../index.php' style='background: #8a8a8a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
        
    } else {
        echo "<p style='color: red;'>❌ Database setup may have failed. Please check the error messages above.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2>Setup Error</h2>";
    echo "<p style='color: red;'>❌ Error during setup: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Display database status
echo "<hr>";
echo "<h3>Database Status</h3>";
$status = getDatabaseStatus();
echo "<pre>" . print_r($status, true) . "</pre>";
?>
