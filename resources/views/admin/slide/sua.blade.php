@extends('admin.layout.index')

@section('content')   
   <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Slide
                            <small>{{$slide->Ten}}</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach                            
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                         @endif 
                         <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label>Tên Slide</label>
                                <input class="form-control" name="Ten" placeholder="Nhập Tên slide" value="{{$slide->Ten}}" />
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <p><img style="width:300px;height:200px;" src="upload/slide/{{$slide->Hinh}}" /></p>
                                <input type="file" class="form-control" name="Hinh" />
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <input class="form-control" name="NoiDung" placeholder="Nhập Nội dung" value="{{$slide->NoiDung}}" />
                            </div>

                            <div class="form-group">
                                <label>link</label>
                                <input class="form-control" name="link" placeholder="Nhập Link" value="{{$slide->link}}" />
                            </div>
                            
                            <button type="submit" class="btn btn-default">Sửa</button>
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