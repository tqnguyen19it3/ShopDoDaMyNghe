@extends('welcome')
@section('content')
            <!-- main page -->
            <div class="fluid-container px-5-percent">
                <div class="row">
                    <div class="col-md-12">
                        <div id="main-carousel" class="owl-carousel default-carousel">
                        @foreach($slider as $key => $slide)
                            <div class="carousel-item">
                                <div class="carousel-item-content">
                                    <div class="fluid-container">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 offset-1">
                                                <h1>Cửa hàng
                                                    <br> Đá mỹ nghệ Non Nước </h1>
                                                <p class="lead hidden-md-down mb_30">{{$slide->slider_desc}}</p>
                                                <a href="{{URL::TO('/cua-hang-do-da')}}" class="btn btn-default">Ghé cửa hàng </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <img src="{{URL::TO('public/Uploads/banner/'.$slide->slider_img)}}" alt="Product Img" width="1920" height="932">
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="fluid-container px-5-percent">

                <div class="row mt_40 mb_30">
                    @foreach($category as $key => $cate)
                        <div class="col-md-4" style="margin-bottom: 30px;">
                            <div class="et-banner">
                                <figure class="effect-banner">
                                    <img src="{{URL::TO('public/Uploads/category/'.$cate->category_image)}}" alt="Category Product" width="639" height="650">
                                    <figcaption>
                                        <div class="figure_caption_container">
                                            <div class="figure_caption">
                                                <h2> #{{$cate->category_slug}} </h2>
                                            </div>
                                        </div>
                                        <a href="{{URL::TO('danh-muc-sp/'.$cate->category_slug.'/'.$cate->category_id)}}">Xem ngay</a>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="container mt_70 mb_50">
                <div class="row">
                    <div class="col-md-6 offset-md-3 align-center">
                        <h2>Sản phẩm bán chạy</h2>
                        <p>Khám phá ngay một loạt các sản phẩm điêu khắc bán chạy tốt nhất trên cửa hàng để tìm ra sản phẩm dành cho bạn! 
                        </p>
                    </div>
                </div>
            </div>

            <div class="fluid-container px-5-percent">
                <ul class="row products">
                    @foreach($selling_products as $key => $selling)
                    <li class="product col-md-3 col-sm-6">
                        <a href="{{URL::TO('/chi-tiet-sp/'.$selling->product_slug.'/'.$selling->product_id)}}">
                            <img alt="selling product" src="{{URL::TO('public/Uploads/product/'.$selling->product_image)}}" width="430" height="480" />
                            <h2>{{$selling->product_name}}</h2>
                            <span class="price">
                                <span class="amount">
                                    {{number_format($selling->product_price)}}<span class="currencySymbol"> VNĐ</span></span>
                            </span>
                        </a>
                        <a rel="nofollow" href="{{URL::TO('/chi-tiet-sp/'.$selling->product_slug.'/'.$selling->product_id)}}" class="btn-bottom-line"> Xem chi tiết</a>
                    </li>
                    @endforeach
                </ul>
            </div>


            <div class="bg-grey-light bg-img-6 mx-5-percent">
                <div class="container">
                    <div class="row  height_50 align-items-center">
                        <div class="col-md-8">
                            <div class="px-4 px-md-5">

                                <h1>Sản phẩm mới năm {{date("Y")}} </h1>
                                <p class="font-regular">Cơ sở điêu khắc đá mỹ nghệ Non Nước chuyên thiết kế, chế tác các sản phẩm điêu khắc đá nguyên khối thủ công trên toàn quốc. Nằm trong làng nghề truyền thống đá, với nhiều năm kinh nghiệm trong nghề, cơ sở chúng tôi sẽ mang đến cho quý khách hàng những sản phẩm bền đẹp nhất với giá thành hợp lý.</p>
                                <a href="{{URL::TO('/cua-hang-do-da')}}" class="btn btn-default">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--             <div class="container mt_70 mb_50">
                <div class="row">
                    <div class="col-md-8 offset-md-2 align-center">
                        <h2>Sản phẩm ưa thích</h2>
                        <p>Sản phẩm yêu thích, các sản phẩm độc đáo, được sự quan tâm của đông đảo khách hàng đặt mua.
                        </p>
                    </div>
                </div>
            </div>
            <div class="fluid-container px-5-percent">
                <ul class="row products">
                    <li class="product col-md-3 col-sm-6">
                        <a href="single-product.html">
                            <img alt="product" src="images/image-credit-nendo-40.jpg" width="430" height="480" />
                            <h2>Mango Sofa Won</h2>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>559.00
                                </span>
                            </span>
                        </a>
                        <a rel="nofollow" href="single-product.html" class="btn-bottom-line"> Add to cart</a>
                    </li>
                    <li class="product col-md-3 col-sm-6">
                        <a href="single-product.html">
                            <img alt="product" src="images/products/image-credit-nendo-10.jpg" width="430" height="480" />
                            <h2>Campfire series for Mitab</h2>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>750.00</span>
                            </span>
                        </a>
                        <a rel="nofollow" href="single-product.html" class="btn-bottom-line"> Add to cart</a>
                    </li>
                    <li class="product col-md-3 col-sm-6">
                        <a href="single-product.html">
                            <img alt="product" src="images/products/image-credit-nendo-11.jpg" width="430" height="480" />
                            <h2>Shell stool brwon</h2>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>399.00</span>
                            </span>
                        </a>
                        <a rel="nofollow" href="single-product.html" class="btn-bottom-line"> Add to cart</a>
                    </li>
                    <li class="product col-md-3 col-sm-6">
                        <a href="single-product.html">
                            <img alt="product" src="images/image-credit-nendo-42.jpg" width="430" height="480" />
                            <h2>Shell stool black</h2>
                            <span class="price">
                                <span class="amount">
                                    <span class="currencySymbol">$</span>399.00</span>
                            </span>
                        </a>
                        <a rel="nofollow" href="single-product.html" class="btn-bottom-line"> Add to cart</a>
                    </li>
                </ul>
            </div> --}}

            <div class="bg-grey-light pt_100 pb_90 align-center mx-5-percent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="content_box ">
                                <div class="content_icon">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                                <div class="content_info">
                                    <h3>Money Back Guarantee</h3>
                                    <p>Phasellus varius cursus turpis dign issim mollis. Vestibulum hendrerit arcu nunc, sit
                                        amet dignissim dui mollis maximus. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="content_box">
                                <div class="content_icon">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="content_info">
                                    <h3>24/7 Customer Service</h3>
                                    <p>Phasellus varius cursus turpis dign issim mollis. Vestibulum hendrerit arcu nunc, sit
                                        amet dignissim dui mollis maximus. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="content_box">
                                <div class="content_icon">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                </div>
                                <div class="content_info">
                                    <h3>Free Shipping Worldwide</h3>
                                    <p>Phasellus varius cursus turpis dign issim mollis. Vestibulum hendrerit arcu nunc, sit
                                        amet dignissim dui mollis maximus. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt_90 mb_80">
                <div class="row">
                    <div class="col-md-12 align-center">
                        <h3>Tìm hiểu về đá mỹ nghệ</h3>
                    </div>
                    <div class="col-md-12">
                        <div id="second_carousel" class="testimonials owl-carousel" data-aos="fade-zoom-in">
                            <div class="testimonial">
                                <p> Đá mỹ nghệ không chỉ phổ biến bởi tính bền đẹp không ngại thời tiết, mà còn đảm bảo được độ thẩm mỹ cao, thu hút người xem. Đá mỹ nghệ có rất nhiều màu sắc đa dạng có thể linh hoạt tạo ra nhiều sản phẩm hấp dẫn về mặt thị giác. </p>
                                <div class="client">
                                    <div class="client-info">
                                        <span class="client-name">
                                            "Nghệ nhân"
                                        </span>

                                    </div>
                                </div>
                            </div>
                            <div class="testimonial">
                                <p> Đá mỹ nghệ là những tác phẩm nghệ thuật thủ công bằng đá được các nghệ nhân chế tác theo các ý tưởng, phong cách khác nhau. Mỗi sản phẩm là mang ý nghĩa phong thủy khác nhau theo màu sắc hoặc chất liệu.</p>
                                <div class="client">
                                    <div class="client-info">
                                        <span class="client-name">
                                            "Nghệ nhân"
                                        </span>

                                    </div>
                                </div>
                            </div>
                            <div class="testimonial">
                                <p> Sản phẩm đá mỹ nghệ thường được điêu khắc từ những khối đá tự nhiên nên sau khi được chế tác sẽ mang trong mình những nét đặc trưng riêng biệt, khó giống nhau.</p>
                                <div class="client">
                                    <div class="client-info">
                                        <span class="client-name">
                                            "Nghệ nhân"
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-grey-light pt_40 pb_20 align-center mx-5-percent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 align-center">
                            <h5>Theo dõi chúng tôi trên <a href="https://www.facebook.com/C%E1%BB%ADa-h%C3%A0ng-%C4%91%E1%BB%93-%C4%91%C3%A1-m%E1%BB%B9-ngh%E1%BB%87-Non-N%C6%B0%E1%BB%9Bc-135588608694768" target="_blank">Fanpage Facebook</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fluid-container px-5-percent">
                <ul id="instagramfeed" class="instagram_feed no-gutters"></ul>
            </div>
            <!-- main page end -->
@endsection