<?php 
$host = "localhost";
$user = "root";
$pwd ="";
$database = "produitdb";

$conn = mysqli_connect($host, $user, $pwd, $database);
if(!$conn){
    echo "";
}
?>