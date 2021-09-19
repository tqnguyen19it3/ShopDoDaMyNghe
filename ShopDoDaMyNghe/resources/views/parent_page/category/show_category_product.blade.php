@extends('welcome')
@section('content')
            <div class="fluit-container px-5-percent ">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="shop-item-toolbar mt_80">
                            <div class="items-ordering">
                               <form>
                                    @csrf
                                <select name="orderby_product_cateshop" id="orderby_product_cateshop" class="orderby custom-select">
                                    <option value="{{Request::url()}}?sort_by=cateshop_product_id">Sắp xếp mặc định</option>
                                    <option value="{{Request::url()}}?sort_by=cateshop_product_characters_az">Sắp xếp theo tên: A -> Z</option>
                                    <option value="{{Request::url()}}?sort_by=cateshop_product_characters_za">Sắp xếp theo tên: Z -> A</option>
                                    <option value="{{Request::url()}}?sort_by=cateshop_product_price_ascending">Sắp xếp theo giá: Thấp -> cao</option>
                                    <option value="{{Request::url()}}?sort_by=cateshop_product_price_decrease">Sắp xếp theo giá: Cao -> thấp</option>
                                </select>
                                </form>
                            </div>
                            <div class="fb-share-button" data-href="{{$url_canonical}}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>

                            <div class="item-result-count">Hiển thị {!!$category_by_id->count()!!} trên {!!$category_by_id->total()!!} sản phẩm</div>
                        </div>
                        <div class="text-center" style="font-size: 25px; font-weight: 800;">Tất cả mặt hàng</div><br>
                            <?php
                                $message = Session::get('message');
                                if($message){
                                    echo "<div class='text-center'>";
                                        echo "<h3 style='color:green;'>" ;
                                            echo $message;
                                            Session::put('message', null);
                                        echo "</h3>";
                                    echo "</div>";
                                }else{
                            ?> 
                        <ul class="row products">
                            @foreach($category_by_id as $key => $product_cate)
                                <li class="product col-md-4 col-sm-8">
                                    <form>
                                    @csrf <br>
                                    <input type="hidden" value="{{$product_cate->product_id}}" class="cart_product_id_{{$product_cate->product_id}}">
                                    <input type="hidden" value="{{$product_cate->product_name}}" class="cart_product_name_{{$product_cate->product_id}}">
                                    <input type="hidden" value="{{$product_cate->product_quantity}}" class="cart_product_quantity_{{$product_cate->product_id}}">               
                                    <input type="hidden" value="{{$product_cate->product_image}}" class="cart_product_image_{{$product_cate->product_id}}">
                                    <input type="hidden" value="{{$product_cate->product_price}}" class="cart_product_price_{{$product_cate->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$product_cate->product_id}}">
                                    <a href="{{URL::TO('/chi-tiet-sp/'.$product_cate->product_slug.'/'.$product_cate->product_id)}}">
                                        <img width="430" height="480" src="{{URL::TO('public/Uploads/product/'.$product_cate->product_image)}}" alt="{{$product_cate->product_name}}">
                                        <h2>{{$product_cate->product_name}}</h2>
                                        <span class="price">
                                            <span class="amount">
                                                {{number_format($product_cate->product_price)}} <span class="currencySymbol"> VNĐ</span></span>
                                        </span>
                                    </a>
                                    {{-- <a rel="nofollow" href="" class="btn-bottom-line">Thêm giỏ hàng</a> --}}
                                    <button type="button" name="add-to-cart" data-id_product="{{$product_cate->product_id}}" class="btn-bottom-line add-to-cart">Thêm giỏ hàng</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <nav class="pagination_holder">
                            <ul class="pagination justify-content-center mb_60">
                                {!!$category_by_id->links("pagination::bootstrap-4")!!}
                            </ul>
                        </nav>
                            <?php
                                }
                            ?>
                    </div>
                    <div class="col-sm-3">
                        <div class="sidebar">
                            <div class="widget">
                               <h4 class="widget-title">{{$category_name->category_name}}</h4>
                                    <div class="widget">
                                        <a href=""><img src="{{URL::TO('public/Uploads/category/'.$category_name->category_image)}}" alt="img" width="1280" height="1707"></a>
                                    </div>
                                        <p>{{$category_name->category_desc}}</p>
                            </div>
                            <div class="widget">
                                {{-- <form role="search" method="post" action="{{URL::TO('/tim-kiem')}}" class="form-fields-bg-alabaster">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm" id="keywords1" name="keywords_submit">
                                        <div id="search-ajax1"></div>
                                        <div class="input-group-btn">
                                            <input name="search_items" value="Search" class="btn btn-default" type="submit" style="background-color: black; color: white;"><i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </form> --}}
                            </div>
                           
                            <div class="widget widget_categories">
                                <h4 class="widget-title">Danh mục</h4>
                                
                                <ul>
                                    @foreach($category as $key => $cate)
                                    <li>
                                        <a href="{{URL::TO('danh-muc-sp/'.$cate->category_slug.'/'.$cate->category_id)}}">{{$cate->category_name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
@endsection            