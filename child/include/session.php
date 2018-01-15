<?php
    session_start();
    if(empty($_SESSION['nursery_school_id'])){
        header('Location: ./parents_login.php');
    }
?>