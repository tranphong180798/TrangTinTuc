<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\TheLoai;
use App\Models\Slide;
use App\Models\LoaiTin;
use App\Models\TinTuc;
use App\Models\User;
class PagesController extends Controller
{
    function __construct()
	{
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai',$theloai);
		view()->share('slide',$slide);

		if(Auth::check())
		{
			view()->share('nguoidung',Auth::user());
		}
    }
    
    function trangchu()
	{
		
		return view('pages.trangchu');
    }
    function gioithieu(){
        return view('pages.gioithieu');
    }
    function lienhe(){
        return view('pages.lienhe');
    }

    public function loaitin($id){
            $loaitin=LoaiTin::find($id);
            $tintuc=Tintuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    public function tintuc($id)
    {   
        $tintuc=Tintuc::find($id);
        $tinnoibat=Tintuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan=Tintuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinlienquan'=>$tinlienquan,'tinnoibat'=>$tinnoibat]);
    }

    public function getDangNhap(){

        return view('pages.dangnhap');
    }

    public function postDangNhap(Request $request){

       
		 $this->validate($request,[
            'email'=>'required',
            'password'=>'required|min:3|max:32'
            ],
            [
            'email.request'=>'Bạn Chưa Nhập Email',
            'password.required'=>'Bạn Chưa Nhập Mật Khẩu',
            'password.min'=>'Mật Khẩu Không Được Nhỏ Hơn 3 Ký Tự',
            'password.max'=>'Mật Khẩu Không Được Nhỏ Hơn 32 Ký Tự'
            ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('trangchu');
        }
        else
        {
            return redirect('dangnhap')->with('thongbao','Bạn Đăng Nhập Không Thành Công');
        }
    }
    public function getDangXuat(){
        Auth::logout();
        return redirect('trangchu');
    }

    public function getNguoiDung(){
        $user=Auth::user();
        return view('pages.nguoidung',['nguoidung'=>$user]);
    }

    public function postNguoiDung(Request $request){

        $this->validate($request,[
            'name'=>'required|min:3',
            ],[
            'name.required'=>'Bạn Chưa Nhập Tên Người Dùng',
            'name.min'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự'          
            ]);
        $user = Auth::user();
        $user->name = $request->name;

        if($request->changePassword == "on")
        {
            $this->validate($request,[
            'password'=>'required|min:3|max:32',
            'passwordagain'=>'required|same:password'
            ],[
            'password.required'=>'Bạn Chưa Nhập Mật Khẩu',
            'password.min'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự',
            'password.max'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự',
            'passwordagain.required'=>'Bạn Chưa Nhập Lại Mật Khẩu',
            'passwordagain.same'=>'Mật Khẩu Nhập Chưa Khớp'
            ]);
            $user->password =bcrypt($request->password);
        }
        $user->save();
        return redirect('nguoidung')->with('thongbao','Bạn Đã Sửa Thành Công');
    }

    public function getDangky(){
        return view('pages.dangki');
    }

    public function postDangKy(Request $request){

        $this->validate($request,[
            'name'=>'required|min:3',
            'email'=>'required|min:3|unique:users,email',
            'password'=>'required|min:3|max:32',
            'passwordagain'=>'required|same:password'
            ],[
            'name.required'=>'Bạn Chưa Nhập Tên Người Dùng',
            'name.min'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự',
            'email.unique'=>'Email Đã Tồn Tại',
            'email.required'=>'Bạn Chưa Nhập Email',
            'email.email'=>'Bạn Chưa Nhập Đúng Định Dạng Email',
            'password.required'=>'Bạn Chưa Nhập Mật Khẩu',
            'password.min'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự',
            'password.max'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự',
            'passwordagain.required'=>'Bạn Chưa Nhập Lại Mật Khẩu',
            'passwordagain.same'=>'Mật Khẩu Nhập Chưa Khớp'
            ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =bcrypt($request->password);
        $user->quyen = 0;

        $user->save();

        return redirect('dangky')->with('thongbao','Bạn Đã Đăng Ký Thành Công');
    }
    public function getTimKiem(Request $request){
        $tukhoa=$request->get('tukhoa');
        $tintuc=TinTuc::where('TieuDe','like',"%$tukhoa%")->orwhere('TomTat','like',"%$tukhoa%")->orwhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5)->appends(['tukhoa'=>$tukhoa]);
        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
    }
}
