<?php

include("../include/db.php");

include("../include/exec.php");



$db = new Database();

$str_conn = $db->getConnection();

$str_exe = new ExecSQL($str_conn);

$action = $_POST['cmd'];

switch($action){

    case 'insert' :

    $pid = $_POST['pid'];
    $title = $_POST['title'];

    $fname = $_POST['fname'];

    $lname = $_POST['lname'];

    //$age = $_POST['age'];

    $strSQL = $str_exe->insert("drivers",

    "pid, title, fname, lname",

    "'$pid', '$title', '$fname', '$lname'");

    if($strSQL){ echo "1"; }

    else { echo "0"; }

    break;



    case 'update' :

    $pid = $_POST['pid'];
    $fname = $_POST['fname'];
    $title = $_POST['title'];
    $lname = $_POST['lname'];

    $stmt = $str_exe->update("drivers", "title = '$title', fname = '$fname', lname = '$lname'", 
    "where pid = '$pid'");

    if($stmt){ echo "1"; }

    else { echo "0"; }

    break;





    case 'delete' :

    $pid = $_POST['pid'];

    $stmt = $str_exe->readOne("DELETE FROM", "drivers", "WHERE pid = '$pid'");

    if($stmt){ echo "1"; }

    else{ echo "0"; }

    break;

}

?>

