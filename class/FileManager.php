<?php
    require_once dirname(__FILE__)."/DBManager.php";
    class FileManager{
        function get_photo_new($nursery_school_id,$limit_num){
            
            $dbm = new DBManager();
            $list = $dbm->photo_select_new($nursery_school_id,$limit_num);
            return $list;
            
        }
        function get_photo_tag($tag_id){

        }
        function insert_photo($photo_name,$photo_date,$photo_path){

        }
        function update_photo($photo_id,$photo_name,$photo_date){

        }
        function delete_photo($phpto_id){

        }
        function get_movie_new($nursery_school_id,$limit_num){
            $dbm = new DBManager();
            $list = $dbm->movie_select_new($nursery_school_id,$limit_num);
            return $list;
        }
        function get_movie_tag($tag_id){

        }
        function insert_movie($movie_name,$movie_date,$movie_path){

        }
        function update_movie($movie_id,$movie_name,$movie_date){

        }
        function update_movie_URL($movie_id){

        }
        function delete_movie($movie_id){

        }
        function get_nursery_photo_select($nursery_school_id){
            $dbm = new DBManager();
            $list = $dbm->nursery_photo_select($nursery_school_id);
            return $list;
        }
        function movie_photo_download($photo_id_list,$movie_id_list){
            // Zipクラスロード
            $zip = new ZipArchive();
            // Zipファイル名
            $zipFileName = 'download.zip';
            // Zipファイル一時保存ディレクトリ
            $zipTmpDir = './zip';
            //すべてのパスを結合した文字列
            $allFilePath = " ";
            
            // ここでDB等から画像イメージ配列を取ってくる
            $dbm = new DBManager();
            $mpt = new MoviePhotoTblDT();
            foreach($photo_id_list as $photo_id){
                $mpt = $dbm->photo_select($photo_id);
                $allFilePath .= $mpt[0]->path . " ";
            }      
            // ここでDB等から画像イメージ配列を取ってくる
            $dbm = new DBManager();
            $mtd = new MoviesTblDT();
            foreach($movie_id_list as $movie_id){
                $mtd = $dbm->movie_select($movie_id);
                $allFilePath .= $mtd[0]->path . " ";
            }       

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
        }
    }
?>