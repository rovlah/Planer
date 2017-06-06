<?php 
// Including database connections
require_once 'database_connections.php';
// Fetching the updated data & storin in new variables
$data = json_decode(file_get_contents("php://input")); 
// Escaping special characters from updated data
$id = mysqli_real_escape_string($con, $data->id);
$kategorija = mysqli_real_escape_string($con, $data->kategorija);
$ime = mysqli_real_escape_string($con, $data->ime);
$vaznost = mysqli_real_escape_string($con, $data->vaznost);
$datum = mysqli_real_escape_string($con, $data->datum);
// mysqli query to insert the updated data
$query = "UPDATE detalji SET ime_kategorije='$kategorija',ime_obveze='$ime',vaznost_obveze='$vaznost',datum_obveze='$datum' WHERE id_obveze=$id";
mysqli_query($con, $query);
echo true;
?>