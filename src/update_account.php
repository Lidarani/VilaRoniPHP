<?php
session_start();
require '../app/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['field'], $_POST['new_value'])) {
    $user_id = $_SESSION['user_id'];
    $field = $_POST['field'];
    $new_value = trim($_POST['new_value']);

    $allowed_fields = ['telefon', 'email', 'password', 'nume']; //anti sql injection

    if (!in_array($field, $allowed_fields)) {
        die("Invalid field selection.");
    }

    // If updating password, hash it before storing
    if ($field === 'password') {
        $new_value = password_hash($new_value, PASSWORD_BCRYPT);
    }

    $sql = "UPDATE client SET $field = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database error.");
    }

    $stmt->bind_param("si", $new_value, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: modify_account.php?success=1");
    exit;
}
?>