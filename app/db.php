<?php
$default_db = 'vilaroni_roni';
$host = 'mysql-vilaroni.alwaysdata.net';
$username = 'vilaroni_admin'; 
$password = 'Caiorn007';
$conn = mysqli_connect($host, $username, $password, $default_db);

if($conn === false){
    die("Connection Error: " . mysqli_connect_error());
}
?>