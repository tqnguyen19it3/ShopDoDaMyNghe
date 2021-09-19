@extends('welcome')
@section('content')
        <div class="hero_title_container d-flex align-items-center height_35 mx-5-percent">
          <div class="fluid-container px-5-percent" align="center">
            <div class="hero_box w-50">
              <div class="hero_title hero_title_small">
                <h1>Thông tin cá nhân của bạn</h1>
                <p>Thông tin cá nhân và các tùy chọn giúp quản lý thông tin đó. Bạn có thể cho phép người khác nhìn thấy một số dữ liệu của thông tin này (chẳng hạn như thông tin liên hệ) để họ có thể dễ dàng liên hệ với bạn. Bạn cũng có thể xem thông tin tóm tắt về các hồ sơ của mình.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="fluid-container px-5-percent mt_80 mb_80">
          <div class="row">
            <div class="col-md-12">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#customer-profile" role="tab" data-toggle="tab">Thông tin tài khoản</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#order-placed" role="tab" data-toggle="tab">Đơn hàng của bạn</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#favorite-product" role="tab" data-toggle="tab">Sản phẩm bạn yêu thích</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#post-saved" role="tab" data-toggle="tab">Các bài viết bạn đã lưu</a>
                </li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="customer-profile">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="simple-team-person align-center">
                        <div class="team-image">
                          @if($user->customer_avatar == '')
                          <img class="rounded-circle" src="{{asset('public/FrontEnd/Images/avatar.png')}}" alt="customer avatar" width="550" height="550">
                          @else
                          <img class="rounded-circle" src="{{URL::TO('./public/Uploads/avatar/'.$user->customer_avatar)}}" alt="customer avatar" width="550" height="550">
                          @endif
                        </div>
                        <div class="team-info-holder">
                          <div class="team-info">
                            <h5 class="team-name">Ảnh đại diện</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <?php
                          $message = Session::get('message');
                          if($message){
                            echo"<div class='alert alert-success'>";
                              echo "<strong>Thành công! </strong>"; echo $message;
                              Session::put('message', null);
                            echo"</div>";
                          }
                      ?>
                      <div class="sticky-top mt_10">
                        <div class="details_list mt_40 mb_40">
                          <p>Họ và tên: <strong>{{$user->customer_name}}</strong>
                          </p>
                          <p>Email: <strong>{{$user->customer_email}}</strong>
                          </p>
                          <p>SĐT: <strong>{{$user->customer_phone}}</strong>
                          </p>
                          <p>Giới tính : {{$user->customer_gender}}
                          </p>
                        </div>
                      </div>
                      <button type="button" class="btn m-1 btn-info btn-sm" data-toggle="modal" data-target="#myModalProfileCustomer">Cập nhật</button>
                      <button type="button" class="btn m-1 btn-warning btn-sm">Đổi mật khẩu</button>
                      <button type="button" class="btn m-1 btn-danger btn-sm"><a style="color: #FFF;" href="{{URL::TO('/logout-customer')}}">Đăng xuất</a></button>
                    </div>
                  </div>
                      <!-- Modal -->
                      <div class="modal fade" id="myModalProfileCustomer">
                        <div class="modal-dialog modal-dialog-scrollable">
                          <div class="modal-content" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
                            <div class="modal-header" align="center" style="background-color: #5cb85c;">
                              <h4 class="modal-title" style="color: white; font-weight: 900">FORM CẬP NHẬT</h4>
                              <button type="button" style="color: white;" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="register-form">
                                        <form action="{{URL::TO('/update-customer-profile/'.$user->customer_id)}}" method="post" enctype="multipart/form-data">
                                          {{ csrf_field() }}
                                            <h4 align="center">Cập nhật hồ sơ cá nhân</h4>
                                            <div class="form-group">
                                              <label for="sel1"><B>Họ và tên:</B></label>
                                              <div class="input-box">
                                                  <input name="cus_name" placeholder="Điền tên mới" required="" type="text" value="{{ $user->customer_name }}">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="sel1">E-mail:</label>
                                              <div class="input-box">
                                                  <input name="cus_email" placeholder="Điền E-mail mới" required="" type="email" value="{{ $user->customer_email }}">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="sel1">SĐT:</label>
                                              <div class="input-box">
                                                  <input name="cus_phone" placeholder="Điền số điện thoại mới" required="" type="text" value="{{ $user->customer_phone }}">
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="sel1">Giới tính:</label>
                                              <select class="form-control" required="" multiple name="cus_gender">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                                <option value="Khác">Khác</option>
                                              </select>
                                            </div>
                                            <div class="form-group">
                                              <label for="sel1">Avatar:</label>
                                              <div class="input-box">
                                                <input type="file" name="cus_avatar">
                                              </div>
                                            </div>
                                            <div class="btn-box" style="margin-top: 10px;">
                                                <button type="submit" class="btn btn-outline-success">
                                                    Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Thoát</button>
                            </div>
                        </div>
                        </div>
                      </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="order-placed">
                  <div class="row">
                    <div class="col-md-6">
                      <p>1Code Quality ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit. </p>
                    </div>
                    <div class="col-md-6">
                      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </p>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="favorite-product">
                  <div class="row">
                    <div class="col-md-6">
                      <p>2Code Quality ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit. </p>
                    </div>
                    <div class="col-md-6">
                      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </p>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="post-saved">
                  <div class="row">
                    <div class="col-md-6">
                      <p>3Visual Design ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit. </p>
                    </div>
                    <div class="col-md-6">
                      <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection