<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>Đăng ký</title>
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
                    <img src="{{asset('public/BackEnd/images/graphic1.svg')}}" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Chào mừng khách hàng!</h3>
                        <p>Hoàn thành nhiều việc hơn với nền tảng đăng ký.</p>
                        <p id="text" style="display:none; font-weight: 500; color:red;">WARNING! Caps lock is ON.</p>
                        <div class="page-links">
                            <a href="{{URL::TO('/khach-hang-dang-nhap')}}">Đăng nhập</a><a href="{{URL::TO('/khach-hang-dang-ky')}}" class="active">Đăng ký</a>
                        </div>
                        <form action="{{URL::TO('/regist-customer')}}" method="post">
                            {{ csrf_field() }}
                            <input class="form-control" type="text" name="cus_name" placeholder="Full Name" required>
                            <input class="form-control" type="text" name="cus_phonenumber" placeholder="Phone Number" required>
                            <input class="form-control" id="myInput" type="email" name="cus_email" placeholder="E-mail Address" required>
                            <input class="form-control" id="myInput1" type="password" name="cus_password" placeholder="Password" required>
                            <select class="form-control" name="cus_gender">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Khác">Khác</option>
                            </select>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Đăng ký</button>
                            </div>
                        </form>
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