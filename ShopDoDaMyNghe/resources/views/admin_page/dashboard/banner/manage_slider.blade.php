@extends('admin_page.admin_layout')
@section('admin_content')     
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê Banner
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
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th>Xóa</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_slider as $key => $slide)
          <tr>
            <td><img src="{{URL::TO('./public/Uploads/banner/'.$slide->slider_img)}}" height="120" width="500"></td>
            <td>{{ $slide->slider_desc }}</td>
            <td><span class="text-ellipsis">
              <?php
               if($slide->slider_status == 1){
                ?>
                <a href="{{URL::to('/unactive-slider/'.$slide->slider_id)}}"><span style="color: green; font-size: 25px;" class="fa fa-toggle-on"></span></span></a>
                <?php
                 }else{
                ?>  
                 <a href="{{URL::to('/active-slider/'.$slide->slider_id)}}"><span style="color: red; font-size: 25px;" class="fa fa-toggle-off"></a></a>
                <?php
               }
              ?>
            </span></td>
            <td>
             
              <a onclick="return confirm('Bạn có chắc là muốn xóa slide này ko?')" href="{{URL::to('/delete-slider/'.$slide->slider_id)}}" class="active styling-edit" ui-toggle-class="" data-toggle="tooltip" data-placement="left" title="Xóa">
                <i class="fa fa-times text-danger text"></i>
              </a>

            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection