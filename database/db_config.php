<?php
// Database configuration for GIANI Restaurant
// Update these settings according to your MySQL setup

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'Giani');
define('DB_USER', 'root'); // Change this to your MySQL username
define('DB_PASS', ''); // Change this to your MySQL password
define('DB_CHARSET', 'utf8mb4');

// PDO connection options
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create database connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $pdo_options);
    
} catch (PDOException $e) {
    // Log error and show user-friendly message
    error_log("Database connection failed: " . $e->getMessage());
    error_log("Connection details - Host: " . DB_HOST . ", DB: " . DB_NAME . ", User: " . DB_USER);
    
    // Show more detailed error in development
    if (isset($_GET['debug']) || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false)) {
        die("Database connection failed: " . $e->getMessage() . "<br>Host: " . DB_HOST . ", DB: " . DB_NAME . ", User: " . DB_USER);
    } else {
        die("Database connection failed. Please try again later.");
    }
}

// Helper function to get database connection
function getDB() {
    global $pdo;
    return $pdo;
}

// Helper function to execute prepared statements safely
function executeQuery($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query execution failed: " . $e->getMessage());
        throw new Exception("Database query failed");
    }
}

// Helper function to get single row
function getSingleRow($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetch();
}

// Helper function to get multiple rows
function getMultipleRows($sql, $params = []) {
    $stmt = executeQuery($sql, $params);
    return $stmt->fetchAll();
}

// Helper function to insert and get last insert ID
function insertAndGetId($sql, $params = []) {
    global $pdo;
    $stmt = executeQuery($sql, $params);
    return $pdo->lastInsertId();
}

// Helper function to check if table exists
function tableExists($tableName) {
    global $pdo;
    try {
        $sql = "SHOW TABLES LIKE '" . $tableName . "'";
        $stmt = $pdo->query($sql);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("tableExists error: " . $e->getMessage());
        return false;
    }
}

// Helper function to get menu items by category
function getMenuItemsByCategory($category = null) {
    if ($category) {
        $sql = "SELECT * FROM menu_items WHERE category = ? ORDER BY item_name";
        return getMultipleRows($sql, [$category]);
    } else {
        $sql = "SELECT * FROM menu_items ORDER BY category, item_name";
        return getMultipleRows($sql);
    }
}

// Helper function to get all menu categories
function getMenuCategories() {
    $sql = "SELECT DISTINCT category FROM menu_items ORDER BY 
            CASE category 
                WHEN 'Pane' THEN 1
                WHEN 'Starters' THEN 2
                WHEN 'Pasta' THEN 3
                WHEN 'Risotto' THEN 4
                WHEN 'Secondi' THEN 5
                WHEN 'Contorni' THEN 6
                WHEN 'Dolci' THEN 7
                WHEN 'Combos' THEN 8
                WHEN 'Kids' THEN 9
                WHEN 'After Dinner' THEN 10
                WHEN 'Non-Alcoholic' THEN 11
                ELSE 12
            END";
    return getMultipleRows($sql);
}

// Helper function to format dietary tags
function formatDietaryTags($tags) {
    if (empty($tags)) return '';
    
    $tagMap = [
        'v' => 'Vegetarian',
        'vgn' => 'Vegan',
        'gf' => 'Gluten Free',
        'df' => 'Dairy Free'
    ];
    
    $formattedTags = [];
    $tagsArray = explode(',', $tags);
    
    foreach ($tagsArray as $tag) {
        $tag = trim($tag);
        if (isset($tagMap[$tag])) {
            $formattedTags[] = $tagMap[$tag];
        } else {
            $formattedTags[] = ucfirst($tag);
        }
    }
    
    return implode(', ', $formattedTags);
}

// Helper function to format price
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

// Database initialization check
function checkDatabaseConnection() {
    try {
        global $pdo;
        $pdo->query("SELECT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Check if database is properly initialized
function isDatabaseInitialized() {
    return tableExists('menu_items');
}

// Display database status (for debugging)
function getDatabaseStatus() {
    $status = [
        'connected' => checkDatabaseConnection(),
        'initialized' => isDatabaseInitialized(),
        'menu_items_count' => 0
    ];
    
    if ($status['connected'] && $status['initialized']) {
        $sql = "SELECT COUNT(*) as count FROM menu_items";
        $result = getSingleRow($sql);
        $status['menu_items_count'] = $result['count'];
    }
    
    return $status;
}
?>
