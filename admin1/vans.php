 <!-- Alertbox -->

 <script src="js/alertbox.js"></script>

<?php

  include("../include/db.php");

  include("../include/exec.php");

  include("plugin.php");



  $db = new Database();

  $str_conn = $db->getConnection();

  $str_exe = new ExecSQL($str_conn);

  $stmt = $str_exe->readAll("vans v, brands b, drivers d, initial i 
    where v.brand_id = b.brand_id and v.id_card = d.pid and d.title = i.initial_id");

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
<button type="button" id="add_van" class="btn btn-success" name="button">

<span class="glyphicon glyphicon-plus"></span> เพิ่มรถตู้</button>
</div> <br>

<div class="table-responsive">

<table id="tbl_van" class="table table-striped table-hover table-condensed">

  <caption><div align="center">

    <p style="font-size: 24px;"><span class="label label-primary">ข้อมูลรถตู้</span></p>
    </div></caption>

  <thead class="thead-dark">

    <th class="no-sort"><div align="center">ลำดับ</div></th>

    <th><div align="center">ทะเบียนรถ</div></th>

    <th><div align="center">ยี่ห้อ</div></th>

    <th class="no-sort"><div align="center">ที่นั่ง</div></th>

    <th class="no-sort"><div align="center">เลขประจำตัวประชาชน</div></th>

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

            <td><div align="center"><?php echo $rows['van_id']; ?></div></td>

            <td><div align="center"><?php echo $rows['name']; ?></div></td>

            <td><div align="center"><?php echo $rows['seat']; ?></div></td>

            <td><div align="center">
              <a href="#" data-toggle="popover" title="ข้อมูลคนขับรถตู้" data-html="true"
              data-content="ชื่อ-สกุล: <?php echo $rows['initial_name'].' '.$rows['fname'].' '.$rows['lname']; ?> 
             "><?php echo substrIDCard($rows['id_card']); ?></a>
              </div></td>

            <td><div align="center">

              <button type="button" class="btn btn-warning" id="edt_van" name="<?php echo $rows['van_id']; ?>">

              <span class="glyphicon glyphicon-edit"></span></button>

            </div></td>

            <td><div align="center">

              <button type="button" class="btn btn-danger" id="del_van" name="<?php echo $rows['van_id']; ?>">

                <span class="glyphicon glyphicon-trash"></span></button>

            </div></td>

          </tr>

     <?php } } ?>

  </tbody>

</table>

</div>

<!-- Modal -->

<div id="md_del_van" class="modal fade" role="dialog">

  <div class="modal-dialog">

     <!-- Modal content-->

     <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p class="modal-title" style="font-size: 18px;"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</p>
      </div>
     <div class="modal-body">
        <div align="center">
       <p style="font-size: 14px;">ต้องการลบข้อมูลนี้หรือไม่? &nbsp; <input type="hidden" id="txt_van_id" readonly></p>
       </div>

     </div>

     <div class="modal-footer">

       <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

       <button type="button" class="btn btn-danger" id="deled_van">ตกลง</button>

     </div>

  </div>

 </div>

</div>

<!-- End Modal -->

<script type="text/javascript">

  $(document).ready(function(){

    $('#add_van').on('click', function(){

      $('#display_table').load("van_insert_form.php")

    });



    $('*[id^=edt_van]').on('click', function(){

      var van_id = $(this).attr('name')

      $('#display_table').load("van_edit_form.php",{van_id : van_id})

    });



    $('*[id^=del_van]').on('click', function(){

      var van_id = $(this).attr('name')

      $('#md_del_van').modal('show')

      $('#md_del_van').find('#txt_van_id').val(van_id)

    })



    $('#deled_van').on('click', function(){

      $.post("sql_van.php",{

        cmd : 'delete',

        van_id : $('#txt_van_id').val()

      }, function(data){

        if (data == '1') {
          $("#md_del_van").modal('hide')
          alert_success('ลบข้อมูลเรียบร้อย')
          setTimeout(function(){ $("#display_table").load("vans.php"); }, 2000);
        } else {

          alert_danger('ไม่สามารถลบข้อมูลได้')

        }

      })

    })

    $('[data-toggle="popover"]').popover()



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

