<?php

include("../include/db.php");

include("../include/exec.php");



$db = new Database();

$str_conn = $db->getConnection();

$str_exe = new ExecSQL($str_conn);

$action = $_POST['cmd'];

switch($action){

    case 'insert' :

    $route_id = $_POST['route_id'];

    $time = $_POST['time'];

    $van_id = $_POST['van_id'];



    $strSQL = $str_exe->insert("reservations",

    "round_id, route_id, time, van_id",

    "NULL, '$route_id', '$time', '$van_id'");

    if($strSQL){ echo "1"; }

    else { echo "0"; }

    break;



    case 'update_payment' :

    $re_id = $_POST['re_id'];

    foreach($re_id as $id) {

        $stmt = $str_exe->update("reservations", "payment_status = '2'", "where re_id = '$id'");

    }

    

    if($stmt){ echo "1"; }

    else { echo "0"; }

    break;





    case 'delete' :

    $round_id = $_POST['round_id'];

    $stmt = $str_exe->readOne("DELETE FROM", "reservations", "WHERE round_id = '$round_id'");

    if($stmt){ echo "1"; }

    else{ echo "0"; }

    break;

    case 'update_half' :
    $re_id = $_POST['re_id'];
    $price_half = $_POST['price_half'];

    $sql = "UPDATE reservations set reserv_price = '$price_half' where re_id = '$re_id'";
    $result = $str_conn->query($sql);
    if($result){
        echo "1";
    } else {
        echo $re_id.$price_half;
    }
    break;
}

?>

