<?php
      include("../include/db.php");
      include("../include/exec.php");
      include("style_form.php");

      $month = $_GET['month'];
      $year = $_GET['year'];

      $db = new Database();
      $str_conn = $db->getConnection();
      $str_exe = new ExecSQL($str_conn);

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
  ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลรถตู้</title>
    <!-- Alertbox -->
 <script src="js/alertbox.js"></script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Route', 'Amount'],
  <?php 
    foreach($res as $re) {
      echo "['".$re["route"]."', ".$re["sum_cosumer"]."],";  
    }
  ?>
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'สรุปการใช้บริการ', 'width':550, 'height':400};

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
  </head>
  <body>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left">
    <p style="font-size: 24px;"><span class="label label-primary">
    <?php
    if(isset($month)){
      $y = ' ปี '.$year_bhudda;
    } else {
      $y = '';
    }
    ?>
    รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด <?php echo $title.$y; ?> </span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
        <div class="form-group">
        <div align="center">
        <div id="piechart"></div>
        </div>
        </div>
        <div class="form-group">
        <?php 
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
            echo "<div align=center>";
            echo 'รวมเงินทั้งหมด = '.$total.' บาท <br>';
            echo 'รวมผู้ใช้บริการทั้งหมด = '.$total_consumer.' คน <br>';
            echo 'เส้นทางที่คนใช้บริการมากที่สุด = '.$res_rou;
            echo "</div>";
        ?>
        </div>
        <!-- <div class="form-group">
        <button type="button" class="btn btn-default" id="back_round">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="edted_round">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
        </div> -->
      </form>
</div>
 </body>
</html>


