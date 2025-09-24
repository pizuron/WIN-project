<?php
// Simple database test script
echo "<h1>Database Test</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} pre{background:#f8f8f8;padding:10px;border-radius:4px;}</style>";

// Test 1: Basic PDO connection
echo "<h2>Test 1: Basic PDO Connection</h2>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=Giani;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p class='success'>✅ PDO connection successful</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ PDO connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Test 2: Check if database exists
echo "<h2>Test 2: Database Existence</h2>";
try {
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    echo "<p class='info'>Current database: " . htmlspecialchars($result['current_db']) . "</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Database check failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 3: Check if table exists
echo "<h2>Test 3: Table Existence</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'menu_items'");
    $result = $stmt->fetch();
    if ($result) {
        echo "<p class='success'>✅ menu_items table exists</p>";
    } else {
        echo "<p class='error'>❌ menu_items table does not exist</p>";
        echo "<p>You need to run the database setup script.</p>";
        exit;
    }
} catch (PDOException $e) {
    echo "<p class='error'>❌ Table check failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 4: Check table structure
echo "<h2>Test 4: Table Structure</h2>";
try {
    $stmt = $pdo->query("DESCRIBE menu_items");
    $columns = $stmt->fetchAll();
    echo "<p class='info'>Table columns:</p>";
    echo "<pre>";
    foreach ($columns as $column) {
        echo htmlspecialchars($column['Field'] . " - " . $column['Type'] . " - " . $column['Null'] . " - " . $column['Key']) . "\n";
    }
    echo "</pre>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Table structure check failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 5: Count records
echo "<h2>Test 5: Record Count</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM menu_items");
    $result = $stmt->fetch();
    echo "<p class='info'>Total records: " . $result['count'] . "</p>";
    
    if ($result['count'] == 0) {
        echo "<p class='error'>❌ No records found in menu_items table</p>";
        echo "<p>You need to run the database setup script to insert data.</p>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>❌ Record count failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 6: Get sample records
echo "<h2>Test 6: Sample Records</h2>";
try {
    $stmt = $pdo->query("SELECT * FROM menu_items LIMIT 3");
    $records = $stmt->fetchAll();
    
    if (count($records) > 0) {
        echo "<p class='success'>✅ Sample records retrieved</p>";
        echo "<pre>" . htmlspecialchars(print_r($records, true)) . "</pre>";
    } else {
        echo "<p class='error'>❌ No sample records found</p>";
    }
} catch (PDOException $e) {
    echo "<p class='error'>❌ Sample records failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 7: Get categories
echo "<h2>Test 7: Categories</h2>";
try {
    $stmt = $pdo->query("SELECT DISTINCT category FROM menu_items ORDER BY category");
    $categories = $stmt->fetchAll();
    
    echo "<p class='info'>Categories found: " . count($categories) . "</p>";
    echo "<ul>";
    foreach ($categories as $category) {
        echo "<li>" . htmlspecialchars($category['category']) . "</li>";
    }
    echo "</ul>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Categories query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Test 8: Test our helper functions
echo "<h2>Test 8: Helper Functions</h2>";
require_once __DIR__ . "/database/db_config.php";

try {
    $categories = getMenuCategories();
    echo "<p class='info'>getMenuCategories() returned: " . count($categories) . " categories</p>";
    
    if (count($categories) > 0) {
        $firstCategory = $categories[0]['category'];
        $items = getMenuItemsByCategory($firstCategory);
        echo "<p class='info'>getMenuItemsByCategory('$firstCategory') returned: " . count($items) . " items</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Helper functions failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Next Steps</h2>";
echo "<p><a href='database/setup.php'>Run Database Setup</a></p>";
echo "<p><a href='menu.php'>View Menu Page</a></p>";
echo "<p><a href='debug.php'>View Debug Page</a></p>";
?>
