@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật danh mục bài viết
                        </header>
                        <div class="panel-body">
                            @foreach($edit_category_post as $key => $edit_value )
                            <div class="position-center">
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
                                <form role="form" method="post" action="{{URL::TO('/update-category-post/'.$edit_value->category_post_id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{$edit_value->category_post_name}}" name="category_post_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập danh mục" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục</label>
                                    <textarea class="form-control" rows="5" name="category_post_desc" id="exampleInputPassword1" required="">{{$edit_value->category_post_desc}}</textarea>
                                </div>
                                <button type="submit" name="category_post_update" class="btn btn-info">Cập nhật danh mục</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
        </div>

@endsection