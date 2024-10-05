<?php
// Database connection
$host = 'localhost'; // MySQL server hostname
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$dbName = 'booklendingDB'; // Replace with the desired database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    echo "Data imported successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
