<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/BackEnd/css/bootstrap.min.css')}}" >
<link rel="shortcut icon" href="{{asset('public/FrontEnd/Images/logo/logo_transparent.png')}}">
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/BackEnd/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/BackEnd/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/BackEnd/css/font.css')}}" type="text/css"/>
<link href="{{asset('public/BackEnd/css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{asset('public/BackEnd/js/jquery2.0.3.min.js')}}"></script>
</head>
<body>
<div class="log-w3">
<div class="w3layouts-main">
	<h2>Admin Đăng nhập</h2>
	<p id="text" style="display:none; font-weight: 500; color:red;">WARNING! Caps lock is ON.</p>
        <?php
            $message = Session::get('message');
             if($message){
                echo "<div class='text-center'>";
                    echo "<strong style='color:red;'>" ;
                        echo $message;
                       	Session::put('message', null);
                    echo "</strong>";
                echo "</div>";
            }
        ?>
        <?php
             if($errors->has('g-recaptcha-response')){
                echo "<div class='text-center'>";
                    echo "<strong style='color:red;'>" ;
                        echo $errors->first('g-recaptcha-response');
                    echo "</strong>";
                echo "</div>";
            }
        ?>
		<form action="{{URL::TO('/login-admin')}}" method="post">
			{{csrf_field()}}
      
			<input type="email" class="ggg" id="myInput" name="adminEmail" placeholder="E-MAIL" required="">
			<input type="password" class="ggg" id="myInput1" name="adminPassword" placeholder="PASSWORD" required="">
			<span><input type="checkbox" />Ghi nhớ</span>
			<h6><a href="#">Quên mật khẩu?</a></h6>
      <div class="g-recaptcha" required="" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
				<div class="clearfix"></div>
				<input type="submit" value="Đăng nhập" name="login">
		</form>
</div>
</div>

<script>
    var input = document.getElementById("myInput");
    var input1 = document.getElementById("myInput1");
    var text = document.getElementById("text");
    input.addEventListener("keyup", function(event) {

    if (event.getModifierState("CapsLock")) {
        text.style.display = "block";
      } else {
        text.style.display = "none"
      }
    });
    input1.addEventListener("keyup", function(event) {

    if (event.getModifierState("CapsLock")) {
        text.style.display = "block";
      } else {
        text.style.display = "none"
      }
    });
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{asset('public/BackEnd/js/bootstrap.js')}}"></script>
<script src="{{asset('public/BackEnd/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/BackEnd/js/scripts.js')}}"></script>
<script src="{{asset('public/BackEnd/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/BackEnd/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/BackEnd/js/jquery.scrollTo.js')}}"></script>
</body>
</html>
