@extends('admin_page.admin_layout')
@section('admin_content') 
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách hàng
    </div>
    <div class="table-responsive">
        <?php
            echo "<div class='text-center'>";
                echo "<strong style='color:green;'>" ;
                    $message = Session::get('message');
                    if($message){
                        echo $message;
                        Session::put('message', null);
                    }
                echo "</strong>";
            echo "</div>";
        ?> 
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>SĐT</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_email}}</td>
            <td>{{$customer->customer_phone}}</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Chi tiết đơn hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
        <?php
            echo "<div class='text-center'>";
                echo "<strong style='color:green;'>" ;
                    $messageOrder = Session::get('messageOrder');
                    if($messageOrder){
                        echo $messageOrder;
                        Session::put('messageOrder', null);
                    }
                echo "</strong>";
            echo "</div>";
        ?> 
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng mua</th>
            <th>Sản phẩm còn trong kho</th>
            <th>Mã giảm</th>
            <th>Đơn giá</th>
            <th>Tiền theo số lượng</th>
            {{-- <th>Ngày thêm</th> --}}
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
            $i = 0;
            $total = 0;
          @endphp
          @foreach($order_details as $key => $orderDetails)
          @php 
          $i++;
          $subtotal = $orderDetails->product_price * $orderDetails->product_sales_quantity;
          $total+=$subtotal;
          @endphp
          <tr class="color_qty_{{$orderDetails->product_id}}">
            <td><i>{{$i}}</i></td>
            <td>{{$orderDetails->product_name}}</td>
            <td>
              <input type="number" name="product_sales_quantity" class="order_qty_{{$orderDetails->product_id}}" disabled="true" value="{{$orderDetails->product_sales_quantity}}">
              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$orderDetails->product_id}}">
            </td>
            <td>{{$orderDetails->product->product_quantity}}</td>
            <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$orderDetails->product_id}}" value="{{$orderDetails->product->product_quantity}}">
            <td>@if($orderDetails->product_coupon != 'no')
                  {{$orderDetails->product_coupon}}
                @else 
                  Không áp dụng mã giảm giá
                @endif
            </td>
            <td>{{number_format($orderDetails->product_price)}} VNĐ</td>
            <td>{{number_format($subtotal)}} VNĐ</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-right text-center-xs ">
          @php 
            $total_coupon = 0;
          @endphp
          @if($coupon_condition == 1)
            @php
              $total_after_coupon = ($total * $coupon_number) / 100;
              echo 'Tổng giảm: '.number_format($total_after_coupon).' VNĐ'.'</br>';
              $total_coupon = $total - $total_after_coupon ;
            @endphp
          @elseif($coupon_condition == 2) 
            @php
              echo 'Tổng giảm: '.number_format($coupon_number).' VNĐ'.'</br>';
              $total_coupon = $total - $coupon_number ;
            @endphp
          @endif
          <strong>Tổng tiền phải trả:</strong>  {{number_format($total_coupon)}} VNĐ
        </div>
        <td colspan="6">
              @foreach($order as $key => $or)
                @if($or->order_status == 1)
                <form>
                   @csrf
                  <select class="form-control order_details">
                    <option value="" disabled="">----Chọn hình thức đơn hàng-----</option>
                    <option id="{{$or->order_id}}" selected value="1">Chưa xử lý</option>
                    <option id="{{$or->order_id}}" value="3">Đang xử lý</option>
                    <option id="{{$or->order_id}}" value="2">Đã xử lý - Đã giao hàng</option>
                  </select>
                </form>
                @elseif($or->order_status == 2)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="" disabled="">----Chọn hình thức đơn hàng-----</option>
                    <option id="{{$or->order_id}}" value="1" disabled="">Chưa xử lý</option>
                    <option id="{{$or->order_id}}" value="3" disabled="">Đang xử lý</option>
                    <option id="{{$or->order_id}}" selected value="2">Đã xử lý - Đã giao hàng</option>
                  </select>
                </form>
                @else
                <form>
                   @csrf
                  <select class="form-control order_details">
                    <option value="" disabled="">----Chọn hình thức đơn hàng-----</option>
                    <option id="{{$or->order_id}}" value="1" disabled>Chưa xử lý</option>
                    <option id="{{$or->order_id}}" selected value="3">Đang xử lý</option>
                    <option id="{{$or->order_id}}" value="2">Đã xử lý - Đã giao hàng</option>
                  </select>
                </form>
                @endif
                @endforeach
            </td>
          </br>
        <div class="col-sm-6 text-right text-center-xs">                
          <a target="_blank" class="btn btn-primary" href="{{url('/print-order/'.$orderDetails->order_code)}}">In đơn hàng</a>
        </div>
      </div>
     
    </footer>
  </div>
</div>
<br><br>
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin vận chuyển
    </div>
    <div class="table-responsive">
        <?php
            echo "<div class='text-center'>";
                echo "<strong style='color:green;'>" ;
                    $message = Session::get('message');
                    if($message){
                        echo $message;
                        Session::put('message', null);
                    }
                echo "</strong>";
            echo "</div>";
        ?> 
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên người nhận</th>
            <th>Email người nhận</th>
            <th>Địa chỉ giao hàng</th>
            <th>SĐT người nhận</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_notes}}</td>
            <td>@if($shipping->shipping_method == 1) Tiền mặt @elseif($shipping->shipping_method == 2) Thẻ ATM @else Thẻ ghi nợ @endif</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection