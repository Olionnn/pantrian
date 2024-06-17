<?php
    require_once("db.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['role_id'])) {
        $roleId = intval($_POST['role_id']);
        
        $permissions = getPermissions();
        $rolePermissions = getRolePermissions($roleId);
        $result = [];
        foreach ($permissions as $permission) {
            $assigned = in_array($permission['id'], array_column($rolePermissions, 'perm_id'));
            $result[] = [
                'id' => $permission['id'],
                'tag' => $permission['tag'],
                'perm_desc' => $permission['perm_desc'],
                'assigned' => $assigned
            ];
        }

        echo json_encode($result);
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

    function getRolePermissions($roleId) {
        global $db;
        $sql = "SELECT * FROM role_permission WHERE role_id = $roleId";
        $result = $db->query($sql);
        $permissions = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $permissions[] = $row;
            }
        }
        return $permissions;
    }
?>