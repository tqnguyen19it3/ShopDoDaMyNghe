<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProductModels;
use App\Models\PostModels;
use App\Models\OrderModels;
use App\Models\CouponModels;
use App\Models\CustomerModels;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*', function($view){

            $product_donut = ProductModels::all()->count();
            $post_donut = PostModels::all()->count();
            $order_donut = OrderModels::all()->count();
            $coupon_donut = CouponModels::all()->count();
            $customer_donut = CustomerModels::all()->count();

             $view->with(compact('product_donut', 'post_donut', 'order_donut', 'coupon_donut', 'customer_donut'));

        });
        
    }
}
