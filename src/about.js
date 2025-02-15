window.onload = function randSelectReviews()
{
	comments = [
	"<p><i>„Superb, friendly staff, clean, warm, nice yard and nice view. We will come back!.”</i></p>",
	"<p><i>„The place looks better in reality than in the pictures. Maybe the pictures should be updated with new ones.”</i></p>",
	"<p><i>„Locația,o priveliște de vis,aer curat, facilități foarte bune, mulțumim”</i></p>",
	"<p><i> Amabilitate, curatenie, panorama superba, recomandarile gazdei pentru vizitarea obiectivelor turistice din zona.Am sa recomand cu placere, asa cum de altfel sper sa mai revin </i> </p>",
	"<p><i> Foarte cutat. Un loc excellent pentru familie și prieteni. Bucătărie spatioasa si living unde poți petrece cu familia și prieteni.</i></p>",
	"<p><i> Liniste, priveliste foarte frumoasa daca vremea o permite, cabana din lem aproape de padure, camere curate, bucataria ultilata, si nu in ultimul rand gazda de nota 20. Felicitari doamna Miki </i></p>",
	"<p><i> Locatie super, cu priveliste minunata. Gazde super amabile. Mi s-a stricat automobilul si am fost ajutat de gazde cu mecanic si transport la pensiune. Le multumesc si pe aceasta cale gazdelor (lui Miki in special).</i></p>"
	]

	images = [
	"<img src = 'https://xx.bstatic.com/static/img/review/avatars/ava-i.png' id = 'imgRev1'>",
	"<img src = 'https://lh5.googleusercontent.com/-qtTNdrnNQHA/AAAAAAAAAAI/AAAAAAAAAAA/AMZuuckMkByIinYvb9E-uF3ALbEJu1ruqA/s96-c/photo.jpg' id = 'imgRev2'>",
	"<img src = 'https://xx.bstatic.com/static/img/review/avatars/ava-g.png' id = 'imgRev3'>"
	]

	let rand = Math.floor(Math.random() * 1000) % 7;
	revs = document.getElementsByClassName("review")
	let r2 = Math.floor(Math.random() * 100);
	
	for(let i = 0; i < 3; i++)
	{
		revs[i].innerHTML = images[(r2 + i) % 3] + comments[(rand * i) % 7];
	}

	var list = document.getElementById("imgRev1").classList;
	list.add("review-img")


	list = document.getElementById("imgRev2").classList;
	list.add("review-img")


	list = document.getElementById("imgRev3").classList;
	list.add("review-img")
}