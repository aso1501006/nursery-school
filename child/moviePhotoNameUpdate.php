<?php
    require_once dirname(__FILE__)."/class/FileManager.php";
    $list = $_POST['data'];
    $name = htmlspecialchars($_POST['name']);
    $fileManager = new FileManager();
    if(!empty($list['movie']))$fileManager->update_movie($list['movie'],$name);
    if(!empty($list['photo']))$fileManager->update_photo($list['photo'],$name);
?>