<?php
// Database initialization script
// This script creates the database and tables from scratch

echo "<h1>Database Initialization</h1>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .info{color:blue;} pre{background:#f8f8f8;padding:10px;border-radius:4px;}</style>";

// Step 1: Connect without specifying database
echo "<h2>Step 1: Connecting to MySQL Server</h2>";
try {
    $pdo = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p class='success'>✅ Connected to MySQL server</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Failed to connect to MySQL server: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Step 2: Create database
echo "<h2>Step 2: Creating Database</h2>";
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS Giani");
    echo "<p class='success'>✅ Database 'Giani' created or already exists</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Failed to create database: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Step 3: Connect to the specific database
echo "<h2>Step 3: Connecting to Giani Database</h2>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=Giani;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p class='success'>✅ Connected to Giani database</p>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Failed to connect to Giani database: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Step 4: Read and execute SQL file
echo "<h2>Step 4: Creating Tables and Inserting Data</h2>";
$sqlFile = __DIR__ . '/briscola_menu.sql';
if (!file_exists($sqlFile)) {
    echo "<p class='error'>❌ SQL file not found: $sqlFile</p>";
    exit;
}

try {
    $sql = file_get_contents($sqlFile);
    
    // Remove the CREATE DATABASE line since we already created it
    $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS Giani;?\s*/i', '', $sql);
    
    // Split SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($statements as $statement) {
        if (empty($statement) || strpos($statement, '--') === 0) {
            continue; // Skip empty statements and comments
        }
        
        try {
            $pdo->exec($statement);
            $successCount++;
            echo "<p class='info'>✅ Executed: " . substr($statement, 0, 50) . "...</p>";
        } catch (PDOException $e) {
            $errorCount++;
            echo "<p class='error'>⚠️ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p class='error'>Statement: " . htmlspecialchars(substr($statement, 0, 100)) . "...</p>";
        }
    }
    
    echo "<h3>Execution Summary</h3>";
    echo "<p class='success'>✅ Successfully executed: $successCount statements</p>";
    if ($errorCount > 0) {
        echo "<p class='error'>⚠️ Errors: $errorCount statements</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error reading SQL file: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Step 5: Verify data
echo "<h2>Step 5: Verifying Data</h2>";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM menu_items");
    $result = $stmt->fetch();
    echo "<p class='info'>Total menu items: " . $result['count'] . "</p>";
    
    $stmt = $pdo->query("SELECT DISTINCT category FROM menu_items");
    $categories = $stmt->fetchAll();
    echo "<p class='info'>Categories: " . count($categories) . "</p>";
    echo "<ul>";
    foreach ($categories as $category) {
        echo "<li>" . htmlspecialchars($category['category']) . "</li>";
    }
    echo "</ul>";
    
    if ($result['count'] > 0) {
        echo "<p class='success'>✅ Database initialization completed successfully!</p>";
    } else {
        echo "<p class='error'>❌ No data found. Check the SQL file and try again.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p class='error'>❌ Verification failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Next Steps</h2>";
echo "<p><a href='test_db.php'>Test Database Connection</a></p>";
echo "<p><a href='../menu.php'>View Menu Page</a></p>";
echo "<p><a href='../debug.php'>View Debug Page</a></p>";
?>
