<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลรถตู้</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Alertbox -->
 <script src="js/alertbox.js"></script>
  </head>
  <body>
    <?php
      include("../include/db.php");
      include("../include/exec.php");
      include("style_form.php");

      $db = new Database();
      $str_conn = $db->getConnection();
      $str_exe = new ExecSQL($str_conn);

      $month = $_GET['month'];
      $year = $_GET['year'];

      function checkMonth($m) {
       switch($m){
          case '1':
          return 'มกราคม';
          break;
          case '2':
          return 'กุมภาพันธ์';
          break;
          case '3':
          return 'มีนาคม';
          break;
          case '4':
          return 'เมษายน';
          break;
          case '5':
          return 'พฤษภาคม';
          break;
          case '6':
          return 'มิถุนายน';
          break;
          case '7':
          return 'กรกฎาคม';
          break;
          case '8':
          return 'สิงหาคม';
          break;
          case '9':
          return 'กันยายน';
          break;
          case '10':
          return 'ตุลาคม';
          break;
          case '11':
          return 'พฤศจิกายน';
          break;
          case '12':
          return 'ธันวาคม';
          break;
        }
      }

      if(isset($month)) {
        $title = "ประจำเดือน ".checkMonth($month);
      } else {
        $title = "ประจำปี ".$year;
      }

      $year_current = date('Y');
      $year_bhudda = $year_current + 543;
      
      $year = $year - 543;
    ?>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left" style="margin-top: 10px;">
    <p style="font-size: 24px;"><span>
    <?php
    if(isset($month)){
      $y = ' ปี '.$year_bhudda;
    } else {
      $y = '';
    }
    ?>
    <!-- รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด <?php echo $title.$y; ?></span></p> -->
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
        <div class="form-group">
        <?php
/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object<br>";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties<br>";
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
//echo date('H:i:s') . " Add some data<br>";
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด'.$title.$y)
            ->setCellValue('A2', 'ลำดับ')
            ->setCellValue('B2', 'เส้นทาง')
            ->setCellValue('C2', 'จำนวนคน')
			      ->setCellValue('D2', 'รวม');

// Write data from MySQL result
if(isset($month)) {
  $stmt = "SELECT * FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 6, 2) = '".$month."'
           AND substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id ORDER BY rt.route";
} else {
  $stmt = "SELECT * FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 1, 4) = '".$year."'
           AND re.round_id = ro.round_id AND ro.route_id = rt.route_id ORDER BY rt.route";
} 
$result = $str_conn->query($stmt);
if($result){
$total = 0;
$total_consumer = 0;
$i = 0;
$row_cell = 3;
 $sort_person = array();
 $sort_route = array();
foreach($result as $rows){
  $i++;
  if(isset($month)) {
    $sql = "select SUM(reserv_price) as sum_route, SUM(reserv_seat) as sum_consumer from reservations WHERE round_id = '".$rows['round_id']."'
            and substr(travel_date, 6, 2) = '".$month."' AND substr(travel_date, 1, 4) = '".$year_current."'";
  } else {
    $sql = "select SUM(reserv_price) as sum_route, SUM(reserv_seat) as sum_consumer from reservations WHERE round_id = '".$rows['round_id']."'
            and substr(travel_date, 1, 4) = '".$year."'";
  }
  $result_sum = $str_conn->query($sql);
  $sum_route = 0;
  $sum_consumer = 0;
  $route_most = '';
  foreach($result_sum as $res){
    $sum_route += $res['sum_route'];
    $sum_consumer += $res['sum_consumer'];
    $total_consumer += $sum_consumer;
  }
  $total += $rows['reserv_price'];
 
  array_push($sort_person, $sum_consumer);
  array_push($sort_route, $rows['route']);

  // echo $i.'. ';
  // echo ' เส้นทาง = '.$rows['route'];
  // echo ' รวม = '.$sum_route;
  // echo ' จำนวนคน = '.$sum_consumer;
  // echo "<br>";

  $objPHPExcel->getActiveSheet()->setCellValue('A' . $row_cell, $i);
  $objPHPExcel->getActiveSheet()->setCellValue('B' . $row_cell, $rows['route']);
  $objPHPExcel->getActiveSheet()->setCellValue('C' . $row_cell, $sum_consumer);
  $objPHPExcel->getActiveSheet()->setCellValue('D' . $row_cell, $sum_route);
  $row_cell++;
}

if(isset($month)) {
  $sql_report = "SELECT rt.route, SUM(re.reserv_seat) as sum_cosumer FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 6, 2) = '".$month."'
   AND substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route";
} else {
  $sql_report = "SELECT rt.route, SUM(re.reserv_seat) as sum_cosumer FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 1, 4) = '".$year."'
  AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route";
}

$res = $str_conn->query($sql_report);
} else {
echo "ไม่มีข้อมูลในช่วงเวลานี้ที่กำหนด";
return;
}

if(isset($month)) {
  $sql_route = "SELECT rt.route FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 6, 2) = '".$month."'
  AND substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route ORDER BY re.reserv_seat DESC LIMIT 1";
} else {
  $sql_route = "SELECT rt.route FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route ORDER BY re.reserv_seat DESC LIMIT 1";
}

$result_route = $str_conn->query($sql_route);
   
    foreach($result_route as $res_route){
      $res_rou = $res_route['route'];
    }   
    if(isset($month)) {
      $sql_max = "SELECT MAX(re.reserv_seat) as sum_cosumer FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 6, 2) = '".$month."'
      AND substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route";
    } else {
      $sql_max = "SELECT MAX(re.reserv_seat) as sum_cosumer FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 1, 4) = '".$year."' 
      AND re.round_id = ro.round_id AND ro.route_id = rt.route_id GROUP BY rt.route";
    }
    $res_max = $str_conn->query($sql_max);
   
    foreach($res_max as $max){
      $max = $max['sum_cosumer'];
    }
    // echo "<div align=center>";
    // echo 'รวมเงินทั้งหมด = '.$total.' บาท <br>';
    // echo 'รวมผู้ใช้บริการทั้งหมด = '.$total_consumer.' คน <br>';
    // echo 'เส้นทางที่คนใช้บริการมากที่สุด = '.$res_rou;
    // echo "</div>";
  $row_cell = $row_cell + 1;
  $row_cell1 = $row_cell + 1;
  $row_cell2 = $row_cell + 2;
$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_cell, 'รวมเงินทั้งหมด = '.$total);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_cell1, 'รวมผู้ใช้บริการทั้งหมด = '.$total_consumer);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $row_cell2, 'เส้นทางที่คนใช้บริการมากที่สุด = '.$res_rou);


// Rename sheet
//echo date('H:i:s') . " Rename sheet<br>";
$objPHPExcel->getActiveSheet()->setTitle('My Customer');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format<br>";
$day = date('d');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
if(isset($month)){
  $strFileName = $year_bhudda.'-'.$month.'-'.$day."-report_excel(m).xlsx";
} else {
  $mo = date('m');
  $strFileName = $year_bhudda.'-'.$mo.'-'.$day."-report_excel(y).xlsx";
}

$objWriter->save($strFileName);


// Echo memory peak usage
//echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r<br>";

// Echo done
//echo date('H:i:s') . " Done writing file.\r<br>";
?>
          </div>
        <div class="form-group">
        <!-- <button type="button" class="btn btn-default" id="back_round">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button> -->
          <!-- <a href="<?php echo $strFileName; ?>" id="edted_round" donwload><button type="button" class="btn btn-success">
           <span class="glyphicon glyphicon-download"></span> ดาวน์โหลด</button></a> -->
                  </div>
      </form>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #6699FF; color: white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</h4>
      </div>
      <div class="modal-body">
        <p>รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด <?php echo $title.$y; ?></p>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" id="back_round">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button> 
      <a href="<?php echo $strFileName; ?>" id="edted_round" donwload><button type="button" class="btn btn-success">
           <span class="glyphicon glyphicon-download"></span> ดาวน์โหลด</button></a>
      </div>
    </div>

  </div>
</div>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#myModal').modal('show')
    $('#back_round').on('click', function(){
      window.location = 'index.php' 
    });

    $('#edted_round').on('click', function(){
      $('#myModal').modal('hide')
      alert_success('ดาวน์โหลดเรียบร้อย')
      setTimeout(function(){ window.location = 'index.php' }, 2000)
    //   var round_id = $('#round_id').val()
    //   var route_id = $('#route_id').val()
    //   var time_s = $('#time_s').val()
    //   var time_f = $('#time_f').val()
    //   var time_sum = time_s + " - " + time_f
    //   var van_id = $('#van_id').val()
    //  $.post("sql_round.php", {
    //   cmd : 'update',
    //   round_id : round_id,
    //   route_id : route_id,
    //   time : time_sum,
    //   van_id : van_id
    // }, function(data){
    //   if (data == '1') {
      //   setTimeout(function(){ $("#display_table").load("rounds.php"); }, 2000)
      //   // $('#route_id').val(null);
      //   // $('#time_s').val(null);
      //   // $('#time_f').val(null);
      //   // $('#van_id').val(null);
      // }else {
      //   alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก')
      // }
    })
 })
</script>
