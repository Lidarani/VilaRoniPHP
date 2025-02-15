<?php
session_start();
include "../app/db.php";
if (isset($_SESSION["username"])) {
    $redirectPage = $_SESSION['username'] === 'admin' ? 'dashboard_admin.php' : 'calendar_user.php';
}
else {
    $redirectPage = 'login.php';
}
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
$user_ip = getUserIP();

if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    $stmt = $conn->prepare("SELECT * FROM analytics WHERE page_name = 'homepage'");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_page_views = $row['page_views'] + 1;

        if ($row['last_visitor_ip'] != $user_ip) {
            $new_unique_visitors = $row['unique_visitors'] + 1;
        } else {
            $new_unique_visitors = $row['unique_visitors'];
        }

        $update_stmt = $conn->prepare("UPDATE analytics SET page_views = ?, unique_visitors = ?, last_visitor_ip = ?, last_visit_time = NOW() WHERE page_name = 'homepage'");
        $update_stmt->bind_param("iii", $new_page_views, $new_unique_visitors, $user_ip);
        $update_stmt->execute();
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO analytics (page_name, page_views, unique_visitors, last_visitor_ip) VALUES ('homepage', 1, 1, ?)");
        $insert_stmt->bind_param("s", $user_ip);
        $insert_stmt->execute();
    }
}
?>

<!DOCTYPE html>
<head>
	<title>Pensiunea Roni</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="homepage.css">
	<script src="homepage.js"></script>
</head>
<body>
	<script src="homepage.js"></script>
	<div id="before">
		<img src="../img/dark.png" alt="bd" id="bd-image">
	</div>
	<div id="after">
        <?php include '../src/header.php'; ?>
		<div class="book">
		</div>
		<section>
			<div class = "container">
				<div class = "white-box">
					<h1 id = "title"> Pensiunea Roni</h1>
					<section id = "slogan">
						<h2> Quiet neighborhood, enjoyable walks around, wonderful view.</h2>
					</section>
				</div>
			</div>
		</section>
		<!-- <div class = "buton">
			<button id="glow-button" onclick="showModal()"> Welcome</button>
		</div>
		<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close" onclick="closeModal()"> &times; </span>
				<div class="slideshow-container">
					<div class="mySlides fade">
						<div class="numbertext">1 / 6</div>
						<img src="../img/img1.jpg" alt="img1" class = "showimg">
					</div>
					<div class="mySlides fade">
						<div class="numbertext">2 / 6</div>
						<img src="../img/img2.jpg" alt="img2" class = "showimg">
					</div>
					<div class="mySlides fade">
						<div class="numbertext">3 / 6</div>
						<img src="../img/img4.jpg" alt="img3" class = "showimg">
					</div>
					<div class="mySlides fade">
						<div class="numbertext">4 / 6</div>
						<img src="../img/img6.jpg" alt="img4" class = "showimg">
					</div>
					<div class="mySlides fade">
						<div class="numbertext">5 / 6</div>
						<img src="../img/img7.jpg" alt="img5" class = "showimg">
					</div>
					<div class="mySlides fade">
						<div class="numbertext">6 / 6</div>
						<img src="../img/img8.jpg" alt="img6" class = "showimg">
					</div>
					<a id="prev" onclick="plusSlides(-1)"> &lt; </a>
					<a id="next" onclick="plusSlides(1)"> > </a>
				</div>
				<br>
				<div id = "spans">
					<span class="dot" onclick="currentSlide(1)"></span>
					<span class="dot" onclick="currentSlide(2)"></span>
					<span class="dot" onclick="currentSlide(3)"></span>
					<span class="dot" onclick="currentSlide(4)"></span>
					<span class="dot" onclick="currentSlide(5)"></span>
					<span class="dot" onclick="currentSlide(6)"></span>
				</div>
			</div>
		</div> -->
        <div class = "buton">
			<button id="glow-button" onclick="window.location.href='<?php echo $redirectPage; ?>'">Welcome</button>
		</div>
	</div>
</body>