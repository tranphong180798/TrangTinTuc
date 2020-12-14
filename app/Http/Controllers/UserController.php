<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function getDanhSach(){
        $user=User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    }
    public function getThem(){
        return view('admin.user.them');
    }
    public function postThem(Request $request){
        $this->validate($request,
            [
                'name'=>'required|min:3|max:100|unique:User,name',
                'email'=>'required|min:3|max:100|unique:User,name'
            ],
            [
                'name.required'=>'Bạn chưa nhập tên ',
                'name.min'=>'Tên thể loại phải có độ dài từ 3 đến 100',
                'name.max'=>'Tên thể loại phải có độ dài lớn nhất là 100',
                'name.unique'=>'Teend thể loại của bạn  đã tồn tại',
                'email.required'=>'Bạn chưa nhập email ',
                'email.min'=>'email thể loại phải có độ dài từ 3 đến 100',
                'email.max'=>'email thể loại phải có độ dài lớn nhất là 100',
                'email.unique'=>'email  của bạn  đã tồn tại',
            ],
        );

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->quyen=$request->quyen;
        $user->save();

        return redirect('admin/user/them')->with('thongbao','bạn đã thêm thành công');
    }

    public function getSua($id){
        $user=User::find($id);
        return view('admin.user.sua',['user'=>$user]);
    }
    public function postSua(Request $request,$id)
    {
       $this->validate($request,[
            'name'=>'required|min:3',
            ],[
            'name.required'=>'Bạn Chưa Nhập Tên Người Dùng',
            'name.min'=>'Tên Người Dùng Phải Có Ít Nhất 3 Ký Tự'          
            ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->quyen = $request->quyen;

        if($request->changepassword == "on")
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
        return redirect('admin/user/sua/'.$id)->with('thongbao','Bạn Đã Sửa Thành Công');

        
    }
    public function getXoa($id){
        $user=User::find($id);
        $user->delete();
        return redirect('admin/user/danhsach')->with('thongbao','bạn đã xóa thành công');
    }

    public function getDangNhapAdmin(){
        return view('admin/login');
    }
    public function postDangNhapAdmin(Request $request){
       $this->validate($request,
       [
            'email' => 'required',
            'password'=>'required|min:3,max:32'
       ],
       [
            'email.request'=>'bạn chưa đăng nhập Email',
            'password.required'=>'bạn chưa đăng nhập mật khẩu',
            'password.min'=>'Mật khẩu không được nhỏ hơn 3 kí tự',
            'password.max'=>'Mật khẩu không được lớn hơn 100 ký tự',
       ]);
       if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
       {
            return redirect('admin/theloai/danhsach');
       }
       else
       {
           return redirect('admin/dangnhap')->with('thongbao','bạn đăng nhập không thành công');
       }
    }

    public function getDangXuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
    function dashboard()
	{
		return view('admin.dashboard.danhsach');
	}
}
