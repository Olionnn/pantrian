<?php 
    $title = "Brands Page";
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

    checkAccessPage($db, 10, "./noacc.php");

    function getBrands() {
        global $db;
        $data = $db->query("SELECT * FROM brands");
        $result = [];
        while ($row = $data->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }

    if (isset($_POST['addbrand'])) {
        $brand_name = $_POST['brand_name'];
        $deskripsi = $_POST['deskripsi'];

        if(empty($brand_name)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Brand name tidak boleh kosong'];
            header('Location: ./brands.php');
            exit();
        }

        $query = "INSERT INTO brands (brand_name, deskripsi) VALUES ('$brand_name', '$deskripsi')";
        $db->query($query);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Brand berhasil ditambahkan'];
        header('Location: ./brands.php');
        exit();
    }

    if(isset($_POST['ebrand'])) {
        $id = $_POST['id'];
        $brand_name = $_POST['brand_name'];
        $deskripsi = $_POST['deskripsi'];

        if(empty($brand_name)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Brand name tidak boleh kosong'];
            header('Location: ./brands.php');
            exit();
        }

        $query = "UPDATE brands SET brand_name = '$brand_name', deskripsi = '$deskripsi' WHERE id = $id";
        $db->query($query);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Brand berhasil diubah'];
        header('Location: ./brands.php');
        exit();
    }

    if(isset($_POST['dbrand'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM brands WHERE id = $id";
        $db->query($query);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Brand berhasil dihapus'];
        header('Location: ./brands.php');
        exit();
    }



    function btnAddPermision() {
        global $db;
        if (checkAccessPage($db , 12 , '')) {
            return '
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Add Brands
                </button>
            ';
        }
    }


    function btnEditPermision($brand) {
        global $db;
        if (checkAccessPage($db , 11 , '')) {
            return "
                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='".$brand['id']."' data-brand='".$brand['brand_name']."'  data-deskripsi='".$brand['deskripsi']."' >
                    <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                    Edit
                </button>
            ";
        }
    }

    function btnDeletePermision($brand) {
        global $db;
        if (checkAccessPage($db , 13 , '')) {
            return "
                <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' data-id='".$brand['id']."' data-brand='".$brand['brand_name']."'>
                    <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Brands Data Tables</h6>
                            <?= btnAddPermision() ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Brand</th>
                                            <th>Deskripsi</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Brand</th>
                                            <th>Deskripsi</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            $brands = getBrands();
                                            foreach($brands as $brand) {

                                                echo "<tr>";
                                                echo "<td>".$no."</td>";
                                                echo "<td>".$brand['brand_name']."</td>";
                                                echo "<td>".$brand['deskripsi']."</td>";
                                                echo "<td>
                                                        ".btnEditPermision($brand)."
                                                        ".btnDeletePermision($brand)."
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


        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Brands</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" id="brand_name" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="addbrand" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-brand-id">
                        <div class="form-group">
                            <label for="brand_name">Brand Name</label>
                            <input type="text" name="brand_name" id="edit-brand-name" class="form-control" placeholder="Brand Name">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" name="deskripsi" id="edit-brand-deskripsi" class="form-control" placeholder="Deskripsi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-primary" type="submit" name="ebrand" value="Save Changes">
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Brands</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        Are you sure you want to delete the brand: <span id="delete-brand-name"></span>?
                        <input type="hidden" name="id" id="delete-brand-id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-danger" type="submit" name="dbrand" value="Delete">
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
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('brand');
                var deskripsi = button.data('deskripsi');

                var modal = $(this);
                modal.find('#edit-brand-id').val(id);
                modal.find('#edit-brand-name').val(name);
                modal.find('#edit-brand-deskripsi').val(deskripsi);
            });

        
                $('#deleteModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var name = button.data('brand');
        
                    var modal = $(this);
                    modal.find('#delete-brand-id').val(id);
                    modal.find('#delete-brand-name').text(name);
                });
        </script>
        ";



        require_once("../layout/footer.php"); 

    ?>