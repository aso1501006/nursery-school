<?php
    require_once './class/DBManager.php';
    $movie_id = $_POST['movie_id'];
    $tag_id_list = $_POST['tag_id'];
    $DBM = new DBManager();
    foreach($tag_id_list as $tag_id){
        if((int)$tag_id['value'] !== 0)$DBM->movie_tag_insert($movie_id,$tag_id['value']);
    }
?>