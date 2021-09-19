@extends('welcome')
@section('content')
           <!-- Page Loader -->
            <div class="page_loading">
                <div class="spinner"></div>
            </div>
            <!-- End Page Loader -->
            <div class="embed-responsive embed-responsive-16by9 map_height_40">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.2063771141957!2d108.26206839883106!3d16.002768736621324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314210c7ccf2969f%3A0x29e1aea627fb10d!2zMTQxIEh1eeG7gW4gVHLDom4gQ8O0bmcgQ2jDumEsIEhvw6AgSOG6o2ksIE5nxakgSMOgbmggU8ahbiwgxJDDoCBO4bq1bmcgNTUwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1626704165755!5m2!1svi!2s" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="container mt_80 mb_20">
                <div class="row">
                    <div class="col-md-5">
                        <h3 class="mb-3">Liên hệ với chúng tôi</h3>
                        ĐỀ XUẤT & NHẬN XÉT
                        <p>Chúng tôi muốn nghe ý kiến của bạn.</br>
                        Có một vài câu hỏi? Chúng tôi có câu trả lời!</p>
                        <h4 class="mb-3">Địa chỉ</h4>
                        <p class="lead mb-3">141 Huyền Trân Công Chúa, Hoà Hải, Ngũ Hành Sơn, Đà Nẵng</p>
                        <p class="lead">Email:
                            <a href="#">hoanghiep@gmail.com</a>
                            <br> SĐT: 092 4852 9925
                        </p>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <form  action="{{URL::TO('/send-mail')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-sm-6 col-xs-12">
                                    <label>Họ và tên *</label>
                                    <input id="form_name" type="text" name="contact_name" class="form-control" placeholder="" required="required" data-error="Bạn chưa điền đủ thông tin.">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <label>Email *</label>
                                    <input id="form_email" type="email" name="contact_email" class="form-control" placeholder="" required="required" data-error="Bạn chưa điền đủ thông tin.">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <label>Số điện thoại *</label>
                                    <input id="form_phonemuner" type="text" name="contact_phonenumber" class="form-control" placeholder="" rows="8" required="required" data-error="Bạn chưa điền đủ thông tin">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Lời nhắn * </label>
                                    <textarea id="form_message" name="contact_message" class="form-control"  rows="8" required="required"
                                        data-error="Xin vui lòng để lại chúng tôi một lời nhắn"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 col-xs-12 align-right mt-3">
                                    <button type="submit" class="btn btn-default send_btn" data-toggle="tooltip" title="Chúng tôi mong chờ phản hồi từ bạn">Gửi yêu cầu</button>
                                </div>
                            </div>
                            <div class="loading-spinner"></div>
                            <div class="messages"></div>
                        </form> 
                    </div>
                </div>
            </div>
@endsection