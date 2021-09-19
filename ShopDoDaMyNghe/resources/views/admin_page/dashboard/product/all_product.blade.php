@extends('admin_page.admin_layout')
@section('admin_content')
        <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê sản phẩm
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
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đã bán</th>
            <th>Giá gốc</th>
            <th>Giá bán</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Ẩn/Hiện</th>
            {{-- <th>Ngày thêm</th> --}}
            <th style="width:30px;">Thao tác</th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_product as $key => $product)
          <tr>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->product_quantity }}</td>
            <td>{{ $product->product_sold }}</td>
            <td>{{number_format($product->product_cost)}}</td>
            <td>{{number_format($product->product_price)}}</td>
            <td><img src="{{URL::TO('./public/Uploads/product/'.$product->product_image)}}" width="100" height="100" alt="Product"></td>
            <td>{{ $product->category_name }}</td>
            <td><span class="text-ellipsis">
                <?php
                    if($product->product_status == 1){
                        ?>
                        <a href="{{URL::TO('/unactive-product/'.$product->product_id)}}"><span style="color: green; font-size: 25px;" class="fa fa-toggle-on"></span></a>
                <?php
                    }else{
                ?>
                <a href="{{URL::TO('/active-product/'.$product->product_id)}}"><span style="color: red; font-size: 25px;" class="fa fa-toggle-off"></a>
                <?php
                    }
                ?>
            </span></td>
            {{-- <td><span class="text-ellipsis">{item.PrHelpText1}</span></td> --}}
            <td>
                <a href="{{URL::TO('/edit-product/'.$product->product_slug.'/'.$product->product_id)}}" class="active" ui-toggle-class="" data-toggle="tooltip" data-placement="left" title="Chỉnh sửa">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a> / 
                <a onclick="return confirm('Bạn có chắc xóa sản phẩm này?')" href="{{URL::TO('/delete-product/'.$product->product_id)}}" class="active" ui-toggle-class="" data-toggle="tooltip" data-placement="right" title="Xóa">
                    <i class="fa fa-times text-danger text"></i></a></br>
              <a class="btn btn-primary" href="{{URL::TO('/add-gallery-product/'.$product->product_id)}}">Quản lý thư viện</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <!-----import data---->
      <form action="{{url('import-csv-product')}}" method="POST" enctype="multipart/form-data">
          @csrf
          
        <input type="file" name="file" accept=".xlsx"><br>

       <input type="submit" value="Nhập file Excel" name="import_csv" class="btn btn-warning">
      </form>

    <!-----export data---->
       <form action="{{url('export-csv-product')}}" method="POST">
          @csrf
       <input type="submit" value="Xuất file Excel" name="export_csv" class="btn btn-success">
      </form>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {!!$all_product->count()!!} trên tổng số {!!$all_product->total()!!} sản phẩm</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_product->links("pagination::bootstrap-4")!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>

@endsection