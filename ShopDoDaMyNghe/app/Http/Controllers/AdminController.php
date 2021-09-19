<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\AdminModels;
use App\Models\StatisticalModels;
use App\Models\VisitorsModels;
use App\Models\ProductModels;
use App\Models\PostModels;
use App\Models\OrderModels;
use App\Models\CouponModels;
use App\Models\CustomerModels;
use App\Http\Requests;
use Session;
use App\Rules\CaptchaRules;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    //

    public function AuthLoginAdmin(){
        $admin_id = Session::get('admin_id');  
        if($admin_id){                                      
            return Redirect::to('/admin-dashboard');              
        }else return Redirect::to('/login-form-admin')->send();   
    }

    public function login_form_admin(){
		return view('admin_page.admin_login');
	}

	public function show_dashboard(Request $request){
		$this->AuthLoginAdmin();

        $user_ip_address = $request->ip();

        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $one_year = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();


        //today last month 
        $visitors_of_lastmonth = VisitorsModels::whereBetween('date_visitors', [$early_last_month, $end_of_last_month])->get();
        $visitors_lastmonth_count = $visitors_of_lastmonth->count();
        //today this month 
        $visitors_of_thismonth = VisitorsModels::whereBetween('date_visitors', [$early_this_month, $now])->get();
        $visitors_thismonth_count = $visitors_of_thismonth->count();
         //today last year
        $visitors_of_year = VisitorsModels::whereBetween('date_visitors', [$early_this_month, $now])->get();
        $visitors_year_count = $visitors_of_year->count();


        //current online 
        $visitors_current = VisitorsModels::where('ip_visitors', $user_ip_address)->get();
        $visitors_count = $visitors_current->count();
        if($visitors_count < 1){
            $visitors = new VisitorsModels();
            $visitors->ip_visitors = $user_ip_address;
            $visitors->date_visitors = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitors->save();
        }

        //total visitors
        $visitors = VisitorsModels::all();
        $visitors_total = $visitors->count();

        //total
        $product_donut = ProductModels::all()->count();
        $post_donut = PostModels::all()->count();
        $order_donut = OrderModels::all()->count();
        $coupon_donut = CouponModels::all()->count();
        $customer_donut = CustomerModels::all()->count();

        //views
        $post_views = PostModels::orderBy('post_views', 'DESC')->take(10)->get();
        $product_views = ProductModels::orderBy('product_views', 'DESC')->take(15)->get();

		return view('admin_page.dashboard.admin_dashboard')->with(compact('visitors_count', 'visitors_total', 'visitors_lastmonth_count','visitors_thismonth_count', 'visitors_year_count', 'product_donut', 'post_donut', 'order_donut', 'coupon_donut', 'customer_donut','post_views','product_views'));
	}

	public function login_admin(Request $request){

        $data1 = $request->all();

        $data = $request->validate([
            //validation laravel 
            'adminEmail' => 'required',
            'adminPassword' => 'required',
            'g-recaptcha-response' => new CaptchaRules(),
        ]);

        $admin_email = $data1['adminEmail'];
        $admin_password = md5($data1['adminPassword']);

        $result = AdminModels::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();

        if($result){
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return Redirect::to('/admin-dashboard');
        }
        else{
           Session::put('message', 'Tài Khoản hoặc mật khẩu không hợp lệ');
            return Redirect::to('/login-form-admin');
        }

	}

    public function logout_admin(){
      
    	Session::put('admin_name', null);
    	Session::put('admin_id', null);
    	return Redirect::to('/login-form-admin');
    }


    public function filter_by_date(Request $request){ //load chart theo phạm vi tự set

        $data = $request->all();
        $from_date = $data['fromDate'];
        $to_date = $data['toDate'];

        $get = StatisticalModels::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $value) {
            
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            ); 

        }
        echo $data = json_encode($chart_data);
    }
    
    public function dashboard_filter(Request $request){ //load chart theo select option

        $data = $request->all();

        // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        // $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('d-m-Y H:i:s');
        // $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->format('d-m-Y H:i:s');
        // $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(15)->format('d-m-Y H:i:s');
        // $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->format('d-m-Y H:i:s');

        $dau_thang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();;
        $cuoi_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();;

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $now =  Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value'] == '7ngayqua'){
            $get = StatisticalModels::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == 'thangtruoc'){
            $get = StatisticalModels::whereBetween('order_date', [$dau_thang_truoc, $cuoi_thang_truoc])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == 'thangnay'){
            $get = StatisticalModels::whereBetween('order_date', [$dau_thang_nay, $now])->orderBy('order_date', 'ASC')->get();
        }elseif($data['dashboard_value'] == '365ngayqua'){
            $get = StatisticalModels::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }

        foreach ($get as $key => $value) {
            
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            ); 

        }


        echo $data = json_encode($chart_data);
    }

    public function days_order(Request $request){ //auto load chart theo 15 ngày qua khi truy cập vào dashboard

        $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(15)->toDateString();

        $now =  Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = StatisticalModels::whereBetween('order_date', [$sub15days, $now])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $value) {
            
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            ); 

        }
        echo $data = json_encode($chart_data);
    }

}


