<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

include '../app/db.php';

if (isset($_POST['cancel_reservation'])) {
    $reservation_id = (int)$_POST['reservation_id'];
    $sql = "DELETE FROM rezervare WHERE id = $reservation_id AND id_client = " . $_SESSION['user_id'];
    
    if ($conn->query($sql) === TRUE) {
        echo "Reservation cancelled successfully!";
    } else {
        echo "Error cancelling reservation: " . $conn->error;
    }
}

$user_id = $_SESSION['user_id'];
$sql = "
    SELECT r.id, r.data_inceput, r.durata, r.observatii, c.numar_camera, t.nume 
    FROM rezervare r 
    JOIN camera c ON r.id_camera = c.id 
    JOIN tip_camera t ON c.tip = t.id 
    WHERE r.id_client = $user_id 
    ORDER BY r.data_inceput DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="view_reservations.css">
</head>
<body>
    <div class="container">
        <h2>Your Reservations</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Start Date</th>
                        <th>Duration (days)</th>
                        <th>Observations</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['numar_camera']; ?></td>
                            <td><?php echo $row['nume']; ?></td>
                            <td><?php echo date('F j, Y', strtotime($row['data_inceput'])); ?></td>
                            <td><?php echo $row['durata']; ?></td>
                            <td><?php echo htmlspecialchars($row['observatii']); ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="cancel_reservation" class="cancel-button">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no reservations yet.</p>
        <?php endif; ?>

    </div>
</body>
</html>
