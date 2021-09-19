<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\SliderModels;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class SliderController extends Controller
{
    //

    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');              
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function add_slider(){
    	$this->AuthLoginAdmin();
    	return view('admin_page.dashboard.banner.add_slider');
    }

    public function save_slider(Request $request){
    	$this->AuthLoginAdmin();

    	$data = $request->all();
    	$post_slider = new SliderModels();
    	$post_slider->slider_desc = $data['slider_desc'];
    	$post_slider->slider_status = $data['slider_status'];

    	$get_image = $request->file('slider_image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); 
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            $get_image->move('./public/Uploads/banner', $new_custom_name_image);
            $post_slider->slider_img = $new_custom_name_image;
            $post_slider->save();
            Session::put('message', 'Đã thêm mới slider');
            return redirect()->back();
        }else{
        	Session::put('message','Làm ơn hãy thêm hình ảnh slider!');
        	return redirect()->back();
        }
    }
    public function manage_slider(){
    	$this->AuthLoginAdmin();
    	$all_slider = SliderModels::orderBy('slider_id','DESC')->get();
    	return view('admin_page.dashboard.banner.manage_slider')->with(compact('all_slider'));
    }

    public function unactive_slider($slider_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status'=>0]);
    	Session::put('message', 'Slider đã bị ẩn ở trang chính!');
    	return Redirect::to('/manage-slider');
    }
    public function active_slider($slider_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status'=>1]);
    	Session::put('message', 'Slider đã được cho hiển thị ở trang chính!');
    	return Redirect::to('/manage-slider');
    }

    public function delete_slider($slider_id){

    	$posts_slider = SliderModels::find($slider_id);
    	$posts_slider_img = $posts_slider->slider_img;

    	if($posts_slider_img){
    		$path = './public/Uploads/banner/'.$posts_slider_img;
    		unlink($path);
    	}

    	$posts_slider->delete();
    	
    	Session::put('message', 'Đã xóa slider.');
    	return redirect()->back();
    }
}
