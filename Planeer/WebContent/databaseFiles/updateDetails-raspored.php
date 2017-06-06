<?php
// Including database connections
require_once 'database_connections.php';
// Fetching the updated data & storin in new variables
$data = json_decode(file_get_contents("php://input"));
// Escaping special characters from updated data
$broj = mysqli_real_escape_string($con, $data->broj);
$naziv_kolegija = mysqli_real_escape_string($con, $data->naziv_kolegija);
$pred_vjezbe = mysqli_real_escape_string($con, $data->pred_vjezbe);
$ime_profesora = mysqli_real_escape_string($con, $data->ime_profesora);
$dan = mysqli_real_escape_string($con, $data->dan);
$pocetak = mysqli_real_escape_string($con, $data->pocetak);
$zavrsetak = mysqli_real_escape_string($con, $data->zavrsetak);

// mysqli query to insert the updated data
$query = "UPDATE raspored SET naziv_kolegija='$naziv_kolegija',pred_vjezbe='$pred_vjezbe',ime_profesora='$ime_profesora',dan='$dan',pocetak='$pocetak',zavrsetak='$zavrsetak' WHERE broj=$broj";
mysqli_query($con, $query);
echo true;
?>