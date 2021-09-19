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
				<div class="your-cart">
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
										<input type="number" placeholder="1" min="1" class="number" value="{{$v_content->qty}}">
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
							<a href="{{URL::TO('/delete-to-cart/'.$v_content->rowId)}}" onclick="return confirm('Bạn muốn xóa sản phẩm này ra khỏi giỏ hàng?')" class="remove-cart-item">x</a>
						</li>
						@endforeach
					</ul>
					<div class="group-button">
						<a href="{{URL::TO('/cua-hang-do-da')}}" class="backtoshop button">Trở lại cửa hàng</a>
						<div class="button-cart">
							<a href="#" class="update button">Cập nhật</a>
							<a href="#" class=" clear-all">Xóa hết</a>
						</div>
					</div>
				</div>
				<div class="summary">
					<h4 class="main-title title">Tóm lượt</h4>
					<div class="sumary-content">
						<div class="select-content coupon parent-content">
							<a href="#" class="toggle-button">Nhập mã giảm giá</a>
							<div class="inner-content toggle-content">
								<input type="text" placeholder="Điền mã">
								<a href="#" class="submit">Áp dụng</a>
							</div>
						</div>
						<div class="select-content coupon parent-content">
							<a href="#" class="toggle-button">Calculate Shipping</a>
							<div class="inner-content toggle-content">
								<select name="country" class="country">
									<option value="">France</option>
									<option value="">United Kingdom</option>
									<option value="">Sweden</option>
									<option value="">Norway</option>
									<option value="">Austria</option>
									<option value="">France</option>
									<option value="">United States</option>
								</select>
								<input type="text" placeholder="Postoode / ZIP">
								<a href="#" class="update">Update Totals</a>
							</div>
						</div>
						<div class="subtotal">
							<span class="text">Thuế</span><span class="price">{{Cart::tax().' VNĐ'}}</span>
						</div>
						<div class="other-choose">
							<span class="note-text">Phí vận chuyển</span>
							<div class="check-item">
								<span class="text"><input type="radio" class="standard" name="check-item">Tiêu chuẩn:</span><span class="price">€10</span>
							</div>
							<div class="check-item">
								<span class="text"><input type="radio" class="express" name="check-item"> Nhanh:</span><span class="price">€18</span>
							</div>
						</div>
						<div class="subtotal">
							<span class="text">Tổng phụ</span><span class="price">{{Cart::subtotal().' VNĐ'}}</span>
						</div>
						<div class="total">
							<span class="text">Tổng</span><span class="price">{{Cart::total().' VNĐ'}}</span>
						</div>
					</div>
					<?php
                        $customer_id = Session::get('customer_id');
                        if($customer_id != NULL){
                    ?>
					<a href="{{URL::TO('/checkout')}}" class="button checkout">Tiến hành thanh toán</a>
					<?php
                   		}else{
                    ?>
                    <a href="{{URL::TO('/khach-hang-dang-nhap')}}" class="button checkout">Tiến hành thanh toán</a>
                    <?php
                   		}
                    ?>
				</div>
			</div>
		</div>
	</div>
@endsection