<?php
include("../include/db.php");
include("../include/exec.php");

$db = new Database();
$str_conn = $db->getConnection();
$str_exe = new ExecSQL($str_conn);
$action = $_POST['cmd'];
switch($action){
    case 'insert' :
    $van_id = $_POST['van_id'];
    $brand_id = $_POST['brand_id'];
    $seat = $_POST['seat'];
    $id_card = $_POST['id_card'];

    $stmt = $str_exe->readAll("vans where id_card = '$id_card'");
    $num_row = $str_exe->rowCount("vans where id_card = '$id_card'");
    if($num_row > 0){
        echo "2";
    } else {
    $strSQL = $str_exe->insert("vans",
    "van_id, brand_id, seat, id_card",
    "'$van_id', '$brand_id', '$seat', '$id_card'");
    if($strSQL){ echo "1"; }
    else { echo "0"; }
    }
    break;

    case 'update' :
    $van_id = $_POST['van_id'];
    $brand_id = $_POST['brand_id'];
    $seat = $_POST['seat'];
    $id_card = $_POST['id_card'];

    $stmt = $str_exe->readAll("vans where id_card = '$id_card'");
    $num_row = $str_exe->rowCount("vans where id_card = '$id_card'");
    if($num_row > 0){
        echo "2";
    } else {
    $strSQL = $str_exe->update("vans"
    ," brand_id = '$brand_id', seat = '$seat', id_card = '$id_card'",
     "where van_id = '$van_id'");
    if($strSQL){ echo "1"; }
    else { echo "0"; }
    }
    break;

    case 'delete' :
    $van_id = $_POST['van_id'];
    $stmt = $str_exe->readOne("DELETE FROM", "vans", "WHERE van_id = '$van_id'");

    if($stmt){ echo "1"; }
    else{ echo "0"; }
    break;

    case 'check_driver' :
    $id_card = $_POST['id_card'];
    $stmt = "select * from vans WHERE id_card = '$id_card'";
    $result = $str_conn->query($stmt);
    if($result){ echo $result; }
    else{ echo $result; }
    break;
}
?>
