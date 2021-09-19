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
                                @foreach($post_details as $key => $value)
                                <span>
                                    <a href="{{URL::TO('danh-muc-bai-viet/'.$value->category_post_slug.'/'.$value->category_post_id)}}">{{$value->category_post_name}}</a>
                                </span>
                                <span class="separator">/</span>
                                <span class="last-item">{{$value->post_name}}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fluid-container px-5-percent  single-product-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-extra-info" style="margin-top: 0;">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active mb_80" id="ideas">
                                    <div class="row">
                                        <div class="col-md-12">
                                        @foreach($post_details as $key => $value)
                                            <h3 align="center">{{$value->post_name}}</h3>
                                            <div>{!!$value->post_content!!}</div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            
                <div class="row mb_40">
                    <div class="col-md-12">
                        <h4>Bài viết liên quan</h4>
                    </div>
                </div>
                <ul class="row products">
                    @foreach($related as $key => $bvRecoment)
                        <li class="product col-md-3 col-sm-6">
                            <a href="{{URL::TO('/chi-tiet-bai-viet/'.$bvRecoment->post_slug.'/'.$bvRecoment->post_id)}}">
                                <img width="430" height="480" src="{{URL::TO('public/Uploads/post/'.$bvRecoment->post_image)}}" alt="{{$bvRecoment->post_name}}">
                                <h2>{{$bvRecoment->post_name}}</h2>
                            </a>
                            <a rel="nofollow" href="{{URL::TO('/chi-tiet-bai-viet/'.$bvRecoment->post_slug.'/'.$bvRecoment->post_id)}}" class="btn-bottom-line">Xem chi tiết bài viết</a>
                        </li>
                    @endforeach
                </ul>
            </div>

@endsection
