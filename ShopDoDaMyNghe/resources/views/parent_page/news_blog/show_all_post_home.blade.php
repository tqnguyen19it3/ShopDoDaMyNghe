@extends('welcome')
@section('content')
        <div class="hero_title_container d-flex align-items-center height_35  mx-5-percent">
          <div class="fluid-container px-5-percent">
            <div class="hero_box w-50 align-center">
              <div class="hero_title hero_title_small">
                <h1>Tất cả bài viết</h1>
                <p>Hãy tham khảo một số bài viết của chúng tôi để biết thêm thông tin và việc lựa chọn sản phẩm trở nên dễ dàng hơn!</p>
              </div>
            </div>
          </div>
        </div>
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
        <div class="fluid-container px-5-percent">
          <div class="row">
            <div class="col-md-12">
              <div class="blog_posts stander_blog mt_80 mb_10 stander_blog_card">
                <div class="row">
                  @foreach($category_post_by_id as $key => $post_cate)
                  <div class="col-md-4 col-sm-6">
                    <article>
                      <div class="card">
                        <a href="{{URL::TO('/chi-tiet-bai-viet/'.$post_cate->post_slug.'/'.$post_cate->post_id)}}">
                          <img src="{{URL::TO('public/Uploads/post/'.$post_cate->post_image)}}" alt="{{$post_cate->post_name}}" width="1024" height="682">
                        </a>
                        <div class="card-block">
                          <h4 class="card-title">{{$post_cate->post_name}}</h4>
                          <div class="card-post-meta-top">
                            <span class="post_meta_date">{{$post_cate->created_at}}</span>
                            <span class="post_meta_category">
                              {{$post_cate->category_post_name}}
                            </span>
                          </div>
                          <p>{{$post_cate->post_desc}}</p>
                          <div class="card-post-meta-bottom">
                            <div class="row">
                              <div class="col-md-6">
                                <span class="post_meta_author">By Admin</span>
                              </div>
                              <div class="col-md-6 align-right">
                                <a class="post_read_more_btn" href="{{URL::TO('/chi-tiet-bai-viet/'.$post_cate->post_slug.'/'.$post_cate->post_id)}}">Chi tiết <i class="fa fa-long-arrow-right fa-lg ml-2" aria-hidden="true"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </article>
                  </div>
                  @endforeach
                </div>
              </div>
              <nav class="pagination_holder">
                <ul class="pagination justify-content-center mb_20">
                  {!!$category_post_by_id->links("pagination::bootstrap-4")!!}
                </ul>
              </nav>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
@endsection