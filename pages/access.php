<?php
    function checkAccessPage($db, $accesid, $redirectpage) {

        if ($_SESSION['user']['role_id'] != '') {
            $sql = "SELECT * FROM role_permission WHERE role_id = ".$_SESSION['user']['role_id'];
            $result = mysqli_query($db, $sql);
            $perm = [];
            while ($data = mysqli_fetch_assoc($result)) {
                $perm[] = $data['perm_id'];
            }
    
            $re  = in_array($accesid, $perm);
    
            if ($re == false) {
                if ($redirectpage != '') {
                    header('Location: ' . $redirectpage);
                } else {
                    return false;
                }
                return false;
            } else {
                return true;
            }
    
        } 
    }



?>