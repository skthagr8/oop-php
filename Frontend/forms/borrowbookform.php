<?php

// Include the Navbar class
try {
    require_once('../layouts/navbar.php');

} catch (\Throwable $e) {
    echo "File not Found or Wrong File Import". $e->getMessage();
    exit;
}

try {
    // Create a Navbar instance
    $nav = new Navbar($isLoggedIn, $isAdmin);
} catch (\Throwable $th) {
    echo "Class Not Found ".$e->getMessage();
    exit;

}

 // Create a Navbar instance
 $navbar = new Navbar($isLoggedIn, $isAdmin);

try {
   // Render the navbar
   $navbar->render_navbar();
} catch (\Throwable $th) {
    echo 'Function called does not exist'.$e->getMessage();
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

    <div class="container mt-5 p-10">
        <h1>Welcome to the Library System</h1>
        <p>Find your favorite books and manage your borrowed books.</p>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
