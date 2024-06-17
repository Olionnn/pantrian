<?php 
    $title = "Roles Management Page";
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


    function getRoles() {
        global $db;
        $sql = "SELECT * FROM roles";
        $result = $db->query($sql);
        $roles = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $roles[] = $row;
            }
        }
        return $roles;
    }
    
    function getPermissions() {
        global $db;
        $sql = "SELECT * FROM permission";
        $result = $db->query($sql);
        $permissions = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $permissions[] = $row;
            }
        }
        return $permissions;
    }

    


    if(isset($_POST['addrole'])) {
        $role = $_POST['role'];
        $permissions = $_POST['permissions'];
        $sql = "INSERT INTO roles (role) VALUES ('$role')";
        $db->query($sql);
        $role_id = $db->insert_id;
        foreach($permissions as $permission) {
            $sql = "INSERT INTO role_permission (role_id, perm_id) VALUES ('$role_id', '$permission')";
            $db->query($sql);
        }
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Role berhasil ditambahkan'];
        header('Location: ./roles.php');
        exit();
    }


    if(isset($_POST['drole'])) {
        $role_id = $_POST['id'];
        $sql = "DELETE FROM roles WHERE id = '$role_id'";
        $psql = "DELETE FROM role_permission WHERE role_id = '$role_id'";
        $db->query($psql);
        $db->query($sql);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Role berhasil dihapus'];
        header('Location: ./roles.php');
        exit();
    }
    
    if(isset($_POST['erole'])) {
        $role_id = $_POST['id'];
        $role = $_POST['role'];
        $permissions = $_POST['permissions'];
        $sql = "UPDATE roles SET role = '$role' WHERE id = '$role_id'";
        $db->query($sql);
        $db->query("DELETE FROM role_permission WHERE role_id = '$role_id'");
        foreach($permissions as $permission) {
            $sql = "INSERT INTO role_permission (role_id, perm_id) VALUES ('$role_id', '$permission')";
            $db->query($sql);
        }
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Role berhasil diubah'];
        header('Location: ./roles.php');
        exit();
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Roles Data Tables</h6>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Add Roles
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Roles</th>
                                            <th>Actions</th>


                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Roles</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                        $no = 1;
                                        $roles = getRoles();
                                        foreach($roles as $role) {
                                            echo "<tr>";
                                            echo "<td>".$no."</td>";
                                            echo "<td>".$role['role']."</td>";
                                            echo "<td>
                                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='".$role['id']."' data-role='".$role['role']."'>
                                                    <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                                                    Edit
                                                </button>
                                                <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' data-id='".$role['id']."' data-role='".$role['role']."'>
                                                    <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                                                    Delete
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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Roles</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="role" class="form-control form-control-user" id="exampleRole"
                                placeholder="Role Name">
                        </div>
                        <div class="card p-2">
                            <div class="row">
                            <?php 
                                $permissions = getPermissions();
                                foreach($permissions as $permission) {
                                    echo "<div class='col-12 col-md-6 col-lg-4'>
                                        <div class='form-check d-flex align-items-center'>
                                            <input class='form-check-input' name='permissions[]' type='checkbox' value='". $permission["id"] ."' id='". $permission['tag'] ."'>
                                            <label class='form-check-label ml-2' for='". $permission['tag'] ."'>
                                            " . $permission["perm_desc"] ."
                                            </label>
                                        </div>
                                    </div>";
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-primary" type="submit" name="addrole" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-role-id">
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <input type="text" name="role" id="edit-role-name" class="form-control" placeholder="Role Name">
                        </div>
                        <div class="card p-2">
                            <div class="row permissions-container">
                                <!-- Permissions will be loaded here via AJAX -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-primary" type="submit" name="erole" value="Save Changes">
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        Are you sure you want to delete the role: <span id="delete-role-name"></span>?
                        <input type="hidden" name="id" id="delete-role-id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-danger" type="submit" name="drole" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php
    
        require_once("../layout/logoutModal.php");
        $customsc = "
        <script>
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var role = button.data('role');

                var modal = $(this);
                modal.find('#edit-role-id').val(id);
                modal.find('#edit-role-name').val(role);

                modal.find('.permissions-container').empty();

                $.ajax({
                    url: '../init.php',
                    method: 'POST',
                    data: { role_id: id },
                    success: function(response) {
                        var rawJsonString = response; 

                        var jsonString = rawJsonString.replace(/<\/?[^>]+(>|$)/g, '');

                        try {
                            var jsonArray = JSON.parse(jsonString);
                            console.log(jsonArray); 
                        } catch (e) {
                            console.error('Invalid JSON string');
                        }
                        var permissions = JSON.parse(jsonString);
                        permissions.forEach(function(permission) {
                            var isChecked = permission.assigned == true || permission.assigned == 'true' ? 'checked' : '';
                            var permHTML = `
                                <div class='col-12 col-md-6 col-lg-4'>
                                    <div class='form-check d-flex align-items-center'>
                                        <input class='form-check-input' name='permissions[]' type='checkbox' value='\${permission.id}' id='\${permission.tag}' \${isChecked}>
                                        <label class='form-check-label ml-2' for='\${permission.tag}'>
                                            \${permission.perm_desc}
                                        </label>
                                    </div>
                                </div>`;
                            modal.find('.permissions-container').append(permHTML);
                        });
                    }
                });
            });

        
                $('#deleteModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var role = button.data('role');
        
                    var modal = $(this);
                    modal.find('#delete-role-id').val(id);
                    modal.find('#delete-role-name').text(role);
                });
        </script>
        ";
        require_once("../layout/footer.php");
    ?>
