<?php
    session_start();
    require_once dirname(__FILE__)."/class/ScheduleManager.php";

    $nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);

    //$schedule_date = strtotime($_POST['schedule_date']);
    $schedule_date = htmlspecialchars($_POST['schedule_date']);
    $schedule_name = htmlspecialchars($_POST['schedule_name']);
    //var_dump($schedule_date);
    /*
    var_dump("a".$nursery_school_id);
    var_dump("b".$schedule_date);
    var_dump("c".$schedule_name);
    */
    //var_dump($_POST);
    
    $DB = new ScheduleManager();
    $DB->insert_schedule($nursery_school_id,$schedule_name,$schedule_date);
    
    return;
    
?>