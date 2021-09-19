@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật sản phẩm
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
                               @foreach($edit_product as $key => $pro)
                                <form role="form" method="post" action="{{URL::TO('/update-product/'.$pro->product_id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputName1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" id="exampleInputName1" required="" value="{{($pro->product_name)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice1">Giá gốc sản phẩm</label>
                                    <input type="text" name="product_cost" class="form-control price_format" required="" id="exampleInputPrice1" value="{{($pro->product_cost)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice1">Giá bán sản phẩm</label>
                                    <input type="text" name="product_price" class="form-control price_format" required="" id="exampleInputPrice1" value="{{($pro->product_price)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPrice1">Số lượng sản phẩm</label>
                                    <input type="number" name="product_quantity" required="" min="0" class="form-control" id="exampleInputPrice1" value="{{($pro->product_quantity)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputImage1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputImage1"> 
                                    <img src="{{URL::TO('./public/Uploads/product/'.$pro->product_image)}}" alt="Product" height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput1">Mô tả sản phẩm</label>
                                    <textarea class="form-control" required="" name="product_desc" id="exampleInput1">{{($pro->product_desc)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Nội dung sản phẩm</label>
                                    <textarea class="form-control" required="" name="product_content" id="ckeditor">{{($pro->product_content)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput2">Từ khóa sản phẩm</label>
                                    <textarea class="form-control" required="" name="meta_product_keywords" id="exampleInput1">{{($pro->meta_product_keywords)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInput3">Danh mục sản phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15" id="exampleInput3">
                                        @foreach($cate_product as $key => $cate)
                                        @if($cate->category_id == $pro->category_id)
                                        <option selected value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @else <option value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" name="product_add" class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
        </div>

@endsection