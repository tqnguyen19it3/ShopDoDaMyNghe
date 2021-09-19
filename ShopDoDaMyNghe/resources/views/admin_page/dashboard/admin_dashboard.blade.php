@extends('admin_page.admin_layout')
@section('admin_content')
<?php
    $name = Session::get('admin_name');
    if($name){
    	echo '<div class="alert alert-success alert-dismissible fade in">';
    		echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
  			echo '<strong>'. $name .'</strong> đã đăng nhập thành công!';
		echo '</div>';
    }
?>
<style type="text/css">
	p.title_thongke{
		text-align: center;
		font-size: 22px;
		font-weight: bold;
	}
</style>
<div class="row">
	<p class="title_thongke">Thống kê doanh số đơn hàng</p>
	<form autocomplete="off">
		@csrf
		<div class="col-md-2">
			<p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p>
			<input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả" name="" style="margin-top: 10px;">
		</div>
		<div class="col-md-2">
			<p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
			
		</div>
		<div class="col-md-2">
			<p>
				Lọc theo: 
				<select class="dashboard-filter form-control">
					<option>--------Chọn--------</option>
					<option value="7ngayqua">7 ngày qua</option>
					<option value="thangtruoc">Tháng trước</option>
					<option value="thangnay">Tháng này</option>
					<option value="365ngayqua">365 ngày qua</option>
				</select>
			</p>
		</div>
	</form>
	<div class="col-md-12">
		<div id="myfirstchart" style="height: 250px;"></div>
	</div>
</div>
<div class="row" style="margin-top: 20px;">
	<div class="col-sm-12">
		<p class="title_thongke">Thống kê truy cập</p>
		<table class="table table-dark table-hover" style="background: #343a40;">
	    <thead>
	      <tr>
	        <th>Đang online</th>
	        <th>Tổng tháng trước</th>
	        <th>Tổng tháng này</th>
	        <th>Tổng một năm</th>
	        <th>Tổng lượt truy cập</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr>
	        <td>{{$visitors_count}}</td>
	        <td>{{$visitors_lastmonth_count}}</td>
	        <td>{{$visitors_thismonth_count}}</td>
	        <td>{{$visitors_year_count}}</td>
	        <td>{{$visitors_total}}</td>
	      </tr>
	    </tbody>
	  </table>
	</div>
</div>
<div class="row" style="margin-top: 20px;">
	<div class="col-sm-4 col-xs-12">
		<h2 class="text-center">Thống kê mục</h2>
		<div id="donut_chart" class="morris-donut-inverse"></div>
	</div>
	<div class="col-md-4 col-xs-4">
			<p class="text-center title_thongke" style="font-weight: bold; color: #ff5162; text-decoration: underline;">Sản phẩm xem nhiều</p>
			<ol class="list_views">
				@foreach($product_views as $key => $all_pro_views)
					<li>
						<a style="color: #81cfcc;" target="_blank" href="{{URL::TO('/chi-tiet-sp/'.$all_pro_views->product_slug.'/'.$all_pro_views->product_id)}}">{{$all_pro_views->product_name}} | <span style="color: #ff5162">{{$all_pro_views->product_views}}</span></a>
					</li>
				@endforeach
			</ol>
		</div>
		<div class="col-md-4 col-xs-4">
			<p class="text-center title_thongke" style="font-weight: bold; color: #ff8e51; text-decoration: underline;">Bài viết xem nhiều</p>
			<ol class="list_views">
				@foreach($post_views as $key => $all_post_views)
					<li>
						<a style="color: #81cfcc;" target="_blank" href="{{URL::TO('/chi-tiet-bai-viet/'.$all_post_views->post_slug.'/'.$all_post_views->post_id)}}">{{$all_post_views->post_name}} | <span style="color: #ff8e51">{{$all_post_views->post_views}}</span></a>
					</li>
				@endforeach
			</ol>
		</div>
</div>

@endsection