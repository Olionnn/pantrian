<?php 
    $title = "Register Page";
    $custom = "
    <style>
      
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    </style>
    <link rel='stylesheet' href='../assets/css/signin.css'>

    ";
    require_once("../layout/head.php");
    require_once("../db.php");

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = 3;
        
        if (empty($username) || empty($email) || empty($password)) {
            echo "<script>alert('Data Tidak Boleh Kosong')</script>";
        } else {
            $email = $db->real_escape_string($email);
            $data = $db->query("SELECT * FROM users WHERE email = '$email'");
            if($data->num_rows > 0){
              echo "<script>alert('Email Sudah Terdaftar')</script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $username = $db->real_escape_string($username);

                $sql = "INSERT INTO users (id, username, email, password, role_id) VALUES (0, '$username', '$email', '$hashed_password', $role)";
                if ($db->query($sql) === TRUE) {
                    echo "<script>alert('Registrasi berhasil!'); window.location.href = './login.php';</script>";
                } else {
                    echo "<script>alert('Registrasi gagal: " . $db->error . "');</script>";
                }
            }
        }
    }
?>

<main class="form-signin w-100 m-auto">
    <form method="POST" action="">
        <img class="mb-4" src="https://placehold.co/123/1F2544/FFD0EC?text=MC+SERVER&font=roboto" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Sign Up</h1>
        <div class="form-floating mb-1">
            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="John Doe" required>
            <label for="floatingInput">Nama Lengkap</label>
        </div>
        <div class="form-floating mb-1">
            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
            <label for="floatingEmail">Email address</label>
        </div>
        <div class="form-floating mb-1">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <p>Sudah Punya akun? <a href="./login.php">Login Disini!!</a></p>
        <input class="w-100 btn btn-lg btn-primary" name="submit" type="submit" value="Create">
        <p class="mt-5 mb-3 text-muted">&copy; Pantrian 2024</p>
    </form>
</main>

<?php require_once("../layout/foot.php"); ?>
