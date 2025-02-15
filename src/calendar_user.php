<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])):
    header("location: login.php");
    exit;
else:
    if ($_SESSION['username'] == 'admin'):
        header("location: dashboard_admin.php");
        exit;
    endif;
endif;
include '../app/db.php';
echo '<link rel="stylesheet" type="text/css" href="calendar_user.css">';

function draw_calendar($month, $year) {
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, numar_camera, tip FROM Camera";
    $result = $conn->query($sql);
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
    $headings = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    if ($running_day == 0) {
        $running_day = 7;
    }
    
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

    $calendar .= '<tr class="calendar-row">';
    $days_in_this_week = 1;
    $day_counter = 0;

    for ($x = 1; $x < $running_day; $x++) {
        $calendar .= '<td class="calendar-day-np"> </td>';
        $days_in_this_week++;
    }

    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
        $available_rooms = count($rooms);
        $reservations_sql = "SELECT COUNT(*) as reserved_count FROM Rezervare WHERE data_inceput = '$year-$month-$list_day'";
        $reservations_result = $conn->query($reservations_sql);
        $reserved_count = $reservations_result->fetch_assoc()['reserved_count'];
        $available_rooms -= $reserved_count;

        $current_date = date('Y-m-d');
        $current_day = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($list_day, 2, '0', STR_PAD_LEFT);
        $is_past_date = ($current_day < $current_date);

        $calendar .= '<td class="calendar-day">';
        if (!$is_past_date) {
            $calendar .= '<a href="reserve.php?day=' . $list_day . '&month=' . $month . '&year=' . $year . '">';
        }
        $calendar .= '<div class="day-number">' . $list_day . '</div>';
        if (!$is_past_date) {
            $calendar .= '</a>';
        }
        $calendar .= '<div class="available-rooms">Available rooms: ' . max(0, $available_rooms) . '</div>';
        $calendar .= '</td>';

        if ($running_day == 7) {
            $calendar .= '</tr>';
            if (($day_counter + 1) != $days_in_month) {
                $calendar .= '<tr class="calendar-row">';
            }
            $running_day = 0;
            $days_in_this_week = 0;
        }

        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    }

    if ($days_in_this_week < 7) {
        for ($x = 1; $x <= (7 - $days_in_this_week); $x++) {
            $calendar .= '<td class="calendar-day-np"> </td>';
        }
    }

    $calendar .= '</tr>';
    $calendar .= '</table>';

    return $calendar;
}

$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$prevMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
$prevYear = $currentMonth == 1 ? $currentYear - 1 : $currentYear;
$nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
$nextYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="calendar-controls">
            <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>"><button>Previous</button></a>
            <span><?php echo date('F', mktime(0, 0, 0, $currentMonth, 10)); ?> <?php echo $currentYear; ?></span>
            <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>"><button>Next</button></a>
        </div>

        <?php echo draw_calendar($currentMonth, $currentYear); ?>
    </div>
</body>
</html>