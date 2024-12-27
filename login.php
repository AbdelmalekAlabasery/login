<?php
session_start();
include 'dbcon.php';

// Simple Validator Class for output encoding
class Validator {

    // Sanitizes and encodes input to prevent XSS
    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }

    // Sanitize the input
    $email = Validator::sanitizeInput($email);
    $password = Validator::sanitizeInput($password);

    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and password is correct
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password using password_verify (uses password_hash in registration)
        if (password_verify($password, $user['password'])) {
            // Password matches, create session
            $_SESSION['user'] = $user['email']; // Store user email in session or other details

            // Redirect to the index page (or a dashboard)
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid email or password!";
        }
    } else {
        // User does not exist
        echo "No user found with that email!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <!-- Login Form -->
    <form method="POST" action="login.php">
        <h2>Login</h2>
        <a href="registration.php" class="btn btn-danger">Don't have an account? Register here</a>
        <br><br>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" required maxlength="255">
        <br>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required maxlength="255">
        <br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
