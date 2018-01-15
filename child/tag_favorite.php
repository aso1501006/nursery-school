<?php
    require_once dirname(__FILE__)."/class/DBManager.php";
    $DBM = new DBManager();
    $limit = 6;
    $list = $DBM->get_tag_favorite($limit);
    echo json_encode($list,JSON_UNESCAPED_UNICODE);
?>