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

      if (isset($_POST['pid'])) {
      $db = new Database();
      $str_conn = $db->getConnection();
      $str_exe = new ExecSQL($str_conn);
      $stmt = $str_exe->readAll("drivers where pid = '".$_POST['pid']."'");
      $num_row = $str_exe->rowCount("vans");
      if ($num_row != 0) {
        $i = 0;
        foreach ($stmt as $row) { $i++; ?>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left">
    <p style="font-size: 24px;"><span class="label label-primary">แก้ไขข้อมูลคนขับรถ</span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
          <input type="hidden" id="pid" value="<?php echo $row['pid']; ?>">
      <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label w">คำหน้าชื่อ :</label>
            <div class="col-sm-9">
              <select class="form-control w" id="title" required>
            <option value="" disabled selected>คำหน้าชื่อ</option>
            <?php
              $stmt = $str_exe->readAll("initial");
              $num_row = $str_exe->rowCount("initial");
              if ($num_row != 0){
                  foreach($stmt as $rows){ ?>
                  <option value="<?php echo $rows['initial_id']?>" <?php if($rows['initial_id'] == $row['title']) {echo ' selected="selected"';} ?>><?php echo $rows['initial_name']; ?></option>
               <?php } } ?>
          </select>
            </div>
        </div>
        <div class="form-group">
            <label for="id_card" class="col-sm-1 control-label w" style="width: 117px;">ชื่อ :</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="fname" style="width: 160px;"
            placeholder="ชื่อ" value="<?php echo $row['fname']; ?>" required>
          </div>
          <label for="id_card" class="col-sm-1 control-label" style="width: 100px;">นามสกุล :</label>
          <div class="col-sm-1">
            <input type="text" class="form-control" id="lname" style="width: 190px;"
            placeholder="นามสกุล" value="<?php echo $row['lname']; ?>" required>
          </div>
          </div>
          <div class="form-group">
        <button type="button" class="btn btn-default" id="back_van">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="edted_van">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
        </div>
      </form>
  </div>
  <?php } } } ?>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#back_van').on('click', function(){
      $('#display_table').load("drivers.php");
    });

    $('#edted_van').on('click', function(){
      let pid = $('#pid').val()
      let title = $('#title').val()
      let fname = $('#fname').val()
      let lname = $('#lname').val()
      
      $.post("sql_driver.php", {
      cmd : 'update',
      pid : pid,
      title : title,
      fname : fname,
      lname : lname
    }, function(data){
      if (data == 1) {
        alert_success('บันทึกเรียบร้อย');
        setTimeout(() => {
          $('#display_table').load('drivers.php')
        }, 2000);
        // $('#van_id').val(null);
        // $('#brand_id').val(null);
        // $('#seat').val(null);
        // $('#id_card').val(null);
      }
    });
  });
 });
</script>
