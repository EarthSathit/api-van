<?php
require('fpdf/fpdf.php');
include("../include/db.php");
include("../include/exec.php");
define('FPDF_FONTPATH','font/');

$pdf = new FPDF();
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
$pdf->AddPage('L','A4');
$pdf->SetFont('THSarabunNew','B', 18);

  $month = $_GET['month'];
  $year = $_GET['year'];

  $year_current = date('Y');
  $year_bhudda = $year_current + 543;

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

  if(isset($month)){
  $y = ' ปี '.$year_bhudda;
  } else {
  $y = '';
  }
  if(isset($month)) {
    $title = "ประจำเดือน ".checkMonth($month);
  } else {
    $title = "ประจำปี ".$year_bhudda;
  }

$ti = "รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด ".$title.$y;
$pdf->Ln(5);
$pdf->Cell(0, 10, iconv('UTF-8', 'cp874', $ti), '', 1, 'C', false);
$pdf->Ln(10);
$pdf->Cell(54);
$pdf->SetFont('THSarabunNew','B', 16);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'ลำดับ'), 'B, T', 0, 'C', false);
$pdf->Cell(50, 10, iconv('UTF-8', 'cp874', 'เส้นทาง'), 'B, T', 0, 'C', false);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'จำนวนคน'), 'B, T', 0, 'C', false);
$pdf->Cell(40, 10, iconv('UTF-8', 'cp874', 'รวม'), 'B, T', 0, 'C', false);
$pdf->SetFont('THSarabunNew','', 16);
$db = new Database();
$str_conn = $db->getConnection();
$str_exe = new ExecSQL($str_conn);
$month = $_GET['month'];
$year = $_GET['year'];
$year = $year - 543;
if(isset($month)) {
  $stmt = "SELECT * FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 6, 2) = '".$month."'
           AND substr(travel_date, 1, 4) = '".$year_current."' AND re.round_id = ro.round_id AND ro.route_id = rt.route_id ORDER BY rt.route";
} else if(isset($year)){
  $stmt = "SELECT * FROM reservations re, rounds ro, routes rt WHERE substr(travel_date, 1, 4) = '".$year."'
           AND re.round_id = ro.round_id AND ro.route_id = rt.route_id ORDER BY rt.route";
} else {
  exit();
}
$result = $str_conn->query($stmt);
      if($result){
      $total = 0;
      $total_consumer = 0;
      $i = 0;
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
        // $pdf->Cell(54);
        $pdf->Ln();
        $pdf->Cell(54);
        $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $i), '', 0, 'C', false);
        $pdf->Cell(50, 10, iconv('UTF-8', 'cp874', $rows['route']), '', 0, 'L', false);
        $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $sum_consumer), '', 0, 'C', false);
        $pdf->Cell(40, 10, iconv('UTF-8', 'cp874', $sum_route.'.-'), '', 0, 'C', false);
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
        $pdf->SetFont('THSarabunNew','B', 16);
        $pdf->Ln(20);
        $pdf->Cell(22);
        $pdf->Cell(233, 10, iconv('UTF-8', 'cp874', '================================================================================'), '', 1, 'C', false);
        $pdf->Ln(10);
        $pdf->Cell(1);
        $pdf->Cell(80, 10, iconv('UTF-8', 'cp874', 'รวมเงินทั้งหมด = '.$total.' บาท'), '', 1, 'C', false);
        $pdf->Cell(2);
        $pdf->Cell(80, 10, iconv('UTF-8', 'cp874', 'รวมผู้ใช้บริการทั้งหมด = '.$total_consumer.' คน'), '', 1, 'C', false);
        $pdf->Cell(1);
        $pdf->Cell(115, 10, iconv('UTF-8', 'cp874', 'เส้นทางที่คนใช้บริการมากที่สุด = '.$res_rou), '', 1, 'C', false);
$pdf->Output();
?>