@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm bài viết
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
                                <form role="form" method="post" action="{{URL::TO('/save-post')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputName1">Tên bài viết</label>
                                    <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 kí tự" name="post_name" class="form-control" id="exampleInputName1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh bài viết</label>
                                    <input type="file" name="post_image" class="form-control" id="exampleInputImage1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput1">Mô tả bài viết</label>
                                    <textarea class="form-control" rows="5" name="post_desc" required="" placeholder="Mô tả danh mục"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Nội dung bài viết</label>
                                    <textarea class="form-control" name="post_content" id="ckeditor" placeholder="Nội dung danh mục" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Từ khóa bài viết</label>
                                    <textarea class="form-control" name="meta_post_keywords" id="exampleInput2" placeholder="Từ khóa bài viết" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput3">Danh mục bài viết</label>
                                    <select name="post_cate" class="form-control input-sm m-bot15" id="exampleInput3">
                                        @foreach($cate_post as $key => $cate_val)
                                        <option value="{{($cate_val->category_post_id)}}">{{($cate_val->category_post_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput5">Trạng thái hiển thị</label>
                                    <select name="post_status" id="exampleInput5" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <button type="submit" name="post_add" class="btn btn-info">Thêm bài viết</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection