<?php
$servername = "localhost";
$username = "root";
$password = "Licoreria"; 
$dbname = "Cheers";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) die("Conexión fallida: " . mysqli_connect_error());
