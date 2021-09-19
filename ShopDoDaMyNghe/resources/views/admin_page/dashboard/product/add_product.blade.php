@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" method="post" action="{{URL::TO('/save-product')}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputName1">Tên sản phẩm</label>
                                    <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền ít nhất 10 kí tự" name="product_name" class="form-control" id="exampleInputName1" required="" placeholder="Nhập danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice1">Giá gốc sản phẩm</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="làm ơn" name="product_cost" class="form-control price_format" id="" placeholder="Nhập giá gốc" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice1">Giá bán sản phẩm</label>
                                    <input type="text" data-validation="number" data-validation-error-msg="làm ơn" name="product_price" class="form-control price_format" id="" placeholder="Nhập giá bán" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Số lượng sản phẩm</label>
                                    <input type="number" required="" name="product_quantity" class="form-control" id="exampleInputName1" min="0">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputImage1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput1">Mô tả sản phẩm</label>
                                    <textarea class="form-control" name="product_desc" required="" placeholder="Mô tả danh mục"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Nội dung sản phẩm</label>
                                    <textarea class="form-control" name="product_content" id="ckeditor" placeholder="Nội dung danh mục" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Từ khóa sản phẩm</label>
                                    <textarea class="form-control" name="meta_product_keywords" id="exampleInput2" placeholder="Từ khóa sản phẩm" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput3">Danh mục sản phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15" id="exampleInput3">
                                        @foreach($cate_product as $key => $cate)
                                        <option value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput5">Trạng thái hiển thị</label>
                                    <select name="product_status" id="exampleInput5" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                                <button type="submit" name="product_add" class="btn btn-info">Thêm sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection