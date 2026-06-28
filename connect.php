<?php
$servername = "localhost";
$username   = "bimbel_pintar";
$password   = "AF6jEz9fTe0LfqO2";
$dbname     = "bimbel_pintar";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
