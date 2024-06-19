<?php 
    $title = "Montors Page";
    $custom = "";
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start(); 
    require_once("../layout/header.php");
    require_once("../db.php");
    require_once("./access.php");


    
    checkAccessPage($db, 18, "./noacc.php");

    if (!isset($_SESSION['user'])) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Anda harus login terlebih dahulu'];
        header('Location: ./login.php');
        exit();
    }


    function getMontor() {
        global $db;
        $query = "SELECT montors.*, brands.deskripsi as brand_deskripsi, brands.brand_name, montors.deskripsi  as mtr_desc FROM montors JOIN brands ON montors.brand_id = brands.id";
        // $query = "SELECT montors.*, brands.id as brandid, brands.deskripsi as brand_deskripsi, brands.brand_name, montors.deskripsi  as mtr_desc,  FROM montors JOIN brands ON montors.brand_id = brands.id";
        $result = mysqli_query($db, $query);
        $montors = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $montors[] = $row;
        }
        return $montors;
    }

    $fotopath = "../assets/images/montor/";

    if (isset($_POST['addmontor'])) {
        $mtr_name = $_POST['mtr_name'];
        $brand_id = $_POST['brand_id'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
    
        $img = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        $target_dir = realpath( "../assets/images/montor");

        if (empty($mtr_name) || empty($brand_id) || empty($img) || empty($harga) || empty($deskripsi)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Semua field harus diisi'];
            header('Location: ./montors.php');
            exit();
        }
    
         $target_file = $target_dir ."/". basename($img);
        if (move_uploaded_file($img_tmp, $target_file)) {
            $query = "INSERT INTO montors (mtr_name, brand_id, img, harga, deskripsi) VALUES ('$mtr_name', '$brand_id', '$img', '$harga', '$deskripsi')";
            $result = mysqli_query($db, $query);
            if ($result) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Montor berhasil ditambahkan'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Montor gagal ditambahkan'];
            }
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gambar gagal diupload'. $img_tmp. $target_file. $img];
        }
        header('Location: ./montors.php');
        exit();
    }
     


    if (isset($_POST['emontor'])) {
        $id = $_POST['id'];
        $mtr_name = $_POST['mtr_name'];
        $brand_id = $_POST['brand_id'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
    
        $img = $_FILES['img']['name'];
        $img_tmp = $_FILES['img']['tmp_name'];
        $target_dir = realpath("../assets/images/montor/");

    
        if (empty($mtr_name) || empty($brand_id) || empty($harga) || empty($deskripsi)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Semua field harus diisi'];
            header('Location: ./montors.php');
            exit();
        }
    
        if (!empty($img)) {
            $target_file = $target_dir ."\\". basename($img);
            if (move_uploaded_file($img_tmp, $target_file)) {
                $query = "UPDATE montors SET mtr_name = '$mtr_name', brand_id = '$brand_id', img = '$img', harga = '$harga', deskripsi = '$deskripsi' WHERE id = $id";
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gambar gagal diupload'];
                header('Location: ./montors.php');
                exit();
            }
        } else {
            $query = "UPDATE montors SET mtr_name = '$mtr_name', brand_id = '$brand_id', harga = '$harga', deskripsi = '$deskripsi' WHERE id = $id";
        }
        
        $result = mysqli_query($db, $query);
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Montor berhasil diubah'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Montor gagal diubah'];
        }
        header('Location: ./montors.php');
        exit();
    }
    
    if (isset($_POST['dmontor'])) {
        $id = $_POST['id'];
        echo $id;
        $query = "DELETE FROM montors WHERE montors.id = $id";
        $result = mysqli_query($db, $query);
        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Montor berhasil dihapus'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Montor gagal dihapus'];
        }
        header('Location: ./montors.php');
        exit();
    }



    function btnAddPermission() {
        global $db;
        if (checkAccessPage($db, 19, '')) {
            return "<button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#addModal'>
                <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                Add Montors
            </button>";
        }
    }


    function btnEditPermission($montor) {
        global $db;
        if (checkAccessPage($db, 20, '')) {
            return "<button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' 
                data-id='{$montor['id']}' 
                data-img='{$montor['img']}' 
                data-brandid='{$montor['brand_id']}' 
                data-brand='{$montor['mtr_name']}' 
                data-harga='{$montor['harga']}'
                data-deskripsi='{$montor['mtr_desc']}'>
                Edit
            </button>";
        }
    }

    function btnDeletePermission($montor) {
        global $db;
        if (checkAccessPage($db, 21, '')) {
            return "<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' 
                data-id='{$montor['id']}' 
                data-montor='{$montor['mtr_name']}'>
            Delete
            </button>";
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
                                <?= btnAddPermission(); ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Montor</th>
                                            <th>Nama Brand</th>
                                            <th>Gambar</th>
                                            <th>Harga</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Montor</th>
                                            <th>Nama Brand</th>
                                            <th>Gambar</th>
                                            <th>Harga</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            $montors = getMontor();
                                            foreach ($montors as $montor) {
                                                echo "<tr>
                                                    <td>{$no}</td>
                                                    <td>{$montor['mtr_name']}</td>
                                                    <td>{$montor['brand_name']}</td>
                                                    <td><img src='../assets/images/montor/{$montor['img']}' alt='{$montor['mtr_name']}' width='100'></td>
                                                    <td>{$montor['harga']}</td>
                                                    <td>
                                                        ".btnEditPermission($montor)."
                                                        ".btnDeletePermission($montor)."
                                                    </td>
                                                </tr>";
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Montors</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post"  enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="mtr_name">Nama Montor</label>
                                <input type="text" name="mtr_name" class="form-control" placeholder="Nama Montor">
                            </div>
                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">Pilih Brand</option>
                                    <?php 
                                        $query = "SELECT * FROM brands";
                                        $result = mysqli_query($db, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['id']}'>{$row['brand_name']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="img">Gambar</label>
                                <input type="file" name="img" class="form-control" placeholder="Gambar">
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="text" name="harga" class="form-control" placeholder="Harga">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="addmontor" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Montors</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="form-group">
                                <label for="edit-montor-name">Nama Montor</label>
                                <input type="text" name="mtr_name" class="form-control" id="edit-montor-name" placeholder="Nama Montor">
                            </div>
                            <div class="form-group">
                                <label for="edit-brand-id">Brand</label>
                                <select name="brand_id" class="form-control" id="edit-brand-id">
                                    <option value="">Pilih Brand</option>
                                    <?php 
                                        $query = "SELECT * FROM brands";
                                        $result = mysqli_query($db, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['id']}'>{$row['brand_name']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-img">Gambar</label>
                                <input type="file" name="img" class="form-control" id="edit-img">
                                <div class="img-preview mt-2"></div>
                            </div>
                            <div class="form-group">
                                <label for="edit-harga">Harga</label>
                                <input type="text" name="harga" class="form-control" id="edit-harga" placeholder="Harga">
                            </div>
                            <div class="form-group">
                                <label for="edit-montor-deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="edit-montor-deskripsi"  rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="emontor" value="Save Changes">
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Montors</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        Are you sure you want to delete the Montor:  <span id="delete-montor-name"></span>?
                        <input type="hidden" name="id" id="delete-montor-id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-danger" type="submit" name="dmontor" value="Delete">
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
                var img = button.data('img');
                var brandid = button.data('brandid');
                var harga = button.data('harga');
                var deskripsi = button.data('deskripsi');
            
                var modal = $(this);
                modal.find('#edit-id').val(id);
                modal.find('#edit-montor-name').val(name);
                // modal.find('#edit-img').val(img);
                modal.find('#edit-img').attr('data-img-path', img);
                modal.find('#edit-brand-id').val(brandid);
                modal.find('#edit-harga').val(harga);
                modal.find('#edit-montor-deskripsi').text(deskripsi);


                if (img) {
                    var imgPreview = '<img src=\"../assets/images/montor/' + img + '\" alt=\"Current Image\" class=\"img-fluid\" />';
                    modal.find('.img-preview').html(imgPreview);
                } else {
                    modal.find('.img-preview').html('');
                }
            });

        
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('montor');


                var modal = $(this);
                modal.find('#delete-montor-id').val(id);
                modal.find('#delete-montor-name').text(name);
            });
        </script>
        ";



        require_once("../layout/footer.php"); 

    ?>