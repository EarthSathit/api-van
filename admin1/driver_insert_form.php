<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลคนขับรถ</title>
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
     ?>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left">
    <p style="font-size: 24px;"><span class="label label-primary">เพิ่มข้อมูลคนขับรถ</span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
      <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label w" style="width: 120px;">รหัสประจำตัว :</label>
          <div class="col-sm-9">
            <input type="text" class="col-sm-1 form-control" id="pid" maxlength="13" style="width: 180px;">
        </div>
        </div>
        <div class="form-group">
          <label for="title" class="col-sm-1 control-label w">คำหน้าชื่อ :</label>
            <div class="col-sm-9">
              <select class="form-control w" id="title" required>
            <option value="" disabled selected>คำหน้าชื่อ</option>
            <?php
              $stmt = $str_exe->readAll("initial");
              $num_row = $str_exe->rowCount("initial");
              if ($num_row != 0){
                  foreach($stmt as $rows){ ?>
                  <option value="<?php echo $rows['initial_id']?>"><?php echo $rows['initial_name']; ?></option>
               <?php } } ?>
          </select>
            </div>
        </div>
        <div class="form-group">
            <label for="id_card" class="col-sm-1 control-label w" style="width: 117px;">ชื่อ :</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="fname" style="width: 160px;"
            placeholder="ชื่อ" value="<?php echo $row['name']; ?>" required>
          </div>
          <label for="id_card" class="col-sm-1 control-label" style="width: 100px;">นามสกุล :</label>
          <div class="col-sm-1">
            <input type="text" class="form-control" id="lname" style="width: 190px;"
            placeholder="นามสกุล" value="<?php echo $row['lastname']; ?>" required>
          </div>
          </div>
        <!-- <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label w" style="width: 130px;">วัน/เดือน/ปี :</label>
          <div class="col-sm-9">
             <div class="form-group">
             <input type="text" class="col-sm-1 form-control" id="datepicker" style="width: 200px;">
          </div>
        </div>
        </div> -->
                  <div class="form-group">
        <button type="button" class="btn btn-default" id="back_driver">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="save_driver">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
                  </div>
      </form>
  </div>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#back_driver').on('click', function(){
      $('#display_table').load("drivers.php");
    });
  
    $('#save_driver').on('click', function(){
      let pid = $('#pid').val()
      let title = $('#title').val()
      let fname = $('#fname').val()
      let lname = $('#lname').val()
      //let date = $('#id_datecard').val()
     
    if(pid != '' && title != '' && fname != '' && lname != ''){
      $.post("sql_driver.php", {
      cmd : 'insert',
      pid : pid,
      title : title,
      fname : fname,
      lname : lname
    }, function(data){
        
      if (data == 1) {
        alert_success('บันทึกเรียบร้อย')
        setTimeout(() => {
          $('#display_table').load('drivers.php')
        }, 2000);
        // $('#van_id').val(null);
        // $('#brand_id').val(null);
        // $('#seat').val(null);
        // $('#id_card').val(null);
      }else {
          alert_warning('ddsdd')
      }
    });
  } else {
    alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก')
  }
  });
 });
</script>
