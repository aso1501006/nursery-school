<?php
require_once dirname(__FILE__)."/DBManager.php";
require_once dirname(__FILE__)."/SchedulesTblDT.php";
class ScheduleManager{

    public function insert_schedule($nursery_school_id,$schedule_name,$schedule_date){
        $DB = new DBManager();

        $DB->schedule_insert($nursery_school_id,$schedule_name,$schedule_date);
        
        return;
    }


    function get_schedule($nursery_school_id,$schedule_date){
        $dbm = new DBmanager(); 
        $list = $dbm->schedule_select($nursery_school_id,$schedule_date);
        $schedule_name_list = array();
        foreach($list as $a){
            $std = new SchedulesTblDT();
            $schedule_name_list[] = $a->schedule_name;
        }
        return $schedule_name_list;
    }


    public function get_schedule_between($nursery_school_id,$start_date,$end_date){
        $DB = new DBManager();

        $list = array();
        $list = $DB->schedule_select_between($nursery_school_id,$start_date,$end_date);

        return $list;
    }


    public function delete_schedule($nursery_school_id,$schedule_date,$schedule_name){
        $DB = new DBManager();

        $DB->schedule_delete($nursery_school_id,$schedule_date,$schedule_name);

        return;
    }


    public function update_schedule($nursery_school_id,$schedule_date,$schedule_name,$schedule_aName){
        $DB = new DBManager();

        $DB->schedule_update($nursery_school_id,$schedule_date,$schedule_name,$schedule_aName);

        return;
    }

    public function tag_insert($nursery_school_id,$schedule_date){
        $DB = new DBManager();

        $DB->tag_insert($nursery_school_id,$schedule_date);

        return;
    }
}
?>