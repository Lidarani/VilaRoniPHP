<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])):
    header("location: login.php");
    exit;
endif;

include '../app/db.php';

function make_reservation($client_id, $camera_id, $data_inceput, $durata, $observatii) {
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO Rezervare (id_client, id_camera, data_inceput, durata, observatii) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $client_id, $camera_id, $data_inceput, $durata, $observatii);

    if ($stmt->execute()) {
        echo "Reservation made successfully!";
    } else {
        echo "Error making reservation: " . $stmt->error;
    }

    $stmt->close();
}

$day = isset($_GET['day']) ? (int)$_GET['day'] : 0;
$month = isset($_GET['month']) ? (int)$_GET['month'] : 0;
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;

if ($day && $month && $year) {
    $date_selected = "$year-$month-$day";

    $sql = "SELECT c.id, c.numar_camera, t.nume FROM Camera c JOIN Tip_camera t ON c.tip = t.id";
    $result = $conn->query($sql);
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $room_id = $_POST['room_id'];
        $duration = $_POST['duration'];
        $observations = $_POST['observations'];

        $client_id = $_SESSION['user_id'];
        make_reservation($client_id, $room_id, $date_selected, $duration, $observations);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reserve Room</title>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" type="text/css" href="reserve.css">
</head>
<body>
    <div class="container">
        <h2>Reserve Room for <?php echo date('F j, Y', strtotime($date_selected)); ?></h2>
        
        <?php if (count($rooms) > 0): ?>
    <form method="post">
        <h3>Select Room for Reservation</h3>
        <?php
        foreach ($rooms as $room):
            $room_id = $room['id'];

            $sql = "SELECT COUNT(*) as reserved_count FROM Rezervare WHERE id_camera = $room_id AND data_inceput = '$date_selected'";
            $result = $conn->query($sql);
            $reserved_count = $result->fetch_assoc()['reserved_count'];

            if ($reserved_count == 0):
        ?>

            <div class="room-info">
                <label for="room_id_<?php echo $room_id; ?>">Select Room:</label>
                <input type="radio" id="room_id_<?php echo $room_id; ?>" name="room_id" value="<?php echo $room_id; ?>" required>
                <label for="room_id_<?php echo $room_id; ?>"><?php echo $room['numar_camera'] . ' - ' . $room['nume']; ?></label>
            </div>

        <?php 
            endif;
        endforeach;
        ?>

        <br>

        <label for="duration">Duration (days):</label>
        <input type="number" name="duration" id="duration" required>
        <br>

        <label for="observations">Observations:</label>
        <textarea name="observations" id="observations"></textarea>
        <br>

        <button type="submit">Confirm Reservation</button>
    </form>
<?php else: ?>
    <p>No rooms available for the selected date.</p>
<?php endif; ?>
    </div>
</body>
</html>