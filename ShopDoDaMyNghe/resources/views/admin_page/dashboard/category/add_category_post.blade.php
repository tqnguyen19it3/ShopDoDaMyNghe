@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm danh mục bài viết
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
                                <form role="form" method="post" action="{{URL::TO('/save-category-post')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInput1">Tên danh mục bài viết</label>
                                    <input type="text" name="category_post_name" class="form-control" id="exampleInput1" placeholder="Nhập danh mục bài viết" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Mô tả danh mục bài viết</label>
                                    <textarea class="form-control" name="category_post_desc" id="exampleInput2" placeholder="Mô tả danh mục bài viết" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <select name="category_post_status" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <button type="submit" name="category_post_add" class="btn btn-info">Thêm danh mục</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection