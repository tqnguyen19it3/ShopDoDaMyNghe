@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật bài viết
                        </header>
                        <div class="panel-body">
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
                               @foreach($edit_post as $key => $pro)
                                <form role="form" method="post" action="{{URL::TO('/update-post/'.$pro->post_id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputName1">Tên bài viết</label>
                                    <input type="text" name="post_name" class="form-control" id="exampleInputName1" required="" value="{{($pro->post_name)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh bài viết</label>
                                    <input type="file" name="post_image" class="form-control" id="exampleInputImage1"> 
                                    <img src="{{URL::TO('./public/Uploads/post/'.$pro->post_image)}}" alt="post" height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput1">Mô tả bài viết</label>
                                    <textarea class="form-control" rows="5" required="" name="post_desc" id="exampleInput1">{{($pro->post_desc)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Nội dung bài viết</label>
                                    <textarea class="form-control" required="" name="post_content" id="ckeditor">{{($pro->post_content)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Từ khóa bài viết</label>
                                    <textarea class="form-control" required="" name="meta_post_keywords" id="exampleInput1">{{($pro->meta_post_keywords)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput3">Danh mục bài viết</label>
                                    <select name="post_cate" class="form-control input-sm m-bot15" id="exampleInput3">
                                        @foreach($cate_post as $key => $cate)
                                        @if($cate->category_post_id == $pro->category_post_id)
                                        <option selected value="{{($cate->category_post_id)}}">{{($cate->category_post_name)}}</option>
                                        @else <option value="{{($cate->category_post_id)}}">{{($cate->category_post_name)}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" name="post_add" class="btn btn-info">Cập nhật bài viết</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection