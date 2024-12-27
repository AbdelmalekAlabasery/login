<?php
include 'dbcon.php';

// Simple Validator Class
class Validator {
    
    // Validates email format
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validates password strength (minimum 8 characters, including a number and a special character)
    public static function validatePassword($password) {
        $pattern = "/^(?=.*\d)(?=.*[!@#$%^&*(),.?\":{}|<>]).{8,}$/";
        return preg_match($pattern, $password);
    }

    // Sanitizes input to prevent XSS
    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!Validator::validateEmail($email)) {
        echo "Invalid email format!";
        exit();
    }

    // Validate password strength
    if (!Validator::validatePassword($password)) {
        echo "Password must be at least 8 characters long, and contain a number and a special character!";
        exit();
    }

    // Sanitize inputs
    $email = Validator::sanitizeInput($email);
    $password = Validator::sanitizeInput($password);

    // Hash the password using password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database with a parameterized query
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");  // Redirect to login after registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <form method="POST" action="registration.php">
        <label for="email">Email</label>
        <input type="email" name="email" required maxlength="255">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" required maxlength="255">
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
