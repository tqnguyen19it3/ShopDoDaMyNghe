<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\CategoryModels;
use App\Models\PostCateModels;
use App\Models\PostModels;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class PostController extends Controller
{
    //
    public function AuthLoginAdmin(){                      
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');            
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function add_category_post(){
        $this->AuthLoginAdmin();
    	return view('admin_page.dashboard.category.add_category_post');
    }

    public function save_category_post(Request $request){

        $this->AuthLoginAdmin();

        $data = $request->all();
        $cate = new PostCateModels();

        $cate->category_post_name = $data['category_post_name'];
        $cate->category_post_desc = $data['category_post_desc'];
        $cate->category_post_status = $data['category_post_status'];
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
        $cate->category_post_slug = create_slug($cate->category_post_name);

        $cate->save();

    	Session::put('message', 'Thêm danh mục bài viết thành công!');
    	return Redirect::to('/add-category-post');
    }

    public function all_category_post(){
        $this->AuthLoginAdmin();
        $all_category_post = PostCateModels::orderBy('category_post_id','DESC')->paginate(5);
        $manager_category_post = view('admin_page.dashboard.category.all_category_post')->with('all_category_post', $all_category_post);
        return view('admin_page.admin_layout')->with('admin_page.dashboard.category.all_category_post', $manager_category_post);
    }

    public function edit_category_post($category_post_slug, $category_post_id){
        $this->AuthLoginAdmin();
        $edit_category_post = PostCateModels::where('category_post_id',$category_post_id)->get();
        $manager_category_post = view('admin_page.dashboard.category.edit_category_post')->with('edit_category_post', $edit_category_post);
        return view('admin_page.admin_layout')->with('admin_page.dashboard.category.edit_category_post', $manager_category_post);
    }

    public function update_category_post(Request $request, $category_post_id){
        $this->AuthLoginAdmin();

        $data = $request->all();
        $cate = PostCateModels::find($category_post_id);
        $cate->category_post_name = $data['category_post_name'];
        $cate->category_post_desc = $data['category_post_desc'];

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
        $cate->category_post_slug = create_slug($cate->category_post_name);
       
        $cate->save();
        Session::put('message', 'Cập nhật danh mục bài viết thành công!');
        return Redirect::to('/all-category-post');
    }

    public function active_category_post($category_post_id){
        $this->AuthLoginAdmin();
        DB::table('tbl_category_post')->where('category_post_id', $category_post_id)->update(['category_post_status'=>1]);
        Session::put('message', 'Hiển thị danh mục thành công!');
        return Redirect::back();
    }

    public function unactive_category_post($category_post_id){
        $this->AuthLoginAdmin();
        DB::table('tbl_category_post')->where('category_post_id', $category_post_id)->update(['category_post_status'=>0]);
        Session::put('message', 'Ẩn danh mục thành công!');
        return Redirect::back();
    }
   
    
    public function delete_category_post($category_post_id){
        $this->AuthLoginAdmin();

        $category = DB::table('tbl_category_post')->where('category_post_id', $category_post_id)->first();

        DB::table('tbl_category_post')->where('category_post_id', $category_post_id)->delete();
        Session::put('message', 'Xóa danh mục thành công!');
        return Redirect::back();
    }

    public function add_post(){
        $this->AuthLoginAdmin();

        $cate_post= PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();

        return view('admin_page.dashboard.post.add_post')->with('cate_post', $cate_post);
    }

    public function save_post(Request $request){

        $this->AuthLoginAdmin();

        $data = $request->all();
        $post = new PostModels();

        $post->post_name = $data['post_name'];
        $post->post_desc = $data['post_desc'];
        $post->category_post_id = $data['post_cate'];
        $post->post_status = $data['post_status'];
        $post->post_content = $data['post_content'];
        $post->meta_post_keywords = $data['meta_post_keywords'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $post->created_at = now();
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
        $post->post_slug = create_slug($post->post_name);

        $get_image = $request->file('post_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); 
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            //getClientOriginalExtention():lấy đuôi mở rộng
            $get_image->move('./public/Uploads/post', $new_custom_name_image);
            $post->post_image = $new_custom_name_image;
            $post->save();
            Session::put('message', 'Thêm bài viết thành công!');
            return Redirect::to('/add-post');
        }

        $post->post_image = '';
        $post->save();

        Session::put('message', 'Thêm bài viết thành công!');
        return Redirect::to('/add-post');
    }

    public function all_post(){
        $this->AuthLoginAdmin();

        $all_post = PostModels::join('tbl_category_post','tbl_category_post.category_post_id', '=', 'tbl_post.category_post_id')->orderby('tbl_post.post_id', 'desc')->paginate(5);

        $manager_post = view('admin_page.dashboard.post.all_post')->with('all_post', $all_post);
        return view('admin_page.admin_layout')->with('admin_page.dashboard.post.all_post', $manager_post);
    }

    public function edit_post($post_slug, $post_id){
        $this->AuthLoginAdmin();

        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
        $edit_post = PostModels::where('post_id',$post_id)->get();

        $manager_post = view('admin_page.dashboard.post.edit_post')->with('edit_post', $edit_post)->with('cate_post', $cate_post);
        return view('admin_page.admin_layout')->with('admin_page.dashboard.post.edit_post', $manager_post);
    }

    public function update_post(Request $request, $post_id){
        $this->AuthLoginAdmin();

        $data = $request->all();
        $post = PostModels::find($post_id);
        $post->post_name = $data['post_name'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->category_post_id = $data['post_cate'];
        $post->meta_post_keywords = $data['meta_post_keywords'];

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
        $post->post_slug = create_slug($post->post_name);
        $get_image = $request->file('post_image');

        if($get_image){
            $pst = DB::table('tbl_post')->where('post_id', $post_id)->first();
            $img = $pst->post_image;
            if($img){
                $path = './public/Uploads/post/'.$img;
                unlink($path);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
            $get_image->move('./public/Uploads/post', $new_custom_name_image);
            $post->post_image = $new_custom_name_image;
            $post->save();
            Session::put('message', 'Cập nhật bài viết thành công!');
            return Redirect::to('/all-post');
        }
        $post->save();
        Session::put('message', 'Cập nhật bài viết thành công!');
        return Redirect::to('/all-post');
    }


    public function active_post($post_id){
        $this->AuthLoginAdmin();
        DB::table('tbl_post')->where('post_id', $post_id)->update(['post_status'=>1]);
        Session::put('message', 'Hiển thị bài viết thành công!');
        return Redirect::back();
    }

    public function unactive_post($post_id){
        $this->AuthLoginAdmin();
        DB::table('tbl_post')->where('post_id', $post_id)->update(['post_status'=>0]);
        Session::put('message', 'Ẩn bài viết thành công!');
        return Redirect::back();
    }

    
    public function delete_post($post_id){
        $this->AuthLoginAdmin();

        $post = DB::table('tbl_post')->where('post_id', $post_id)->first();
        $img = $post->post_image;
        if($img){
            $path = './public/Uploads/post/'.$img;
            unlink($path);
        }
        DB::table('tbl_post')->where('post_id', $post_id)->delete();
        Session::put('message', 'Xóa bài viết thành công!');
        return Redirect::back();
    }

    
    public function show_category_post_home(Request $request, $category_post_slug, $category_post_id){
        
        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
        $cate_post2 = PostCateModels::where('category_post_status', '1')->where('category_post_id', $category_post_id)->get();

        $category_post_by_id = DB::table('tbl_post')->join('tbl_category_post','tbl_post.category_post_id','=','tbl_category_post.category_post_id')->where('tbl_category_post.category_post_id',$category_post_id)->where('post_status', '1')->where('category_post_status', '1')->orderby('post_id','desc')->paginate(6);

        foreach ($cate_post2 as $key => $value) {
            // SEO
            $meta_desc = $value->category_post_desc;
            $meta_keywords = "";
            $meta_title = $value->category_post_name;
            $url_canonical = $request->url();
            // END SEO
        }


        //danh mục có sản phẩm
            if(count($category_post_by_id) != 0){

                return view('parent_page.news_blog.show_all_post_home')->with('category',$cate_product)->with('category_post',$cate_post)->with('category_post_by_id', $category_post_by_id)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
            }else{
                Session::put('message', 'Hiện tại danh mục này chưa có bài viết nào!');
                return view('parent_page.news_blog.show_all_post_home')->with('category',$cate_product)->with('category_post',$cate_post)->with('category_post_by_id', $category_post_by_id)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
            }
        
    }

    
    public function details_post_home(Request $request, $post_slug, $post_id){

        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();

        $details_post = PostModels::join('tbl_category_post','tbl_category_post.category_post_id', '=', 'tbl_post.category_post_id')->where('tbl_post.post_id', $post_id)->get();

        foreach ($details_post as $key => $value) {

            $category_post_id = $value->category_post_id;
            $post_id = $value->post_id;
            // SEO
            $meta_desc = $value->post_desc;
            $meta_keywords = $value->meta_post_keywords;
            $meta_title = $value->post_name;
            $url_canonical = $request->url();
            // END SEO
            $views_post_id = $value->post_id;
        }

        //update views
        $post = PostModels::where('post_id', $views_post_id)->first();
        $post->post_views =  $post->post_views + 1;
        $post->save();


        //bài viết liên quan
        $related_post = PostModels::join('tbl_category_post','tbl_category_post.category_post_id', '=', 'tbl_post.category_post_id')->where('tbl_post.category_post_id',$category_post_id)->whereNotIn('tbl_post.post_id',[$post_id])->where('tbl_post.post_status', 1)->orderby('post_id','desc')->take(4)->get();

        return view('parent_page.news_blog.show_details_post')->with('category',$cate_product)->with('category_post',$cate_post)->with('post_details',$details_post)->with('related', $related_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }
}
