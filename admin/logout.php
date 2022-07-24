<?php  
    include_once 'include.php';
    session_destroy();
    redirect('login.php');
?>