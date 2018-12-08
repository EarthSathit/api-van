<?php

include("include/db.php");

include("include/exec.php");


$db = new Database();

$str_conn = $db->getConnection();

$str_exe = new ExecSQL($str_conn);


$action = $_POST['cmd'];

switch($action){

    case "select":

      $stmt = $str_exe->readAll("reservations re, rounds ro, routes rt where re.round_id = ro.round_id

                                  and rt.route_id = ro.route_id and re.phone = '".$_POST['phone']."'");


    $num_row = $str_exe->rowCount("reservations");

    //echo json_encode($num_row);

    if ($num_row > 0){

        $data_arr['rs'] = array();

        foreach($stmt as $rows){

            $item = array(

                're_id' => $rows['re_id'],

                'round_id' => $rows['round_id'],

                'id_card' => $rows['id_card'],

                'reserv_date' => $rows['reserv_date'],

                'travel_date' => $rows['travel_date'],

                'payment_status' => $rows['payment_status'],

                'payment_method' => $rows['payment_method'],

                'route' => $rows['route'],

                'time' => $rows['time'],

                'price' => $rows['reserv_price'],

                'van_id' => $rows['van_id'],

            );

            array_push($data_arr['rs'], $item);

        }

            echo json_encode($data_arr);

    }else{

        echo json_encode(array('msg' => 'result not format'));

    }

    break;



    case 'insert' :

    $re_id = $_POST['re_id'];

    $round_id = $_POST['round_id'];

    //$id_card = $_POST['id_card'];

    $phone = $_POST['phone'];

    $reserv_date = $_POST['reserv_date'];

    $travel_date = $_POST['travel_date'];

    $payment_status = $_POST['payment_status'];

    $payment_method = $_POST['payment_method'];

    $reserv_seat = $_POST['reserv_seat'];

    $reserv_price = $_POST['reserv_price'];



    $strSQL = $str_exe->insert("reservations",

    "re_id, round_id, phone, reserv_date, travel_date, payment_status, payment_method,

    reserv_seat, reserv_price",

    "'$re_id', '$round_id', '$phone', '$reserv_date', '$travel_date', '$payment_status',

    '$payment_method', '$reserv_seat', '$reserv_price'");

    if($strSQL){

      echo json_encode(array('msg' => 'Insert Success'));

    }else {

      echo json_encode(array('msg' => 'Can not Insert'));

    }

    break;



    case 'update' :

    $re_id = $_GET['re_id'];

    $round_id = $_GET['round_id'];

    $id_card = $_GET['id_card'];

    $reserv_date = $_GET['reserv_date'];

    $payment_status = $_GET['payment_status'];

    $payment_method = $_GET['payment_method'];



    $stmt = $str_exe->update("reservations"

    ," round_id = '$round_id', id_card = '$id_card', reserv_date = '$reserv_date',

     payment_status = '$payment_status', payment_method = '$payment_method'",  "where re_id = ".$re_id);

    if($stmt){

      echo json_encode(array('msg' => 'Update Success'));

    }else {

      echo json_encode(array('msg' => 'Can not Update'));

    }

    break;





    case 'delete' :

      $re_id = $_GET['re_id'];

      $stmt = $str_exe->readOne("DELETE FROM", "reservations", "WHERE re_id = ".$re_id);

      if($stmt){

        echo json_encode(array('msg' => 'Delete Success'));

      }

      else{

        echo json_encode(array('msg' => 'Can not Delete'));

      }

    break;



    case 'history':

      $phone = $_POST['phone'];

      $stmt = "select SUM(reserv_seat) as amount_service from

                                  reservations where status_promotion = '0' and payment_status = '2' and phone = '$phone'";

      $result = $str_conn->query($stmt);

      if($result){

        $data_arr['rs'] = array();

        foreach($result as $rows){
          if($rows['amount_service'] == null){
            $item = array(

              'amount_service' => '0',

            );

            array_push($data_arr['rs'], $item);
          }else {
            $item = array(

              'amount_service' => $rows['amount_service'],

            );

            array_push($data_arr['rs'], $item);

        }
          }
                echo json_encode($data_arr);

        }else {

        echo $stmt;

      }

    break;
	
	case 'used_promotion':
    	$phone = $_POST['phone'];
    	$stmt = "UPDATE reservations SET status_promotion = '1' WHERE phone = '$phone' ORDER BY re_id
             LIMIT 10";
    	$result = $str_conn->query($stmt);
    	break;

	case 'unused_promotion':
    	$phone = $_POST['phone'];
    	$stmt = "UPDATE reservations SET status_promotion = '0' WHERE phone = '$phone' ORDER BY re_id
             LIMIT 10";
    	$result = $str_conn->query($stmt);
    	break;
	
	case 'data_reserv':

    if (isset($_POST['phone'])) {
      $stmt = $str_exe->readAll("reservations re, rounds ro, routes rt where re.round_id = ro.round_id
                                  and rt.route_id = ro.route_id and phone = '".$_POST['phone']."'
                                  and payment_status = '1'");
    }
    $num_row = $str_exe->rowCount("reservations");
    //echo json_encode($num_row);
    if ($num_row > 0){
        $data_arr['rs'] = array();
        foreach($stmt as $rows){
            $item = array(
                're_id' => $rows['re_id'],
                'round_id' => $rows['round_id'],
                'phone' => $rows['phone'],
                'reserv_date' => $rows['reserv_date'],
                'travel_date' => $rows['travel_date'],
                'payment_status' => $rows['payment_status'],
                'payment_method' => $rows['payment_method'],
                'route' => $rows['route'],
                'time' => $rows['time'],
                'price' => $rows['reserv_price'],
                'van_id' => $rows['van_id'],
            );
            array_push($data_arr['rs'], $item);
        }
            echo json_encode($data_arr);
    }else{
        echo json_encode(array('msg' => 'result not format'));
    }
    break;
	  case 'save_img_payment':
    $path_img = $_POST['img_payment'];
    $strSQL = $str_exe->insert("reservations", "img_payment", "'$path_img'");
    if($strSQL){
      echo json_encode(array('msg' => 'Insert Success'));
    }else {
      echo json_encode(array('msg' => 'Can not Insert'));
    }
    break;
case 'cancel_reserv': 
    $phone = $_POST['phone'];
    $re_id = $_POST['re_id'];
    $strSQL = $str_exe->readOne("DELETE FROM", "reservations", "WHERE re_id = ".$re_id);
    if($strSQL) {
      echo json_encode(array('msg' => 'Delete Success'));
    }else {
      echo json_encode(array('msg' => 'Can not Delete'));
    }
    break;
 case 'save_image': 
     function getFileName(){
     $db = new Database();
     $str_conn = $db->getConnection();
      $sql = "SELECT * FROM reservations order by re_id desc limit 1";
      $result = $str_conn->query($sql);
      foreach($result as $row){
        if($row['re_id'] == null){
          return 1;
        } else {
          return $row['re_id'];
        }
      }
    }
    $upload_path = 'uploads/'; //this is our upload folder
    $server_ip = gethostbyname(gethostname()); //Getting the server ip
    $upload_url = 'http://wssathit.codehansa.com/'.$upload_path; //upload url
 
    //response array
    $response = array();
	
    $caption = $_POST['caption'];
    $re_id = $_POST['re_id'];
    $fileinfo = pathinfo($_FILES['image']['name']);//getting file info from the request
    $extension = $fileinfo['extension']; //getting the file extension
    $file_url = $upload_url . getFileName() . '.' . $extension; //file url to store in the database
    $file_path = $upload_path . getFileName() . '.'. $extension; //file path to upload in the server
    $img_name = getFileName() . '.'. $extension; //file name to store in the database

    try{
        move_uploaded_file($_FILES['image']['tmp_name'],$file_path); //saving the file to the uploads folder;
       
        //adding the path and name to database
        // $sql = "INSERT INTO photos(photo_name, photo_url, caption) ";
        // $sql .= "VALUES ('{$img_name}', '{$file_url}', '{$caption}');";
        $stmt = "UPDATE reservations SET img_payment = '$file_url', img_name = '$img_name', img_caption = '$caption'
                WHERE re_id = '$re_id'";
        $result = $str_conn->query($stmt);
         
        if($result){
            //filling response array with values
            $response['error'] = false;
            $response['photo_name'] = $img_name;
            $response['photo_url'] = $file_url;
            $response['caption'] = $caption;
        }
        //if some error occurred
    }catch(Exception $e){
        $response['error']=true;
        $response['message']=$result->getMessage();
    }
    //displaying the response
    echo json_encode($response);
    break;
}

?>

