@extends('welcome')
@section('content') 
            <div class="etcodes_breadcrumb bg-grey-light mx-5-percent">
                <div class="fluid-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="breadcrumbs">
                                <span class="first-item">
                                    <a href="{{URL::TO('/trang-chu')}}">Trang chủ</a>
                                </span>
                                <span class="separator">/</span>
                                <span>
                                    <a href="{{URL::TO('/cua-hang-do-da')}}">Cửa hàng</a>
                                </span>
                                <span class="separator">/</span>
                                @foreach($product_details as $key => $value)
                                <span class="last-item">{{$value->product_name}}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fluid-container px-5-percent  single-product-content">
            @foreach($product_details as $key => $value)
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-product-images popup_gallery">
                            <ul class="product-images-gallery">
                                <li>
                                    <img src="images/products/fusion_collection_chair02.jpg" alt="Product image" width="163" height="182">
                                </li>
                                <li>
                                    <img src="images/products/fusion_collection_chair05.jpg" alt="Product image" width="163" height="182">
                                </li>
                                <li>
                                    <img src="images/products/fusion_collection_chair04.jpg" alt="Product image" width="163" height="182">
                                </li>
                                <li>
                                    <img src="images/products/fusion_collection_chair03.jpg" alt="Product image" width="163" height="182">
                                </li>
                            </ul>
                            <div class="product-hero-image">
                                <img src="{{URL::TO('public/Uploads/product/'.$value->product_image)}}" alt="{{$value->product_name}}" width="686" height="764">
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="single-product-des">
                            <h2 class="product-title">{{$value->product_name}}</h2>
                            <div class="single-product-price">{{number_format($value->product_price)}} VNĐ</div>
                            <div class="single-product-rating">
                                <a href="#">(2 customer review)</a>
                            </div>
                            <div class="single-product-deta">
                                <p>
                                    {{$value->product_desc}}
                                </p>
                                <form method="post" action="{{URL::TO('/save-cart')}}">
                                    {{csrf_field()}}
                                    <div class="add-to-cart-warp">
                                        <div class="quantity d-flex">
                                            <input type="number" step="1" min="1" max="{{$value->product_quantity}}" name="quantity" value="1" title="Qty" class="input-text qty text total-quantity" size="4">
                                            <input name="product_id_hiden" type="hidden" value="{{$value->product_id}}" />
                                        </div>
                                        <input type="submit" class="btn btn-default btn-lg add-cart-btn" value="Thêm giỏ hàng" style="background-color: black; color: white;">
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                                <ul class="single-product-meta">
                                    <li>
                                        <span class="meta-name">Số lượng:</span>{{$value->product_quantity}}</li>
                                    <li>
                                        <span class="meta-name">Danh mục:</span>{{$value->category_name}}</li>
                                    <li>
                                </ul>
                                <div style="margin-top: 10px; display: flex;">
                                <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                                <div style="margin-top: -8px;" class="fb-share-button" data-href="{{$url_canonical}}" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div></div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-extra-info">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active " href="#ideas" role="tab" data-toggle="tab">Chi tiết sản phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#code-quality" role="tab" data-toggle="tab">Hình ảnh</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#visual-design" role="tab" data-toggle="tab">Bình luận</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active mb_80" id="ideas">
                                    <div class="row">
{{--                                         <div class="col-md-6 mb_20">
                                            <img src="images/image-credit-nendo-44.jpg" alt="product img">
                                        </div> --}}
                                        <div class="col-md-12">
                                            <h3>{{$value->product_name}}</h3>
                                            <div>{!!$value->product_content!!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade  mb_80" id="code-quality">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Code Quality ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                                nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut
                                                wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                                                lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure
                                                dolor in hendrerit.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade  mb_80" id="visual-design">
                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="fb-comments" data-href="{{$url_canonical}}" data-numposts="25" data-width="100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                <div class="row mb_40">
                    <div class="col-md-12">
                        <h4>Sản phẩm liên quan</h4>
                    </div>
                </div>
                <ul class="row products">
                @foreach($related as $key => $spRecoment)
                    <li class="product col-md-3 col-sm-6">
                        <a href="{{URL::TO('/chi-tiet-sp/'.$spRecoment->product_slug.'/'.$spRecoment->product_id)}}">
                            <img width="430" height="480" src="{{URL::TO('public/Uploads/product/'.$spRecoment->product_image)}}" alt="{{$spRecoment->product_name}}">
                            <h2>{{$spRecoment->product_name}}</h2>
                            <span class="price">
                                <span class="amount">
                                    {{number_format($spRecoment->product_price)}} <span class="currencySymbol"> VNĐ</span></span>
                            </span>
                        </a>
                        <a rel="nofollow" href="" class="btn-bottom-line">Thêm giỏ hàng</a>
                    </li>
                @endforeach
                </ul>
            </div>
@endsection