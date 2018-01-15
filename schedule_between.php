<?php
session_start();
require_once dirname(__FILE__)."/class//ScheduleManager.php";

$DB = new ScheduleManager();

$nursery_school_id = htmlspecialchars($_SESSION['nursery_school_id']);
$month = htmlspecialchars($_POST['month']);
$start_date = date('y-m-d', strtotime('first day of' . $month));
$end_date = date('y-m-d', strtotime('last day of' . $month));

$sche = $DB->get_schedule_between($nursery_school_id,$start_date,$end_date);
echo json_encode($sche);
?>