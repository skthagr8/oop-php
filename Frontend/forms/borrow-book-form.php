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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 mb-5 container rounded-5 p-4 shadow">
    <h1 class=" col mb-3 ">Would You Like To Take a Book Home?</h1>
    <h3 class="col mb-3">Fill the form below.</h3>
    <p class="col mb-3">Note that the Maximum return date is after 5 weeks</p>

    <form action="submit_borrow.php" method="POST" class=''> <!-- Specify the action and method -->
        <div class=''>

            <div class='row'>
                <div class="col mb-3">
                    <label class="form-label" for='member_id'>Member ID</label>
                    <input type="text" name="member_id" class="form-control" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label" for='book_id'>Book ID</label>
                    <input type="tel" name="phone" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <div class='row'>
                <div class="col mb-3">
                    <label class="form-label" for='book_title'>Title of the Book</label>
                    <input type="text" name="book_title" class="form-control" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label" for='book_author'>Author of the Book</label>
                    <input type="text" name="book_author" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <div class='row'>
                <div class="col mb-3">
                    <label class="form-label" for='book_isbn_no'>ISBN Number</label>
                    <input type="text" name="isbn" class="form-control" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label" for='book_copy_no'>Copy Number</label>
                    <input type="text" name="copy_number" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <div class='row'>
                <div class="col mb-3">
                    <label class="form-label" for='borrow_date'>Borrow Date </label>
                    <input type="date" name="borrow_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label" for='return_date'>Return Date</label>
                    <input type="date" name="return_date" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <div class="form-check col mb-3">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required> <!-- Added required -->
                <label class="form-check-label" for="flexCheckDefault">
                    I agree to the library's borrowing policies.
                </label>
            </div>

            <div class="col mb-3">
                <label class='text_area' for='suggested_reason'>Reason for Borrowing</label>
                <textarea class="form-control" name="reason" rows="3" required></textarea> <!-- Added name and required -->
            </div>

            <button type="submit" class="btn btn-primary mt-3 col mb-3">Submit</button> <!-- Added submit button -->
        </div>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
