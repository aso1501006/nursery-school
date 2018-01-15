<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    $data = $_POST['data'];
    $DBM = new DBManager();
    $tag = $DBM->photo_get_tag($data);
    echo json_encode($tag,JSON_UNESCAPED_UNICODE);
?>