<?php 

    $hostname = "localhost";
    $username = "root";
    $password = "121212";
    $database = "pantrian";

    $db = mysqli_connect($hostname, $username, $password, $database);

    if (!$db) {
        echo("Error : Koneksi DB");
    }
    
    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Anda berhasil logout'];
        header('Location: login.php');
        exit();
    }



?>