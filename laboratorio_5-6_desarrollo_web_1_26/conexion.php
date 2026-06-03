<?php
$con = new mysqli("localhost:3307", "root", "", "bd_biblioteca");

if ($con->connect_error) {
    die("Error al conectarse: " . $con->connect_error);
}
?>