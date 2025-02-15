<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: homepage.php");
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include __DIR__ . '/../app/db.php';

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $nume = trim($_POST['nume']);
    $telefon = trim($_POST['telefon']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    }
    // Validate phone number (only digits allowed)
    elseif (!empty($telefon) && !preg_match('/^\d+$/', $telefon)) {
        $error_message = "Phone number can only contain numbers.";
    }
    // Validate name (cannot contain numbers)
    elseif (!empty($nume) && preg_match('/\d/', $nume)) {
        $error_message = "Name cannot contain numbers.";
    }
    // Check if passwords match
    elseif ($password !== $confirm_password) {
        $error_message = "Passwords don't match.";
    } else {
        // Check if the username already exists
        $stmt = $conn->prepare("SELECT id FROM client WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error_message = "This username is already taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO client (username, password, email, nume, telefon) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $hashed_password, $email, $nume, $telefon);
            
            if ($stmt->execute()) {
                header("location: login.php");
                // After successful registration, redirect to the login page
                header("location: login.php");
                exit;
            } else {
                $error_message = "Registration error. Please try again.";
            }
        }
        $stmt->close();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="login.css">
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <p id="register_now"><a href="login.php">Already a member? Login now!</a></p>
        <?php if (!empty($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            <br>
            <label>Email:</label>
            <input type="text" name="email" required>
            <br>
            <label>Name (optional):</label>
            <input type="text" name="nume">
            <br>
            <label>Phone (optional):</label>
            <input type="text" name="telefon">
            <br>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
