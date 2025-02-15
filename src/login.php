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

    $stmt = $conn->prepare("SELECT id, username, password FROM client WHERE username = ?");
    $stmt->bind_param("s", $username);  
    $stmt->execute();  
    $result = $stmt->get_result();  
    $row = $result->fetch_assoc();  

    if ($result->num_rows == 1) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            if(getenv('IS_TESTING')) 
                return;
            if($_SESSION['username'] === 'admin') {
                header("location: dashboard_admin.php");
                exit;
            }
            header("location: homepage.php");
            exit;
        } else {
             $error_message = "Incorrect password";
        }
    } else {
         $error_message = "User does not exist!"; 
    }

    $stmt->close(); 
    mysqli_close($conn);  
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <?php include 'header.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="login-container">
        <h2>Login</h2>
        <p id="register_now"><a href="register.php">Not a member? Register now!</a></p>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <p id="error-message" style="color: red; text-align: center; margin-top: 10px;">
				<?php echo htmlspecialchars($error_message); ?>
			</p>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>