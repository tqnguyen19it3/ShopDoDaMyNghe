<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\CategoryModels;
use App\Models\PostCateModels;
use App\Models\ProductModels;
use App\Models\GalleryModels;
use App\Imports\ProductExcelImports;
use App\Exports\ProductExcelExports;
use Excel;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');            
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function add_product(){
        $this->AuthLoginAdmin();
    	$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();

    	return view('admin_page.dashboard.product.add_product')->with('cate_product', $cate_product);
    }

    public function save_product(Request $request){
        $this->AuthLoginAdmin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
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
                                        $data['product_slug'] = create_slug($data['product_name']);
        $data['product_quantity'] = $request->product_quantity;
        $data['product_sold'] = 0;
        $num_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $num_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $data['product_cost'] = $num_cost;
    	$data['product_price'] = $num_price;
    	$data['product_desc'] = $request->product_desc;
    	$data['product_content'] = $request->product_content;
    	$data['category_id'] = $request->product_cate;
    	$data['product_status'] = $request->product_status;
        $data['meta_product_keywords'] = $request->meta_product_keywords;
    	$get_image = $request->file('product_image');

    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.', $get_name_image));
    		$new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
    		$get_image->move('./public/Uploads/product', $new_custom_name_image);
    		$data['product_image'] = $new_custom_name_image;
	    	DB::table('tbl_product')->insert($data);
	    	Session::put('message', 'Thêm thành công!');
	    	return Redirect::to('/add-product');
    	}

    	$data['product_image'] = '';
    	DB::table('tbl_product')->insert($data);
    	Session::put('message', 'Thêm sản phẩm thành công!');			//truong hop nay la ko co anh
    	return Redirect::to('/add-product');
    }

    public function all_product(){
        $this->AuthLoginAdmin();
    	$all_product = DB::table('tbl_product')
    	->join('tbl_category_product','tbl_category_product.category_id', '=', 'tbl_product.category_id')
    	->orderby('tbl_product.product_id', 'desc')->paginate(5);

    	$manager_product = view('admin_page.dashboard.product.all_product')->with('all_product', $all_product);
    	return view('admin_page.admin_layout')->with('admin_page.dashboard.product.all_product', $manager_product);
    }

    public function edit_product($product_slug, $product_id){
        $this->AuthLoginAdmin();
    	$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();

    	$edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
    	$manager_product = view('admin_page.dashboard.product.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product);
    	return view('admin_page.admin_layout')->with('admin_page.dashboard.product.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id){
        $this->AuthLoginAdmin();
    	$data = array();
    	$data['product_name'] = $request->product_name;
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
                                        $data['product_slug'] = create_slug($data['product_name']);
        $num_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $num_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $data['product_cost'] = $num_cost;
        $data['product_price'] = $num_price;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['product_quantity'] = $request->product_quantity;
        $data['meta_product_keywords'] = $request->meta_product_keywords;
        $get_image = $request->file('product_image');

        if($get_image){
        	$product = DB::table('tbl_product')->where('product_id', $product_id)->first();
	    	$img = $product->product_image;
	    	if($img){
	    		$path = './public/Uploads/product/'.$img;
	    		unlink($path);
	    	}
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); 
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            $get_image->move('./public/Uploads/product', $new_custom_name_image);
            $data['product_image'] = $new_custom_name_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Cập nhật sản phẩm thành công!');
            return Redirect::to('/all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Cập nhật sản phẩm thành công!');
    	return Redirect::to('/all-product');
    }

    public function active_product($product_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>1]);
    	Session::put('message', 'Hiển thị sản phẩm thành công!');
    	return Redirect::back();
    }

    public function unactive_product($product_id){
        $this->AuthLoginAdmin();
    	DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status'=>0]);
    	Session::put('message', 'Ẩn sản phẩm thành công!');
    	return Redirect::back();
    }

    
    public function delete_product($product_id){
        $this->AuthLoginAdmin();

        $product = DB::table('tbl_product')->where('product_id', $product_id)->first();
    	$img = $product->product_image;
    	if($img){
    		$path = './public/Uploads/product/'.$img;
    		unlink($path);
    	}
    	DB::table('tbl_product')->where('product_id', $product_id)->delete();
    	Session::put('message', 'Xóa sản phẩm thành công!');
    	return Redirect::back();
    }


    public function export_csv_product(){
        return Excel::download(new ProductExcelExports , 'product.xlsx');
    }
    public function import_csv_product(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ProductExcelImports, $path);
        return back();
    }

    //chi tiet san pham
    public function details_product(Request $request, $product_slug, $product_id){

        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach ($details_product as $key => $value) {

            $category_id = $value->category_id;
            $product_id = $value->product_id;
            // SEO
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->meta_product_keywords;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
            // END SEO
            $views_product_id = $value->product_id;
        }

        //update views
        $product = ProductModels::where('product_id', $views_product_id)->first();
        $product->product_views =  $product->product_views + 1;
        $product->save();

        //sp liên quan
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->where('tbl_product.product_status', 1)->orderby('product_id','desc')->take(4)->get();

        //gallery
        $gallery = GalleryModels::where('product_id', $product_id)->orderby('gallery_id','desc')->take(3)->get();
        $gallery_product = GalleryModels::where('product_id', $product_id)->get();

        return view('parent_page.details_product.show_details')->with('category',$cate_product)->with('category_post',$cate_post)->with('product_details',$details_product)->with('related', $related_product)->with('gallery',$gallery)->with('gallery_product',$gallery_product)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }

    public function add_gallery_product($product_id){
        $this->AuthLoginAdmin();
        $pro_id = $product_id;
        return view('admin_page.dashboard.gallery.add_gallery_product')->with(compact('pro_id'));
    }

    public function select_gallery_product(Request $request){

        $product_id = $request->pro_id;
        $gallery = GalleryModels::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();
        $output = '<form>'.csrf_field().'
                <table class="table">
                    <thead class="thead-dark" style="color: #fff; background-color: #343a40;">
                        <tr>
                            <td>Thứ tự</td>
                            <th>Tên ảnh</th>
                            <th>Hình ảnh</th>
                            <th>Thao tác</th>
                         </tr>
                     </thead>
                    <tbody>';
        if($gallery_count > 0){
            $i = 0;
            foreach ($gallery as $key => $value) {
                $i++;
                $output .= '<tr>
                                <td>'. $i .'</td>
                                <td contenteditable class="edit_gal_name_pro" data-gal_id="'.$value->gallery_id.'">'. $value->gallery_name .'</td>
                                <td><img src="'.url('./public/Uploads/gallery/'.$value->gallery_img).'" width="100" height="100" alt="Gallery Product"</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-danger delete-gallery-product" data-gal_id="'.$value->gallery_id.'">Xóa</button>
                                </td>
                            </tr>';
            }
        }else{
            $output .=' <tr>
                            <td colspan="4"><strong style="color:red;">Sản phẩm này chưa được thêm thư viện ảnh<strong></td>
                        </tr>';
        }
        $output .='</tbody></table></form>';
        echo $output;
        // return view('admin_page.dashboard.gallery.add_gallery_product')->with(compact('pro_id'));
    }
    public function insert_gallery_product(Request $request, $product_id){

        $get_images = $request->file('file');
        if($get_images){
            foreach ($get_images as $image) {
                $get_name_image = $image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$image->getClientOriginalExtension(); 
                $image->move('./public/Uploads/gallery', $new_custom_name_image);
                $gallery = new GalleryModels();
                $gallery->gallery_name = $new_custom_name_image;
                $gallery->gallery_img = $new_custom_name_image;
                $gallery->product_id = $product_id;
                $gallery->save();
            }
        }
        Session::put('message', 'Thêm thư viện ảnh thành công!');
        return redirect()->back();

    }

    public function update_gallery_name_product(Request $request){

        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = GalleryModels::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save();
    }

    public function delete_gallery_product(Request $request){

        $gal_id = $request->gal_id;
        $gallery = GalleryModels::find($gal_id);

        $path = './public/Uploads/gallery/'.$gallery->gallery_img;
        unlink($path);
        $gallery->delete();
    }

}
