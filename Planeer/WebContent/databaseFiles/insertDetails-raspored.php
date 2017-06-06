<?php
// Including database connections
require_once 'database_connections.php';
// Fetching and decoding the inserted data
$data = json_decode(file_get_contents("php://input"));
// Escaping special characters from submitting data & storing in new variables.
$naziv_kolegija = mysqli_real_escape_string($con, $data->naziv_kolegija);
$pred_vjezbe = mysqli_real_escape_string($con, $data->pred_vjezbe);
$ime_profesora = mysqli_real_escape_string($con, $data->ime_profesora);
$dan = mysqli_real_escape_string($con, $data->dan);
$pocetak = mysqli_real_escape_string($con, $data->pocetak);
$zavrsetak = mysqli_real_escape_string($con, $data->zavrsetak);

// mysqli insert query
$query = "INSERT into raspored (naziv_kolegija,pred_vjezbe,ime_profesora,dan,pocetak,zavrsetak) VALUES ('$naziv_kolegija','$pred_vjezbe','$ime_profesora','$dan','$pocetak','$zavrsetak')";
// Inserting data into database
mysqli_query($con, $query);
echo true;
?>