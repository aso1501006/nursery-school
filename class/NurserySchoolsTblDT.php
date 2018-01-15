<?php
  class NurserySchoolsTblDT{
    private $nursery_school_id;
    private $nursery_schol_name;
    private $password;
    private $address;
    private $update_date;
    
  function get_nursery_school_id(){
    return $this->nursery_school_id;
  }
  function get_nusery_school_name(){
    return $this->nusery_school_name;
  }
  function get_password(){
    return $this->password;
  }
  function get_address(){
    return $this->address;
  }
  function get_update_date(){
    return $this->update_date;
  }
  function set_nursery_school_id($nursery_school_id){
    $this->nursery_school_id = $nursery_school_id;
  }
  function set_nursery_school_name($nusery_school_name){
    $this->nusery_school_name = $nusery_school_name;
  }
  function set_password($password){
    $this->password = $password;
  }
  function set_address($address){
    $this->address = $address;
  }
  function set_update_date($update_date){
    $this->update_date = $update_date;
  }
  }

?>