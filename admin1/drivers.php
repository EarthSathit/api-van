 <!-- Alertbox -->

 <script src="js/alertbox.js"></script>

<?php

  include("../include/db.php");

  include("../include/exec.php");

  include("plugin.php");



  $db = new Database();

  $str_conn = $db->getConnection();

  $str_exe = new ExecSQL($str_conn);

  $stmt = $str_exe->readAll("drivers d, initial i 
    where d.title = i.initial_id");

  $num_row = $str_exe->rowCount("vans");



  function substrIDCard($id_card){

    $id1 = substr($id_card, 0, 1);

    $id2 = substr($id_card, 1, 4);

    $id3 = substr($id_card, 5, 5);

    $id4 = substr($id_card, 10, 2);

    $id5 = substr($id_card, 12, 1);

    return $id1.'-'.$id2.'-'.$id3.'-'.$id4.'-'.$id5;

  }

  function diffDate($date) {
    $current_date = date("Y-m-d");
    $sub_date_current = substr($current_date, 0, 4);
    $sub_date_age = substr($date, 0, 4);
   
    return  $sub_date_current - $sub_date_age;
  }

?>

<div id="alertbox"></div>
<div align="right">
<button type="button" id="add_driver" class="btn btn-success" name="button">

<span class="glyphicon glyphicon-plus"></span> เพิ่มคนขับรถ</button>
</div> <br>

<div class="table-responsive">

<table id="tbl_van" class="table table-striped table-hover table-condensed">

  <caption><div align="center">

    <p style="font-size: 24px;"><span class="label label-primary">ข้อมูลคนขับรถตู้</span></p>
    </div></caption>

  <thead class="thead-dark">

    <th class="no-sort"><div align="center">ลำดับ</div></th>

    <th><div align="center">ชื่อ-สกุล</div></th>

    <!-- <th><div align="center">อายุ</div></th> -->
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

            <td><div align="left"><?php echo $rows['initial_name'].' '.$rows['fname'].' '.$rows['lname']; ?></div></td>

            <!-- <td><div align="center"><?php //echo diffDate($rows['age']); ?></div></td> -->


            <td><div align="center">

              <button type="button" class="btn btn-warning" id="edt_driver" name="<?php echo $rows['pid']; ?>">

              <span class="glyphicon glyphicon-edit"></span></button>

            </div></td>

            <td><div align="center">

              <button type="button" class="btn btn-danger" id="del_driver" name="<?php echo $rows['pid']; ?>">

                <span class="glyphicon glyphicon-trash"></span></button>

            </div></td>

          </tr>

     <?php } } ?>

  </tbody>

</table>

</div>

<!-- Modal -->

<div id="md_del_driver" class="modal fade" role="dialog">

  <div class="modal-dialog">

     <!-- Modal content-->

     <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="modal-title" style="font-size: 18px;"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</p>
      </div>
     <div class="modal-body">
        <div align="center">
       <p style="font-size: 14px;">ต้องการลบข้อมูลนี้หรือไม่? &nbsp; <input type="hidden" id="txt_pid" readonly></p>
       </div>

     </div>

     <div class="modal-footer">

       <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

       <button type="button" class="btn btn-danger" id="deled_driver">ตกลง</button>

     </div>

  </div>

 </div>

</div>

<!-- End Modal -->

<script type="text/javascript">

  $(document).ready(function(){

    $('#add_driver').on('click', function(){

      $('#display_table').load("driver_insert_form.php")

    })



    $('*[id^=edt_driver]').on('click', function(){

      var pid = $(this).attr('name')

      $('#display_table').load("driver_edit_form.php",{pid : pid})
    })



    $('*[id^=del_driver]').on('click', function(){

      var pid = $(this).attr('name')

      $('#md_del_driver').modal('show')

      $('#md_del_driver').find('#txt_pid').val(pid)

    })



    $('#deled_driver').on('click', function(){
      $.post("sql_driver.php",{
        cmd : 'delete',
        pid : $('#txt_pid').val()
      }, function(data){
        if (data == 1) {
          $("#md_del_driver").modal('hide')
          alert_success('ลบข้อมูลเรียบร้อย')
          setTimeout(function(){ $("#display_table").load("drivers.php"); }, 2000);
        } else {
          alert_danger('ไม่สามารถลบข้อมูลได้')
        }
      })
    })

    // $('[data-toggle="popover"]').popover()

    $('#tbl_van').DataTable({

      "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],

      "order": [],

      "columnDefs": [ {

      "targets"  : 'no-sort',

      "orderable": false,

      }]
    })
  })
</script>

