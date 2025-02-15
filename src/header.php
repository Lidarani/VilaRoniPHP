<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pension Roni</title>
    <link rel="stylesheet" href="header.css">
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="rooms.php">Rooms &amp; Suites</a></li>
            <li><a href="amenities.php">Amenities</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <?php
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                <?php
                if ($_SESSION['username'] === 'admin'): ?>
                    <li><a href="dashboard_admin.php">Dashboard</a></li>
                <?php else: ?>
                    <li><a href="dashboard_client.php">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

</body>
</html>