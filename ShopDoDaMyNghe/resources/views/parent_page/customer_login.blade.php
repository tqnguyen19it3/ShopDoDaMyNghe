<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="{{asset('public/BackEnd/css/bootstrap2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/BackEnd/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/BackEnd/css/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/BackEnd/css/iofrm-theme4.css')}}">
</head>
<body>
    <div class="form-body">
        
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="{{asset('public/BackEnd/images/graphic1.svg')}}" alt="img desc">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Chào mừng khách hàng!</h3>
                        <p>Hoàn thành nhiều việc hơn với nền tảng đăng nhập.</p>
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
                        ?><br>
                        <div class="page-links">
                            <a href="{{URL::TO('/khach-hang-dang-nhap')}}" class="active">Đăng nhập</a><a href="{{URL::TO('/khach-hang-dang-ky')}}">Đăng ký</a>
                        </div>
                        <form action="{{URL::TO('/login-customer')}}" method="post">
                            {{ csrf_field() }}
                            <input class="form-control" id="myInput" type="text" name="cusEmail" placeholder="E-mail Address" required>
                            <input class="form-control" id="myInput1" type="password" name="cusPassword" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Đăng nhập</button> <a href="#">Quên mật khẩu?</a>
                            </div>
                        </form>
                        <div class="other-links">
                            <span>Đăng nhập với</span><a href="{{URL::TO('/login-facebook')}}">Facebook</a><a href="{{URL::TO('/login-google')}}">Google</a>
                        </div>
                    </div>
                </div>
            </div>
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
</body>
</html>