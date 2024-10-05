<?php

// Start session
session_start();

try {
    require_once('../layouts/navbar.php');
} catch (\Throwable $e) {
    echo "File not Found or Wrong File Import: " . $e->getMessage();
    exit;
}

// Check if the user is logged in and if they are an admin
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';


try {
    // Create a Navbar instance
    $navbar = new Navbar($isLoggedIn, $isAdmin);
} catch (\Throwable $th) {
    echo "Class Not Found: " . $th->getMessage();
    exit;
}

try {
    // Render the navbar
    $navbar->render_navbar();
} catch (\Throwable $th) {
    echo 'Function called does not exist: ' . $th->getMessage();
    exit;
}



class browsebooks{
    
    public function render_books(){
        ?>
        <?php
        $host = 'localhost'; // MySQL server hostname
        $username = 'root'; // Replace with your MySQL username
        $password = ''; // Replace with your MySQL password
        $dbName = 'booklendingDB'; // Replace with the desired database name
        // Database connection
        try {
            $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
        // Fetching books from the database
        $books = [];

        try {
            // Fetching books from the database
            $stmt = $pdo->prepare("SELECT * FROM Books");
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching books: " . $e->getMessage();
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Book List</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Book List</h1>
    <div class="row">
        <?php if ($books): ?>
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Author: <?php echo htmlspecialchars($book['author']); ?></h6>
                            <p class="card-text">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                            <p class="card-text">Published: <?php echo htmlspecialchars($book['published_date']); ?></p>
                            <p class="card-text">Edition: <?php echo htmlspecialchars($book['edition']); ?></p>
                            <p class="card-text">Category ID: <?php echo htmlspecialchars($book['category_id']); ?></p>
                            <p class="card-text">Total Copies: <?php echo htmlspecialchars($book['total_copies']); ?></p>
                            <p class="card-text">Available Copies: <?php echo htmlspecialchars($book['available_copies']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No books available.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




    <?php
    }
}

try {
    $browsebookspage = new browsebooks;
} catch (\Throwable $th) {
    echo 'Class called does not exist: ' . $th->getMessage();
    exit;
}

try {
    $browsebookspage->render_books();
} catch (\Throwable $th) {
    echo 'Function called does not exist: ' . $th->getMessage();
    exit;
}


?>