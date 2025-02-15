window.onload = function() {
  var before = document.getElementById('before');
  var after = document.getElementById('after');

  setTimeout(function() {
    before.style.opacity = 0;
    before.style.pointerEvents = 'none';
    after.classList.add('show');
  }, 700);
};

function leftRight(event)
  {
    if(event.key == 'a' || event.key == 'LeftArrow')
      plusSlides(-1);
    else if(event.key == 'd' || event.key == 'RightArrow')
      plusSlides(1);
  }

function showModal()
{ 
  var modal = document.getElementById("myModal");
  modal.style.display = "block";
  showSlides(1);

  document.addEventListener("keydown", leftRight);
}

function closeModal()
{
  var modal = document.getElementById("myModal");
  modal.style.display = "none";

  document.removeEventListener("keydown", leftRight);
}

var slideIndex = 1;

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIdex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

function plusSlides(n) 
{
  showSlides(slideIndex += n);
}

function plusSlide(event)
{
  let k = event.key;
  if(k == 'd' || k == "ArrowRight")
    plusSlides(1);
  if(k == 'a' || k == "ArrowLeft")
    plusSlides(-1);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}
