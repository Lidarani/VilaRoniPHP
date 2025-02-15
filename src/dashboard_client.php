<?php
// Assuming a session or login check is already in place.
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Menu</title>
        <?php include 'header.php'; ?>
        <link rel="stylesheet" href="dashboard_client.css">
        <script>
            function confirmDelete() {
                return confirm(" Are you sure you want to delete your account?\n This will cancel all your reservations!\n This action cannot be undone!");
            }
        </script>
</head>
<body>
    <div class="menu">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <ul>
            <li><a href="modify_account.php">Modify Account Details</a></li>
            <li><a href="view_reservations.php">See Reservations</a></li>
            <li><a id = delete_account href="delete_account.php" onclick="return confirmDelete()">Delete Account</a></li>
        </ul>
    </div>
</body>
</html>