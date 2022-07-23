<?php  
    include 'includes/include.php';
    session_destroy();
    redirect('login.php');
?>