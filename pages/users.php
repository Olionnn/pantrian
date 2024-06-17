<?php 
    $title = "Users Management Page";
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


    function getUsers() {
        global $db;
        $sql = "SELECT * FROM users";
        $result = $db->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
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
    

    if(isset($_POST['auser'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role_id = $_POST['role_id'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        echo $username;
        echo $email;
        echo $role_id;
        echo $password;
        echo $cpassword;

        if ($password != $cpassword) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Password tidak sama'];
            header('Location: ./users.php');
            exit();
        }

        $password = password_hash($password, PASSWORD_DEFAULT);        

        $sql = "INSERT INTO users (username, email, role_id, password) VALUES ('$username', '$email', $role_id, '$password')";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'User berhasil ditambahkan'];
            header('Location: ./users.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'User gagal ditambahkan'];
            header('Location: ./users.php');
            exit();
        }
    
    }

    if(isset($_POST['euser'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role_id = $_POST['role_id'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (!password_verify($password, $row['password'])) {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Password salah'];
                header('Location: ./users.php');
                exit();
            }
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'User tidak ditemukan'];
            header('Location: ./users.php');
            exit();
        }

        $sql = "UPDATE users SET username = '$username', email = '$email', role_id = $role_id WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'User berhasil diubah'];
            header('Location: ./users.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'User gagal diubah'];
            header('Location: ./users.php');
            exit();
        }
    
    }


    if(isset($_POST['duser'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM users WHERE id = $id";
        if ($db->query($sql) === TRUE) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'User berhasil dihapus'];
            header('Location: ./users.php');
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'User gagal dihapus'];
            header('Location: ./users.php');
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
                            <h6 class="m-0 my-auto font-weight-bold text-primary ">Users Data Tables</h6>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Add Users
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Usernmae</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NO</th>
                                            <th>Usernmae</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Actions</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            $users = getUsers();
                                            foreach($users as $user) {

                                                echo "<tr>";
                                                echo "<td>".$no."</td>";
                                                echo "<td>".$user['username']."</td>";
                                                echo "<td>".$user['email']."</td>";
                                                echo "<td>".$user['role_id']."</td>";
                                                echo "<td>
                                                    <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='".$user['id']."' data-username='".$user['username']."'  data-email='".$user['email']."' data-role='".$user['role_id']."'>
                                                        <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                                                        Edit
                                                    </button>
                                                    <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteModal' data-id='".$user['id']."' data-username='".$user['username']."'  data-email='".$user['email']."'>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Users</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" id="exampleFirstName"
                                    placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                    placeholder="Email Address">
                            </div>
                            <select name="role_id" class="form-control form-control mb-3">
                                <option>Small select</option>
                                <?php 
                                    $roles = getRoles();
                                    foreach($roles as $role) {
                                        echo "<option  value='".$role['id']."'>".$role['role'] . $role['id'] ."</option>";
                                    }
                                ?>
                            </select>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="cpassword" class="form-control form-control-user"
                                        id="exampleRepeatPassword" placeholder="Repeat Password">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="auser" value="Add">
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
                    <input type="hidden" name="id" id="edit-user-id">

                    <div class="modal-body">
                            <div class="form-group">
                                <input id="edit-user-username" type="text" name="username" class="form-control form-control-user" id="exampleFirstName"
                                    placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input id="edit-user-email" type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                    placeholder="Email Address">
                            </div>
                            <select id="edit-user-role" name="role_id" class="form-control form-control mb-3">
                                <?php 
                                    $roles = getRoles();
                                    foreach($roles as $role) {
                                        echo "<option  value='".$role['id']."'>".$role['role'] ."</option>";
                                    }
                                ?>
                            </select>

                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        id="exampleInputPassword" placeholder="Verify The Password To Change">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <input class="btn btn-primary" type="submit" name="euser" value="Edit">
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
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        Are you sure you want to delete the Username: <span id="delete-user-username"></span> Email : <span id="delete-user-email"></span> ?
                        <input type="hidden" name="id" id="delete-user-id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <input class="btn btn-danger" type="submit" name="duser" value="Delete">
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
                var username = button.data('username');
                var email = button.data('email');
                var role = button.data('role');

                var modal = $(this);
                modal.find('#edit-user-id').val(id);
                modal.find('#edit-user-username').val(username);
                modal.find('#edit-user-email').val(email);
                modal.find('#edit-user-role').val(role);


                modal.find('.permissions-container').empty();

                
            });

        
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var username = button.data('username');
                var email = button.data('email');

                var modal = $(this);
                modal.find('#delete-user-id').val(id);
                modal.find('#delete-user-username').text(username);
                modal.find('#delete-user-email').text(email);

            });
        </script>
        ";
    
    
    
        require_once("../layout/footer.php"); 
    
    ?>