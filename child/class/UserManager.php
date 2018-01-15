<?php
require_once dirname(__FILE__)."/DBManager.php";
require_once dirname(__FILE__)."/ParentsTblDT.php";
require_once dirname(__FILE__)."/NurserySchoolsTblDT.php";
    

class UserManager {
    function user_register_parent($nursery_school_id,$parent_name){

    }
    function user_register_nursery_school($nursery_school_name,$address){

    }
    function user_parents_login($parent_id,$password){
        $dbm = new DBManager();
        $ptb = new ParentsTblDT();
        $password = (String)$password;
        $parent_id = (String)$parent_id;
        $list = $dbm->parent_select($parent_id);
        $id_list = array();
        $pass_list = array();
        foreach($list as $id){
            $id_list[] = $id->get_parent_id();
            $pass_list[] = $id->get_password();
        }
        if(!empty($list)){
            $hashpass = $pass_list[0];
            $passcheck = $this->user_check_pass_parent($password,$hashpass);
            if($passcheck == true) {
                $_SESSION["nursery_school_id"] = $id_list[0];
                $_SESSION["kubun"] = "parent";
                header("Location:top.php");
            }else {
                header("Location:parents_login.php");
            }

        }else {
                header("Location:parents_login.php");
        }
    }
    function user_nursery_school_login($nursery_school_id,$password){
        $dbm = new DBManager();
        $ptb = new NurserySchoolsTblDT();
        $password = (String)$password;
        $nursery_school_id = (String)$nursery_school_id;

        $list = $dbm->nursery_school_select($nursery_school_id);
        $id_list = array();
        $pass_list = array();
        foreach($list as $id){
            $id_list[] = (String)$id->get_nursery_school_id();
            $pass_list[] = (String)$id->get_password();
        }
        
        if(!empty($list)){
            $hashpass = $pass_list[0];
            $passcheck = $this->user_check_pass_nursery_school($password,$hashpass);
            if($passcheck == true) {
                $_SESSION["nursery_school_id"] = $id_list[0];
                $_SESSION["kubun"] = "nursery_school";
                header("Location:top.php");
            }else {
                header("Location:parents_login.php");
            }
            
        }else {
                header("Location:nursery_school_login.php");
        }
    }
    function user_check_pass_parent($password,$hashpass){
        /*$result = password_verify($password,$hashpass);*/
        $result = false;
        if($password == $hashpass){
            $result = true;
        }
        return $result;
    }
    function user_check_pass_nursery_school($password,$hashpass){
        /*$result = password_verify($password,$hashpass);*/
        $result = false;
        if($password == $hashpass){
            $result = true;
        }
        return $result;
    }
    function user_delete_parent($parent_id){

    }
    function user_delete_nursery_school($nursery_id){

    }
    function user_create_pass(){

    }
    function user_update_parent($parent_id,$password){

    }
    function user_update_nursery_school($parent_id,$password){

    }
}
?>