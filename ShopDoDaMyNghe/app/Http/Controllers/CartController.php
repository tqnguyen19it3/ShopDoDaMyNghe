<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\CategoryModels;
use App\Models\PostCateModels;
use App\Models\CouponModels;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    //

    public function save_cart(Request $request){
    	$productID = $request->product_id_hiden;
    	$quantity = $request->quantity;

    	$product_info = DB::table('tbl_product')->where('product_id',$productID)->first();

    	$data['id'] = $product_info->product_id;
    	$data['qty'] = $quantity;
    	$data['name'] = $product_info->product_name;
    	$data['price'] = $product_info->product_price;
    	$data['weight'] = $product_info->product_price;
    	$data['options']['image'] = $product_info->product_image;
    	Cart::add($data);
    	// Cart::destroy();
    	return Redirect::to('/show-cart');
    }

    public function delete_cart($rowId){ //delete 1
    
     Cart::update($rowId, 0);

     return Redirect::to('/show-cart');
    }



    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),7);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id'] == $data['cart_product_id']){
                    $is_avaiable++;
                    $cart[$key] = array(
                    'session_id' => $val['session_id'],
                    'product_name' => $val['product_name'],
                    'product_id' => $val['product_id'],
                    'product_image' => $val['product_image'],
                    'product_quantity' => $val['product_quantity'],
                    'product_qty' => $val['product_qty']+ $data['cart_product_qty'],
                    'product_price' => $val['product_price'],
                    );
                    Session::put('cart',$cart);
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();
        // Session::put('cart',null);
    }

    public function show_cart(Request $request){

        // SEO
        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        // END SEO

    	$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();

    	return view('parent_page.cart.show_cart_ajax')->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }

    public function update_cart(Request $request){ //update 2 bang ajax
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true){
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if($val['session_id'] == $key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect::to('/show-cart')->with('message', 'Cập nhật số lượng sản phẩm thành công!');
        }else
            return Redirect::to('/show-cart')->with('error', 'Cập nhật số lượng sản phẩm thất bại!');
    }

    public function del_product_cart($session_id){ //delete 2 bang ajax
        
        $cart = Session::get('cart');
        if($cart == true){
            foreach ($cart as $key => $value) {
                if ($value['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
        Session::put('cart',$cart);
        return Redirect::to('/show-cart')->with('message', 'Đã xóa sản phẩm ra khỏi giỏ hàng!');
        }else{
            return Redirect::to('/show-cart')->with('error', 'Xóa sản phẩm ra khỏi giỏ hàng thất bại!');
        }
        
    }

    public function del_all_product_cart(){ //delete 2 bang ajax
        
        $cart = Session::get('cart');
        if($cart == true){
           // Session::destroy(); //có bn session nó sẽ hủy hết
            Session::forget('cart'); //chỉ hủy phiên cart
            Session::forget('coupon'); //hủy phiên giảm giá
            return Redirect::to('/show-cart')->with('message', 'Đã xóa tất cả sản phẩm ra khỏi giỏ hàng!');
        }
    }



    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = CouponModels::where('coupon_code',$data['coupon_code'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                $coupon_session = Session::get('coupon');
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable == 0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return Redirect::to('/show-cart')->with('message','Mã giảm giá áp dụng thành công!');
            }

        }else{
            return Redirect::to('/show-cart')->with('error','Mã giảm giá không đúng!');
        }
    }   

    

}
