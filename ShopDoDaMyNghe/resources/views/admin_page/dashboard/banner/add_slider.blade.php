@extends('admin_page.admin_layout')
@section('admin_content')     
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm Slider
                        </header>
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
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-slider')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" placeholder="Slide">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả slider</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Mô tả cho slider này"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="slider_status" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_slider" class="btn btn-info">Thêm slider</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection