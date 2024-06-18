<?php
$title = "Register Page";
$custom = "";

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

require_once("../layout/header.php");
require_once("../db.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = 3;

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Data Tidak Boleh Kosong'];
    } else {
        $remail = $db->real_escape_string($email);
        $data = $db->query("SELECT username FROM users WHERE email = '$remail'");
        foreach ($data as $row) {
            echo($row['username']);
        }
        if ($data->num_rows > 0) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Email Sudah Terdaftar'];
        } else {

            if ($password != $cpassword) {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Password tidak sama'];
                header('Location: ./register.php');
                exit();
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $username = $db->real_escape_string($username);

            $sql = "INSERT INTO users (id, username, email, password, role_id) VALUES (0, '$username', '$remail', '$hashed_password', $role)";
            if ($db->query($sql) === TRUE) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Registrasi berhasil!'];
                header('Location: ./login.php');
                exit(); 
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Registrasi gagal: ' . $db->error];
            }
        }
    }
}
?>


<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <img class="col-lg-5 d-none d-lg-block bg-register-image" src="https://placehold.co/520/1F2544/FFD0EC?text=MC+SERVER&font=roboto" alt="">
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
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
                                <input type="text" name="username" class="form-control form-control-user" id="exampleFirstName"
                                    placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                    placeholder="Email Address">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="cpassword" class="form-control form-control-user"
                                        id="exampleRepeatPassword" placeholder="Repeat Password">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Register Account">
                        </form>
                        <hr>
                        <!-- <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div> -->
                        <!-- <div class="text-center">
                            <a class="small" href="./login.php">Already have an account? Login!</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    $customsc = "";
    require_once("../layout/footer.php");
?>
