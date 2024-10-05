<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include PHPMailer autoload

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';


function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


// Validate fullname (letters, space, dash, quotation)
function validateFullname($fullname) {
    return preg_match("/^[a-zA-Z\s\-'\"]+$/", $fullname);
}


// Validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateEmailDomain($email) {
    $allowedDomains = ['@strathmore.edu', '@gmail.com', '@yahoo.com', '@mada.co.ke'];
    $blockedDomains = ['@yanky.net'];
    
    $emailDomain = substr(strrchr($email, "@"), 1);  // Get the email domain
    
    foreach ($blockedDomains as $blocked) {
        if (strpos($email, $blocked) !== false) {
            return false;  // Email is blocked
        }
    }

    foreach ($allowedDomains as $allowed) {
        if (strpos($email, $allowed) !== false) {
            return true;   // Email is allowed
        }
    }

    return false;
}

function validatePasswordLength($password) {
    return strlen($password) >= 4 && strlen($password) <= 8;
}

function emailExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

function usernameExists($pdo, $username) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetchColumn() > 0;
}



// Generate OTP
$otp = rand(100000, 999999);

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com';
        $mail->Password = 'your_password';
        $mail->SMTPSecure = 'tls';   // Enable TLS encryption
        $mail->Port = 587;           // TCP port to connect to

        // Recipients
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body    = "Your OTP is: <b>$otp</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Store OTP in session (or database)
$_SESSION['otp'] = $otp; 

// Verify OTP
function verifyOTP($userOtp) {
    return $userOtp == $_SESSION['otp'];  // Compare input OTP with session OTP
}


class memberloginform{
    public function loginform(){
        ?>
        <!DOCTYPE html<html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Library - Home</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container mt-5 mb-5 container rounded-5 p-4 shadow">
            <h1 class=" col mb-3 ">Login</h1>
 
            <form action="submit_borrow.php" method="POST" class=''> <!-- Specify the action and method -->


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

?>