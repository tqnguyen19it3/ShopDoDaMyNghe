<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\CategoryModels;
use App\Models\CustomerModels;
use App\Models\PostCateModels;
use App\Models\ProductModels;
use App\Models\SliderModels;
use App\Http\Requests;
use Session;
use Mail;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    //

    public function AuthLogin(){
        $customer_id = Session::get('customer_id');  
        if($customer_id){                                      
            return Redirect::to('/');              
        }else return Redirect::to('/khach-hang-dang-nhap')->send();
    }

	public function index(Request $request){

		$meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Đồ đá mỹ nghệ Non Nước";
        $url_canonical = $request->url();
        
        $slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status' , '1')->take(3)->get();
		$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
		// $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id','desc')->get();

        //sp bán chạy
		$selling_products = DB::table('tbl_product')->where('product_status', '1')->orderby('product_sold','desc')->take(4)->get();

    	return view('parent_page.home')->with('category',$cate_product)->with('category_post',$cate_post)->with('slider',$slider)->with('selling_products',$selling_products)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
	}

	public function home_shop(Request $request){

		$meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Cửa hàng đồ đá mỹ nghệ Non Nước";
        $url_canonical = $request->url();

		$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();


        if(isset($_GET['sort_by'])){

            $sort_by = $_GET['sort_by'];

            if($sort_by == 'homeshop_product_characters_az'){

                $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_name','ASC')->paginate(9)->appends(request()->query());

            }elseif($sort_by == 'homeshop_product_characters_za'){

                $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_name','DESC')->paginate(9)->appends(request()->query());

            }elseif($sort_by == 'homeshop_product_price_ascending'){

                $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_price','ASC')->paginate(9)->appends(request()->query());

            }elseif($sort_by == 'homeshop_product_price_decrease'){

                $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_price','DESC')->paginate(9)->appends(request()->query());

            }
            elseif($sort_by == 'homeshop_product_id'){

                $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','DESC')->paginate(9)->appends(request()->query());

            }

        }else{

            $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id','DESC')->paginate(9);

        }

    	return view('parent_page.home_shop')->with('category',$cate_product)->with('category_post',$cate_post)->with('all_product',$all_product)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
	}

	public function contact(Request $request){

		$meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Liên hệ";
        $url_canonical = $request->url();

		$cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();

    	return view('parent_page.contact.contact')->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
	}

	public function send_mail(Request $request){
         //send mail
                $to_name = $request->contact_name;;
                $to_email = $request->contact_email;
                $phonenumber = $request->contact_phonenumber;
                $body = $request->contact_message;

                $data = array("email"=>$to_email, "name"=>$to_name,"sdt"=>$phonenumber,"body"=>$body); //body of mail.blade.php

                Mail::send('parent_page.contact.send_mail',$data,function($message) use ($to_name, $to_email){
                    
                    $message->to('drhappykun.tqn@gmail.com')->subject('Thư phản hồi từ khách hàng shop đồ đá');//send this mail with subject
                    $message->from($to_email,$to_name);
                });
                //--send mail
                // return Redirect::to('/')->with('message','');
                return redirect()->back();

    }

    public function about_us(Request $request){

        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Cửa hàng đồ đá mỹ nghệ Non Nước";
        $url_canonical = $request->url();

        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
        
        return view('parent_page.about.about_us')->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }

    public function customer_profile(Request $request, $customer_id){

        $this->AuthLogin();

        $meta_desc = "Chuyên bán những đồ điêu khắc đá mỹ nghệ thủ công, xuất sứ từ làng đá mỹ nghệ Non Nước, Ngũ Hành Sơn, Đà Nẵng";
        $meta_keywords = "đồ đá mỹ nghệ thủ công, do da my nghe thu cong, da dieu khac, đá điêu khắc";
        $meta_title = "Thông tin tài khoản khách hàng";
        $url_canonical = $request->url();

        $user = CustomerModels::where('customer_id', $customer_id)->first();

        $cate_product = CategoryModels::where('category_status', '1')->orderby('category_id','desc')->get();
        $cate_post = PostCateModels::where('category_post_status', '1')->orderby('category_post_id','desc')->get();
        
        return view('parent_page.customer.account_profile')->with('user', $user)->with('category',$cate_product)->with('category_post',$cate_post)->with('meta_desc',$meta_desc)->with('meta_title', $meta_title)->with('meta_keywords',$meta_keywords)->with('url_canonical',$url_canonical);
    }

    public function autocomplete_ajax(Request $request){

        $data = $request->all();


        if($data['query']){

            $product = ProductModels::where('product_status', 1)->where('product_name', 'LIKE', '%'.$data['query'].'%')->get();

            $output = '<ul class = "dropdown-menu" style="display: block; position:relative;">';

                foreach ($product as $key => $value) {
                    $output .='<li class="li_search_ajax"><a href="#" style="color:red;">'.$value->product_name.'</a></li>';
                }

            $output .= '</ul>';
            echo $output;
        }

    }


}