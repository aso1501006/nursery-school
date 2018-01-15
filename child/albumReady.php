<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    $DBM = new DBManager();
    session_start();
    $nursery_school_id = $_SESSION['nursery_school_id'];
    $limit_num = 100;
    $list = array();
    $movie_list_new = $DBM->movie_select_new($nursery_school_id,$limit_num);
    $photo_list_new = $DBM->photo_select_new($nursery_school_id,$limit_num);
    $list[] = $movie_list_new;
    $list[] = $photo_list_new;
    //var_dump($list);
    echo json_encode($list,JSON_UNESCAPED_UNICODE);
?>