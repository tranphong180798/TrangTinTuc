<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiTin;
use App\Models\TheLoai;
class LoaiTinController extends Controller
{
      //
      public function getDanhSach(){
        $loaitin=LoaiTin::all();
        return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }

    public function getThem(){
        $theloai=TheLoai::all();
         return view('admin.loaitin.them',['theloai'=>$theloai]);
    }
    public function postThem(Request $request){
        $this->validate($request,
            [
                'Ten'=>'required|min:3|max:100|unique:LoaiTin,Ten'
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại',
                'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100',
                'Ten.unique'=>'Teend thể loại của bạn  đã tồn tại'
            ],
        );

        $loaitin=new LoaiTin();
        $loaitin->Ten=$request->Ten;
        $loaitin->idTheLoai=$request->TheLoai;
        $loaitin->TenKhongDau=changeTitle($request->Ten);
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao','bạn đã thêm thành công');
    }

    public function getSua($id){
        $theloai = TheLoai::all();
        $loaitin=LoaiTin::find($id);
        return view('admin/loaitin/sua',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request,$id){

       
        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:LoaiTin,Ten'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên thể loại',
            'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100',
            'Ten.unique'=>'Ten thể loại của bạn  đã tồn tại',
            'Ten.max'=>'Tên Thể Loại Phải Có Độ Dài Từ 3 Cho Đến 100 Ký Tự',
            'TheLoai.required'=>'Bạn chưa chọn thể loại'
        ],
    );

    $loaitin=LoaiTin::find($id);

    $loaitin->Ten=$request->Ten;
    $loaitin->TenKhongDau=changeTitle($request->Ten);
    $loaitin->idTheLoai=$request->TheLoai;
    $loaitin->save();

    return redirect('admin/loaitin/sua/'.$id,)->with('thongbao','bạn đã sửa thành công');
    }


    public function getXoa($id){
        $loaitin=LoaiTin::find($id);
        $loaitin->delete();

        return redirect('admin/loaitin/danhsach')->with('thongbao','bạn đã xóa thành công');
    }
}
