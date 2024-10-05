<?php

class authenticate {

    public function signup($conn) {
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize inputs
            $fullname = sanitizeInput($_POST['fullname']);
            $username = sanitizeInput($_POST['username']);
            $email = sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Initialize an empty errors array
            $errors = [];

            // Validate inputs
            if (!validateFullname($fullname)) {
                $errors[] = "Fullname can only contain letters, spaces, dashes, or quotation marks.";
            }
            if (!validateEmail($email)) {
                $errors[] = "Invalid email format.";
            }
            if (!validateEmailDomain($email)) {
                $errors[] = "Unauthorized email domain.";
            }
            if (emailExists($conn, $email)) {
                $errors[] = "Email already exists.";
            }
            if (usernameExists($conn, $username)) {
                $errors[] = "Username already exists.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }
            if (!validatePasswordLength($password)) {
                $errors[] = "Password must be between 4 and 8 characters.";
            }

            // If there are no validation errors
            if (empty($errors)) {
                // Generate OTP and store it in session
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;

                // Send OTP to user's email
                if (sendOTP($email, $otp)) {
                    // Redirect to OTP verification page (or display success message)
                    header('Location: otp_verification.php');
                    exit;
                } else {
                    $errors[] = "Failed to send OTP. Please try again.";
                }
            } else {
                // Display validation errors
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            }
        }
    }
}

?>