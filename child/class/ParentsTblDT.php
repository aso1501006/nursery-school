<?php
  class ParentsTblDT{
    private $parent_id;
    private $nursery_school_id;
    private $parent_name;
    private $password;
    
  function get_parent_id(){
    return $this->parent_id;
  }
  function get_nursery_id(){
    return $this->nursery_school_id;
  }
  function get_parent_name(){
    return $this->parent_name;
  }
  function get_password(){
    return $this->password;
  }
  function set_parent_id($parent_id){
    $this->parent_id = $parent_id;
  }
  function set_nursery_id($nursery_id){
    $this->nursery_id = $nursery_id;
  }
  function set_parent_name($parent_name){
    $this->parent_name = $parent_name;
  }
  function set_password($password){
    $this->password = $password;
  }
  }

?>