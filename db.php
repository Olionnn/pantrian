<?php 

    $hostname = "localhost";
    $username = "root";
    $password = "121212";
    $database = "pantrian";

    $db = mysqli_connect($hostname, $username, $password, $database);

    if (!$db) {
        echo("Error : Koneksi DB");
    }
    


?>