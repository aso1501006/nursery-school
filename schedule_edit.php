<?php
    session_start();
    require_once dirname(__FILE__)."/class/ScheduleManager.php";

    $nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);

    $schedule_date = htmlspecialchars($_POST['schedule_date']);
    $schedule_name = htmlspecialchars($_POST['schedule_name']);
    $scheudle_aName = htmlspecialchars($_POST['schedule_aName']);

    $DB = new ScheduleManager();
    $DB->update_schedule($nursery_school_id,$schedule_date,$schedule_name,$scheudle_aName);
    
    return;
?>