<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Đăng ký & đăng nhập khách hàng
Route::get('/khach-hang-dang-ky', 'App\Http\Controllers\CustomerController@customer_form_register');
Route::post('/regist-customer', 'App\Http\Controllers\CustomerController@regist_customer');
Route::get('/khach-hang-dang-nhap', 'App\Http\Controllers\CustomerController@customer_form_login');
Route::post('/login-customer', 'App\Http\Controllers\CustomerController@login_customer');
Route::get('/logout-customer', 'App\Http\Controllers\CustomerController@logout_customer');

//Login facebook
Route::get('/login-facebook','App\Http\Controllers\CustomerController@login_facebook');
Route::get('/login/callback','App\Http\Controllers\CustomerController@callback_facebook');

//Login google
Route::get('/login-google','App\Http\Controllers\CustomerController@login_google');
Route::get('/google/callback','App\Http\Controllers\CustomerController@callback_google');

//HOME
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index');
Route::get('/lien-he', 'App\Http\Controllers\HomeController@contact');
Route::get('/gioi-thieu', 'App\Http\Controllers\HomeController@about_us');
Route::get('/tai-khoan-khach-hang/{customer_id}', 'App\Http\Controllers\HomeController@customer_profile');
//END HOME

//Cập nhật thông tin tài khoản khách hàng
Route::post('/update-customer-profile/{customer_id}', 'App\Http\Controllers\CustomerController@update_customer_profile');

//===SEND MAIL===//
// Route::get('/send-mail', 'App\Http\Controllers\HomeController@send_mail');
Route::post('/send-mail', 'App\Http\Controllers\HomeController@send_mail');
//===END SEND MAIL===//

//Cửa hàng
Route::get('/cua-hang-do-da', 'App\Http\Controllers\HomeController@home_shop');

//Tìm kiếm sản phẩm
Route::post('/tim-kiem', 'App\Http\Controllers\HomeController@tim_kiem'); //chưa xong
Route::post('/autocomplete-ajax', 'App\Http\Controllers\HomeController@autocomplete_ajax');//đang lỗi

//Danh mục sản phẩm
Route::get('/danh-muc-sp/{category_slug}/{category_id}', 'App\Http\Controllers\CategoryProductController@show_category_home');

//chi tiet san pham
Route::get('/chi-tiet-sp/{product_slug}/{product_id}', 'App\Http\Controllers\ProductController@details_product');

//Danh mục bài viết
Route::get('/danh-muc-bai-viet/{category_post_slug}/{category_post_id}', 'App\Http\Controllers\PostController@show_category_post_home');

//chi tiết bài viết
Route::get('/chi-tiet-bai-viet/{post_slug}/{post_id}', 'App\Http\Controllers\PostController@details_post_home');

// CART
// Route::post('/save-cart', 'App\Http\Controllers\CartController@save_cart'); //cũ
// Route::get('/delete-to-cart/{rowId}', 'App\Http\Controllers\CartController@delete_cart'); //cũ
Route::post('/add-cart-ajax','App\Http\Controllers\CartController@add_cart_ajax');
Route::get('/show-cart', 'App\Http\Controllers\CartController@show_cart');
Route::post('/update-cart', 'App\Http\Controllers\CartController@update_cart');
Route::get('/del-product-cart/{session_id}', 'App\Http\Controllers\CartController@del_product_cart');
Route::get('/del-all-product-cart', 'App\Http\Controllers\CartController@del_all_product_cart');
Route::post('/check-coupon', 'App\Http\Controllers\CartController@check_coupon');

//Checkout
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@checkout');
Route::post('/confirm-order', 'App\Http\Controllers\CheckoutController@confirm_order');
// Route::post('/save-checkout-customer', 'App\Http\Controllers\CheckoutController@save_checkout_customer');//cũ
// Route::get('/payment', 'App\Http\Controllers\CheckoutController@payment'); //cũ
// Route::post('/order-place', 'App\Http\Controllers\CheckoutController@order_place'); //cũ





//****************ADMIN***************

//LOGIN ADMIN 
Route::get('/login-form-admin', 'App\Http\Controllers\AdminController@login_form_admin');
Route::post('/login-admin', 'App\Http\Controllers\AdminController@login_admin');
Route::get('/logout-admin', 'App\Http\Controllers\AdminController@logout_admin');


//DASHBOARD
Route::get('/admin-dashboard', 'App\Http\Controllers\AdminController@show_dashboard');
Route::post('/filter-by-date', 'App\Http\Controllers\AdminController@filter_by_date');
Route::post('/dashboard-filter', 'App\Http\Controllers\AdminController@dashboard_filter');
Route::post('/days-order', 'App\Http\Controllers\AdminController@days_order');


//CATEGORY PRODUCT
Route::get('/add-category-product', 'App\Http\Controllers\CategoryProductController@add_category_product');
Route::post('/save-category-product', 'App\Http\Controllers\CategoryProductController@save_category_product');
Route::get('/all-category-product', 'App\Http\Controllers\CategoryProductController@all_category_product');
Route::get('/edit-category-product/{category_product_slug}/{category_product_id}', 'App\Http\Controllers\CategoryProductController@edit_category_product');
Route::post('/update-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@update_category_product');
Route::get('/active-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@active_category_product');
Route::get('/unactive-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@unactive_category_product');
Route::get('/delete-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@delete_category_product');
Route::post('/export-csv-category','App\Http\Controllers\CategoryProductController@export_csv_category');
Route::post('/import-csv-category','App\Http\Controllers\CategoryProductController@import_csv_category');


//PRODUCT
Route::get('/add-product', 'App\Http\Controllers\ProductController@add_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::get('/all-product', 'App\Http\Controllers\ProductController@all_product');
Route::get('/edit-product/{product_slug}/{product_id}', 'App\Http\Controllers\ProductController@edit_product');
Route::post('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');
Route::get('/active-product/{product_id}', 'App\Http\Controllers\ProductController@active_product');
Route::get('/unactive-product/{product_id}', 'App\Http\Controllers\ProductController@unactive_product');
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');
Route::post('/export-csv-product','App\Http\Controllers\ProductController@export_csv_product');
Route::post('/import-csv-product','App\Http\Controllers\ProductController@import_csv_product');


//CATEGORY POST
Route::get('/add-category-post', 'App\Http\Controllers\PostController@add_category_post');
Route::post('/save-category-post', 'App\Http\Controllers\PostController@save_category_post');
Route::get('/all-category-post', 'App\Http\Controllers\PostController@all_category_post');
Route::get('/edit-category-post/{category_post_slug}/{category_post_id}', 'App\Http\Controllers\PostController@edit_category_post');
Route::post('/update-category-post/{category_post_id}', 'App\Http\Controllers\PostController@update_category_post');
Route::get('/active-category-post/{category_post_id}', 'App\Http\Controllers\PostController@active_category_post');
Route::get('/unactive-category-post/{category_post_id}', 'App\Http\Controllers\PostController@unactive_category_post');
Route::get('/delete-category-post/{category_post_id}', 'App\Http\Controllers\PostController@delete_category_post');


//POST
Route::get('/add-post', 'App\Http\Controllers\PostController@add_post');
Route::post('/save-post', 'App\Http\Controllers\PostController@save_post');
Route::get('/all-post', 'App\Http\Controllers\PostController@all_post');
Route::get('/edit-post/{post_slug}/{post_id}', 'App\Http\Controllers\PostController@edit_post');
Route::post('/update-post/{post_id}', 'App\Http\Controllers\PostController@update_post');
Route::get('/active-post/{post_id}', 'App\Http\Controllers\PostController@active_post');
Route::get('/unactive-post/{post_id}', 'App\Http\Controllers\PostController@unactive_post');
Route::get('/delete-post/{post_id}', 'App\Http\Controllers\PostController@delete_post');


//GALLERY
Route::get('/add-gallery-product/{product_id}', 'App\Http\Controllers\ProductController@add_gallery_product');
Route::post('/select-gallery-product','App\Http\Controllers\ProductController@select_gallery_product');
Route::post('/insert-gallery-product/{product_id}','App\Http\Controllers\ProductController@insert_gallery_product');
Route::post('/update-gallery-name-product','App\Http\Controllers\ProductController@update_gallery_name_product');
Route::post('/delete-gallery-product','App\Http\Controllers\ProductController@delete_gallery_product');


//ORDER MANAGE
Route::get('/manage-order', 'App\Http\Controllers\OrderController@manage_order');
Route::get('/view-order/{order_code}', 'App\Http\Controllers\OrderController@view_order');
Route::get('/print-order/{checkout_code}','App\Http\Controllers\OrderController@print_order');
Route::post('/update-order-qty','App\Http\Controllers\OrderController@update_order_qty');
// Route::get('/manage-order', 'App\Http\Controllers\CheckoutController@manage_order'); //cũ
// Route::get('/view-order/{order_id}', 'App\Http\Controllers\CheckoutController@view_order'); //cũ
// Route::get('/delete-order/{order_id}', 'App\Http\Controllers\CheckoutController@delete_order');


//COUPON MANAGE 
Route::get('/insert-coupon', 'App\Http\Controllers\CouponController@insert_coupon');
Route::post('/insert-coupon-code', 'App\Http\Controllers\CouponController@insert_coupon_code');
Route::get('/list-coupon', 'App\Http\Controllers\CouponController@list_coupon');
Route::get('/unset-coupon', 'App\Http\Controllers\CouponController@unset_coupon');
Route::get('/delete-coupon/{coupon_id}', 'App\Http\Controllers\CouponController@delete_coupon');


//===START SLIDER BANNER===//
Route::get('/add-slider', 'App\Http\Controllers\SliderController@add_slider');
Route::post('/save-slider', 'App\Http\Controllers\SliderController@save_slider');
Route::get('/manage-slider', 'App\Http\Controllers\SliderController@manage_slider');
Route::get('/unactive-slider/{slider_id}', 'App\Http\Controllers\SliderController@unactive_slider');
Route::get('/active-slider/{slider_id}', 'App\Http\Controllers\SliderController@active_slider');
Route::get('/delete-slider/{slider_id}', 'App\Http\Controllers\SliderController@delete_slider');





