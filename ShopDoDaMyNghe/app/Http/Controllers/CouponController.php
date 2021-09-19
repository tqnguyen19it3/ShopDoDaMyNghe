<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\CouponModels;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');            
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function insert_coupon(){
    	$this->AuthLoginAdmin();
    	return view('admin_page.dashboard.coupon.insert_coupon');
    }

    public function insert_coupon_code(Request $request){
    	
    	$data = $request->all();

    	$coupon = new CouponModels;

    	$coupon->coupon_name = $data['coupon_name'];
    	$coupon->coupon_number = $data['coupon_number'];
    	$coupon->coupon_code = $data['coupon_code'];
    	$coupon->coupon_time = $data['coupon_time'];
    	$coupon->coupon_condition = $data['coupon_condition'];
    	$coupon->save();

    	Session::put('message','Thêm mã giảm giá thành công!');
        return Redirect::to('insert-coupon');

    }

    public function list_coupon(){
    	$this->AuthLoginAdmin();
    	$coupon = CouponModels::orderby('coupon_id','DESC')->paginate(5);
    	return view('admin_page.dashboard.coupon.list_coupon')->with(compact('coupon'));
	}

 //    public function unset_coupon(){
	// 	$coupon = Session::get('coupon');
 //        if($coupon==true){
          
 //            Session::forget('coupon');
 //            return redirect()->back()->with('message','Xóa mã khuyến mãi thành công!');
 //        }
	// }

    public function delete_coupon($coupon_id){
    	$coupon = CouponModels::find($coupon_id);	
    	$coupon->delete();
    	Session::put('message','Xóa mã giảm giá thành công!');
        return Redirect::back();
    }


}
