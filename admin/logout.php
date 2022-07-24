<?php  
    include_once 'include.php';
    session_destroy();
    header('Location: login.php');
    exit();
    // redirect('login.php');
?>