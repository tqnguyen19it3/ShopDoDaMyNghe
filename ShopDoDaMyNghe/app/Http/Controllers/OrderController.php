<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingModels;
use App\Models\OrderModels;
use App\Models\OrderDetailsModels;
use App\Models\CouponModels;
use App\Models\StatisticalModels;
use App\Models\CustomerModels;
use App\Models\ProductModels;
use Carbon\Carbon;
use PDF;

class OrderController extends Controller
{
    //
    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');              
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function manage_order(){
    	$all_order = OrderModels::orderby('created_at','desc')->paginate(5);
    	return view('admin_page.dashboard.manage_order.manage_order')->with(compact('all_order'));
    }

    public function view_order($order_code){

		$order_details = OrderDetailsModels::with('product')->where('order_code',$order_code)->get();
		$order = OrderModels::where('order_code',$order_code)->get();

		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		
		$customer = CustomerModels::where('customer_id',$customer_id)->first();
		$shipping = ShippingModels::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetailsModels::with('product')->where('order_code', $order_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;

		}

		if($product_coupon != 'no'){
			$coupon = CouponModels::where('coupon_code',$product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;
		}
		
		return view('admin_page.dashboard.manage_order.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));

	}

	public function print_order($checkout_code){

		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		
		return $pdf->stream();

	}

	public function print_order_convert($checkout_code){

		$order_details = OrderDetailsModels::where('order_code', $checkout_code)->get();
		$order = OrderModels::where('order_code', $checkout_code)->get();

		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}

		$customer = CustomerModels::where('customer_id',$customer_id)->first();
		$shipping = ShippingModels::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetailsModels::with('product')->where('order_code', $checkout_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}

		if($product_coupon != 'no'){
			$coupon = CouponModels::where('coupon_code',$product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if($coupon_condition == 1){
				$coupon_echo = $coupon_number.'%';
			}elseif($coupon_condition==2){
				$coupon_echo = number_format($coupon_number).' VNĐ';
			}
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		
		}

		$output = '';

		$output.='<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
			border-collapse: collapse;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
			border-collapse: collapse;
		}

		.table-styling td{
			margin: auto;
			padding: 5px 15px;
		}

		</style>
		<h3><center>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</center></h3>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
		<h4><center>-----***-----</center></h4>
		<h1><center>Cửa hàng đồ đá mỹ nghệ Non Nước</center></h1>
		<p><B>Người đặt hàng</B></p>
		<table class="table-styling">
				<thead>
					<tr>
						<th>Tên khách</th>
						<th>Số điện thoại</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td>'.$customer->customer_name.'</td>
						<td>'.$customer->customer_phone.'</td>
						<td>'.$customer->customer_email.'</td>
						
					</tr>';
				

		$output.='				
				</tbody>
			
		</table>

		<p><B>Thông tin vận chuyển</B></p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên người nhận</th>
						<th>SĐT</th>
						<th>Email</th>
						<th>Địa chỉ</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td>'.$shipping->shipping_name.'</td>
						<td>'.$shipping->shipping_phone.'</td>
						<td>'.$shipping->shipping_email.'</td>
						<td>'.$shipping->shipping_address.'</td>
						<td>'.$shipping->shipping_notes.'</td>
						
					</tr>';
				

		$output.='				
				</tbody>
			
		</table>

		<p><B>Đơn hàng đặt</B></p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên sản phẩm</th>
						<th>Số lượng</th>
						<th>Mã giảm giá</th>
						<th>Giá sản phẩm</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';
			
				$total = 0;

				foreach($order_details_product as $key => $product){

					$subtotal = $product->product_price*$product->product_sales_quantity;
					$total+=$subtotal;

					if($product->product_coupon!='no'){
						$product_coupon = $product->product_coupon;
					}else{
						$product_coupon = 'không mã';
					}		

		$output.='		
					<tr>
						<td>'.$product->product_name.'</td>
						<td>'.$product->product_sales_quantity.'</td>
						<td>'.$product_coupon.'</td>
						<td>'.number_format($product->product_price).' VNĐ'.'</td>
						<td>'.number_format($subtotal).' VNĐ'.'</td>
						
					</tr>';
				}

				if($coupon_condition == 1){
					$total_after_coupon = ($total*$coupon_number)/100;
	                $total_coupon = $total - $total_after_coupon;
				}else{
                  	$total_coupon = $total - $coupon_number;
				}

		$output.= '<tr>
				<td colspan="5">
					<p>Tổng giảm: '.$coupon_echo.'</p>
				</td>
		</tr>
		<tr>
				<td colspan="5">
					<p>Thanh toán : '.number_format($total_coupon).' VNĐ'.'</p>
				</td>
		</tr>';
		$output.='				
				</tbody>
			
		</table>
		<table style="margin-top: 50px;">
			<thead>
				<tr>
					<th width="200px">Người lập phiếu</th>
					<th width="800px">Người nhận</th>
					
				</tr>
			</thead>
			<tbody>';
						
		$output.='				
			</tbody>
			
		</table>
		';


		return $output;

	}

	// public function order_code(Request $request ,$order_code){
	// 	$order = Order::where('order_code',$order_code)->first();
	// 	$order->delete();
	// 	 Session::put('message','Xóa đơn hàng thành công');
 //        return redirect()->back();

	// }
	// public function update_qty(Request $request){
	// 	$data = $request->all();
	// 	$order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
	// 	$order_details->product_sales_quantity = $data['order_qty'];
	// 	$order_details->save();
	// }
	public function update_order_qty(Request $request){
		//update order
		$data = $request->all();
		$order = OrderModels::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();

		$order_date = $order->order_date;
		$statistic = StatisticalModels::where('order_date', $order_date)->get();

		if($statistic){
			$statistic_count = $statistic->count();
		}else{
			$statistic_count = 0;
		}

		if($order->order_status == 2){
			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;

			foreach($data['order_product_id'] as $key => $product_id){
				
				$product = ProductModels::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$product_cost = $product->product_cost;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

				foreach($data['quantity'] as $key2 => $qty){
					if($key == $key2){
						$pro_remain = $product_quantity - $qty;
						$product->product_quantity = $pro_remain;
						$product->product_sold = $product_sold + $qty;
						$product->save();

						$quantity += $qty;
						$total_order += 1;
						$sales += $product_price * $qty;
						$profit += ($product_price*$qty) - ($product_cost*$qty);
					}
				}
			}

			//update doanh số
			if($statistic_count>0){ //nếu đã có doanh số ngày đó thì cộng thêm đơn hàng mới
				$statistic_update = StatisticalModels::where('order_date', $order_date)->first();
				$statistic_update->sales = $statistic_update->sales + $sales;
				$statistic_update->profit = $statistic_update->profit + $profit;
				$statistic_update->quantity = $statistic_update->quantity + $quantity;
				$statistic_update->total_order = $statistic_update->total_order + $total_order;
				$statistic_update->save();
			}else{ //nếu chưa có doanh số ngày đó thì cộng thêm ngày mới và đơn hàng đó
				$statistic_new = new StatisticalModels();
				$statistic_new->order_date = $order_date;
				$statistic_new->sales = $sales;
				$statistic_new->profit = $profit;
				$statistic_new->quantity = $quantity;
				$statistic_new->total_order = $total_order;
				$statistic_new->save();
			}
		}
		// elseif($order->order_status != 2 && $order->order_status != 3){
		// 	foreach($data['order_product_id'] as $key => $product_id){
				
		// 		$product = ProductModels::find($product_id);
		// 		$product_quantity = $product->product_quantity;
		// 		$product_sold = $product->product_sold;

		// 		foreach($data['quantity'] as $key2 => $qty){
		// 			if($key == $key2){
		// 				$pro_remain = $product_quantity + $qty;
		// 				$product->product_quantity = $pro_remain;
		// 				$product->product_sold = $product_sold - $qty;
		// 				$product->save();
		// 			}
		// 		}
		// 	}
		// }


	}
}
