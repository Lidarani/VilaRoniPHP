<?php
session_start();
require '../app/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    if ($new_password !== $confirm_password) {
        die("New passwords do not match.");
    }

    $sql = "SELECT password FROM client WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($current_password, $user['password'])) {
        die("Incorrect current password.");
    }

    $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = "UPDATE client SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password_hashed, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: modify_account.php?password_updated=1");
    exit;
}
?>