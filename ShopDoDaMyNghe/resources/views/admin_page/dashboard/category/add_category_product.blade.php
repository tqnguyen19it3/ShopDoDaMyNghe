@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm danh mục sản phẩm
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
                                <form role="form" method="post" action="{{URL::TO('/save-category-product')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInput1">Tên danh mục sản phẩm</label>
                                    <input type="text" name="category_product_name" class="form-control" id="exampleInput1" placeholder="Nhập danh mục sản phẩm" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh danh mục sản phẩm</label>
                                    <input type="file" name="category_product_image" class="form-control" id="exampleInputImage1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Mô tả danh mục sản phẩm</label>
                                    <textarea class="form-control" name="category_product_desc" id="exampleInput2" placeholder="Mô tả danh mục sản phẩm" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Từ khóa danh mục sản phẩm</label>
                                    <textarea class="form-control" name="category_product_keywords" id="exampleInput2" placeholder="Từ khóa danh mục sản phẩm" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <select name="category_product_status" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <button type="submit" name="category_product_add" class="btn btn-info">Thêm danh mục</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection