<?php
session_start();
include '../app/db.php';

if ($_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit;
}

    $page_query = "SELECT DISTINCT page_name FROM analytics";
    $page_result = $conn->query($page_query);
    $pages = [];
    while ($row = $page_result->fetch_assoc()) {
        $pages[] = $row['page_name'];
    }

    $selected_page = isset($_GET['page_name']) ? $_GET['page_name'] : ($pages[0] ?? '');

    $analytics_query = "SELECT last_visit_time, page_views FROM analytics WHERE page_name = ?";
    $stmt = $conn->prepare($analytics_query);
    $stmt->bind_param("s", $selected_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $analytics_data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics</title>
    <?php include 'header.php'; ?>
    <script>
        function updateAnalytics() {
            let pageName = document.getElementById("pageDropdown").value;
            window.location.href = "admin_analytics.php?page_name=" + encodeURIComponent(pageName);
        }
    </script>
    <link rel="stylesheet" href="admin_dash.css">
</head>
<body>

    <div class="container">
        <h2>Analytics Dashboard</h2>

        <label for="pageDropdown">Select Page:</label>
        <select id="pageDropdown" name="page_name" onchange="updateAnalytics()">
            <?php foreach ($pages as $page): ?>
                <option value="<?php echo htmlspecialchars($page); ?>" <?php echo ($selected_page == $page) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($page); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <table class="analytics-table">
            <thead>
                <tr>
                    <th>Last Visit Time</th>
                    <th>Page Views</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($analytics_data)): ?>
                    <?php foreach ($analytics_data as $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['last_visit_time']); ?></td>
                            <td><?php echo htmlspecialchars($data['page_views']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">No data available for this page.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>