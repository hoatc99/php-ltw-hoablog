<?php

    include_once '../include.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "SELECT * FROM blog_user 
                WHERE v_username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "true";
        } else {
            echo "false";
        }
    }

?>