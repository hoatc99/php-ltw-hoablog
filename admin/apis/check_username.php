<?php

    include_once '../include.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user->v_username = $_POST['username'];
        echo $user->api_check_username();
    }

?>