<?php
    require_once './class/DBManager.php';
    $photo_id = $_POST['photo_id'];
    $tag_id_list = $_POST['tag_id'];
    $DBM = new DBManager();
    foreach($tag_id_list as $tag_id){
        if((int)$tag_id['value'] !== 0)$DBM->photo_tag_insert($photo_id,$tag_id['value']);
    }
?>