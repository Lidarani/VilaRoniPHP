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
		<link rel="stylesheet" href="aboutus.css">
		<script src="about.js"></script>
	</head>
	<body>
		<?php include '../src/header.php'; ?>
		<div class="book">
		</div>
		<h2 id="subtitle">About us</h2>
		<hr>
		<div class="about">
			<img class="about-img" alt ="ab" src="https://scontent.fclj1-2.fna.fbcdn.net/v/t31.18172-8/18489657_172872229908788_3900223506733217945_o.jpg?_nc_cat=107&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeGNPWGEnIYOWHQ_scRZvDxUUL3Tvr0blpFQvdO-vRuWkdayW--SVNdMsURXYOM4CbkUSz8cu8T6uQrazirkvqXJ&_nc_ohc=3FF7QVVtxNEAX_JqMHZ&_nc_ht=scontent.fclj1-2.fna&oh=00_AfCwWkSaWwKFjax3fzaS9IZC7q9oyvgXYfy1tbR2aK1AXQ&oe=6499FBE3">
			<p class="about-p"><i>"Our property is located far away from the noisy city and roads, close to the woods. It's the only place where you can find quietness and peace of the mind and soul. We offer a spectacular view to the Carpathians Mountains and the surroundings.
			
				Starting with 2004, my family and I decided to open a brand new property, different from all other properties, with a new perspective on offering quality service and assistance to all our guests.
				Quiet neighborhood, enjoyable walks around, wonderful view" ~Mihaela Benhaim~</i><br>Languages spoken:
			English, French, Hebrew, Romanian</p>
		</div>
		<div class="reviews">
			<p id="rews">Reviews</p>
			<br><br><br>
			<img  src="../img/bordura.jpg" alt ="covor" class = "bordura">
			<div class="review">
				<img src="https://xx.bstatic.com/static/img/review/avatars/ava-i.png" alt = "poza1">
				<p><i>„Locația,o priveliște de vis,aer curat, facilități foarte bune, mulțumim”</i></p>
			</div>
			<img  src="../img/bordura.jpg" alt ="covor" class = "bordura">
			<div class="review">
				<img src="https://xx.bstatic.com/static/img/review/avatars/ava-r.png" alt = "poza2">
				<p><i>„Priveliște superba, gazda foarte ospitaliera . Ne-am simțit ca acasa .De acum numai acolo vom merge .”</i></p>
			</div>
			<img  src="../img/bordura.jpg" alt ="covor" class = "bordura">
			<div class="review">
				<img src="https://xx.bstatic.com/static/img/review/avatars/ava-g.png" alt = "poza3">
				<p><i>„Locatia este foarte buna.E liniste, o panorama frumoasa, se vad muntii. Curtea este mare, placut amenajata. Gazdele sunt deosebite. Isi dau silinta ca oaspetii sa se simta bine, sa nu le lipseasca nimic. Vom reveni cu placere.”</i></p>
			</div>
			<img  src="../img/bordura.jpg" alt ="covor" class = "bordura">
		</div>
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