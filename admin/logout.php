<?php  
    include_once 'includes/include.php';
    session_destroy();
    redirect('login.php');
?>