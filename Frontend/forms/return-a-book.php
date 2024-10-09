<?php
// Start session
session_start();

// Include the Navbar class
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
    echo "Error on Class: " . $th->getMessage();
    exit;
}

try {
    // Render the navbar
    $navbar->render_navbar();
} catch (\Throwable $th) {
    echo 'Error on Function: ' . $th->getMessage();
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Return Book</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4">Return a Book</h2>
    <form action="process_return.php" method="POST">
        <!-- Member ID Input -->
        <div class="form-group">
            <label for="member_id">Member ID</label>
            <input type="number" class="form-control" id="member_id" name="member_id" placeholder="Enter Member ID" required>
        </div>

        <!-- Book Selection -->
        <div class="form-group">
            <label for="book_id">Book ID</label>
            <select class="form-control" id="book_id" name="book_id" required>
                <option value="">Select Book to Return</option>
                <!-- Use PHP to fetch and list borrowed books for this member -->
                <?php
                // Assuming you have a PDO connection $pdo
                try {
                    $stmt = $pdo->prepare("SELECT b.book_id, b.title 
                                           FROM Books b 
                                           JOIN Lending l ON b.book_id = l.book_id 
                                           WHERE l.member_id = :member_id AND l.return_date IS NULL");
                    $stmt->execute(['member_id' => $_POST['member_id']]);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['book_id']}'>{$row['title']}</option>";
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </select>
        </div>

        <!-- Due Date and Fine Display -->
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" readonly>
        </div>

        <div class="form-group">
            <label for="fine">Fine</label>
            <input type="text" class="form-control" id="fine" name="fine" readonly>
        </div>

        <!-- Return Book Button -->
        <button type="submit" class="btn btn-primary">Return Book</button>
    </form>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
