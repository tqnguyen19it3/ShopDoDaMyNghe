@extends('admin_page.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thư viện ảnh cho sản phẩm
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
                                
                            </div>

                            <form method="post" action="{{URL::TO('/insert-gallery-product/'.$pro_id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3" align="right">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" name="file[]" id="file_gal_pro" accept="image/*" class="form-control" multiple>
                                        <span id="error_gal_pro"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" name="upload_gallery_product" class="btn btn-success" value="Tải ảnh">
                                    </div>
                                </div>

                            </form></br>

                            <input type="hidden" name="pro_id" value="{{$pro_id}}" class="pro_id">
                            <form>
                                {{csrf_field()}}
                                
                                <div id="gallery_load_product">
                                    
                                </div>
                            </form>
                            
                        </div>
                    </section>

            </div>
        </div>

@endsection