<?php
session_start();
include "../app/db.php";
if (isset($_SESSION["username"])) {
    $redirectPage = $_SESSION['username'] === 'admin' ? 'dashboard_admin.php' : 'calendar_user.php';
}
else {
    $redirectPage = 'login.php';
}
?>

<!DOCTYPE html>
<head>
	<title>Pensiunea Roni</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="rooms.css">
	<script type="text/javascript" src="rooms.js">
	</script>
</head>
<body>
	<?php include 'header.php'; ?>
	<div class="book">
	</div>
	<h2 id ="subtitle"> Rooms </h2	>
	<hr>
	<section id="rooms">
		<div class="room">
			<h2>Double Room</h2>
			<img class = "room-photo" src="../img/dubla.png" alt="Double Room">
			<p>
				Our Double Room is a cozy and comfortable room perfect for couples. It features a double bed, a private bathroom, and all the amenities you need to enjoy your stay.
			</p>
			<p class = "price">Price: 190 RON per night</p>
			<hr>
			<div class = "amm">
				<ul>
					<li> Television </li>
					<li> Free Wi-fi </li>
					<li> Warm in the winter </li>
					<li> View to the mountains </li>
					<li> Private bathroom</li>
					<li> Bathroom amenities included </li>
				</ul>
				<button class = "res" onclick="window.location.href='<?php echo $redirectPage; ?>'"> Reserve now!</button>
			</div>
		</div>
		<div class="room">
			<h2>Triple Room</h2>
			<img class = "room-photo" src="../img/tripla.png" alt="Triple Room">
			<p>
				Our Triple Room is a spacious and stylish room perfect for families or groups of friends. It features three comfortable beds, a private bathroom, and all the amenities you need to enjoy your stay.
			</p>
			<p class = "price">Price: 220 RON per night</p>
			<hr>
			<div class = "amm">
				<ul>
					<li> Perfect for families </li>
					<li> Television </li>
					<li> Free Wi-fi </li>
					<li> Warm in the winter </li>
					<li> View to the mountains </li>
					<li> Private bathroom</li>
				</ul>
				<button class = "res" onclick="window.location.href='<?php echo $redirectPage; ?>'"> Reserve now!</button>
			</div>
		</div>
	</section>
	<div id="final">
		<p class="trademark">Pension Roni® 2023</p>
		<hr>
		<footer>
			<div>
				<p>Contact us:</p>
				<p>Phone: +(40) 0740 207 562</p>
				<p>Email: haimlida@hotmail.com</p>
			</div>
			<img id="logof" alt="logofooter" src="../img/logo1.png">
		</footer>
	</div>
</body>