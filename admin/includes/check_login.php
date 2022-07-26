<?php 
    
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }

?>