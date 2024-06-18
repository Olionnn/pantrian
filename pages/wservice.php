<?php 
    $title = "Services Page";
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
        $sql = "SELECT * FROM services WHERE status = 1 AND service_type = 1 ORDER BY id DESC";
        $result = $db->query($sql);
        $services = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
        return $services;
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Service Queue</h6>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Add Service
                            </button>
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
                                                            <button class="btn btn-primary" id="editService" 
                                                            data-id="' . $service["id"] . '
                                                            data-codeq="' . $service["codeq"] . '
                                                            data-service_type="' . $service["service_type"] . '
                                                            data-status="' . $service["status"] . '
                                                            
                                                            
                                                            >Edit</button>
                                                            <button class="btn btn-primary">Detail</button>
                                                            <button class="btn btn-primary">Finish</button>
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
        require_once("../layout/logoutModal.php"); 
        $customsc = "
        
        ";



        require_once("../layout/footer.php"); 

    ?>