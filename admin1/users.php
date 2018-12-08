<!-- Alertbox -->
<script src="js/alertbox.js"></script>
<?php
  include("../include/db.php");
  include("../include/exec.php");
  include("plugin.php");

  $db = new Database();
  $str_conn = $db->getConnection();
  $str_exe = new ExecSQL($str_conn);
  $stmt = $str_exe->readAll("users u, initial i where u.initial_id = i.initial_id");
  $num_row = $str_exe->rowCount("users");

  function substrIDCard($id_card){
    $id1 = substr($id_card, 0, 1);
    $id2 = substr($id_card, 1, 4);
    $id3 = substr($id_card, 5, 5);
    $id4 = substr($id_card, 10, 2);
    $id5 = substr($id_card, 12, 1);
    return $id1.'-'.$id2.'-'.$id3.'-'.$id4.'-'.$id5;
  }

  function subTel($phone){
    $p1 = substr($phone, 0, 3);
    $p2 = substr($phone, 3, 9);
    return $p1.'-'.$p2;
  }
  
  function hidePassword($pass){
    $length = strlen($pass);
    $arr_length = array();
    for($i=1; $i<=$length; $i++){
      array_push($arr_length, '*');
    }

    return implode(" ",$arr_length);;
  }
?>
<div id="alertbox"></div>
<div align="right">
<button type="button" id="add_user" class="btn btn-success" name="button">
<span class="glyphicon glyphicon-plus"></span> เพิ่มผู้ใช้งาน</button>
</div> <br>
<div class="table-responsive">
<table id="tbl_van" class="table table-striped table-hover table-condensed">
  <caption><div align="center">
<p style="font-size: 24px;"><span class="label label-primary">ข้อมูลผู้ใช้งาน</span></p></div></caption>
  <thead class="thead-dark">
    <th class="no-sort"><div align="center">ลำดับ</div></th>
    <th><div align="center">ชื่อ-นามสกุล</div></th>
    <th><div align="center">อีเมล์</div></th>
    <th class="no-sort"><div align="center">โทรศัพท์</div></th>
    <th class="no-sort"><div align="center">รหัสผ่าน</div></th>
    <th class="no-sort"><div align="center">แก้ไข</div></th>
    <th class="no-sort"><div align="center">ลบ</div></th>
  </thead>
  <tbody id="myTable">
    <?php
    if ($num_row != 0) {
      $i = 0;
        foreach($stmt as $rows) { $i++;?>
          <tr>
            <td><div align="center"><?php echo $i; ?></div></td>
            <td><div align="left"><?php echo $rows['initial_name']." ".$rows['name']." ".$rows['lastname']; ?></div></td>
            <td><div align="left"><?php echo $rows['email']; ?></div></td>
            <td><div align="center"><?php echo subTel($rows['phone']); ?></div></td>
            <td><div align="center"><?php echo hidePassword($rows['password']); ?></div></td>
            <td><div align="center">
              <button type="button" class="btn btn-warning" id="edt_user" name="<?php echo $rows['phone']; ?>">
              <span class="glyphicon glyphicon-edit"></span></button>
            </div></td>
            <td><div align="center">
              <button type="button" class="btn btn-danger" id="del_user" name="<?php echo $rows['phone']; ?>">
                <span class="glyphicon glyphicon-trash"></span></button>
            </div></td>
          </tr>
     <?php } } ?>
  </tbody>
</table>
</div>
<!-- Modal -->
<div id="md_del_user" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="modal-title" style="font-size: 18px;"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</p>
      </div>
     <div class="modal-body">
        <div align="center">
       <p style="font-size: 14px;">ต้องการลบข้อมูลนี้หรือไม่? &nbsp; <input type="hidden" id="txt_phone" readonly></p>
       </div>

     </div>

     <div class="modal-footer">

       <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

       <button type="button" class="btn btn-danger" id="deled_user">ตกลง</button>

     </div>

  </div>
 </div>
</div>
<!-- End Modal -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#add_user').on('click', function(){
      $('#display_table').load("user_insert_form.php");
    });

    $('*[id^=edt_user]').on('click', function(){
      let phone = $(this).attr('name');
      $('#display_table').load("user_edit_form.php",{phone : phone});
    });

    $('*[id^=del_user]').on('click', function(){
      let phone = $(this).attr('name');
      $('#md_del_user').modal('show');
      $('#md_del_user').find('#txt_phone').val(phone)
    });

    $('#deled_user').on('click', function(){
      $.post("sql_user.php",{
        cmd : 'delete',
        phone : $('#txt_phone').val()
      }, function(data){
        if (data == '1') {
          $("#md_del_user").modal('hide')
          alert_success('ลบข้อมูลเรียบร้อย')
          setTimeout(function(){ $("#display_table").load("users.php"); }, 2000)
        } else {
          alert_danger('ลบข้อมูลล้มเหลว')
        }
      });
    });

    $('#tbl_van').DataTable({
      "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
      "order": [],
      "columnDefs": [ {
      "targets"  : 'no-sort',
      "orderable": false,
      }]
    });
  });
</script>
