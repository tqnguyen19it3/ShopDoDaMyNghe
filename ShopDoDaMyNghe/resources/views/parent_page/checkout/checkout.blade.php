@extends('welcome')
@section('content') 
                @if(Session::get('cart')==true)
                  @php
                      $total = 0;
                      $subtotal = 0;
                      $total_coupon = 0;
                      $total_after_coupon = 0;
                  @endphp
                  @foreach(Session::get('cart') as $key => $cart)
                    @php
                      $subtotal = $cart['product_price']*$cart['product_qty'];
                      $total+=$subtotal;  //tiền chưa có mã giảm
                    @endphp
                  @endforeach
                  @if(Session::get('coupon') == true)
                    @foreach(Session::get('coupon') as $key => $cou)
                      @if($cou['coupon_condition']==1)
                          @php 
                          $total_coupon = ($total*$cou['coupon_number'])/100;
                          @endphp
                        @php 
                          $total_after_coupon = $total-$total_coupon; //tiền sau khi sử dụng mã giảm 1
                        @endphp
                      @elseif($cou['coupon_condition']==2)
                          @php 
                          $total_coupon = $total - $cou['coupon_number'];   //tiền sau khi sử dụng mã giảm 2
                          @endphp
                         @php 
                          $total_after_coupon = $total_coupon;
                        @endphp
                      @endif
                    @endforeach
                  @endif
                @endif
{{--               <?php
                echo ($total_after_coupon).'<br>';
                echo ($total);
              ?> --}}
  <div class="container">
        <form>
          @csrf
          <div class="row">
            <div class="col-sm-6">
              <h2 align="center">Điền thông tin hóa đơn</h2>
              <div class="form-group">
                <input type="text" class="form-control shipping_name" placeholder="Họ và tên" name="shipping_name">
              </div>
              <div class="form-group">
                <input type="email" class="form-control shipping_email" placeholder="Email" name="shipping_email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control shipping_phone" placeholder="Số điện thoại" name="shipping_phone">
              </div>
              <div class="form-group">
                <input type="text" class="form-control shipping_address" placeholder="Địa chỉ" name="shipping_address">
              </div>
              <div class="form-group">
                <textarea class="form-control shipping_notes" rows="6" placeholder="Ghi chú về đơn đặt hàng của bạn" name="shipping_notes"></textarea>

                  @if(Session::get('coupon'))
                    @foreach(Session::get('coupon') as $key => $cou)
                      <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                    @endforeach
                  @else 
                    <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                  @endif

              </div>

              <div class="form-group form-check" align="center">
                <label class="radio-inline">
                  <input type="radio" class="payment_option" name="payment_option"  value="1">Thanh toán tiền mặt | 
                </label>
                <label class="radio-inline">
                  <input type="radio" class="payment_option" name="payment_option" value="2">Thanh toán ATM | 
                </label>
                <label class="radio-inline">
                  <input type="radio" class="payment_option" name="payment_option" value="3">Thanh toán thẻ ghi nợ
                </label>
              </div>
            <input type="button" name="send_order" class="button checkout send_order" style="font-size: 14px; font-weight: 700; color: #fff; padding: 0 25px; line-height: 43px; background-color: #333; text-align: center; cursor: pointer;" value="Gửi">
          </div>
          
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-12">
              <div class="bg-light">
                <blockquote class="mx-5" style="margin: 55px 0 0 0;">
                  Vui lòng sử dụng Đăng ký và Thanh toán để dễ dàng truy cập vào lịch sử đơn đặt hàng của bạn hoặc sử dụng Thanh toán với tư cách Khách
                </blockquote>
              </div>
              </div>  
              <div class="col-sm-12">
              <div class="bg-grey-light">
                <blockquote class="mx-5">
                  “A successful product is never done or perfect”
                    <br> - Geoff Teehan -
                </blockquote>
              </div>
              </div>
            </div>
            </div>      
        </div>
      </form>
  </div>
@endsection