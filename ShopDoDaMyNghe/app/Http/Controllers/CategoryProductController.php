<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\CategoryModels;
use App\Models\ProductModels;
use App\Models\PostCateModels;
use App\Imports\CategoryExcelImports;
use App\Exports\CategoryExcelExports;
use Excel;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProductController extends Controller
{
    public function AuthLoginAdmin(){                            //hàm kiểm tra đăng nhập
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');            
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function add_category_product(){
        $this->AuthLoginAdmin();
    	return view('admin_page.dashboard.category.add_category_product');
    }

    public function save_category_product(Request $request){

        $this->AuthLoginAdmin();

        $data = $request->all();
        $cate = new CategoryModels();

        $cate->category_name = $data['category_product_name'];
        $cate->category_desc = $data['category_product_desc'];
        $cate->category_status = $data['category_product_status'];
        $cate->meta_cate_keywords = $data['category_product_keywords'];
            if (!function_exists('create_slug')) {
                                            function create_slug($string)
                                            {
                                                $search = array(
                                                    '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|ä)#',
                                                    '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
                                                    '#(ì|í|ị|ỉ|ĩ)#',
                                                    '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ö)#',
                                                    '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ü)#',
                                                    '#(ỳ|ý|ỵ|ỷ|ỹ)#',
                                                    '#(đ)#',
                                                    '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Ä)#',
                                                    '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
                                                    '#(Ì|Í|Ị|Ỉ|Ĩ)#',
                                                    '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ö)#',
                                                    '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ü)#',
                                                    '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
                                                    '#(Đ)#',
                                                    '#(ß)#',
                                                    "/[^a-zA-Z0-9\-\_]/",
                                                );
                                                $replace = array(
                                                    'a',
                                                    'e',
                                                    'i',
                                                    'o',
                                                    'u',
                                                    'y',
                                                    'd',
                                                    'A',
                                                    'E',
                                                    'I',
                                                    'O',
                                                    'U',
                                                    'Y',
                                                    'D',
                                                    'B',
                                                    '-',
                                                );
                                                $string = preg_replace($search, $replace, $string);
                                                $string = preg_replace('/(-)+/', '-', $string);
                                                $string = strtolower($string);
                                                return $string;
                                            }
                                        }
        $cate->category_slug = create_slug($cate->category_name);

        $get_image = $request->file('category_product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); //current(explode('.', $get_name_image)); chia chuỗi ra để cắt đuôi từ dấu chấm
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            //getClientOriginalExtention():lấy đuôi mở rộng
            $get_image->move('./public/Uploads/category', $new_custom_name_image);
            $cate->category_image = $new_custom_name_image;
            $cate->save();
            Session::put('message', 'Thêm thành công danh mục sản phẩm!');
            return Redirect::to('/add-category-product');
        }

        $cate->category_image = '';
        $cate->save();

    	Session::put('message', 'Thêm danh mục sản phẩm thành công!');
    	return Redirect::to('/add-category-product');
    }

    public function all_category_product(){
        $this->AuthLoginAdmin();
        $all_category_product = CategoryModels::orderBy('category_id','DESC')->paginate(5);
    	// $all_category_product = DB::table('tbl_category_product')->get();
    	$manager_category_product = view('admin_page.dashboard.category.all_category_product')->with('all_category_product', $all_category_product);
    	return view('admin_page.admin_layout')->with('admin_page.dashboard.category.all_category_product', $manager_category_product);
    }

	public function edit_category_product($category_product_slug, $category_product_id){
        $this->AuthLoginAdmin();
        $edit_category_product = CategoryModels::where('category_id',$category_product_id)->get();
    	// $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
    	$manager_category_product = view('admin_page.dashboard.category.edit_category_product')->with('edit_category_product', $edit_category_product);
    	return view('admin_page.admin_layout')->with('admin_page.dashboard.category.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request, $category_product_id){
        $this->AuthLoginAdmin();

        $data = $request->all();
        $cate = CategoryModels::find($category_product_id);
        $cate->category_name = $data['category_product_name'];
        $cate->category_desc = $data['category_product_desc'];
        $cate->meta_cate_keywords = $data['category_product_keywords'];

        if (!function_exists('create_slug')) {
                                            function create_slug($string)
                                            {
                                                $search = array(
                                                    '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|ä)#',
                                                    '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
                                                    '#(ì|í|ị|ỉ|ĩ)#',
                                                    '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ö)#',
                                                    '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ü)#',
                                                    '#(ỳ|ý|ỵ|ỷ|ỹ)#',
                                                    '#(đ)#',
                                                    '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Ä)#',
                                                    '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
                                                    '#(Ì|Í|Ị|Ỉ|Ĩ)#',
                                                    '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ö)#',
                                                    '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ü)#',
                                                    '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
                                                    '#(Đ)#',
                                                    '#(ß)#',
                                                    "/[^a-zA-Z0-9\-\_]/",
                                                );
                                                $replace = array(
                                                    'a',
                                                    'e',
                                                    'i',
                                                    'o',
                                                    'u',
                                                    'y',
                                                    'd',
                                                    'A',
                                                    'E',
                                                    'I',
                                                    'O',
                                                    'U',
                                                    'Y',
                                                    'D',
                                                    'B',
                                                    '-',
                                                );
                                                $string = preg_replace($search, $replace, $string);
                                                $string = preg_replace('/(-)+/', '-', $string);
                                                $string = strtolower($string);
                                                return $string;
                                            }
                                        }
        $cate->category_slug = create_slug($cate->category_name);
        $get_image = $request->file('category_product_image');

        if($get_image){
            $category = DB::table('tbl_category_product')->where('category_id', $category_product_id)->first();
            $img = $category->category_image;
            if($img){
                $path = './public/Uploads/category/'.$img;
                unlink($path);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            $get_image->move('./public/Uploads/category', $new_custom_name_image);
            $cate->category_image = $new_custom_name_image;
            $cate->save();
            Session::put('message', 'Cập nhật danh mục thành công!');
            return Redirect::to('/all-category-product');
        }
        $cate->save();
    	Session::put('message', 'Cập nhật danh mục thành công!');
    	return Redirect::to('/all-category-product');
    }

 	public function active_category_product($category_product_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>1]);
    	Session::put('message', 'Hiển thị danh mục thành công!');
    	return Redirect::back();
    }

    public function unactive_category_product($category_product_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>0]);
    	Session::put('message', 'Ẩn danh mục thành công!');
    	return Redirect::back();
    }
   
    
    public function delete_category_product($category_product_id){
        $this->AuthLoginAdmin();

        $category = DB::table('tbl_category_product')->where('category_id', $category_product_id)->first();
        $img = $category->category_image;
        if($img){
            $path = './public/Uploads/category/'.$img;
            unlink($path);
        }
    	DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
    	Session::put('message', 'Xóa danh mục thành công!');
    	return Redirect::back();
    }

    public function export_csv_category(){
        return Excel::download(new CategoryExcelExports , 'category_product.xlsx');
    }
    public function import_csv_category(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new CategoryExcelImports, $path);
        return back();
    }

    public function show_category_home(Request $request, $category_slug, $category_id){
        
        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
        $cate_product2 = CategoryModels::where('category_status', '1')->where('category_id', $category_id)->get();

        
        if(isset($_GET['sort_by'])){

            $sort_by = $_GET['sort_by'];

            if($sort_by == 'cateshop_product_characters_az'){

                $category_by_id = ProductModels::with('category')->where('category_id',$category_id)->where('product_status', '1')->orderby('product_name','ASC')->paginate(6)->appends(request()->query());

            }elseif($sort_by == 'cateshop_product_characters_za'){

                $category_by_id = ProductModels::with('category')->where('category_id',$category_id)->where('product_status', '1')->orderby('product_name','DESC')->paginate(6)->appends(request()->query());

            }elseif($sort_by == 'cateshop_product_price_ascending'){

                $category_by_id = ProductModels::with('category')->where('category_id',$category_id)->where('product_status', '1')->orderby('product_price','ASC')->paginate(6)->appends(request()->query());

            }elseif($sort_by == 'cateshop_product_price_decrease'){

                $category_by_id = ProductModels::with('category')->where('category_id',$category_id)->where('product_status', '1')->orderby('product_price','DESC')->paginate(6)->appends(request()->query());

            }
            elseif($sort_by == 'cateshop_product_id'){

                $category_by_id = ProductModels::with('category')->where('category_id',$category_id)->where('product_status', '1')->orderby('product_id','DESC')->paginate(6)->appends(request()->query());

            }

        }else{
            
            $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_category_product.category_id',$category_id)->where('product_status', '1')->where('category_status', '1')->orderby('product_id','desc')->paginate(6);

        }


        foreach ($cate_product2 as $key => $value) {
            // SEO
            $meta_desc = $value->category_desc;
            $meta_keywords = $value->meta_cate_keywords;
            $meta_title = $value->category_name;
            $url_canonical = $request->url();
            // END SEO
        }

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_slug', $category_slug)->where('tbl_category_product.category_id', $category_id)->first();

        //danh mục có sản phẩm
            if(count($category_by_id) != 0){

                return view('parent_page.category.show_category_product')->with('category',$cate_product)->with('category_post',$cate_post)->with('category_by_id', $category_by_id)->with('category_name', $category_name)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
            }else{
                Session::put('message', 'Hiện tại danh mục này chưa có sản phẩm nào!');
                return view('parent_page.category.show_category_product')->with('category_by_id', $category_by_id)->with('category',$cate_product)->with('category_post',$cate_post)->with('category_name', $category_name)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
            }
        
    }
}
