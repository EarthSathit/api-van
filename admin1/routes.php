<!-- Alertbox -->
<script src="js/alertbox.js"></script>
<?php
  include("../include/db.php");
  include("../include/exec.php");
  include("plugin.php");

  $db = new Database();
  $str_conn = $db->getConnection();
  $str_exe = new ExecSQL($str_conn);
  $stmt = $str_exe->readAll("routes");
  $num_row = $str_exe->rowCount("routes");
?>
<div id="alertbox"></div>
<div align="right">
<button type="button" id="add_route" class="btn btn-success" name="button">
<span class="glyphicon glyphicon-plus"></span> เพิ่มเส้นทางรถ</button>
</div> <br>
<div class="table-responsive">
<table id="tbl_route" class="table table-striped table-hover table-condensed">
<caption><div align="center">
<p style="font-size: 24px;"><span class="label label-primary">ข้อมูลเส้นทางรถ</span></p></div>
</caption>
  <thead>
    <th class="no-sort"><div align="center">ลำดับที่</div></th>
    <th><div align="center">เส้นทาง</div></th>
    <th><div align="center">ราคา</div></th>
    <th><div align="center">เวลาเดินทาง</div></th>
    <th class="no-sort"><div align="center">แก้ไข</div></th>
    <th class="no-sort"><div align="center">ลบ</div></th>
  </thead>
  <tbody id="myTable">
    <?php
    if ($num_row != 0) {
      $i = 0;
        foreach($stmt as $rows) { $i++; ?>
          <tr>
            <td><div align="center"><?php echo $i; ?></div></td>
            <td><?php echo $rows['route']; ?></td>
            <td><div align="center"><?php echo $rows['price']." .-"; ?></div></td>
            <td><div align="center"><?php $date = date("H:i", strtotime($rows['time_route'])); echo $date." ชม."; ?></div></td>
            <td><div align="center">
              <button type="button" class="btn btn-warning" id="edt_route" name="<?php echo $rows['route_id']; ?>">
                <span class="glyphicon glyphicon-edit"></span></button>
            </div></td>
            <td><div align="center">
              <button type="button" class="btn btn-danger" id="del_route" name="<?php echo $rows['route_id']; ?>">
                <span class="glyphicon glyphicon-trash"></span></button>
            </div></td>
          </tr>
     <?php } } ?>
  </tbody>
</table>
</div>
<!-- Modal -->
 <div class="modal fade" id="md_del_route" role="dialog">
   <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="modal-title" style="font-size: 18px;"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</p>
      </div>
     <div class="modal-body">
        <div align="center">
       <p style="font-size: 14px;">ต้องการลบข้อมูลนี้หรือไม่? &nbsp; <input type="hidden" id="txt_route_id" readonly></p>
       </div>

     </div>

     <div class="modal-footer">

       <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

       <button type="button" class="btn btn-danger" id="deled_route">ตกลง</button>

     </div>

  </div>
   </div>
 </div>
 <!-- End Modal -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#add_route').on('click', function(){
      $('#display_table').load("route_insert_form.php");
    });

    $('*[id^=edt_route]').on('click', function(){
      var route_id = $(this).attr("name");
      $('#display_table').load("route_edit_form.php", {route_id : route_id});
    });

    $('*[id^=del_route]').on('click', function(){
      var route_id = $(this).attr("name");
      $('#md_del_route').modal('show');
      $('#md_del_route').find('#txt_route_id').val(route_id);
    });

    $('#deled_route').on('click', function(){
      $.post("sql_route.php", {
        cmd : 'delete',
        route_id : $('#txt_route_id').val()
      }, function(data){
        if (data == '1') {
          alert_success('ลบข้อมูลสำเร็จ');
          $("#md_del_route").modal('toggle');
          setTimeout(function(){ $("#display_table").load("routes.php"); }, 2000);
      } else {
          alert_danger('ไม่สามารถลบข้อมูลได้');
      }
      });
    });

    $('#tbl_route').dataTable({
      "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
      "order": [],
      "columnDefs": [ {
      "targets"  : 'no-sort',
      "orderable": false,
      }]
    });
  });
</script>
