@extends('admin.layout.index')

@section('content')   
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Tin tức
                            <small>{{$tintuc->Ten}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br/>
                                @endforeach
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif

                        <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                                <label>Thể Loại</label>
                                <select class="form-control" name="TheLoai" id="TheLoai">
                                    @foreach($theloai as $tl)
                                        <option 
                                            @if($tintuc->loaitin->theloai->id == $tl->id)
                                            {{"selected"}}
                                            @endif
                                    value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loại Tin</label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin">
                                    @foreach($loaitin as $lt)
                                    <option 
                                         @if($tintuc->loaitin->id == $lt->id)
                                            {{"selected"}}
                                         @endif
                                    value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}" />
                            </div>

                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea class="form-control ckeditor" name="TomTat" rows="3" placeholder="Nhập tóm tắt"  >{{$tintuc->TomTat}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội Dung</label>
                                <textarea class="form-control ckeditor" rows="4" name="NoiDung" placeholder="Nhập Nội dung" >{{$tintuc->NoiDung}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                              <p>  <img src="upload/tintuc/{{$tintuc->Hinh}}" alt="" width="300px"></p>
                                <input type="file" class="form-control" name="Hinh" />
                            </div>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <label class="radio-inline">
                                    <input type="radio"   name="NoiBat" value="0" 
                                    @if($tintuc->NoiBat==1)
                                    {{"checked"}}
                                    
                                    @endif
                                    />Không
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="1" name="NoiBat"
                                    @if($tintuc->NoiBat==0)
                                    {{"checked"}}
                                    
                                    @endif

                                    />Có
                                </label>
                            </div>

                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm Mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function(){
               $("#TheLoai").change(function(){
                    var idTheLoai = $(this).val();
                    $.get("admin/ajax/loaitin/"+idTheLoai,function(data){
                            $("#LoaiTin").html(data);
                    });
               });
        });
    </script>


@endsection
