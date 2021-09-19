@extends('welcome')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('public/FrontEnd/css/cart.css')}}">
<style>
    footer{
        display: none;
    }
    @media(max-width: 1199px){
        footer{
            display: block;
        }
    }
    @media(max-width: 991px){
        footer{
            display: block;
        }
    }
</style>
    <div class="main-content shop-page shoppingcart-page">
        <div class="container">
            <div class="breadcrumbs">
                <a href="{{URL::TO('/trang-chu')}}">Trang chủ</a> / <span class="current">Giỏ hàng</span>
            </div>
            <div class="shoppingcart-content">
                <form action="{{URL::TO('/update-cart')}}" method="post">
                    {{ csrf_field() }}
                <div class="your-cart">
                    <h4 class="main-title title">Mặt hàng trong giỏ</h4>
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <h5 style="color: green;" align="center">{{ session()->get('message') }}</h5>
                        </div>
                    @elseif(session()->has('error'))
                         <div class="alert alert-danger">
                           <h5 style="color: red;" align="center">{{ session()->get('error') }}</h5>
                        </div>
                    @endif
                    <ul class="list-item">

                        @php
                        $customer_id = Session::get('customer_id');
                        $product_added = Session::get('cart');
                        // print_r(Session::get('cart'));
                        // Session::put('cart', null);
                        $total = 0;
                        @endphp
                    @if($product_added)
                    @foreach($product_added as $key => $cart)
                        <li class="cart-item">
                            <div class="thumb"><a href=""><img src="{{URL::TO('./public/Uploads/product/'.$cart['product_image'])}}" width="120" height="120" alt="product"></a></div>
                            <div class="info">
                                <a href="" class="product-name">{{$cart['product_name']}}</a>
                                <div class="box-quantity">
                                    <span class="text">Số lượng</span>
                                    <span class="quantity">
                                        <input type="number" placeholder="1" min="1" max="{{$cart['product_quantity']}}" class="number cart_quantity" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">
                                    </span>
                                    <div class="total-price">
                                        <span class="price">
                                            <?php
                                                $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                echo number_format($subtotal).' VNĐ';
                                                $total += $subtotal;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a onclick="return confirm('Bạn muốn xóa sản phẩm này ra khỏi giỏ hàng?')" href="{{url('/del-product-cart/'.$cart['session_id'])}}" class="remove-cart-item">x</a>
                        </li>
                    @endforeach
                    @else
                        <div class="text-center">;
                            <h3 style="color:green;">Giỏ hàng đang trống</h3>
                        </div>
                    @endif
                    </ul>
                    @if($product_added)
                    <div class="group-button">
                        <a href="{{URL::TO('/cua-hang-do-da')}}" style="border-radius: 0.25rem;" class="backtoshop button">Trở lại cửa hàng</a>
                        <div class="button-cart">
                            <input type="submit" style="cursor: pointer;" name="update_qty" value="Cập nhật" class="update button">
                            <a href="{{URL::TO('/del-all-product-cart')}}" style="border-radius: 0.25rem;" class="clear-all">Xóa hết</a>
                        </div>
                    </div>
                    @else
                        <a href="{{URL::TO('/cua-hang-do-da')}}" class="backtoshop button">Trở lại cửa hàng</a>
                    @endif
                </div>
                </form>
                <div class="summary">
                    <h4 class="main-title title">Tóm lượt</h4>
                    <div class="sumary-content">
                        <?php
                            if($product_added){    
                        ?>
                        <form action="{{URL::TO('/check-coupon')}}" method="post">
                            {{csrf_field()}}
                            <div class="select-content coupon parent-content">
                                <a href="#toggle_coupon" data-toggle="collapse" class="toggle-button">Nhập mã giảm giá</a>
                                <div id="toggle_coupon" class="inner-content toggle-content collapse">
                                    <input type="text" name="coupon_code" placeholder="Điền mã">
                                    <input type="submit" value="Áp dụng" class="submit">
                                </div>
                            </div>
                        </form>
                        <?php
                            }
                        ?>
                        <div class="subtotal">
                            <span class="text">Thuế</span><span class="price">0</span>
                        </div>
                        <div class="other-choose">
                            <span class="note-text">Phí vận chuyển</span>
                            <div class="check-item">
                                <span class="text"><input type="radio" class="express" name="check-item"> Nhanh:</span><span class="price">0</span>
                            </div>
                        </div>
                        <div class="subtotal">
                            <span class="text">Tổng phụ</span><span class="price"> 0</span>
                        </div>
                        <div class="total">
                            <span class="text">Tổng</span><span class="price">{{number_format($total).' VNĐ'}}</span>
                        </div>
                        @if(Session::get('coupon') == true && Session::get('cart') == true )
                            @foreach(Session::get('coupon') as $key => $cou)
                                @if($cou['coupon_condition']==1)
                                    <div class="subtotal">
                                        <span class="text">Mã giảm được</span><span class="price">{{$cou['coupon_number']}}%</span></br>
                                    </div>
                                    <div class="subtotal">
                                        @php 
                                            $total_cou = ($total * $cou['coupon_number'])/100;
                                            $total_coupon = $total - $total_cou;
                                            echo '<span class="text">Tiền giảm</span><span class="price">'.number_format($total_cou).' VNĐ</span>';
                                        @endphp
                                    </div>
                                    <div class="total">
                                        <span class="text">Tổng sau giảm</span><span class="price">{{number_format($total_coupon)}} VNĐ</span>
                                    </div>
                                @elseif($cou['coupon_condition']==2)
                                    <div class="subtotal">
                                        <span class="text">Mã giảm được</span><span class="price">{{number_format($cou['coupon_number'])}} VNĐ</span></br>
                                    </div>
                                        @php 
                                            $total_coupon = $total - $cou['coupon_number'];
                                        @endphp
                                    <div class="total">
                                        <span class="text">Tổng sau giảm</span><span class="price">{{number_format($total_coupon)}} VNĐ</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <?php
                    if($product_added){    
                        if($customer_id != NULL){
                    ?>
                    <a href="{{URL::TO('/checkout')}}" class="button checkout">Tiến hành thanh toán</a>
{{--                     <?php
                        }elseif($customer_id != NULL && Session::get('coupon') != true){
                    ?>
                    <a href="{{URL::TO('/checkout/'.$total)}}" class="button checkout">Tiến hành thanh toán</a> --}}
                    <?php
                        }else{
                    ?>
                    <a href="{{URL::TO('/khach-hang-dang-nhap')}}" class="button checkout">Tiến hành thanh toán</a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
@endsection