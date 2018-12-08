<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>เพิ่มข้อมูลรถตู้</title>
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
    <p style="font-size: 24px;"><span class="label label-primary">เพิ่มข้อมูลรถตู้</span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label w">ทะเบียนรถ :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control w" id="van_id" placeholder="ทะเบียนรถ" maxlength="6" required>
            </div>
        </div>
        <div class="form-group">
          <label for="brand" class="col-sm-1 control-label w">ยี่ห้อ :</label>
          <div class="col-sm-2">
          <select class="form-control w" id="brand_id" required>
            <option value="" disabled selected>ยี่ห้อ</option>
            <?php
              $stmt = $str_exe->readAll("brands");
              $num_row = $str_exe->rowCount("brands");
              if ($num_row != 0){
                  foreach($stmt as $rows){ ?>
                  <option value="<?php echo $rows['brand_id']?>"><?php echo $rows['name']; ?></option>
               <?php } } ?>
          </select>
          </div>
            <label for="seat" class="col-sm-1 control-label w">ที่นั่ง :</label>
            <div class="col-sm-2">
              <select class="form-control w" id="seat" required>
                <option value="" disabled selected>ที่นั่ง</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
              </select>
            </div>
        </div>
        <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label w">คนขับรถตู้ :</label>
          <div class="col-sm-9">
          <select class="form-control w" id="id_card" style="width: 200px;" required>
                <option value="" disabled selected>คนขับรถตู้</option>
                <?php
              $stmt = $str_exe->readAll("drivers d, initial i 
              where d.title = i.initial_id");
          
            $num_row = $str_exe->rowCount("drivers");
              if ($num_row != 0){
                  foreach($stmt as $rows){ ?>
                  <option value="<?php echo $rows['pid']?>"><?php echo $rows['initial_name'].' '.$rows['fname'].' '.$rows['lname']; ?></option>
               <?php } } ?>
              </select>
          </div>
        </div>
        <button type="button" class="btn btn-default" id="back_van">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="save_van">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
      </form>
  </div>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#back_van').on('click', function(){
      $('#display_table').load("vans.php");
    });

    // $('#id_card').on('change', function() {
    //   let id_card = $('#id_card').val()
    //   $.post("sql_van.php", {
    //     cmd : 'check_driver',
    //     id_card : id_card
    //   }, function(data){
    //     console.log(data)
    //     if(data == '1'){
    //       alert_warning('คนขับรถมีรถประจำแล้ว กรุณาเลือกคนขับคนอื่น')
    //       $('#id_card').val('')
    //     }
    //   })
    // })

    $('#save_van').on('click', function(){
      let van_id = $('#van_id').val()
      let brand_id = $('#brand_id').val()
      let seat = $('#seat').val()
      let id_card = $('#id_card').val()
     
    if(van_id != null && brand_id != null && seat != null && id_card != null){
      $.post("sql_van.php", {
      cmd : 'insert',
      van_id : van_id,
      brand_id : brand_id,
      seat : seat,
      img_van : null,
      id_card : id_card
    }, function(data){
      if (data == '1') {
        alert_success('บันทึกเรียบร้อย')
        setTimeout(() => {
          $('#display_table').load('vans.php')
        }, 2000);
        // $('#van_id').val(null);
        // $('#brand_id').val(null);
        // $('#seat').val(null);
        // $('#id_card').val(null);
      }  else if(data == '2'){
        alert_warning('คนขับรถมีรถประจำแล้ว กรุณาเลือกคนขับคนอื่น')
        $('#id_card').val('')
        $('#id_card').focus()
      }
    });
  } else {
    alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก')
  }
  });
 });
</script>
