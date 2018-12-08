<?php
include("../include/db.php");
include("../include/exec.php");

$db = new Database();
$str_conn = $db->getConnection();
$str_exe = new ExecSQL($str_conn);
$action = $_POST['cmd'];
switch($action){
    case 'insert' :
    $phone = $_POST['phone'];
    $initial_id = $_POST['initial_id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $user_type_id = $_POST['user_type_id'];
   
    $strSQL = $str_exe->insert("users",
    "phone, initial_id, name, lastname, email, password",
    "'$phone', '$initial_id', '$name', '$lastname', '$email', '$password'");
    if($strSQL){ echo "1"; }
    else { echo "0"; }
    break;

    case 'update' :
    $phone = $_POST['phone'];
    $initial_id = $_POST['initial_id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $str_exe->update("users"
    ," name = '$name', lastname = '$lastname', email = '$email', password = '$password'",
    "where phone = '$phone'");
    if($stmt){ echo "1"; }
    else { echo "0"; }
    break;


    case 'delete' :
    $phone = $_POST['phone'];
    $stmt = $str_exe->readOne("DELETE FROM", "users", "WHERE phone = '$phone'");
    if($stmt){ echo "1"; }
    else{ echo "0"; }
    break;
}
?>
