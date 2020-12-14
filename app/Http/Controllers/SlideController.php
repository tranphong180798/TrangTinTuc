<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
class SlideController extends Controller
{
    public function getDanhSach()
    {
        $slide=Slide::all();
        return view('admin.slide.danhsach',['slide'=>$slide]);
    }
    public function getThem(){
        return view('admin.slide.them');
    }
    public function postThem(Request $request){
        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten',
            'NoiDung'=>'required|min:3|max:100',
            'link'=>'required|min:3|max:100'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên slide',
            'Ten.min'=>'tên slide phải có độ dài từ 3 đến 100',
            'Ten.max'=>'Tên slide loại phải có độ dài từ 3 đến 100',
            'Ten.unique'=>'tên slide của bạn  đã tồn tại',
            'NoiDung.required'=>'Bạn chưa nhập tên slide',
            'NoiDung.min'=>'Tên slide phải có độ dài từ 3 đến 100',
            'NoiDung.max'=>'Tên slide phải có độ dài từ 3 đến 100',
            'NoiDung.unique'=>'tên slide của bạn  đã tồn tại',
        ],
    );

    $slide=new Slide();
    $slide->Ten=$request->Ten;
    if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');          
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg')
            {
                  return redirect('admin/slide/them')->with('loi','Bạn Chỉ Được Chọn File Có Đuôi jpg,png,jpeg');
            }
            
            $name = $file->getClientOriginalName();
            $Hinh =  str_rand(4)."_". $name;
            //echo $Hinh;
            
            while (file_exists("upload/slide/".$Hinh)) 
            {
                $Hinh = str_rand(4)."_". $name;
            }
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;
            
        }
        else
        {
            $slide->Hinh = "";
        }
    $slide->NoiDung=$request->NoiDung;
    $slide->link=$request->link;
    $slide->save();

    return redirect('admin/slide/them')->with('thongbao','bạn đã thêm thành công');
    }

    public function getSua($id){
        $slide=Slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide]);
    }
    public function postSua(Request $request,$id){

        $this->validate($request,
        [
            'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten',
            'NoiDung'=>'required|min:3|max:100',
            'link'=>'required|min:3|max:100'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên slide',
            'Ten.min'=>'tên slide phải có độ dài từ 3 đến 100',
            'Ten.max'=>'Tên slide loại phải có độ dài từ 3 đến 100',
            'Ten.unique'=>'tên slide của bạn  đã tồn tại',
            'NoiDung.required'=>'Bạn chưa nhập tên slide',
            'NoiDung.min'=>'Tên slide phải có độ dài từ 3 đến 100',
            'NoiDung.max'=>'Tên slide phải có độ dài từ 3 đến 100',
            'NoiDung.unique'=>'tên slide của bạn  đã tồn tại',
        ],
    );

    $slide=SLide::find($id);
    $slide->Ten=$request->Ten;
    if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');          
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg')
            {
                  return redirect('admin/slide/them')->with('loi','Bạn Chỉ Được Chọn File Có Đuôi jpg,png,jpeg');
            }
            
            $name = $file->getClientOriginalName();
            $Hinh =  str_rand(4)."_". $name;
            //echo $Hinh;
            
            while (file_exists("upload/slide/".$Hinh)) 
            {
                $Hinh = str_rand(4)."_". $name;
            }
            $file->move("upload/slide",$Hinh);
            $slide->Hinh = $Hinh;
            
        }
        else
        {
            $slide->Hinh = "";
        }
    $slide->NoiDung=$request->NoiDung;
    $slide->link=$request->link;
    $slide->save();

    return redirect('admin/slide/sua/'.$id)->with('thongbao','bạn đã sửa thành công');
    }

    public function getXoa($id){
        $slide=Slide::find($id);
        $slide->delete();
        return redirect('admin/slide/danhsach')->with('thongbao','bạn đã xóa thành công');
    }
}
