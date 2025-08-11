<?php
require_once 'config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "<h1 style='color: green;'>✅ SUCCESS!</h1>";
    echo "<p>PHP " . phpversion() . " is working!</p>";
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "<p>Database has " . $result['count'] . " users</p>";
    
    echo "<h2>🎯 MediConnect is Ready!</h2>";
    echo "<p><a href='patient.php'>Test the Booking App →</a></p>";
    
} catch (Exception $e) {
    echo "<h1 style='color: red;'>❌ Error:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
