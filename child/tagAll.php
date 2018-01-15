<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    $DBManager = new DBManager();
    session_start();
    $list = $DBManager->tag_select_all($_SESSION['nursery_school_id']);
    echo json_encode($list,JSON_UNESCAPED_UNICODE);
?>