<style>
/* The Modal (background) */
.modal_img {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal_content {
    margin: auto;
    display: block;
    width: 80%;
    height: 80%;
    max-width: 500px;
    max-height: 500px;
}
/* Add Animation */
.modal_content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<!-- Alertbox -->

<script src="js/alertbox.js"></script>

<?php

  include("../include/db.php");

  include("../include/exec.php");

  include("plugin.php");



  function currentDate(){ return date("Y-m-d"); }



  $db = new Database();

  $str_conn = $db->getConnection();

  $str_exe = new ExecSQL($str_conn);

  $date_current = date("Y-m-d");

  $stmt = $str_exe->readAll("reservations re, rounds r, routes ro, users u, payment_method p, initial i where re.round_id = r.round_id
                            and r.route_id = ro.route_id and re.phone = u.phone and re.payment_method = p.pm_id
                            and u.initial_id = i.initial_id");  
$num_row = $str_exe->rowCount("reservations");



  function substrIDCard($id_card){

    $id1 = substr($id_card, 0, 1);

    $id2 = substr($id_card, 1, 4);

    $id3 = substr($id_card, 5, 5);

    $id4 = substr($id_card, 10, 2);

    $id5 = substr($id_card, 12, 1);

    return $id1.'-'.$id2.'-'.$id3.'-'.$id4.'-'.$id5;

  }

?>

<div id="alertbox"></div>

<div class="containner-fluid">

  <div class="row">

    <div class="col-sm-4">

      <img src="images/correct.png" alt="" width="30" height="30">

      <label for="">ชำระเงินแล้ว = </label>

      <?php

        $sql_unpaid = "SELECT COUNT(re_id) as unpaid FROM reservations re WHERE re.payment_status = '2'

                        and re.travel_date = '$date_current'";

        $result = $str_conn->query($sql_unpaid);

           foreach ($result as $r) {

              $unpaid = $r['unpaid'];

           } ?>

        <label for=""><?php echo $unpaid; ?></label>

        <label for="">คน</label>

    </div>

    <div class="col-md-4">

        <img src="images/remove.png" alt="" width="30" height="30">

      <label for="">ยังไม่ได้ชำระเงิน = </label>

       <?php

       $sql_paid = "SELECT COUNT(re_id) as paid FROM reservations re WHERE re.payment_status = '1'

                    and re.travel_date = '$date_current'";

       $result = $str_conn->query($sql_paid);

          foreach ($result as $r) {

             $paid = $r['paid'];

          } ?>

        <label for=""><?php echo $paid; ?></label>

        <label for="">คน</label>

    </div>

    <div class="col-md-4">

        <img src="images/cus.png" alt="" width="30" height="30">

      <label for="">ทั้งหมด = </label>

       <?php

       $sql_all = "SELECT COUNT(re_id) as all_cus FROM reservations re WHERE

                   re.travel_date = '$date_current'";

       $result = $str_conn->query($sql_all);

          foreach ($result as $r) {

             $all = $r['all_cus'];

          } ?>

        <label for=""><?php echo $all; ?></label>

        <label for="">คน</label>

    </div>

  </div>

  <div class="row">

    <div class="col-md-12">

      &nbsp;

    </div>

  </div>

</div>

<div class="table-responsive">

<table id="tbl_van" class="table table-striped table-hover table-condensed">

  <caption><div align="center">
<p style="font-size: 24px;"><span class="label label-primary">ข้อมูลการจอง</span></p></div></caption>

    <thead class="thead-dark">
    <th class="no-sort"><div align="center">เลือก</div></th>

    <th class="no-sort"><div align="center">ลำดับ</div></th>

    <th><div align="center">เที่ยวรถ</div></th>

    <th class="no-sort"><div align="center">ลูกค้า</div></th>

    <th class="no-sort"><div align="center">วันที่จอง</div></th>

    <th class="no-sort"><div align="center">สถานะการชำระเงิน</div></th>

    <th class="no-sort"><div align="center">วิธีการชำระเงิน</div></th>

    <th class="no-sort"><div align="center">ราคา</div></th>

    <th class="no-sort"><div align="center">รูป</div></th>
  

  </thead>

  <tbody id="myTable">

    <?php

    if ($num_row != 0) {

      $i = 0;

        foreach($stmt as $rows) { $i++;?>

          <tr id="<?php echo $rows['re_id']; ?>">


            <td><div align="center"><input type="checkbox" class="form-control" id="chk_paid" name="<?php echo $rows['re_id']; ?>"
	 <?php if($rows['payment_status'] == '2'){ echo "disabled"; } ?>></div></td>

            <td><div align="center"><?php echo $i ; ?></div></td>

            <td><div align="left"><?php echo $rows['route']; ?></div></td>

            <td><div align="left"><?php echo $rows['init_name']." ".$rows['name']." ".$rows['lastname']; ?></div></td>

            <td><div align="center"><?php echo $rows['reserv_date']; ?></div></td>

            <?php

              if($rows['payment_status'] == '1'){

                $status = "ยังไม่ได้ชำระเงิน";

                $color = "red";

              } else {

                $status = "ชำระเงินแล้ว";

                $color = "green";

              } ?>

            <td>
            <a href="#" id="onway" name="<?php echo $rows['re_id']; ?>"><span class="glyphicon glyphicon-info-sign"></span></a>
            <div align="center" style="color: <?php echo $color;?>">
            <?php echo $status; ?></div></td>

            <td><div align="center"><?php echo $rows['pm_name']; ?></div></td>
            <td><div align="center"><?php echo $rows['reserv_price'].'.-'; ?></div></td>

              <?php if($rows['payment_method'] == '2') {

                $disabled = "disabled";

              } else {

                $disabled = "";

              } ?>
             
              <td><div align="center">
                 <button class="btn btn-default <?php if($rows['payment_method'] == '1') echo "disabled"; ?>" 
                 name="<?php echo $rows['img_payment']; ?>" id="look_img">
                <span class="glyphicon glyphicon-edit"></span> </button></td>
                
          </tr>

     <?php } } ?>

  </tbody>

</table>
<div align="center">
  <button class="btn btn-success" id="btn_save_peyment"><span class="glyphicon glyphicon-save"></span> บันทึก</button>
</div>

</div>
<!-- Modal -->
<div class="modal fade" id="md_onway" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <p class="modal-title" style="font-size: 16px;">
          <span class="glyphicon glyphicon-info-sign">
          แจ้งเตือน</p>
        </div>
        <div class="modal-body">
          <p>กรณีที่ลูกค้าขึ้น ณ จุดที่ให้บริการที่อยู่ระหว่างทาง โปรดระบุราคาใหม่ตามจุดที่ให้บริการนั้น</p>
          <input type="number" class="form-control" id="price_half">
          <input type="hidden" class="form-control" id="rid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
          <button type="button" class="btn btn-success" id="save_half">ตกลง</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- The Modal -->
<div id="showIMG" class="modal_img">
  <span class="close">&times;</span>
  <img class="modal_content" id="img">
  <div id="caption"></div>
<br><br>
    <div align="center">
      <button type="button" class="btn btn-danger" id="close_modal">&times;</button>
    </div>
</div>

<!-- Modal -->

<div id="md_del_van" class="modal fade" role="dialog">

  <div class="modal-dialog">

     <!-- Modal content-->

     <div class="modal-content">

     <div class="modal-body">

       <h4>ต้องการลบข้อมูลนี้หรือไม่? &nbsp; <input type="hidden" id="txt_van_id" readonly></h4>

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
 let arrReID = [];
let parent;
 let re_id; 

    $('#add_van').on('click', function(){

      $('#display_table').load("van_insert_form.php");

    });

    $('*[id^=onway]').on('click', function(){
      let re_id = $(this).attr('name')
      // console.log(re_id)
      $('#md_onway').modal('show')
      $('#md_onway').find('#rid').val(re_id);
    })

    $('#save_half').on('click', function() {
       let price_half = $('#price_half').val()
       let re_id = $('#rid').val()

       $.post("sql_reserv.php",{
        cmd : 'update_half',
        price_half : price_half,
        re_id : re_id
        }, function(data){
        if (data == 1) {
          alert_success('แก้ไขข้อมูลสำเร็จ');
          $("#md_onway").modal('hide');
          setTimeout(function(){ $("#display_table").load("reserv.php"); }, 2000);
        } else {
          alert_danger('ไม่สามารถแก้ไขข้อมูลได้');
        }
        })
    })

    $('*[id^=edt_van]').on('click', function(){

      var van_id = $(this).attr('name');

      $('#display_table').load("van_edit_form.php",{van_id : van_id});

    });



    $('*[id^=del_van]').on('click', function(){

      var van_id = $(this).attr('name');

      $('#md_del_van').modal('show');

      $('#md_del_van').find('#txt_van_id').val(van_id);

    });

$('*[id^=look_img]').on('click', function() {
      let img_path = $(this).attr('name');
console.log(img_path);
      $('#showIMG').css('display', 'block');
       $('#img').attr("src", img_path);
    });

 $('#close_modal').on('click', function() {
      $('#showIMG').css('display', 'none');
    });
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}

    $('#deled_van').on('click', function(){

      $.post("sql_van.php",{

        cmd : 'delete',

        van_id : $('#txt_van_id').val()

      }, function(data){

        if (data == '1') {

          alert_success('ลบข้อมูลสำเร็จ');

          $("#md_del_van").modal('toggle');

          setTimeout(function(){ $("#display_table").load("van.php"); }, 2000);

        } else {

          alert_danger('ไม่สามารถลบข้อมูลได้');

        }

      });

    });



    $('*[id^=chk_paid]').on('change', function(){
        if (this.checked) {
          re_id = $(this).attr('name');
              arrReID.push(re_id)
              // console.log(arrReID);
        } else {
            re_id = $(this).attr("name");
            arrReID.splice($.inArray(re_id, arrReID), 1);
  // console.log(arrReID);

                 }
    });

$('#btn_save_peyment').on('click', function() {
      $.post("sql_reserv.php", {
        cmd : 'update_payment',
        re_id : arrReID
      }, function(data) {
 // console.log(data);
        if(data == 1) {
         alert_success('บันทึกสำเร็จ');
          $('#display_table').load("reserv.php");
        } else {
          alert_danger('กรุณาเลือกข้อมูลก่อนกดบันทึก');
        }
      });
    });

    $('#tbl_van').DataTable({
"bPaginate": false,
      "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],

      "order": [],

      "columnDefs": [ {

      "targets"  : 'no-sort',

      "orderable": false,

      }]

    });

  });

</script>

