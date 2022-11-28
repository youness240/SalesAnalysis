<?php
//setting header to json
header('Content-Type: application/json');

include('config.php');
include("auth_session.php");
//query to get data from the table


$query = sprintf("SELECT avis,id_jours FROM jours_vendeur,vendeur WHERE vendeur.username='".$_SESSION['username']."' && vendeur.id=id_vendeur");

$data = mysqli_query($mysqli,"SELECT id as id_user FROM vendeur WHERE username='".$_SESSION['username']."'") or die(mysql_error());
$row = mysqli_fetch_assoc($data);
$id = $row['id_user'];

if (isset($_POST['btn']))
{
  $val=$_SESSION['jours'];
  $query = sprintf("SELECT prenom,avis from client where id in (SELECT jours_client.id_client from jours_client,client_vendeur where id_vendeur=$id && id_jours=$val && client_vendeur.id_client=jours_client.id_client)");
}


//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
?>
