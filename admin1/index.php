<?php

  session_start();

  include("style_modal.php");

  if($_SESSION['name'] == ''){ ?>

    <meta http-equiv="refresh" content="0;url=login_van.php">

  <?php }

?>

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="">

    <meta name="author" content="Dashboard">

    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">



    <title>Van Service</title>



    <!-- Bootstrap core CSS -->

    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!--i-con-->

	<link rel=icon href="images/ic_van.png">

    <!--external css-->

    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">

    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />

    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    

    

    <!-- Custom styles for this template -->

    <link href="assets/css/style.css" rel="stylesheet">

    <link href="assets/css/style-responsive.css" rel="stylesheet">



    <script src="assets/js/chart-master/Chart.js"></script>

    

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->

 <style>
    .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: red;
    color: white;
    text-align: center;
}
 </style>
  </head>



  <body>



  <section id="container" >

      <!-- **********************************************************************************************************************************************************

      TOP BAR CONTENT & NOTIFICATIONS

      *********************************************************************************************************************************************************** -->

      <!--header start-->

      <header class="header black-bg">

              <div class="sidebar-toggle-box">

                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>

              </div>

            <!--logo start-->

            <a href="index.html" class="logo"><b>บริษัทหนุมานทัวร์สยามจำกัด</b></a>

            <!--logo end-->

            <div class="top-menu">

            	<ul class="nav pull-right top-menu">

                    <!--<li><button class="btn btn-danger logout" id="logout"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</button></li>-->

            	</ul>

            </div>

        </header>

      <!--header end-->

      

      <!-- **********************************************************************************************************************************************************

      MAIN SIDEBAR MENU

      *********************************************************************************************************************************************************** -->

      <!--sidebar start-->

      <aside>

          <div id="sidebar"  class="nav-collapse ">

              <!-- sidebar menu start-->

              <ul class="sidebar-menu" id="nav-accordion">

              

              	  <p class="centered"><a href="profile.html"><img src="assets/img/ic_van.png" class="img-circle" width="60"></a></p>

              	  <h5 class="centered">ชื่อ-สกุล : <?php echo ' '.$_SESSION['name']; ?></h5>

                      

                  <li class="sub-menu">

                      <a class="active" href="#" id="van" data-toggle="tooltip" title="รถตู้"

                            data-placement="top">

                          <i class="fa fa-dashboard"></i>

                          <span>รถตู้</span>

                      </a>

                  </li>

                   <li class="sub-menu">

<a href="#" id="driver" data-toggle="tooltip" title="รถตู้"

      data-placement="top">

    <i class="glyphicon glyphicon-user"></i>

    <span>คนขับรถตู้</span>

</a>

</li>



                  <li class="sub-menu">

                      <a href="#" id="route" data-toggle="tooltip" data-placement="top"

                            title="เส้นทางรถ">

                          <i class="glyphicon glyphicon-road"></i>

                          <span>เส้นทางรถ</span>

                      </a>

                  </li>



                  <li class="sub-menu">

                      <a href="#"  id="round" data-toggle="tooltip" data-placement="top"

                        title="เที่ยวรถ">

                          <i class="glyphicon glyphicon-calendar"></i>

                          <span>เที่ยวรถ</span>

                      </a>

                  </li>

                  <li class="sub-menu">

                      <a href="#" id="reserv" data-toggle="tooltip" data-placement="top"

                        title="จอง">

                          <i class="fa fa-th"></i>

                          <span>จอง</span>

                      </a>

                  </li>

                   <li class="sub-menu">

<a href="#" id="report">

    <i class="glyphicon glyphicon-list-alt"></i>

    <span>รายงาน</span>

</a>

</li>

                  <li class="sub-menu">

                    <a href="#" id="users" data-toggle="tooltip" data-placement="top"

                      title="ผู้ใช้งาน">

                        <i class="glyphicon glyphicon-user"></i>

                        <span>ผู้ใช้งาน</span>

                    </a>

                  </li>

                  <li class="sub-menu">

                      <a href="#" id="logout1" data-toggle="tooltip" data-placement="top"

                        title="ออกจากระบบ">

                          <i class="glyphicon glyphicon-log-out"></i>

                          <span>ออกจากระบบ</span>

                      </a>

                  </li>

              </ul>

              <!-- sidebar menu end-->

          </div>

      </aside>

      <!--sidebar end-->

      

      <!-- **********************************************************************************************************************************************************

      MAIN CONTENT

      *********************************************************************************************************************************************************** -->

      <!--main content start-->

      <section id="main-content">

          <section class="wrapper">



              <div class="row">

              <div class="col-lg-12 ds">

              <div id="display_table"></div>

            </div>

              

                

      <!-- **********************************************************************************************************************************************************

      RIGHT SIDEBAR CONTENT

      *********************************************************************************************************************************************************** -->                  

                  
          </section>

      </section>



      <!--main content end-->

      <!--footer start-->

      <footer class="container-fluid text-center footer"

style="background-color: #333232;color: #F5F7FA;padding: 10px;width: 100%;">

<a class="dropdown-toggle"

href="http://intranet.specialty.co.th:8000/intrastc/" style="text-decoration: none; color:#F5F7FA;" target="_blank">หนุมานทัวร์สยาม จำกัด.</a><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> : 034-588-111

<a href="line-notify.html" style="color: white; text-decoration: none;">| Contact Me</a><br>

Computer Science &copy; 2018.<b id="akru-footer"></b> Powered by Sathit Sivilaiz. <a class="dropdown-toggle"

href="http://www.kru.ac.th/"

style="text-decoration: none; color:#F5F7FA;" target="_blank">Kanchanaburi Rajabhat University.</a> All rights reserved.

</footer>

      <!-- Modal Logout -->

  <div id="modal_logout" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- Modal Content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน!</h4>

        </div>

        <div class="modal-body">

          <p align="center" style="font-size: 14px;">ต้องการออกจากระบบหรือไม่?</p>

        </div>

        <div class="modal-footer">

          <button id="md_cancel" type="submit" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>

          <button id="md_ok" type="submit" class="btn btn-danger">ตกลง</button>

        </div>

      </div>

    </div>

  </div>

<!-- End Modal -->



<!-- Modal Logout -->

<div id="modal_logout" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <!-- Modal Content-->

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> แจ้งเตือน</h4>

        </div>

        <div class="modal-body">

          <p align="center" style="font-size: 16px;">ต้องการออกจากระบบหรือไม่?</p>

        </div>

        <div class="modal-footer">

          <button id="md_cancel" type="submit" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>

          <button id="md_ok" type="submit" class="btn btn-success">ตกลง</button>

        </div>

      </div>

    </div>

  </div>

<!-- End Modal -->

      <!--footer end-->

  </section>



    <!-- js placed at the end of the document so the pages load faster -->

    <script src="assets/js/jquery.js"></script>

    <script src="assets/js/jquery-1.8.3.min.js"></script>

    <script src="assets/js/bootstrap.min.js"></script>

    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>

    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="assets/js/jquery.sparkline.js"></script>





    <!--common script for all pages-->

    <script src="assets/js/common-scripts.js"></script>

    

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>

    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>



    <!--script for this page-->

    <script src="assets/js/sparkline-chart.js"></script>    

	<script src="assets/js/zabuto_calendar.js"></script>	

	

	<script type="text/javascript">

        $(document).ready(function () {

        

        return false;

        });

	</script>

	

	<script type="application/javascript">

        $(document).ready(function () {

            $('#display_table').load('vans.php');

            $("#date-popover").popover({html: true, trigger: "manual"});

            $("#date-popover").hide();

            $("#date-popover").click(function (e) {

                $(this).hide();

            });

        

            $("#my-calendar").zabuto_calendar({

                action: function () {

                    return myDateFunction(this.id, false);

                },

                action_nav: function () {

                    return myNavFunction(this.id);

                },

                ajax: {

                    url: "show_data.php?action=1",

                    modal: true

                },

                legend: [

                    {type: "text", label: "กิจกรรมพิเศษ", badge: "00"},

                    {type: "block", label: "กิจกรรมประจำ", }

                ]

            });



            $("#logout").on('click', function(){

      /*var logout = confirm('คุณต้องการออกจากระบบหรือไม่?');

      if(logout == true){

        window.location = "logout.php";

      }*/



      $("#modal_logout").modal('show');

    });



    $("#logout1").on('click', function(){

      $("#modal_logout").modal('show')

    })





    $("#md_ok").on('click', function() {

      window.location = "logout.php"

    })



    $('[data-toggle="tooltip"]').tooltip()



    $("#home").on('click', function(){

      $("#display_table").load("home.php")

    })

    $("#driver").on('click', function(){

$("#display_table").load("drivers.php")

})

    $("#van").on('click' , function(){

      $("#display_table").load("vans.php")

    })



    $("#route").on('click', function(){

      $("#display_table").load("routes.php")

    })



    $("#round").on('click', function(){

      $("#display_table").load("rounds.php")

    });



    $('#users').on('click', function(){

      $('#display_table').load("users.php")

    });



    $('#promotion').on('click', function(){

      $('#display_table').load("promotion.php")

    });



    $('#reserv').on('click', function(){

      $('#display_table').load("reserv.php")

    });



    $('#report').on('click', function(){

      $('#display_table').load("report.php");

    });



    $("#md_ok").on('click', function() {

      window.location = "logout.php";

    });

});

        

        

        function myNavFunction(id) {

            $("#date-popover").hide();

            var nav = $("#" + id).data("navigation");

            var to = $("#" + id).data("to");

            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);

        }

    </script>

  



  </body>

</html>

