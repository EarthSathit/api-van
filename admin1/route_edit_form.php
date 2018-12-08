<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>แก้ไขข้อมูลเส้นทางรถ</title>
    <!-- Alertbox -->
 <script src="js/alertbox.js"></script>
  </head>
  <body>
    <?php
      include("../include/db.php");
      include("../include/exec.php");
      include("style_form.php");

      if (isset($_POST['route_id'])) {
      $db = new Database();
      $str_conn = $db->getConnection();
      $str_exe = new ExecSQL($str_conn);
      $stmt = $str_exe->readAll("routes where route_id = '".$_POST['route_id']."'");
      $num_row = $str_exe->rowCount("routes");
      if ($num_row != 0) {
        $i = 0;
        foreach ($stmt as $row) { $i++;
    ?>
  <div class="container-fluid">
    <div id="alertbox"></div>
    <div align="left">
    <p style="font-size: 24px;"><span class="label label-primary">แก้ไขข้อมูลเส้นทางรถ</span></p>
    </div>
      <hr align="left" style="width: 900px;">
      <form class="form-horizontal">
        <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label w">เส้นทางรถ :</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="route_name" placeholder="เส้นทางรถ"
               value="<?php echo $row['route']; ?>" style="width: 250px;">
               <input type="hidden" class="form-control" id="route_id" placeholder="รหัสเส้นทางรถ"
                value="<?php echo $row['route_id']; ?>">
            </div>
        </div>
        <div class="form-group">
          <label for="brand" class="col-sm-1 control-label w">ราคา :</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="price"
            placeholder="ราคา" value="<?php echo $row['price']; ?>">
          </div>
          </div>
        <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label w">เวลาเดินทาง :</label>
          <div class="col-sm-9">
            <input type="time" class="form-control" id="time_route"
            placeholder="เวลาเดินทาง" value="<?php echo $row['time_route']; ?>" style="width: 140px;">
          </div>
        </div>
        <button type="button" class="btn btn-default" id="back_route">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="edted_route">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
      </form>
</div>
  <?php } } } ?>
 </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
    $('#back_route').on('click', function(){
      $('#display_table').load("routes.php")
    });

    $('#edted_route').on('click', function(){
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
    });
  });
 });
</script>
