<?php

class registerform{
    public function signupform(){
        ?>
        <!DOCTYPE html<html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library - signupform</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container mt-5 mb-5 container rounded-5 p-4 shadow">
            <h1 class=" col mb-3 ">Sign Up</h1>
 
            <form action="submit_borrow.php" method="POST" class=''> <!-- Specify the action and method -->
                <div class=''>
                <div class='row'>
                <div class="col mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <div class='row'>
                <div class="col mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required> <!-- Added type and class -->
                </div>

                <div class="col mb-3">
                    <label class="form-label">Password</label>
                    <input type="tel" name="phone" class="form-control" required> <!-- Added type and class -->
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3 col mb-3">Submit</button> <!-- Added submit button -->
        </div>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

        

<?php
    }
}

try {
    $render_signform = new registerform;
} catch (\Throwable $th) {
    echo 'Class called does not exist: ' . $th->getMessage();
    exit;
}

try {
    $render_signform->signupform();
} catch (\Throwable $th) {
    echo 'Function called does not exist: ' . $th->getMessage();
    exit;
}

?>