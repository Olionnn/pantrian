<?php 
    $title = "Services Page";
    $custom = "";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start(); 
    require_once("../layout/header.php");
    require_once("../db.php");
    require_once("./access.php");

    checkAccessPage($db, 23, "./noacc.php");


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

    if (isset($_POST['editservice'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nomerhp = $_POST['nomerhp'];
        $montor = $_POST['montor'];
        $service_type = $_POST['service_type'];
        $status = $_POST['status'];
        $deskripsi = $_POST['deskripsi'];
        $total = $_POST['total'];

        $sql = "UPDATE services SET nama = '$nama', nomerhp = '$nomerhp', montor = '$montor', service_type = '$service_type', status = '$status', deskripsi = '$deskripsi', total = '$total' WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil diubah'];
            header('Location: ./services.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal diubah'];
            header('Location: ./services.php');
            exit();
        }
    }

    if (isset($_POST['selesaiService'])) {
        $id = $_POST['id'];
        $codeq = $_POST['codeq'];

        $sql = "UPDATE services SET status = 1 WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil diselesaikan'];
            header('Location: ./services.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal diselesaikan'];
            header('Location: ./services.php');
            exit();
        }
    }

    if (isset($_POST['batalService'])) {
        $id = $_POST['id'];
        $codeq = $_POST['codeq'];

        $sql = "UPDATE services SET status = 2 WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Service berhasil dibatalkan'];
            header('Location: ./services.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Service gagal dibatalkan'];
            header('Location: ./services.php');
            exit();
        }
    }



    function btnAddPermision() {
        global $db;
        if (checkAccessPage($db , 23 , '')) {
            return '
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Add Service
                </button>
            ';
        } else {
            return "";
        }
    }


    function btnEditPermision($service) {
        global $db;
        if (checkAccessPage($db , 25 , '')) {
            return '
            <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" 
            data-id="' . $service["id"] . '"
            data-codeq="' . $service["codeq"] . '"
            data-service_type="' . $service["service_type"] . '"
            data-status="' . $service["status"] . '"
            data-nama="' . $service["nama"] . '"
            data-nomerhp="' . $service["nomerhp"] . '"
            data-montor="' . $service["montor"] . '"
            data-deskripsi="' . $service["deskripsi"] . '"
            data-total="' . $service["total"] . '"
            >Edit</button>
            ';
        }
    }

    function btnSelesaiPermision($service) {
        global $db;
        if (checkAccessPage($db , 24 , '')) {
            return '
            <button class="dropdown-item" data-toggle="modal" data-target="#selesaiModal"
            data-id="' . $service["id"] . '"
            data-codeq="' . $service["codeq"] . '"
            >Selesai</button>
            ';
        }
    }

    function btnBatalPermision($service) {
        global $db;
        if (checkAccessPage($db , 26 , '')) {
            return '
            <button class="dropdown-item" data-toggle="modal" data-target="#batalModal"
                data-id="' . $service["id"] . '"
                data-codeq="' . $service["codeq"] . '"
            >Batal</button>
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Service Queue</h6>
                        </div>
                        <div class="card-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama</th>
                                            <th>Nomer HP</th>
                                            <th>Montor</th>
                                            <th>Deskripsi</th>
                                            <th>Total</th>
                                            <th>Code Queue</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama</th>
                                            <th>Nomer HP</th>
                                            <th>Montor</th>
                                            <th>Deskripsi</th>
                                            <th>Total</th>
                                            <th>Code Queue</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                            $services = getServices();
                                            $no = 1;
                                            foreach ($services as $service) {
                                                echo "<tr>";
                                                echo "<td>{$no}</td>";
                                                echo "<td>{$service['nama']}</td>";
                                                echo "<td>{$service['nomerhp']}</td>";
                                                echo "<td>{$service['montor']}</td>";
                                                echo "<td>{$service['deskripsi']}</td>";
                                                echo "<td>{$service['total']}</td>";
                                                echo "<td>{$service['codeq']}</td>";
                                                echo "<td>";
                                                // echo btnEditPermision($service);
;
                                                // echo btnSelesaiPermision($service);
                                                // echo btnBatalPermision($service);
                                                echo "<button class='dropdown-item' data-toggle='modal' data-target='#detailModal'
                                                data-id='{$service["id"]}'
                                                data-codeq='{$service["codeq"]}'
                                                data-service_type='{$service["service_type"]}'
                                                data-status='{$service["status"]}'
                                                data-nama='{$service["nama"]}'
                                                data-nomerhp='{$service["nomerhp"]}'
                                                data-montor='{$service["montor"]}'
                                                data-deskripsi='{$service["deskripsi"]}'
                                                data-total='{$service["total"]}'
                                                >Detail</button>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                        ?>
                                        

                                    </tbody>
                                </table>
                                
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



        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Service</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="detail-nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="detail-nama" disabled>
                        </div>
                        <div class="form-group">
                            <label for="detail-nomerhp">Nomer HP</label>
                            <input type="text" class="form-control" name="nomerhp" id="detail-nomerhp" disabled>
                        </div>
                        <div class="form-group">
                            <label for="detail-montor">Montor</label>
                            <input type="text" class="form-control" name="montor" id="detail-montor" disabled>
                        </div>
                        <div class="form-group">
                            <label for="detail-codeq">Code Queue</label>
                            <input type="text" class="form-control" name="codeq" id="detail-codeq" disabled>
                        </div>
                        <div class="form-group">
                            <label for="detail-service_type">Service Type</label>
                            <select name="service_type" id="detail-service_type" class="form-control" disabled>
                                <option value="1">Service Queue</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail-status">Status</label>
                            <select name="status" id="detail-status" class="form-control" disabled>
                                <option value="1">Active</option>
                                <option value="0">Ongoing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail-deskripsi">Description</label>
                            <textarea name="deskripsi" id="detail-deskripsi" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label for="detail-total">Total</label>
                            <input type="number" class="form-control" name="total" id="detail-total" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


       

        
    

    <?php
        require("../layout/logoutModal.php"); 
        $customsc = "
         <script>
                

                $('#detailModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var codeq = button.data('codeq');
                    var service_type = button.data('service_type');
                    var status = button.data('status');
                    var nama = button.data('nama');
                    var nomerhp = button.data('nomerhp');
                    var montor = button.data('montor');
                    var deskripsi = button.data('deskripsi');
                    var total = button.data('total');

                    var modal = $(this);
                    modal.find('.modal-body #detail-id').val(id);
                    modal.find('.modal-body #detail-codeq').val(codeq);
                    modal.find('.modal-body #detail-service_type').val(service_type);
                    modal.find('.modal-body #detail-status').val(status);
                    modal.find('.modal-body #detail-nama').val(nama);
                    modal.find('.modal-body #detail-nomerhp').val(nomerhp);
                    modal.find('.modal-body #detail-montor').val(montor);
                    modal.find('.modal-body #detail-deskripsi').val(deskripsi);
                    modal.find('.modal-body #detail-total').val(total);
                });

        </script>
        ";



        require_once("../layout/footer.php"); 

    ?>