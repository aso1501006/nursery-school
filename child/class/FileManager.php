<?php
    if(file_exists(dirname(__FILE__)."/DBManager.php")){
        require_once dirname(__FILE__)."/DBManager.php";
    }else{
        require_once("../class/DBManager.php");    
    }
    class FileManager{
        function get_photo_new($nursery_school_id,$limit_num){
            
            $dbm = new DBManager();
            $list = $dbm->photo_select_new($nursery_school_id,$limit_num);
            return $list;
            
        }
        function get_photo_tag($tag_id){

        }
        function insert_photo($photo_name,$nursery_school_id,$photo_date,$photo_path,$tag_id){
            $DBManager = new DBManager();
            $DBManager->photo_insert($photo_name,$nursery_school_id,$photo_date,$photo_path);
            $photo_id = $DBManager->photo_id_get($photo_path);
            if($tag_id != null){
                $DBManager->photo_tag_insert($photo_id,$tag_id);
            }
        }
        function update_photo($photo_id,$photo_name){
            $DBManager = new DBManager();
            $DBManager->photo_update($photo_id,$photo_name);
        }
        function delete_photo($photo_id){
            $DBManager = new DBManager();
            $photo = $DBManager->photo_select($photo_id);
            $DBManager->photo_delete($photo_id);
            $DBManager->photo_tag_delete($photo_id);
            if(!empty($photo)){
                unlink($photo[0]->path);
            }
        }
        function get_movie_new($nursery_school_id,$limit_num){
            $dbm = new DBManager();
            $list = $dbm->movie_select_new($nursery_school_id,$limit_num);
            return $list;
        }
        function get_movie_tag($tag_id){

        }
        function insert_movie($movie_name,$nursery_school_id,$movie_date,$movie_path,$tag_id){
            $DBManager = new DBManager();
            $DBManager->movie_insert($movie_name,$nursery_school_id,$movie_date,$movie_path);
            $movie_id = $DBManager->movie_id_get($movie_path);
            if($tag_id != null){
                $DBManager->movie_tag_insert($movie_id,$tag_id);
            }
        }
        function update_movie($movie_id,$movie_name){
            $DBManager = new DBManager();
            $DBManager->movie_update($movie_id,$movie_name);
        }
        function update_movie_URL($name,$URL){
            $DBManager = new DBManager();
            $DBManager->movie_update_URL($name,$URL);
        }
        function delete_movie($movie_id){
            $DBManager = new DBManager();
            $movie = $DBManager->movie_select($movie_id);
            $DBManager->movie_delete($movie_id);
            $DBManager->movie_tag_delete($movie_id);
            if(!empty($movie)){
                unlink($movie[0]->path);
            }
        }        
        function get_nursery_photo_select($nursery_school_id){
            $dbm = new DBManager();
            $list = $dbm->nursery_photo_select($nursery_school_id);
            return $list;
        }
    }
?>