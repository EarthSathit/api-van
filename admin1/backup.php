<?php
      include("../include/db.php");
      include("../include/exec.php");
      include("style_form.php");

      require('fpdf/fpdf.php');
      define('FPDF_FONTPATH','font/');

      $db = new Database();
      $str_conn = $db->getConnection();
      $str_exe = new ExecSQL($str_conn);

      $month = $_GET['month'];
      $year = $_GET['year'];

      class PDF extends FPDF {
        
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
    
        function setFontTH($font, $file, $size){
            $this->AddFont($font, '', $file);
            $this->SetFont($font, '', $size);
        }

        function writePage($pageNo) {
            $this->returnFont(0, 0, ''.$pageNo.'/{nb}', 0, 0, 'R', false);
            $this->Ln(5);
        }

        function genHeadTable(){
            $this->setFontTH('THSarabunNew_b', 'THSarabunNew_b.php', 16);
            $this->returnFont(10, 10, '', 0, 0, "C", false);
            $this->returnFont(20, 10, 'ลำดับที่', 1, 0, "C");
            $this->returnFont(50, 10, 'เส้นทาง', 1, 0, "C");
            $this->returnFont(50, 10, 'จำนวนคน', 1, 0, "C");
            $this->returnFont(50, 10, 'รวม', 1, 1, "C");
            $this->setFontTH('THSarabunNew', 'THSarabunNew.php', 16);
        }

        function genBody(){
          $db = new Database();
          $str_conn = $db->getConnection();
          $str_exe = new ExecSQL($str_conn);
          $month = $_GET['month'];
          $year = $_GET['year'];
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
          $i++; $n++;
                    if($n != 23){
                        $this->returnFont(10, 10, '', 0, 0, "C", false);
                        $this->returnFont(20, 10, $i, 'L, R', 0, "C", false);
                        $this->returnFont(50, 10, $rows['route'], R, 0, "C", false);
                        $this->returnFont(50, 10, $sum_route, 
                                      R, 0, "0", "L", false);
                        $this->returnFont(50, 10, $sum_consumer, R, 1, "0", "L", false);
                    }else{
                        $this->returnFont(10, 10, '', 0, 0, "C", false);
                        $this->returnFont(20, 10, $i, 'L, R, B', 0, "C", false);
                        $this->returnFont(50, 10, $rows['route'], 'R, B', 0, "C", false);
                        $this->returnFont(50, 10, $sum_route, 
                                      'R, B', 0, "0", "L", false);
                        $this->returnFont(50, 10, $sum_consumer, 'R, B', 1, "0", "L", false);

                        $this->Ln(20);
                        $this->AddPage('P','A4');

                        $this->setFontTH('THSarabunNew_b', 'THSarabunNew_b.php', 18);
                        $this->genHeader();
                        $this->setFontTH('THSarabunNew_b', 'THSarabunNew_b.php', 16);
                        $this->genHeadTable();
                        $n = 0;
                    }

                    if($i == $total){
                        $this->returnFont(10, 10, '', 0, 0, "C", false);
                        $this->returnFont(20, 10, '', 'L, R, B', 0, "C", false);
                        $this->returnFont(50, 10, '', 'R, B', 0, "C", false);
                        $this->returnFont(50, 10, '', 
                                      'R, B', 0, "0", "L", false);
                        $this->returnFont(50, 10, '', 'R, B', 1, "0", "L", false);
                    }
                }
            }
        }

        function returnFont($w, $h, $txt, $border, $ln, $align){
            $this->Cell($w, $h, iconv('UTF-8', 'TIS-620', $txt), $border, $ln, $align);
        }

        function thaiDate(){
            $date.= date("d/");
            $date.= date("m/");
            $date.= (date("Yํ")+543);
            return $date;
        }

        function genHeader(){ 
          if(isset($month)) {
            $title = "ประจำเดือน ".checkMonth($month);
          } else {
            $title = "ประจำปี ".$year;
          }
    
          $year_current = date('Y');
          $year_bhudda = $year_current + 543;
          
          $year = $year - 543;
          
    if(isset($month)){
      $y = ' ปี '.$year_bhudda;
    } else {
      $y = '';
    }
    $title = "รายงานการใช้บริการรถตู้สาธารณะบริษัทหนุมานทัวร์สยาม จำกัด ".$title.$y;
            $this->setFontTH('THSarabunNew_b', 'THSarabunNew_b.php', 18);
            $this->writePage($this->PageNo());
            $this->returnFont(0, 20, $title, 0, 1, "C", false);
            $this->returnFont(20, 10, '', 0, 0, "C", false);
            $this->returnFont(20, 10, 'วันที่', 0, 0, "C", false);
            $this->returnFont(20, 10, $this->thaiDate(), 0, 0, "C", false);
            $this->returnFont(70, 10, '', 0, 0, "C", false);
            $this->returnFont(20, 10, 'รวมเงินทั้งหมด', 0, 0, "C", false);
            $this->returnFont(20, 10, 'รวมผู้ใช้บริการทั้งหมด', 0, 0, "C", false);
            $this->returnFont(20, 10, 'เส้นทางที่คนใช้บริการมากที่สุด', 0, 0, "C", false);
            $db = new Database();
            $str_conn = $db->getConnection();
            $str_exe = new ExecSQL($str_conn);
            $month = $_GET['month'];
            $year = $_GET['year'];
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
            $this->returnFont(5, 10, $total, 0, 0, "C", false);
            $this->returnFont(13, 10, 'บาท', 0, 0, "C", false);
            $this->returnFont(5, 10, $total_consumer, 0, 0, "C", false);
            $this->returnFont(13, 10, 'คน', 0, 0, "C", false);
            $this->returnFont(5, 10, $res_rou, 0, 0, "C", false);
            $this->returnFont(13, 10, '', 0, 0, "C", false);
            $this->Ln();
        }
    }

    $pdf = new PDF();
    $pdf->AddPage('P','A4');
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 10.00125);
    $pdf->genHeader();
    $pdf->genHeadTable();
    $pdf->genBody();
    $pdf->Output();
?>
  