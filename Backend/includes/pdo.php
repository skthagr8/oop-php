<?php
// Database configuration
$host = 'localhost'; // MySQL server hostname
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$dbName = 'booklendingDB'; // Replace with the desired database name

try {
    // Create a new PDO instance to connect to MySQL server (without specifying a database)
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the database already exists
    $dbCheck = $pdo->query("SHOW DATABASES LIKE '$dbName'")->rowCount();

    // If the database does not exist, create it
    if ($dbCheck === 0) {
        $pdo->exec("CREATE DATABASE `$dbName`");
        echo "Database '$dbName' created successfully.<br>";
    } else {
        echo "Database '$dbName' already exists.<br>";
    }

    // Now connect to the created (or existing) database
    $pdo->exec("USE `$dbName`");

    echo "Connected successfully to the database '$dbName'"; // Message on successful connection

} catch (PDOException $e) {
    // Catch any connection error and display the message
    echo "Connection failed: " . $e->getMessage();
}
?>
