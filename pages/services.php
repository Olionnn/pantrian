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
        $sql = "SELECT * FROM services WHERE status = 0 AND service_type = 1 ORDER BY id DESC";
        $result = $db->query($sql);
        $services = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
        return $services;
    }

    if (isset($_POST['addservice'])) {
        $nama = $_POST['nama'];
        $nomerhp = $_POST['nomerhp'];
        $montor = $_POST['montor'];
        $codeq = $_POST['codeq'];
        $service_type = $_POST['service_type'];
        $status = $_POST['status'];
        $deskripsi = $_POST['deskripsi'];
        $total = $_POST['total'];

        $sql = "INSERT INTO services (nama, nomerhp, montor, codeq, service_type, status, deskripsi, total) VALUES ('$nama', '$nomerhp', '$montor', '$codeq', '$service_type', '$status', '$deskripsi', '$total')";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil ditambahkan'];
            header('Location: ./services.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal ditambahkan'];
            header('Location: ./services.php');
            exit();
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
                                                            data-nama="' . $service["nama"] . '
                                                            data-nomerhp="' . $service["nomerhp"] . '
                                                            data-montor="' . $service["montor"] . '
                                                            data-deskripsi="' . $service["deskripsi"] . '
                                                            data-total="' . $service["total"] . '"
                                                            >Edit</button>
                                                            <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal"
                                                            data-id="' . $service["id"] . '
                                                            data-codeq="' . $service["codeq"] . '
                                                            data-service_type="' . $service["service_type"] . '
                                                            data-status="' . $service["status"] . '
                                                            data-nama="' . $service["nama"] . '
                                                            data-nomerhp="' . $service["nomerhp"] . '
                                                            data-montor="' . $service["montor"] . '
                                                            data-deskripsi="' . $service["deskripsi"] . '
                                                            data-total="' . $service["total"] . '"
                                                            >Detail</button>
                                                            <div class="btn-group">
                                                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#">Action</a>
                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                <a class="dropdown-item" href="#">Something else here</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="#">Separated link</a>
                                                            </div>
                                                            </div>
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


        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <!-- nama	nomerhp	montor	user_id	service_type	status	deskripsi	total	codeq	 -->
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="nomerhp">Nomer HP</label>
                                <input type="text" class="form-control" name="nomerhp" id="nomerhp" required>
                            </div>
                            <div class="form-group">
                                <label for="montor">Montor</label>
                                <input type="text" class="form-control" name="montor" id="montor" required>
                            </div>
                            <div class="form-group">
                                <label for="codeq">Code Queue</label>
                                <input type="text" class="form-control" name="codeq" id="codeq" required>
                            </div>
                            <div class="form-group">
                                <label for="service_type">Service Type</label>
                                <select name="service_type" id="service_type" class="form-control" required>
                                    <option value="1">Service Queue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Ongoing</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="number" class="form-control" name="total" id="total" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="addservice" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>


    

    <?php
        require_once("../layout/logoutModal.php"); 
        $customsc = "
        
        ";



        require_once("../layout/footer.php"); 

    ?>