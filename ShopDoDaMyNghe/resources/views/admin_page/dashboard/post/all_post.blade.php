@extends('admin_page.admin_layout')
@section('admin_content')
        <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê bài viết
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
            <th>Tên bài viết</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Danh mục</th>
            <th>Ngày thêm</th>
            <th>Ẩn/Hiện</th>
            <th style="width:30px;">Thao tác</th>
          </tr>
        </thead>
        <tbody>
            @foreach($all_post as $key => $post)
          <tr>
            <td>{{ $post->post_name }}</td>
            <td><img src="{{URL::TO('./public/Uploads/post/'.$post->post_image)}}" width="100" height="100" alt="post"></td>
            <td>{{ $post->post_desc}}</td>
            <td>{{ $post->category_post_name}}</td>
            <td>{{ $post->created_at }}</td>
            <td><span class="text-ellipsis">
                <?php
                    if($post->post_status == 1){
                        ?>
                        <a href="{{URL::TO('/unactive-post/'.$post->post_id)}}"><span style="color: green; font-size: 25px;" class="fa fa-toggle-on"></span></a>
                <?php
                    }else{
                ?>
                <a href="{{URL::TO('/active-post/'.$post->post_id)}}"><span style="color: red; font-size: 25px;" class="fa fa-toggle-off"></a>
                <?php
                    }
                ?>
            </span></td>
            {{-- <td><span class="text-ellipsis">{item.PrHelpText1}</span></td> --}}
            <td>
                <a href="{{URL::TO('/edit-post/'.$post->post_slug.'/'.$post->post_id)}}" class="active" ui-toggle-class="" data-toggle="tooltip" data-placement="left" title="Chỉnh sửa">
                    <i class="fa fa-pencil-square-o text-success text-active"></i></a> </br>
                <a onclick="return confirm('Bạn có chắc xóa bài viết này?')" href="{{URL::TO('/delete-post/'.$post->post_id)}}" class="active" ui-toggle-class="" data-toggle="tooltip" data-placement="right" title="Xóa">
                    <i class="fa fa-times text-danger text"></i></a></br>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {!!$all_post->count()!!} trên tổng số {!!$all_post->total()!!} bài viết</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {!!$all_post->links("pagination::bootstrap-4")!!}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>

@endsection