<?php
session_start();
include '../app/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to delete your account.";
    exit;
}

$user_id = $_SESSION['user_id'];

$delete_reservations_sql = "DELETE FROM rezervare WHERE id_client = ?";

if ($stmt = $conn->prepare($delete_reservations_sql)) {
    $stmt->bind_param('i', $user_id);
    if ($stmt->execute()) {
        $sql = "DELETE FROM client WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $user_id);
            if ($stmt->execute()) {
                echo "Account and reservations deleted successfully.";
                session_destroy();
                header("Location: homepage.php");
                exit;
            } else {
                echo "Error deleting the account.";
            }
            $stmt->close();
        }
    } else {
        echo "Error deleting reservations.";
    }
    $stmt->close();
}

$conn->close();
?>