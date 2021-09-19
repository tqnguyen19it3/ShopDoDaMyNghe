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
				<a href="{{URL::TO('/trang-chu')}}">Trang chủ</a> / <span class="current">Thanh toán</span>
			</div>
			<div class="shoppingcart-content">
				<div class="your-cart" style="width: 100%; max-width: none; margin: 0 0px 50px 0px;">
					<h4 class="main-title title">Mặt hàng trong giỏ</h4>
					<ul class="list-item">
						<?php
							$content = Cart::content();
							//echo "<pre>";
								//print_r($content);
							//echo "</pre>";
						?>
						@foreach($content as $v_content)
						<li class="cart-item">
							<div class="thumb"><a href=""><img src="{{URL::TO('./public/Uploads/product/'.$v_content->options->image)}}" width="120" height="120" alt=""></a></div>
							<div class="info">
								<a href="" class="product-name">{{$v_content->name}}</a>
								<div class="box-quantity">
									<span class="text">Số lượng</span>
									<span class="quantity">
										{{$v_content->qty}}
									</span>
									<div class="total-price">
										<span class="price">
											<?php
												$subtotal = $v_content->price * $v_content->qty;
												echo number_format($subtotal).' VNĐ';
											?>
										</span>
									</div>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					<form class="text-center" method="post" action="{{URL::TO('/order-place')}}">
						{{csrf_field()}}
					    <label class="radio-inline">
					      <input type="radio" value="1" name="payment_option" checked>Thanh toán tiền mặt | 
					    </label>
					    <label class="radio-inline">
					      <input type="radio" value="2" name="payment_option">Thanh toán ATM | 
					    </label>
					    <label class="radio-inline">
					      <input type="radio" value="3" name="payment_option">Thanh toán thẻ ghi nợ
					    </label>
						<div class="group-button">
							<button type="submit" class="backtoshop button">Xác nhận</button> 
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection