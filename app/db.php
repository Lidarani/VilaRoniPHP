<?php
$default_db = 'roni';
$conn = mysqli_connect("localhost", "root", "", $default_db);

if($conn === false){
    die("Eroare la conectare. " . mysqli_connect_error());
}
?>