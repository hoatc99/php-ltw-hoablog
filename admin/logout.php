<?php  
    include_once 'includes/include.php';
    session_destroy();
    header('Location: login.php');
    exit();
    // redirect('login.php');
?>