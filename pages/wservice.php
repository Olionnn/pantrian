<?php 
    $title = "Service Jalan Page";
    $custom = "";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start(); 
    require_once("../layout/header.php");
    require_once("../db.php");


    if (!isset($_SESSION['user'])) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Anda harus login terlebih dahulu'];
        header('Location: ./login.php');
        exit();
    }



    function getServices() {
        global $db;
        $sql = "SELECT * FROM services WHERE status != 1 and status != 2 AND service_type = 2 ORDER BY id DESC";
        $result = $db->query($sql);
        $services = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
        return $services;
    }


    if (isset($_POST['addqueue'])) {
        $service_type = $_POST['service_type'];
        $status = $_POST['status'];
        $codeq = "Q" . date('His');
        $sql = "INSERT INTO services (codeq, service_type, status) VALUES ('$codeq', $service_type, $status)";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil ditambahkan'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal ditambahkan'];
        }
        header('Location: ./wservice.php');
        exit();
    }

    if (isset($_POST['setqueue'])) {
        $id = $_POST['id'];
        $service_type = $_POST['service_type'];
        $status = $_POST['status'];
        $user_id = $_POST['user_id'];
        $sql = "UPDATE services SET status = $status, user_id = $user_id WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil diambil'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal diambil'];
        }
        header('Location: ./wservice.php');
        exit();
    }

    function getBtnStatus($id, $status, $user_id) {
        if ($status == 0) {
            return '
            <form action="" method="post">
                <input type="hidden" name="id" value="'.$id.'">
                <input type="hidden" name="service_type" value="2">
                <input type="hidden" name="status" value="555">
                <input type="hidden" name="user_id" value="' . $_SESSION['user']['id'] . '">
                <button class="btn btn-primary" name="setqueue" type="submit">Ambil</button>
            </form>
            ';
        } else if ($status == 555 && $user_id != $_SESSION['user']['id']) {
            return '<button class="btn btn-primary">Sudah Diambil</button>';
        } else {
            return '
            <Form action="" method="post">
                <input type="hidden" name="id" value="'.$id.'">
                <input type="hidden" name="service_type" value="2">
                <input type="hidden" name="status" value="1">
                <input type="hidden" name="user_id" value="' . $_SESSION['user']['id'] . '">
                <button class="btn btn-primary" name="setqueue" type="submit">Selesaikan</button>
            </Form>
            ';
        }
    }
?>

    <div id="wrapper">

        <?php require_once("../layout/sidebar.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php  require_once("../layout/topbar.php"); ?>

                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
                    <?php
                        if (isset($_SESSION['message'])) {
                            $message = $_SESSION['message'];
                            echo ("<div class='alert alert-{$message['type']}' role='alert'>
                                    {$message['text']}
                                </div>");
                            unset($_SESSION['message']); 
                        }
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Service Jalan Queue</h6>
                            <form action="" method="post">
                                <input type="hidden" name="service_type" value="2">
                                <input type="hidden" name="status" value="0">
                                <button class="btn btn-primary btn-sm" name="addqueue" type="submit">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Add Service Jalan
                                </button>
                            </form>
                        </div>
                        <div class="card-body">

                                <?php
                                    $services = getServices();
                                    if (count($services) == 0) {
                                        echo "<h3 class='text-center'>No Services</h3>"; 
                                    } else {
                                        echo "<div class='row'>";
                                        foreach ($services as $service) {
                                            echo '
                                            <div class="col-sm-3 mt-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">' . $service["codeq"] . '</h5>
                                                        <div class="text-center">
                                                            ' . getBtnStatus($service["id"],$service["status"], $service["user_id"]) . '
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                                        }
                                        echo "</div>";
                                    }
                                ?>
                                
                        </div>
                    </div>


                </div>

            </div>

            <?php require_once("../layout/bottombar.php"); ?>

        </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
        </a>


        


    

    <?php
        require("../layout/logoutModal.php"); 
        $customsc = "
        
        ";



        require_once("../layout/footer.php"); 

    ?>