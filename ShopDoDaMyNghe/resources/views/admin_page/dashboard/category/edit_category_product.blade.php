@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật danh mục sản phẩm
                        </header>
                        <div class="panel-body">
                            @foreach($edit_category_product as $key => $edit_value )
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
                                <form role="form" method="post" action="{{URL::TO('/update-category-product/'.$edit_value->category_id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{$edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập danh mục" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh danh mục</label>
                                    <input type="file" name="category_product_image" class="form-control" id="exampleInputImage1"> 
                                    <img src="{{URL::TO('./public/Uploads/category/'.$edit_value->category_image)}}" alt="categoryImg" height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục</label>
                                    <textarea class="form-control" name="category_product_desc" id="exampleInputPassword1" required="">{{$edit_value->category_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Từ khóa danh mục</label>
                                    <textarea class="form-control" name="category_product_keywords" id="exampleInputPassword1" required="">{{$edit_value->meta_cate_keywords}}</textarea>
                                </div>
                                <button type="submit" name="category_product_update" class="btn btn-info">Cập nhật danh mục</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
        </div>

@endsection