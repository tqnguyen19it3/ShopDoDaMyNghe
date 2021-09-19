@extends('admin_page.admin_layout')
@section('admin_content')        
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
        <?php
            echo "<div class='text-center'>";
                echo "<strong style='color:green;'>" ;
                    $message = Session::get('message');
                    if($message){
                        echo $message;
                        Session::put('message', null);
                    }
                echo "</strong>";
            echo "</div>";
        ?> 
      <table class="table table-striped b-t b-light"> 
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Ngày tháng đặt hàng</th>
            <th>Tình trạng đơn hàng</th>
            <th>Thao tác</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
          $i = 0;
          @endphp
          @foreach($all_order as $key => $order)
            @php 
            $i++;
            @endphp
          <tr>
            <td><i>{{$i}}</i></label></td>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->created_at }}</td>
            <td>@if($order->order_status==1)
                    <span class="badge badge-warning">Chưa xử lý</span><img src="{{asset('public/FrontEnd/Images/new.gif')}}" alt="Logo">
                @elseif($order->order_status==2)
                    <span class="badge badge-success">Đã xử lý - Đã giao</span>
                @else
                    <span class="badge badge-primary">Đang xử lý...</span>
                @endif
            </td>
           
           
            <td>
              <a href="{{URL::to('/view-order/'.$order->order_code)}}" class="active styling-edit" ui-toggle-class="" data-toggle="tooltip" data-placement="left" title="Xem chi tiết">
                <i class="fa fa-eye text-success text-active"></i></a> / 

              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn hàng này không?')" href="{{URL::to('/delete-order/'.$order->order_code)}}" class="active styling-edit" ui-toggle-class="" data-toggle="tooltip" data-placement="right" title="Xóa">
                <i class="fa fa-times text-danger text"></i>
              </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {!!$all_order->count()!!} trên tổng số {!!$all_order->total()!!} đơn hàng</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_order->links("pagination::bootstrap-4")!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>

@endsection