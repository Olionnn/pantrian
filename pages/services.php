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
                                                            <button class="btn btn-primary" data-toggle="modal" data-target="#detailModal"
                                                            data-id="' . $service["id"] . '"
                                                            data-codeq="' . $service["codeq"] . '"
                                                            data-service_type="' . $service["service_type"] . '"
                                                            data-status="' . $service["status"] . '"
                                                            data-nama="' . $service["nama"] . '"
                                                            data-nomerhp="' . $service["nomerhp"] . '"
                                                            data-montor="' . $service["montor"] . '"
                                                            data-deskripsi="' . $service["deskripsi"] . '"
                                                            data-total="' . $service["total"] . '"
                                                            >Detail</button>
                                                            <div class="btn-group">
                                                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <button class="dropdown-item" data-toggle="modal" data-target="#selesaiModal"
                                                                data-id="' . $service["id"] . '"
                                                                data-codeq="' . $service["codeq"] . '"
                                                                >Selesai</button>
                                                                <button class="dropdown-item" data-toggle="modal" data-target="#batalModal"
                                                                data-id="' . $service["id"] . '"
                                                                data-codeq="' . $service["codeq"] . '"
                                                                >Batal</button>
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

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">
                            <input type="hidden" name="codeq" id="edit-codeq">
                            <div class="form-group">
                                <label for="edit-nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="edit-nama" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-nomerhp">Nomer HP</label>
                                <input type="text" class="form-control" name="nomerhp" id="edit-nomerhp" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-montor">Montor</label>
                                <input type="text" class="form-control" name="montor" id="edit-montor" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-service_type">Service Type</label>
                                <select name="service_type" id="edit-service_type" class="form-control" required>
                                    <option value="1">Service Queue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-status">Status</label>
                                <select name="status" id="edit-status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Ongoing</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-deskripsi">Description</label>
                                <textarea name="deskripsi" id="edit-deskripsi" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-total">Total</label>
                                <input type="number" class="form-control" name="total" id="edit-total" required>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="editservice" value="Edit">
                        </div>
                    </form>
                </div>
            </div>
        </div>



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


        <div class="modal fade" id="selesaiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Selesai Service</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menyelesaikan service ini?</p>
                            <input type="hidden" name="id" id="selesai-id">
                            <input type="hidden" name="codeq" id="selesai-codeq">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" name="selesaiService">Selesai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="batalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Batal Service</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin membatalkan service ini?</p>
                            <input type="hidden" name="id" id="batal-id">
                            <input type="hidden" name="codeq" id="batal-codeq">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" name="batalService">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       

        
    

    <?php
        require("../layout/logoutModal.php"); 
        $customsc = "
         <script>
                $('#editModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
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
                    modal.find('.modal-body #edit-id').val(id);
                    modal.find('.modal-body #edit-codeq').val(codeq);
                    modal.find('.modal-body #edit-service_type').val(service_type);
                    modal.find('.modal-body #edit-status').val(status);
                    modal.find('.modal-body #edit-nama').val(nama);
                    modal.find('.modal-body #edit-nomerhp').val(nomerhp);
                    modal.find('.modal-body #edit-montor').val(montor);
                    modal.find('.modal-body #edit-deskripsi').val(deskripsi);
                    modal.find('.modal-body #edit-total').val(total);
                });

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

                $('#selesaiModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var codeq = button.data('codeq');

                    var modal = $(this);
                    modal.find('.modal-body #selesai-id').val(id);
                    modal.find('.modal-body #selesai-codeq').val(codeq);
                });

                $('#batalModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var codeq = button.data('codeq');

                    var modal = $(this);
                    modal.find('.modal-body #batal-id').val(id);
                    modal.find('.modal-body #batal-codeq').val(codeq);
                });


        </script>
        ";



        require_once("../layout/footer.php"); 

    ?>