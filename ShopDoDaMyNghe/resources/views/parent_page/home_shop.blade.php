@extends('welcome')
@section('content')
            <div class="fluit-container px-5-percent ">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="shop-item-toolbar mt_80">
                            <div class="items-ordering">
                                <form>
                                    @csrf
                                <select name="orderby_product_homeshop" id="orderby_product_homeshop" class="orderby custom-select">
                                    <option value="{{Request::url()}}?sort_by=homeshop_product_id">Sắp xếp mặc định</option>
                                    <option value="{{Request::url()}}?sort_by=homeshop_product_characters_az">Sắp xếp theo tên: A -> Z</option>
                                    <option value="{{Request::url()}}?sort_by=homeshop_product_characters_za">Sắp xếp theo tên: Z -> A</option>
                                    <option value="{{Request::url()}}?sort_by=homeshop_product_price_ascending">Sắp xếp theo giá: Thấp -> cao</option>
                                    <option value="{{Request::url()}}?sort_by=homeshop_product_price_decrease">Sắp xếp theo giá: Cao -> thấp</option>
                                </select>
                                </form>
                            </div>
                            <div class="fb-share-button" data-href="{{$url_canonical}}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>

                            <div class="item-result-count">Hiển thị {!!$all_product->count()!!} trên {!!$all_product->total()!!} sản phẩm</div>
                        </div>
                        <div class="text-center" style="font-size: 25px; font-weight: 800;">Tất cả mặt hàng</div><br>
                        <ul class="row products">
                            @foreach($all_product as $key => $product)

                                <li class="product col-md-4 col-sm-8">
                                <form>
                                    @csrf <br>
                                    <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">               
                                    <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                    <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                        <a href="{{URL::TO('/chi-tiet-sp/'.$product->product_slug.'/'.$product->product_id)}}">
                                            <img width="430" height="480" src="{{URL::TO('public/Uploads/product/'.$product->product_image)}}" alt="{{$product->product_name}}">
                                            <h2>{{$product->product_name}}</h2>
                                            <span class="price">
                                                <span class="amount">
                                                    {{number_format($product->product_price)}} <span class="currencySymbol"> VNĐ</span></span>
                                            </span>
                                        </a>
                                        {{-- <a rel="nofollow" href="" class="btn-bottom-line">Thêm giỏ hàng</a> <br><br><br> --}}
                                        <button type="button" name="add-to-cart" data-id_product="{{$product->product_id}}" class="btn-bottom-line add-to-cart">Thêm giỏ hàng</button>
                                </form>
                                </li>
                                
                            @endforeach
                        </ul>
                        <nav class="pagination_holder">
                            <ul class="pagination justify-content-center mb_60">
                                {!!$all_product->links("pagination::bootstrap-4")!!}
                            </ul>
                        </nav>
                    </div>
                    <div class="col-sm-3">
                        <div class="sidebar">
                            <div class="widget">
                               <h4 class="widget-title">Giới thiệu cửa hàng</h4>
                                    <div class="widget">
                                        <a href=""><img src="./public/FrontEnd/images/image-credit-nendo-11.jpg" alt="img" width="1280" height="1707"></a>
                                    </div>
                                        <p>{{$meta_desc}}</p>
                            </div>
                            <div class="widget">
                                <form role="search" method="POST" action="{{URL::TO('/tim-kiem')}}" autocomplete="off" class="form-fields-bg-alabaster">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm" id="keywords" name="keywords_submit">
                                        <div id="search_ajax" style="display: block;"></div>
                                        <div class="input-group-btn">
                                            <input name="search_items" value="Search" class="btn btn-default" type="submit" style="background-color: black; color: white;"><i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </form>
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