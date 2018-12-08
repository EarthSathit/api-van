<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>แก้ไขข้อมูลเส้นทางรถ</title>
    <!-- Alertbox -->
 <script src="js/alertbox.js"></script>
  </head>
  <body>
  <?php 
  include("style_form.php");
  ?>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left">
    <p style="font-size: 24px;"><span class="label label-primary">รายงานการใช้บริการรถตู้</span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal" name="" novalidate>
        <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label w" style="width: 130px;">ประเภทรายงาน :</label>
            <div class="col-sm-9">
            <select id="report_type" class="form-control" style="width: 150px;" required>
              <option value="" disabled selected>ประเภทรายงาน</option>
              <option value="1">PDF</option>
              <option value="2">Excel</option>
              <option value="3">Graph</option>
             </select>
            </div>
        </div>
        <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label w" style="width: 130px;">ช่วงเวลา :</label>
            <div class="col-sm-9">
             <select id="report_period" class="form-control" style="width: 150px;" required>
              <option value="" disabled selected>ช่วงเวลา</option>
              <option value="1">รายเดือน</option>
              <option value="2">รายปี</option>
             </select>
            </div>
        </div>
        <div class="form-group" id="month" style="display: none;">
          <label for="van_id" class="col-sm-1 control-label w" style="width: 130px;">เดือน :</label>
            <div class="col-sm-9">
             <select id="report_month" class="form-control" style="width: 150px;" required>
              <option value="" disabled selected>เลือกเดือน</option>
              <option value="1">มกราคม</option>
              <option value="2">กุมภาพันธ์</option>
              <option value="3">มีนาคม</option>
              <option value="4">เมษายน</option>
              <option value="5">พฤษภาคม</option>
              <option value="6">มิถุนายน</option>
              <option value="7">กรกฎาคม</option>
              <option value="8">สิงหาคม</option>
              <option value="9">กันยายน</option>
              <option value="10">ตุลาคม</option>
              <option value="11">พฤศจิกายน</option>
              <option value="12">ธันวาคม</option>
             </select>
            </div>
        </div> 
        <div class="form-group" id="year" style="display: none;">
          <label for="van_id" class="col-sm-1 control-label w" style="width: 130px;">ปี :</label>
            <div class="col-sm-9">
             <select id="report_year" class="form-control" style="width: 150px;" required>
              <option value="" disabled selected>เลือกปี</option>
              <?php 
                $year_current = date("Y/m/d");
                $sub_year = substr($year_current, 0, 4);
                $year_bhudda = $sub_year + 543;
                for($i=2560; $i<=$year_bhudda; $i++) { ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php }
              ?>
             </select>
            </div>
        </div>
        <div class="form-group">
        <!-- <button type="submit" class="btn btn-warning" id="download_report">
          <span class="glyphicon glyphicon-download"></span> ดาวน์โหลด</button>
        <button type="submit" class="btn btn-success" id="print_report">
          <span class="glyphicon glyphicon-print"></span> พิมพ์รายงาน</button> -->
          <button type="button" class="btn btn-danger" id="clear">
          <span class="glyphicon glyphicon-remove"></span> ยกเลิก</button>
        </div>
      </form>
</div>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    let link;
    let month;
    let year;
    let type;
    let period;

    $('#back_route').on('click', function(){
      $('#display_table').load("routes.php")
    })

    $('#clear').on('click', function(){
      $('#report_type').val('')
      $('#report_period').val('')
      $('#report_month').val('')
      $('#report_year').val('')
    })

    $('#edted_route').on('click', function(){

    if(type != '' && period != ''){
     $.post("sql_route.php", {
      cmd : 'update',
      route_id : $('#route_id').val(),
      route : $('#route_name').val(),
      price : $('#price').val(),
      time_route : $('#time_route').val()
    }, function(data){
      if (data == '1') {
        alert_success('บันทึกเรียบร้อย')
        setTimeout(function(){ $("#display_table").load("routes.php"); }, 2000)
        // $('#route_name').val(null);
        // $('#price').val(null);
        // $('#time_route').val(null);
      }else {
        alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก')
      }
    })
    } else {
      alert_warning('กรุณาเลือกเงื่อนไขรายงานก่อน')
    }
  })

  $('#report_month').on('change', function(){
    const re_month = $(this).val()
    month = re_month
    window.open(`http://wssathit.codehansa.com/admin1/${link}?month=${month}`)
  })

  $('#report_year').on('change', function(){
    const re_year = $(this).val()
    year = re_year
    window.open(`http://wssathit.codehansa.com/admin1/${link}?year=${year}`)
  })

  $('#search_report').on('click', function(){
    // let type_report = $('#report_type').val()
    // // console.log(type_report)
    // if(type_report == '1'){
    //   $('#display_table').load("report_pdf.php")
    // } else if(type_report == '2') {
    //   $('#display_table').load("report_excel.php")
    // } else {
    //   $('#display_table').load("report.graph.php")
    // }
    if(type != ''){
      if(period != ''){
        if(month != '' || year != ''){
      if(link == 'report_pdf.php'){
        if(month != '') {
          window.open(`http://wssathit.codehansa.com/admin1/report_pdf.php?month=${month}`)
        } else {
          window.open(`http://wssathit.codehansa.com/admin1/report_pdf.php?year=${year}`)
        } 
      } else if(link == 'report_excel.php') {
        if(month != '') {
          window.open(`http://wssathit.codehansa.com/admin1/report_excel.php?month=${month}`)
        } else {
          window.open(`http://wssathit.codehansa.com/admin1/report_excel.php?year=${year}`)
        } 
      } else {
        if(month != '' || month != 'undefined' || month != null) {
          console.log(month)
          console.log(year)
          window.open(`http://wssathit.codehansa.com/admin1/report_graph.php?month=${month}`)
        } else {
          window.open(`http://wssathit.codehansa.com/admin1/report_graph.php?year=${year}`)
        } 
      }
    } else {
      alert_warning('กรุณาเลือกเดือนหรือปีที่ต้องการค้นหา')
    }
      } else {
        alert_warning('กรุณาเลือกช่วงเวลา')
      }
    } else {
      alert_warning('กรุณาเลือกประเภทรายงาน')
    }
      month = ''
      year = ''
  })

  $('#report_type').on('change', function() {
     type = $(this).val()
    if(type == '1'){
      link = "report_pdf.php"
    }else if(type == '2'){
      link = "report_excel.php"
    }else {
      link = "report_graph.php"
    }
  })

  $('#report_period').on('change', function() {
    period = $(this).val()
    
    if(period == '1'){
      $('#month').css('display', '')
      $('#year').css('display', 'none')
      $('#year').val('')
    }else {
      $('#year').css('display', '')
      $('#month').css('display', 'none')
      $('#month').val('')
    }
  })

  $('#print_report').on('click', () => {
    const type = $('#report_type').val()
    const period = $('#report_period').val()

     if(type != null && period != null) {
      alert_success('กำลังปริ้น')
     } else {
      alert_warning('กรุณาเลือกเงื่อนไขก่อน')
     }
  })

  $('#download_report').on('click', () => {
    const type = $('#report_type').val()
    const period = $('#report_period').val()

     if(type != null && period != null) {
      alert_success('กำลังดาวน์โหลด')
     } else {
      alert_warning('กรุณาเลือกเงื่อนไขก่อน')
     }
  })
 })
</script>
