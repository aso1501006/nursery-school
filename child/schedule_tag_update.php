<?php
    session_start();
    require_once dirname(__FILE__)."/class/ScheduleManager.php";

    $nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);
    $schedule_name = htmlspecialchars($_POST['schedule_name']);

    $DB = new ScheduleManager();
    $DB->tag_insert($nursery_school_id,$schedule_name);
    
    return;
?>