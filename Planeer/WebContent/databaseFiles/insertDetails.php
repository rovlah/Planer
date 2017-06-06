<?php 
// Including database connections
require_once 'database_connections.php';
// Fetching and decoding the inserted data
$data = json_decode(file_get_contents("php://input")); 
// Escaping special characters from submitting data & storing in new variables.
$kategorija = mysqli_real_escape_string($con, $data->kategorija);
$ime = mysqli_real_escape_string($con, $data->ime);
$vaznost = mysqli_real_escape_string($con, $data->vaznost);
$datum = mysqli_real_escape_string($con, $data->datum);

// mysqli insert query
$query = "INSERT into detalji (ime_kategorije,ime_obveze,vaznost_obveze,datum_obveze) VALUES ('$kategorija','$ime','$vaznost','$datum')";
// Inserting data into database
mysqli_query($con, $query);
echo true;
?>