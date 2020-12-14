<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai=TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }

    public function getThem(){

         return view('admin.theloai.them');
    }
    public function postThem(Request $request){
        $this->validate($request,
            [
                'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'
            ],
            [
                'Ten.required'=>'Bạn chưa nhập tên thể loại',
                'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100',
                'Ten.unique'=>'Teend thể loại của bạn  đã tồn tại'
            ],
        );

        $theloai=new TheLoai();
        $theloai->Ten=$request->Ten;
        $theloai->TenKhongDau=changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao','bạn đã thêm thành công');
    }

    public function getSua($id){
        $theloai=TheLoai::find($id);
        return view('admin/theloai/sua',['theloai'=>$theloai]);
    }

    public function postSua(Request $request,$id){

        $theloai=TheLoai::find($id);

        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên thể loại',
            'Ten.min'=>'Tên thể loại phải có độ dài từ 3 đến 100',
            'Ten.unique'=>'Teend thể loại của bạn  đã tồn tại',
            'Ten.max'=>'Tên Thể Loại Phải Có Độ Dài Từ 3 Cho Đến 100 Ký Tự'
        ],
    );

    
    $theloai->Ten=$request->Ten;
    $theloai->TenKhongDau=changeTitle($request->Ten);
    $theloai->save();

    return redirect('admin/theloai/sua/'.$id,)->with('thongbao','bạn đã sửa thành công');
    }


    public function getXoa($id){
        $theloai=TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao','bạn đã xóa thành công');
    }
}
