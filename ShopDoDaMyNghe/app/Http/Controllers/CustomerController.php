<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\CustomerModels;
use App\Models\SocialModels;
use Socialite;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
session_start();

class CustomerController extends Controller
{
    //

  	public function customer_form_register(Request $request){

		return view('parent_page.customer_register');
	}

	public function regist_customer(Request $request){
		$data = array();
		$data['customer_name'] = $request->cus_name;
		$data['customer_email'] = $request->cus_email;
		$data['customer_phone'] = $request->cus_phonenumber;
        $data['customer_gender'] = $request->cus_gender;
		$data['customer_password'] = md5($request->cus_password);
        $data['customer_avatar'] = "";

		$customer_id = DB::table('tbl_customer')->insertGetId($data);

		return Redirect::to('/khach-hang-dang-nhap');

	}

	public function customer_form_login(Request $request){

		return view('parent_page.customer_login');
	}

	public function login_customer(Request $request){

    	$data = $request->all();

        $customer_email = $data['cusEmail'];
        $customer_password = md5($data['cusPassword']);

        $result = CustomerModels::where('customer_email', $customer_email)->where('customer_password', $customer_password)->first();
        if($result){
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/trang-chu');
        }
        else{
            Session::put('message', 'Tài Khoản hoặc mật khẩu không hợp lệ');
            return Redirect::to('/khach-hang-dang-nhap');
        }
	}

	public function logout_customer(){
		$cus = Session::get('customer_id');
		if($cus == true){
			// Session::flush();
			Session::put('customer_name', null);
	    	Session::put('customer_id', null);
			return Redirect::to('/trang-chu');
		}
	}

	public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = SocialModels::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        
        if($account){
            $account_name = CustomerModels::where('customer_id',$account->user)->first();
            Session::put('login_normal', true);
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_name',$account_name->customer_id);
        }else{

            $social = new SocialModels([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = CustomerModels::where('customer_id',$provider->getEmail())->first();

            if(!$orang){
                $orang = CustomerModels::create([
                    'customer_name' => $provider->getName(),
                    'customer_email' => $provider->getEmail(),
                    'customer_password' => '',
                    'customer_phone' => '',
                    'customer_gender' => '',
                    'customer_avatar' => ''
                    
                ]);
            }
            $social->login()->associate($orang);
            $social->save();

            $account_name = CustomerModels::where('customer_id',$social->user)->first();
            Session::put('login_normal', true);
            Session::put('customer_name',$social->customer_name);
            Session::put('customer_id',$social->customer_id);
        }
        return redirect('/trang-chu')->with('message', 'Đăng nhập thành công'); 
    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){

        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUserGG($users,'google');
        if($authUser){
            $account_name = CustomerModels::where('customer_id',$authUser->user)->first();
            Session::put('login_normal', true);
            Session::put('customer_name', $account_name->customer_name);
            Session::put('customer_id', $account_name->customer_id);
        }elseif($customer_news){
            $account_name = CustomerModels::where('customer_id',$authUser->user)->first();
            Session::put('login_normal', true);
            Session::put('customer_name',$account_name->customer_name);
            Session::put('customer_id',$account_name->customer_id);
        }
        
        return redirect('/trang-chu');

    }
    public function findOrCreateUserGG($users, $provider){

        $authUser = SocialModels::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
                $customer_news = new SocialModels([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);

            $orang = CustomerModels::where('customer_email',$users->email)->first();

                if(!$orang){
                    $orang = CustomerModels::create([
                        'customer_name' => $users->name,
                        'customer_email' => $users->email,
                        'customer_password' => '',
                        'customer_phone' => '',
                        'customer_gender' => '',
                        'customer_avatar' => ''
                    ]);
                }
            $customer_news->login()->associate($orang);
            $customer_news->save();

            return $customer_news;
        }

    }

    public function update_customer_profile(Request $request, $customer_id){

            $data = $request->all();

            $profile_cus = CustomerModels::find($customer_id);
            $profile_cus->customer_email = $data['cus_email'];
            $profile_cus->customer_name = $data['cus_name'];
            $profile_cus->customer_phone = $data['cus_phone'];
            $profile_cus->customer_gender = $data['cus_gender'];

            $get_image = $request->file('cus_avatar');

            if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image)); 
                $new_custom_name_image = $name_image.'('.trim(date('Y-m-d', time())).rand(0,99).')'.'.'.$get_image->getClientOriginalExtension(); 
                $get_image->move('./public/Uploads/avatar', $new_custom_name_image);
                $profile_cus->customer_avatar = $new_custom_name_image;
                $profile_cus->save();

                Session::put('message', 'Bạn vừa cập nhật thông tin thành công!');
                return redirect()->back();
            }

            $profile_cus->save();
            Session::put('message', 'Bạn vừa cập nhật thông tin thành công!');
             return redirect()->back();
    }

}