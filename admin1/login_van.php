<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Van Service</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="GetTemplates.co" />

	<!--i-con-->
	<link rel=icon href="images/ic_van.png">

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Themify Icons-->
	<link rel="stylesheet" href="css/themify-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- Bootstrap DateTimePicker -->
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="js/alertbox.js"></script>

<style media="screen">
	.null{
		background-color: rgb(236, 107, 99);
	}
	.error {
		background-color: rgb(249, 187, 96);
	}
	.success{
		background-color: rgb(152, 250, 127);
	}
	.font-color{
		color: white;
	}
    .modal.modal-wide .modal-dialog {
  width: 70%;
}
.modal-wide .modal-body {
  overflow-y: auto;
}
.modal-header{
     background-color: #FFCC33;
 }
/* irrelevant styling */
body p { 
  max-width: 400px; 
  margin: 20px auto; 
}
#tallModal .modal-body p { margin-bottom: 900px }
</style>
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
	<div class="gtco-loader"></div>

	<div id="page">

	<!-- <div class="page-inner"> -->
	<nav class="gtco-nav" role="navigation">
		<div class="gtco-container">
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div id="gtco-logo" class="font-color">หนุมานทัวร์สยาม จำกัด <em>.</em></div>
				</div>
				<div class="col-xs-8 text-right menu-1">
					<div id="gtco-logo" class="font-color">มหาวิทยาลัยราชภัฏกาญจนบุรี <em>.</em></div>
				</div>
			</div>
		</div>
	</nav>

	<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/iStock_89196887_MEDIUM.jpg)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					<div class="row row-mt-15em">
						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">พัฒนาโดย นาย สาธิต ศิวิลัยซ์</span>
							<h1 class="cursive-font">Your life your travel</h1>
						</div>
						<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
							<div class="form-wrap">
								<div class="tab">
									<div class="tab-content">
										<div class="tab-content-inner active" data-content="signup">
										 <!--<h3 class="cursive-font">เข้าสู่ระบบ!</h3>-->
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start"><span class="glyphicon glyphicon-phone"></span> เบอร์โทรศัพท์</label>
														<input  id="phone" class="form-control"  maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                            type="number" required>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<label for="date-start"><span class="glyphicon glyphicon-lock"></span> &nbsp;รหัสผ่าน</label>
														<input type="password" id="password" class="form-control" required>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12">
														<button type="submit" class="btn btn-primary btn-block"
														id="btn_login"><span class="glyphicon glyphicon-log-in"></span> &nbsp;เข้าสู่ระบบ</button>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-md-12" align="center">
														<a href="#" id="regis">ลงทะเบียน</a>
													</div>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<footer id="gtco-footer" role="contentinfo" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row row-pb-md">
				<div class="col-md-12 text-center">
					<div class="gtco-widget">
						<h3>ติดติดเรา</h3>
						<ul class="gtco-quick-contact">
							<li><a href="#"><i class="icon-phone"></i> 034-588-111</a></li>
							<li><a href="#"><i class="icon-mail2"></i> hanuman@gmail.com</a></li>
							<li><a href="https://goo.gl/maps/eTNZKYQ34MS2" target="_blank">
								<i class="icon-address"></i> Address</a></li>
						</ul>
					</div>
					<div class="gtco-widget">
						<h3>เพิ่มเติม</h3>
						<ul class="gtco-social-icons">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="https://www.facebook.com/%E0%B8%9A%E0%B8%A3%E0%B8%B4%E0%B8%A9%E0%B8%B1%E0%B8%97-%E0%B8%AB%E0%B8%99%E0%B8%B8%E0%B8%A1%E0%B8%B2%E0%B8%99%E0%B8%97%E0%B8%B1%E0%B8%A7%E0%B8%A3%E0%B9%8C%E0%B8%AA%E0%B8%A2%E0%B8%B2%E0%B8%A1-%E0%B8%88%E0%B8%B3%E0%B8%81%E0%B8%B1%E0%B8%94-382949685196738/" target="_blank"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-linkedin"></i></a></li>
							<li><a href="#"><i class="icon-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-12 text-center copyright">
					<p><small class="block">&copy; 2018. All Rights Reserved.</small>
						<!--<small class="block">Designed by <a href="http://gettemplates.co/" target="_blank">GetTemplates.co</a> Demo Images: <a href="http://unsplash.com/" target="_blank">Unsplash</a></small>--> </p>
				</div>
			</div>
		</div>
	</footer>
	<!-- </div> -->
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>

	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- countTo -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>

	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	<!-- Modal Login-->
<div id="welcome_login" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p align="center"><img src="images/loader.gif" display="none" height="25" width="25" alt="Loading...">
					กำลังเข้าสู่ระบบ...</p>
					<!--<p>
						<div class="progress progress-striped active">
    					<div class="progress-bar"></div>
						</div> -->

						<!-- jQuery Script -->
						<script type="text/javascript">
							/*var i = 0;
							function makeProgress(){
								if(i < 100){
									i = i + 2;
									$(".progress-bar").css("width", i + "%").text(i + " %");
								}
							// Wait for sometime before running this script again
								setTimeout("makeProgress()", 100);
							}
							makeProgress();*/
						</script>
					<!--</p>-->
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Error-->
<div id="error_login" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content error">
		<div class="modal-body">
			<p class="font-color" align="center">ไม่สามารถเข้าสู่ระบบได้ กรุณาเข้าสู่ระบบอีกครั้ง!</p>
		</div>
	</div>
</div>
</div>
<!-- End Modal -->

<!-- Modal Null-->
<div id="null_login" class="modal fade" role="dialog">
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content null">
		<div class="modal-body">
			<p class="font-color" align="center">กรุณากรอกข้อมูลให้ครบ ก่อนเข้าสู่ระบบ!</p>
		</div>
	</div>
</div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div id="md_regis" class="modal modal-wide fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="blackground-color: yellow;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div align="left">
        <h4 class="modal-title">ลงทะเบียน</h4>
        </div>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
      <div id="alertbox"></div>
    <div class="row">
      <form class="form-horizontal">
      <div class="form-group">
          <label for="brand" class="col-sm-1 control-label" style="width: 150px;">เบอร์โทรศัพท์ :</label>
          <div class="col-sm-2">
            <input type="number" class="form-control" id="reg_phone" maxlength="10" placeholder="เบอร์โทรศัพท์"
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
            type="number" style="width: 190px;" required>
          </div>
        </div>
        <div class="form-group">
          <label for="van_id" class="col-sm-1 control-label" style="width: 150px;">คำนำหน้าชื่อ :</label>
            <div class="col-sm-2">
              <select class="form-control" id="initial" style="width: 150px;">
                <option value="" disabled selected>คำนำหน้าชื่อ</option>
                <?php
                  $stmt = $str_exe->readAll("initial");
                  $num_row = $str_exe->rowCount("initial");
                  if ($num_row != 0){
                      foreach($stmt as $rows){ ?>
                      <option value="<?php echo $rows['initial_id']?>"><?php echo $rows['initial_name']; ?></option>
                   <?php } } ?>
              </select>
            </div>
            <label for="id_card" class="col-sm-1 control-label" style="width: 80px;">ชื่อ :</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="username" style="width: 180px;"
            placeholder="ชื่อ" required>
          </div>
          <label for="id_card" class="col-sm-1 control-label" style="width: 150px;">นามสกุล :</label>
          <div class="col-sm-1">
            <input type="text" class="form-control" id="lastname" style="width: 190px;"
            placeholder="นามสกุล" required>
          </div>
        </div>
        <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label" style="width: 150px;">อีเมล์ :</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="email" style="width: 300px;"
            placeholder="Example@gmail.com" required>
          </div>
        </div>
        <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label" style="width: 150px;">รหัสผ่าน :</label>
          <div class="col-sm-2">
            <input type="password" class="form-control" id="reg_password" style="width: 140px;"
            placeholder="รหัสผ่าน" required>
          </div>
          <div class="col-sm-2">
              <button type="button" class="btn btn-danger" id="show_password"
              ><span class="glyphicon glyphicon-eye-open"></span></button>
              <button type="button" class="btn btn-danger" id="none_password" style="display: none;"
              ><span class="glyphicon glyphicon-eye-close"></span></button>
            </div>
        </div>
        <div class="form-group">
          <label for="id_card" class="col-sm-1 control-label" style="width: 150px;">ยืนยันรหัสผ่าน :</label>
          <div class="col-sm-2">
            <input type="password" class="form-control" id="re_password" style="width: 140px;"
            placeholder="รหัสผ่าน" required>
          </div>
        </div>
  </div>
  </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">
          <span class="glyphicon glyphicon-arrow-left"></span> กลับ</button>
        <button type="submit" class="btn btn-success" id="save_user">
          <span class="glyphicon glyphicon-save"></span> บันทึก</button>
          </form>
    </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <!-- End Modal -->
	</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
		$("#btn_login").on('click', function(){
			login();
		});

		$("#phone, #password").keypress(function(e){
			 if(e.keyCode == 13){
				 login();
		 		}
		 });

		 $('#regis').on('click', () => {
			 $('#md_regis').modal('show')
		 })

          $('#save_user').on('click', function(){
      let phone = $('#reg_phone').val()
      let initial = $('#initial').val()
      let username = $('#username').val()
      let lastname = $('#lastname').val()
      let email = $('#email').val()
      let pass1 = $('#reg_password').val()
      let pass2 = $('#re_password').val()
      
      let check = true;

       //console.log(phone + initial + username  + lastname + email + pass1)

      // if(!$.isNumeric(id_card)){
      //   alert_danger('กรุณากรอกเลขบัตรประจำตัวประชาชนให้ถูกต้อง')
      //   $('#id_card').val('')
      //   $('#id_card').focus()
      //   check = false;
      // }

      if(phone != '' && initial != '' && username != '' && lastname != '' &&
         email != '' && pass1 != ''){
             
      if(phone.length != 10){
          alert_warning('กรุณากรอกเบอร์โทรศัพท์ให้ครบ')
          $('#reg_phone').focus()
          exit()
      }

      if(pass1 != pass2){
        alert_warning('รหัสผ่านไม่ตรงกัน')
        $('#password').val('')
        $('#re_password').val('')
        $('#password').focus()
        $('#re_password').focus()
        check = false;
      }
        
           if(check){
             $.post("sql_user.php", {
               cmd : 'insert',
               phone : phone,
               initial_id : initial,
               name : username,
               lastname : lastname,
               email : email,
               password : pass1
             }, function(data){
                if(data == '1'){
                  alert_success('บันทึกเรียบร้อย')
                  setTimeout(function(){ $('#md_regis').modal('hide') }, 2000)
                } else {
                  alert_danger('บันทึกล้มเหลว')
                }
             });
           }
         } else {
           alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก')
         }
      /*var route = $('#route_r').val();
      var time_start = $('#time_start').val();
      var time_finish = $('#time_finish').val();
      var time_sum = time_start + " - " + time_finish;
      var van_id = $('#van_id_r').val();
      if(route != null && time_sum != null && van_id != null){
        $.post("sql_round.php", {
          cmd : 'insert',
          route_id : route,
          time : time_sum,
          van_id : van_id
        }, function(data){
          if (data == '1') {
            alert_success('บันทึกสำเร็จ');
            $('#route_r').val(null);
            $('#time_start').val(null);
            $('#time_finish').val(null);
            $('#van_id_r').val(null);
          }else {
            alert_danger('ไม่สามารถบันทึกข้อมูลได้');
          }
        });
      }else {
        alert_warning('กรุณากรอกข้อมูลก่อนกดบันทึก');
      }*/
  })

		function login(){
			var phone = $('#phone').val();
			var password = $('#password').val();
			if(phone != '' && password != ''){
				$.post('login_admin.php',{
					phone : phone,
					password : password
				}, function(data) {
						if (data == '1') {
							$("#welcome_login").modal('show');
							setTimeout(function(){ window.location = 'index.php'; }, 1500);
						}else {
							console.log(data)
							$("#error_login").modal('show');
							//setTimeout(function(){ location.reload(); }, 2000);
						}
				});
			} else {
				$("#null_login").modal('show');
			}
		}

    $('#show_password').on('click', function(){
    $('#reg_password').prop('type', 'text')
    $(this).css('display', 'none')
    $('#none_password').css('display', '')
  })

  $('#none_password').on('click', function(){
    $('#reg_password').prop('type', 'password')
    $(this).css('display', 'none')
    $('#show_password').css('display', '')
  })
	});
</script>
