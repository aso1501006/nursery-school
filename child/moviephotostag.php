<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    //var_dump($_POST);
    $tag_all = $_POST['data'];
    $DBM = new DBManager();
    $list = array();
    $movies = $DBM->movie_select_tag($tag_all);
    $photos = $DBM->photo_select_tag($tag_all);
    $list[] = $movies;
    $list[] = $photos;
    echo json_encode($list,JSON_UNESCAPED_UNICODE);
?>