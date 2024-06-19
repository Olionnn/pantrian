<?php 
    $title = "Sales Page";
    $custom = "";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start(); 
    require_once("../layout/header.php");
    require_once("../db.php");
    require_once("./access.php");


    if (!isset($_SESSION['user'])) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Anda harus login terlebih dahulu'];
        header('Location: ./login.php');
        exit();
    }

    checkAccessPage($db, 14, "./noacc.php");

    if ($_SESSION['user']['role_id'] != 1) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Anda tidak memiliki akses'];
        header('Location: ./index.php');
        exit();
    }

    function getSales() {
        global $db;
        // name	montor_id	user_id	payment	nomerhp	alamat	status
        $sql = "SELECT sales.*, montors.mtr_name as montor_name FROM sales JOIN montors ON sales.montor_id = montors.id";
        // $sql = "SELECT sales.*, montors.mtr_name as montor_name FROM sales JOIN montors ON sales.montor_id = montors.id";
        $result = mysqli_query($db, $sql);
        $sales = [];
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $sales[] = $row;
            }
        }
        return $sales;
    }


    if(isset($_POST['addsales'])) {
        $name = $_POST['name'];
        $alamat = $_POST['alamat'];
        $nomerhp = $_POST['nomerhp'];
        $montor_id = $_POST['montor_id'];
        $payment = $_POST['payment'];
        $status = $_POST['status'];
        $sql = "INSERT INTO sales (name, alamat, nomerhp, montor_id, payment, status) VALUES ('$name', '$alamat', '$nomerhp', '$montor_id', '$payment', '$status')";
        if (mysqli_query($db, $sql)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Sales berhasil ditambahkan'];
            header('Location: ./sales.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Sales gagal ditambahkan'];
            header('Location: ./sales.php');
            exit();
        }
    }

    if(isset($_POST['editsales'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $alamat = $_POST['alamat'];
        $nomerhp = $_POST['nomerhp'];
        $montor_id = $_POST['montor_id'];
        $payment = $_POST['payment'];
        $status = $_POST['status'];
        $sql = "UPDATE sales SET name='$name', alamat='$alamat', nomerhp='$nomerhp', montor_id='$montor_id', payment='$payment', status='$status' WHERE id='$id'";
        if (mysqli_query($db, $sql)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Sales berhasil diubah'];
            header('Location: ./sales.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Sales gagal diubah'];
            header('Location: ./sales.php');
            exit();
        }
    }

    if(isset($_POST['deletesales'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM sales WHERE id='$id'";
        if (mysqli_query($db, $sql)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Sales berhasil dihapus'];
            header('Location: ./sales.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Sales gagal dihapus'];
            header('Location: ./sales.php');
            exit();
        }
    }

    function getSalesById($id) {
        global $db;
        $sql = "SELECT * FROM sales WHERE id='$id'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    function btnAddPermision() {
        global $db;
        if (checkAccessPage($db , 15 , '')) {
            return '
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Add Sales
                </button>
            ';
        } else {
            return "";
        }
    }


    function btnEditPermision($sale) {
        global $db;
        if (checkAccessPage($db , 16 , '')) {
            return "
            <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' 
                data-id='{$sale['id']}' 
                data-name='{$sale['name']}'
                data-alamat='{$sale['alamat']}' 
                data-montor_id='{$sale['montor_id']}' 
                data-nomerhp='{$sale['nomerhp']}' 
                data-payment='{$sale['payment']}'
                data-status='{$sale['status']}'
                >
                Edit
            </button>
            ";
        }
    }

    function btnDeletePermision($sale) {
        global $db;
        if (checkAccessPage($db , 17 , '')) {
            return "
            <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' 
                data-id='{$sale['id']}' 
                data-name='{$sale['name']}'>
                Delete
            </button>
            ";
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Sales Data Tables</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomer HP</th>
                                            <th>Nama Montor</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomer HP</th>
                                            <th>Nama Montor</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            $sales = getSales();
                                            foreach($sales as $sale) {

                                                echo "<tr>";
                                                echo "<td>{$no}</td>";
                                                echo "<td>{$sale['name']}</td>";
                                                echo "<td>{$sale['alamat']}</td>";
                                                echo "<td>{$sale['nomerhp']}</td>";
                                                echo "<td>{$sale['montor_name']}</td>";
                                                echo "<td>
                                                        <button class='btn btn-info btn-sm' data-toggle='modal' data-target='#detailModal' 
                                                        data-id='{$sale['id']}'
                                                        data-name='{$sale['montor_name']}'
                                                        data-alamat='{$sale['alamat']}'
                                                        data-nomerhp='{$sale['nomerhp']}'
                                                        data-montor_id='{$sale['montor_id']}'
                                                        data-payment='{$sale['payment']}'
                                                        data-status='{$sale['status']}'
                                                        >
                                                        Detail
                                                        </button>
                                                    </td>";
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
                        <h5 class="modal-title" id="exampleModalLabel">Detail  Sales</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="edit-name" disabled>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input class="form-control" type="text" name="alamat" id="edit-alamat" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nomerhp">Nomer HP</label>
                                <input class="form-control" type="text" name="nomerhp" id="edit-nomerhp" disabled>
                            </div>
                            <div class="form-group">
                                <label for="montor_id">Montor</label>
                                <select class="form-control" name="montor_id" id="edit-montor_id" disabled>
                                    <option value="">Select Montor</option>
                                    <?php 
                                        $sql = "SELECT * FROM montors";
                                        $result = mysqli_query($db, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['id']}'>{$row['mtr_name']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="payment">Payment</label>
                                <input class="form-control" type="text" name="payment" id="edit-payment" disabled>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="edit-status" disabled>
                                    <option value="0">Pending</option>
                                    <option value="1">Success</option>
                                </select>
                            </div>

                            
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    

    <?php
        require("../layout/logoutModal.php"); 
        $customsc = "
        <script>
            
            
            $('#detailModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var alamat = button.data('alamat')
                var nomerhp = button.data('nomerhp')
                var montor_id = button.data('montor_id')
                var payment = button.data('payment')
                var status = button.data('status')
                var modal = $(this)
                modal.find('.modal-body #edit-id').val(id)
                modal.find('.modal-body #edit-name').val(name)
                modal.find('.modal-body #edit-alamat').val(alamat)
                modal.find('.modal-body #edit-nomerhp').val(nomerhp)
                modal.find('.modal-body #edit-montor_id').val(montor_id)
                modal.find('.modal-body #edit-payment').val(payment)
                modal.find('.modal-body #edit-status').val(status)
            })
        </script>
        ";



        require_once("../layout/footer.php"); 

    ?>