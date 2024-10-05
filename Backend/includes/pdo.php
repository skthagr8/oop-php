<?php
// Database configuration
$host = 'localhost'; // MySQL server hostname
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$dbName = 'booklendingDB'; // Replace with the desired database name

set_time_limit(1000); // Set the time limit to 300 seconds (5 minutes)


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

    // Read the CSV file
    try {
        $csvFile = 'files/Books.csv';
    } catch (\Throwable $th) {
        echo 'File/Folder called does not exist: ' . $th->getMessage();
        exit;
    }
      
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        // Skip the header row
        fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== FALSE) {
            list($isbn, $bookTitle, $authorName, $publisherName, $yearOfPublication) = $data;
            try {
                try {
                 // Check if the 'name' column exists in the 'authors' table
                $result = $pdo->query("SHOW COLUMNS FROM authors LIKE 'name'");
                if ($result->rowCount() == 0) {
                    // If the column does not exist, create it
                    $pdo->exec("ALTER TABLE authors ADD COLUMN name VARCHAR(255) NOT NULL");
                }
                } catch (PDOException $e) {
                    echo "Fatal error: " . $e->getMessage();
                }
               
            
                // Insert Author
                try {
                    $stmt = $pdo->prepare("INSERT IGNORE INTO authors (name) VALUES (:name)");
                    $stmt->execute(['name' => $authorName]);
                } catch (PDOException $e) {
                    echo "Error inserting author: " . $e->getMessage();
                }
            
                // Get Author ID
                try {
                    $stmt = $pdo->prepare("SELECT author_id FROM authors WHERE name = :name");
                    $stmt->execute(['name' => $authorName]);
                    $authorId = $stmt->fetchColumn();
                } catch (PDOException $e) {
                    echo "Error fetching author ID: " . $e->getMessage();
                }
            
                // Check if the 'name' column exists in the 'publishers' table
                $result = $pdo->query("SHOW COLUMNS FROM publishers LIKE 'name'");
                if ($result->rowCount() == 0) {
                    // If the column does not exist, create it
                    $pdo->exec("ALTER TABLE books ADD COLUMN name VARCHAR(255) NOT NULL");
                }
            
                // Insert Publisher
                try {
                    $stmt = $pdo->prepare("INSERT IGNORE INTO publishers (name) VALUES (:name)");
                    $stmt->execute(['name' => $publisherName]);
                } catch (PDOException $e) {
                    echo "Error inserting publisher: " . $e->getMessage();
                }
            
                // Get Publisher ID
                try {
                    $stmt = $pdo->prepare("SELECT publisher_id FROM publishers WHERE name = :name");
                    $stmt->execute(['name' => $publisherName]);
                    $publisherId = $stmt->fetchColumn();
                } catch (PDOException $e) {
                    echo "Error fetching publisher ID: " . $e->getMessage();
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
            
            // Insert Book
            $stmt = $pdo->prepare("INSERT IGNORE INTO books (isbn, title, author, publisher, year_of_publication) VALUES (:isbn, :title, :author_id, :publisher_id, :year)");
            $stmt->execute([
                'isbn' => $isbn,
                'title' => $bookTitle,
                'author_id' => $authorId,
                'publisher_id' => $publisherId,
                'year' => $yearOfPublication
            ]);
        }
        fclose($handle);
    }

} catch (PDOException $e) {
    // Catch any connection error and display the message
    echo "Connection failed: " . $e->getMessage();
}
?>


