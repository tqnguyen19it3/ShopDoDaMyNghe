<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;
use Carbon\Carbon;
use App\Models\CategoryModels;
use App\Models\PostCateModels;
use App\Models\ShippingModels;
use App\Models\OrderModels;
use App\Models\OrderDetailsModels;
session_start();


class CheckoutController extends Controller
{
    //

    public function AuthLogin(){
        $customer_id = Session::get('customer_id');  
        if($customer_id){                                      
            return Redirect::to('/show-cart');              
        }else return Redirect::to('/khach-hang-dang-nhap')->send();
    }

    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');              
        }else return Redirect::to('/login-form-admin')->send();   
    }


	public function checkout(Request $request){
		$this->AuthLogin();
		$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
    	// SEO
        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong,";
        $meta_title = "Thủ tục thanh toán";
        $url_canonical = $request->url();
        // END SEO

		return view('parent_page.checkout.checkout')->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
	}

	public function confirm_order(Request $request){
        $data = $request->all();

        $shipping = new ShippingModels();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()),rand(0,26),7);

  
        $order = new OrderModels;
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // $order->created_at = now();

        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at = $today;
        $order->order_date = $order_date;
        $order->save();

        if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){
                $order_details = new OrderDetailsModels;
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $data['order_coupon'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('cart');
    }



    public function save_checkout_customer(Request $request){  //cũ
		$data = array();
		$data['shipping_name'] = $request->shipping_name;
		$data['shipping_email'] = $request->shipping_email;
		$data['shipping_phone'] = $request->shipping_phone;
		$data['shipping_address'] = $request->shipping_address;
		$data['shipping_notes'] = $request->shipping_notes;

		$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

		Session::put('shipping_id',$shipping_id);

		return Redirect::to('/payment');
	}


    public function payment(Request $request){ //cũ
    	$this->AuthLogin();
      	$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
      	// SEO
        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong,";
        $meta_title = "Hình thức thanh toán";
        $url_canonical = $request->url();
        // END SEO

    	return view('parent_page.checkout.payment')->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
  	}

	public function order_place(Request $request){		//cũ

		//insert payment_method
		$payment_data = array();
		$payment_data['payment_method'] = $request->payment_option;
		$payment_data['payment_status'] = 'Đang xử lý...';

		$payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

		//insert order_method
		$order_data = array();
		$order_data['customer_id'] = Session::get('customer_id');
		$order_data['shipping_id'] = Session::get('shipping_id');
		$order_data['payment_id'] = $payment_id;
		$order_data['order_total'] = Cart::total();
		$order_data['order_status'] = 'Đang xử lý...';

		$order_id = DB::table('tbl_order')->insertGetId($order_data);

		//insert order_details_method
		$content = Cart::content();
		foreach ($content as $v_content) {
			$order_details_data['order_id'] = $order_id;
			$order_details_data['product_id'] = $v_content->id;
			$order_details_data['product_name'] = $v_content->name;
			$order_details_data['product_price'] = $v_content->price;
			$order_details_data['product_sales_quantity'] = $v_content->qty;

			
			DB::table('tbl_order_details')->insertGetId($order_details_data);
		}
		// $order_details_data = array();
		if($payment_data['payment_method'] == 1){
			Cart::destroy();
			echo "Thanh toán bằng tiền mặt";
		}else if($payment_data['payment_method'] == 2){
			echo "Thanh toán bằng ATM";			//chưa phát triển
		}else {
			echo "Thanh toán bằng thẻ ghi nợ";	//chưa phát triển
		}
			// SEO
	 //        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
	 //        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong,";
	 //        $meta_title = "Đặt hàng thành công";
	 //        $url_canonical = $request->url();
  //       // END SEO
		// 	Cart::destroy();
		// 	$cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id','desc')->get();

		// return view('pages.checkout.handcash')->with('category',$cate_product)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
		// }
	}



//quản lý đơn hàng ở trang admin
	public function manage_order(){ //cũ
		$this->AuthLoginAdmin();
    	$all_order = DB::table('tbl_order')
    	->join('tbl_customer','tbl_order.customer_id', '=', 'tbl_customer.customer_id')
    	->select('tbl_order.*','tbl_customer.customer_name')
    	->orderby('tbl_order.order_id')->get();

    	$manage_order = view('admin_page.dashboard.manage_order.manage_order')->with('all_order', $all_order);

    	return view('admin_page.admin_layout')->with('admin_page.dashboard.manage_order.manage_order', $manage_order);
	}

	public function view_order($order_id){ //cũ

		$this->AuthLoginAdmin();

    	$order_byID1 = DB::table('tbl_order')
    	->join('tbl_customer','tbl_order.customer_id', '=', 'tbl_customer.customer_id')
    	->join('tbl_shipping','tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
    	->join('tbl_order_details','tbl_order.order_id', '=', 'tbl_order_details.order_id')
    	->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->where('tbl_order.order_id', $order_id)->first();

    	$order_byID = DB::table('tbl_order')
    	->join('tbl_customer','tbl_order.customer_id', '=', 'tbl_customer.customer_id')
    	->join('tbl_shipping','tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
    	->join('tbl_order_details','tbl_order.order_id', '=', 'tbl_order_details.order_id')
    	->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->where('tbl_order.order_id', $order_id)->get();

    	$manage_order_byID = view('admin_page.dashboard.manage_order.view_order')->with('order_byID', $order_byID)->with('order_byID1', $order_byID1);

    	return view('admin_page.admin_layout')->with('admin_page.dashboard.manage_order.view_order', $manage_order_byID);

	}

	// public function delete_order($order_id){

	// 	$this->AuthLoginAdmin();
 //    	$all_order = DB::table('tbl_order')->where('tbl_order.order_id', $order_id)
 //    	->join('tbl_customer','tbl_order.customer_id', '=', 'tbl_customer.customer_id')
 //    	->select('tbl_order.*','tbl_customer.customer_name')
 //    	->orderby('tbl_order.order_id')->get();

 //    	$manage_order = view('admin_page.dashboard.manage_order.manage_order')->with('all_order', $all_order);

 //    	return view('admin_page.admin_layout')->with('admin_page.dashboard.manage_order.manage_order', $manage_order);
	// }
}
