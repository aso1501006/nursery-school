<?php
    require_once(dirname(__FILE__)."/class/FileManager.php");
    $fileManager = new FileManager();
    $list = $_POST['data'];
    for($i = 0 ; $i < 2; $i++){
        foreach($list[$i] as $array){
            if($i === 0){
                //var_dump("動画".$array);
                $fileManager->delete_movie($array);
            }else{
                //var_dump("写真".$array);
                $fileManager->delete_photo($array);
            }
        }
    }
    echo "完了";
?>
