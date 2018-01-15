<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    $data = $_POST['data'];
    $DBM = new DBManager();
    $hogehoge = $DBM->movie_get_tag($data);
    echo json_encode($hogehoge,JSON_UNESCAPED_UNICODE);
?>