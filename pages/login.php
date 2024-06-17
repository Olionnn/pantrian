<?php 
    $title = "Login Page";
    $custom = "";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start(); 
    require_once("../layout/header.php");
    require_once("../db.php");


    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Data Tidak Boleh Kosong'];
        } else {
            $username = $db->real_escape_string($username);
            $data = $db->query("SELECT username, password , role_id FROM users WHERE username = '$username'");
            if ($data->num_rows > 0) {
                $row = $data->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user'] = ['username' => $row['username'], 'role_id' => $row['role_id']];
                    header('Location: ./dashboard.php');
                    exit();
                } else {
                    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Password Salah'];
                }
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Username Tidak Ditemukan'];
            }
        }
    }



?>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <img class="col-lg-6 d-none d-lg-block bg-login-image" src="https://placehold.co/420/1F2544/FFD0EC?text=MC+SERVER&font=roboto" alt="">
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="POST">
                                    <?php
                                    if (isset($_SESSION['message'])) {
                                        $message = $_SESSION['message'];
                                        echo ("<div class='alert alert-{$message['type']}' role='alert'>
                                                {$message['text']}
                                            </div>");
                                        unset($_SESSION['message']); 
                                    }
                                    ?>
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukan Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Masukan Password">
                                        </div>
                                        <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="./forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="./register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php require_once("../layout/footer.php"); ?>
