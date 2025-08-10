<?php
$host = "localhost";
$dbname = "project2";
$username = "muddamn1";
$password = "Navatej@123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h3 style='color:green;'>Database connection successful!</h3>";
} catch (PDOException $e) {
    echo "<h3 style='color:red;'>Database connection failed: " . $e->getMessage() . "</h3>";
}
?>
