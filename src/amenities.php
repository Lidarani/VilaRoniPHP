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
<html>
	<head>
		<title>Pensiunea Roni</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="amenities.css">
	</head>
	<body>
		<?php include '../src/header.php'; ?>
		<div class="book">
		</div>
		<h2 id="subtitle">Amenities</h2>
		<hr>
		<section id="amenities">
			<div class="amenity">
				<div class="amenity-item-l">
					<img src="../img/Billiards.jpg" alt="Biliards">
					<h3>Biliards</h3>
					<hr>
					<p>Enjoy a game of biliards in our cozy game room.</p>
				</div>
				<div class="amenity-item-r">
					<img src="../img/dining.jpg" alt="Dining Room">
					<h3>Dining Room</h3>
					<hr>
					<p>Our business room is equipped with everything you need to work during your stay.</p>
				</div>
			</div>
			<div class = "amenity">
				<div class = "amenity-item-l">
					<img src="../img/bbq.jfif" alt="BBQ">
					<h3>BBQ</h3>
					<hr>
					<p>Have a fun barbecue with your friends and family in our outdoor BBQ area.</p>
				</div>
				<div class="amenity-item-r">
					<img src="../img/kitchen.jpg" alt="kitchen">
					<h3>Kitchen</h3>
					<hr>
					<p>Our cozy kitchen is perfect for a romantic getaway or a private retreat.</p>
				</div>
			</div>
			<div class="amenity">
				<div class="amenity-item-l">
					<img src="../img/garden.jpg" alt="Garden">
					<h3>Garden</h3>
					<hr>
					<p>Take a stroll in our beautiful garden and enjoy the peaceful surroundings.</p>
				</div>
				<div class="amenity-item-r">
					<img src="../img/bungalow.jpg" alt="bungalow">
					<h3>Bungalow</h3>
					<hr>
					<p>A nice place to spend your time.</p>
				</div>
			</div>
			<div class="amenity">
				<div class="amenity-item-l">
					<img src="../img/sandbox.jpg" alt="sand">
					<h3>Sandpit</h3>
					<hr>
					<p>A safe place for your kids to have fun.</p>
				</div>
				<div class="amenity-item-r">
					<img src="../img/parking.jpg" alt="park">
					<h3>Parking</h3>
					<hr>
					<p>We offer free parking for all our guests.</p>
				</div>
			</div>
		</section>
		<p class="trademark">Pension Roni® 2023</p>
		<hr>
		<footer>
			<div>
				<p>Contact us:</p>
				<p>Phone: +(40) 0740 207 562</p>
				<p>Email: haimlida@hotmail.com</p>
			</div>
			<img id="logof" alt = "logofooter" src="../img/logo1.jpg">
		</footer>
	</body>
</html>