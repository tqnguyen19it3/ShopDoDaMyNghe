<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link rel="canonical" href="{{$url_canonical}}" />
    <meta name="author" content="">
    <meta property="og:site_name" content="{{$url_canonical}}" />
    <meta property="og:description" content="{{$meta_desc}}" />
    <meta property="og:title" content="{{$meta_title}}" />
    <meta property="og:url" content="{{$url_canonical}}" />
    <meta property="og:type" content="website" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('public/FrontEnd/Images/logo/logo_transparent.png')}}">
    <title>{{$meta_title}}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500" rel="stylesheet">
    <!-- Fonts for icons -->
    <link href="{{asset('public/FrontEnd/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- bootstrap -->
    <link href="{{asset('public/FrontEnd/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Styles CSS-->
    <link href="{{asset('public/FrontEnd/css/style.css')}}" rel="stylesheet">
    <!-- Animate CSS-->
    <link href="{{asset('public/FrontEnd/css/aos.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <link href="{{asset('public/FrontEnd/css/sweetalert.css')}}" rel="stylesheet">
</head>

<body>
    <div id="main-content" class="m-scene">
        <!-- Header -->
        <nav class="navbar navbar-toggleable-md px-5-percent header-three">
            <div class="full-width-container">
                <button class="navbar-toggler navbar-toggler-right hamburger-menu-btn ml-auto" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span>Menu chuyển đổi</span>
                </button>
                <a class="navbar-brand" href="{{URL::TO('/')}}">
                    <img src="{{asset('public/FrontEnd/Images/logo/logo_transparent.png')}}" width="150" height="40" alt="Logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="active">
                            <a class="" href="{{URL::TO('/trang-chu')}}">Trang chủ</a>
                        </li>
                        <li>
                            <a class="dropdown-toggle" href="" data-toggle="dropdown">Các trang</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="" href="{{URL::TO('/gioi-thieu')}}">Giới thiệu</a>
                                </li>
                                <li>
                                    <a class="dropdown-toggle" href="" data-toggle="dropdown">Danh mục bài viết</a>
                                    <ul class="dropdown-menu">
                                    @foreach($category_post as $key => $cate_post)
                                        <li>
                                            <a href="{{URL::TO('danh-muc-bai-viet/'.$cate_post->category_post_slug.'/'.$cate_post->category_post_id)}}">{{$cate_post->category_post_name}}</a>
                                        </li>    
                                    @endforeach   
                                    </ul>
                                </li>
                                <li>
                                    <a class="" href="{{URL::TO('/lien-he')}}">Liên hệ</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-toggle" href="" data-toggle="dropdown">Danh mục sản phẩm</a>
                            <ul class="dropdown-menu">
                                @foreach($category as $key => $cate)
                                <li>
                                    <a href="{{URL::TO('danh-muc-sp/'.$cate->category_slug.'/'.$cate->category_id)}}">{{$cate->category_name}}</a>
                                </li>    
                                @endforeach                       
                            </ul>
                        </li>
                        <li>
                            <a class="" href="{{URL::TO('/cua-hang-do-da')}}">Cửa hàng</a>
                        </li>
                        <?php
                            $customer_id = Session::get('customer_id');
                            if($customer_id != NULL){
                        ?>
{{--                         <li>
                            <a class="" href="{{URL::TO('/logout-customer')}}">Đăng xuất</a>
                        </li> --}}
                        <li>
                            <a class="" href="{{URL::TO('/tai-khoan-khach-hang/'.$customer_id)}}">Tài khoản</a>
                        </li>
                        <?php
                            }else{
                        ?>
                        <li>
                            <a class="" href="{{URL::TO('/khach-hang-dang-nhap')}}">Đăng nhập</a>
                        </li>
                        <li>
                            <a class="" href="{{URL::TO('/khach-hang-dang-ky')}}">Đăng ký</a>
                        </li>
                        <?php
                            }
                        ?>
                        @php
                        $customer_id = Session::get('customer_id');
                        $product_added = Session::get('cart');
                        // print_r(Session::get('cart'));
                        // Session::put('cart', null);
                        $total = 0;
                        @endphp
                        <li>
                            <a href="{{URL::TO('/show-cart')}}">
                                <i style="font-size: 25px;" class="fa fa-shopping-bag" aria-hidden="true"></i>
                            </a>
                            @if($product_added)
                            <span style="margin-left: 15px;" class="counter-shop-box"><?php echo(count($product_added)) ?></span>
                            @else
                            <span style="margin-left: 15px;" class="counter-shop-box">0</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Header -->
        <div class="page-container scene-main scene-main--fade_In">

                @yield('content')

            <div class="px-5-percent">
                <footer>
                    <div class="footer_container">
                        <div class="fluid-container">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <p>
                                        © 2021 Shop đồ đá mỹ nghệ Non Nước
                                    </p>
                                </div>
                                <div class="col-lg-5">
                                    <ul class="footer_nav align-center">
                                        <li>
                                            <a href="{{URL::TO('/trang-chu')}}" title="Trang chủ">Trang chủ</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::TO('/gioi-thieu')}}" title="Giới thiệu">Giới thiệu</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::TO('/cua-hang-do-da')}}" title="Cửa hàng">Cửa hàng</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::TO('/lien-he')}}" title="Liên hệ">Liên hệ</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 align-right">
                                    <ul class="list-inline">
                                        <li>
                                            <a href="https://www.facebook.com/energeticthemes">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://instagram.com/energeticthemes">
                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://behance.com/energeticthemes">
                                                <i class="fa fa-google-plus" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/energeticthemes">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- ================================================== -->
    <!-- Placed js files at the end of the document so the pages load faster -->
    <script type="text/javascript" src="{{asset('public/FrontEnd/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/FrontEnd/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/FrontEnd/js/plugins.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/FrontEnd/js/jquery.smoothState.min.js')}}"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAE_JprYsi2sHzUcl8u1DbcUgQnDveJWs4"></script>
    <script type="text/javascript" src="{{asset('public/FrontEnd/js/main.js')}}"></script>
        {{-- Share in FB plugin --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0" nonce="rAKdRJ5W"></script> {{--Like and share facebook--}}
    {{-- SweetAlert --}}
    <script src="{{asset('public/FrontEnd/js/sweetalert.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#orderby_product_homeshop').on('change', function(){
                var url = $(this).val();
                if(url){
                    window.location = url;
                }
                return false;
                // alert(url);
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#orderby_product_cateshop').on('change', function(){
                var url = $(this).val();
                if(url){
                    window.location = url;
                }
                return false;
                // alert(url);
            });

        });
    </script>

    {{-- tìm kiếm bằng ajax --}}
    <script type="text/javascript">
        $('#keywords').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{url('/autocomplete-ajax')}}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            }else{
                 $('#search_ajax').fadeOut();
            }
        });
        $(document).on('click', '.li_search_ajax', function(){
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });

    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_quantity:cart_product_quantity,cart_product_qty:cart_product_qty,_token:_token},
                    success:function(){

                        swal({  
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/show-cart')}}";
                            });

                    }

                });
            });
            $('.add-cart-btn').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_quantity:cart_product_quantity,cart_product_qty:cart_product_qty,_token:_token},
                    success:function(){

                        swal("Thành công!", "Sản phầm đã được thêm vào giỏ!", "success")

                    }

                });
            });
        });
    </script>

    <script type="text/javascript">

          $(document).ready(function(){
            $('.send_order').click(function(){
                swal({
                  title: "Xác nhận đơn hàng",
                  text: "Đơn hàng sẽ không được hoàn trả khi đặt, bạn có muốn đặt không?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Cảm ơn, Mua hàng",

                    cancelButtonText: "Đóng, Chưa mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm){
                     if (isConfirm) {
                        var shipping_email = $('.shipping_email').val();
                        var shipping_name = $('.shipping_name').val();
                        var shipping_address = $('.shipping_address').val();
                        var shipping_phone = $('.shipping_phone').val();
                        var shipping_notes = $('.shipping_notes').val();
                        var shipping_method = $('.payment_option').val();
                        var order_coupon = $('.order_coupon').val();
                        var _token = $('input[name="_token"]').val();

                        $.ajax({
                            url: '{{url('/confirm-order')}}',
                            method: 'POST',
                            data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_coupon:order_coupon,shipping_method:shipping_method},
                            success:function(){
                               swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
                            }
                        });

                        window.setTimeout(function(){ 
                            location.reload();
                        } ,3000);

                      } else {
                        swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                      }
              
                });

               
            });
        });
    </script>

    
</body>

</html>