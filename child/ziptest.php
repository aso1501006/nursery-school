<?php 
require_once(dirname(__FILE__)."/class/DBManager.php");
require_once(dirname(__FILE__)."/class/MoviePhotoTblDT.php");
require_once(dirname(__FILE__)."/class/MoviesTblDT.php");

$movie_id_list = array();
$photo_id_list = array();


if(!empty($_POST['movie']))$movie_id_list = $_POST['movie'];
if(!empty($_POST['photo']))$photo_id_list = $_POST['photo'];

// Zipクラスロード
$zip = new ZipArchive();
// Zipファイル名
$zipFileName = 'download.zip';
// Zipファイル一時保存ディレクトリ
$zipTmpDir = './zip';
//すべてのパスを結合した文字列
$allFilePath = " ";
 
$dbm = new DBManager();
foreach($photo_id_list as $photo_id){
    $mpt = $dbm->photo_select($photo_id);
    $allFilePath .= $mpt[0]->path . " ";
}
foreach($movie_id_list as $movie_id){
    $mtd = $dbm->movie_select($movie_id);
    $allFilePath .= $mtd[0]->path . " ";
}
//var_dump($allFilePath);
//exit();
// 処理制限時間を外す
set_time_limit(0);

//linuxコマンド作成
$command = "zip ./zip/".$zipFileName.$allFilePath;

// Linuxコマンドの実行
exec($command);
// 圧縮したファイルをダウンロードさせる。
header('Content-Type: application/zip; name="' . $zipFileName . '"');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: '.filesize('./zip/'.$zipFileName));
echo file_get_contents('./zip/'.$zipFileName);
// 一時ファイルを削除しておく
unlink('./zip/'.$zipFileName);
exit();
?>