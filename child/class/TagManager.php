<?php
require_once dirname(__FILE__)."/DBManager.php";

class TagManager{

  public function tag_select_all(){
    $DB = new DBManager();
    $nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);

    $select = $DB->tag_select_all($nursery_school_id);
    return $select;
  }

  public function tag_insert($tag_name){
    $DB = new DBManager();
    $nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);
  
    $DB->tag_insert($nursery_school_id,$tag_name);
    return;
  }

  public function tag_edit($tag_id,$tag_name){
    $DB = new DBManager();
    
    $DB->tag_update($tag_id,$tag_name);
    return;
  }

  public function tag_delete($tag_id){
    $DB = new DBManager();

    $DB->tag_delete($tag_id);
    return;
  }

}
?>