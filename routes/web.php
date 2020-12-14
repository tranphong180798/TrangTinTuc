<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

route::get('/admin',function () {
    return view('admin.layout.index');
});


route::get('admin/dangnhap','UserController@getDangNhapAdmin');
route::post('admin/dangnhap','UserController@postDangNhapAdmin');
route::get('admin/logout','UserController@getDangXuatAdmin');
Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function()
	
{
	Route::get('dashboard','UserController@dashboard');
	Route::group(['prefix'=>'theloai'],function()
	{
		//danhsach
		Route::get('danhsach','TheLoaiController@getDanhSach');
		
		//them 
		route::get('them','TheLoaiController@getThem');
		route::post('them','TheLoaiController@postThem');

		//sua
		route::get('sua/{id}','TheLoaiController@getSua');
		route::post('sua/{id}','TheLoaiController@postSua');
	
		//xoa
		route::get('xoa/{id}','TheLoaiController@getXoa');

	});

	Route::group(['prefix'=>'loaitin'],function()
	{
		//danhsach
		Route::get('danhsach','LoaiTinController@getDanhSach');
		
		//them 
		route::get('them','LoaiTinController@getThem');
		route::post('them','LoaiTinController@postThem');

		//sua
		route::get('sua/{id}','LoaiTinController@getSua');
		route::post('sua/{id}','LoaiTinController@postSua');
	
		//xoa
		route::get('xoa/{id}','LoaiTinController@getXoa');
		
	});

	Route::group(['prefix'=>'tintuc'],function()
	{
		//danhsach
		Route::get('danhsach','TinTucController@getDanhSach');
		
		//them 
		route::get('them','TinTucController@getThem');
		route::post('them','TinTucController@postThem');

		//sua
		route::get('sua/{id}','TinTucController@getSua');
		route::post('sua/{id}','TinTucController@postSua');
	
		//xoa
		route::get('xoa/{id}','TinTucController@getXoa');
		
	
	});

	Route::group(['prefix'=>'comment'],function()
	{
		
	
	});

	Route::group(['prefix'=>'slide'],function()
	{
		//danhsach
		Route::get('danhsach','SlideController@getDanhSach');
		
		//them 
		route::get('them','SlideController@getThem');
		route::post('them','SlideController@postThem');

		//sua
		route::get('sua/{id}','SlideController@getSua');
		route::post('sua/{id}','SlideController@postSua');
	
		//xoa
		route::get('xoa/{id}','SlideController@getXoa');
	
	});

	Route::group(['prefix'=>'user'],function()
	{
	
			//danhsach
			Route::get('danhsach','UserController@getDanhSach');
		
			//them 
			route::get('them','UserController@getThem');
			route::post('them','UserController@postThem');
	
			//sua
			route::get('sua/{id}','UserController@getSua');
			route::post('sua/{id}','UserController@postSua');
		
			//xoa
			route::get('xoa/{id}','UserController@getXoa');
		
		
	
	});

	Route::group(['prefix'=>'ajax'],function()
	{
		Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
	});

});	

Route::get('trangchu','PagesController@trangchu');
route::get('gioithieu','PagesController@gioithieu');
route::get('lienhe','PagesController@lienhe');

route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
route::get('tintuc/{id}/{TieuDeKhongDau}.html','PagesController@tintuc');

route::get('dangnhap','pagesController@getDangNhap');
route::post('dangnhap','pagesController@postDangNhap');
route::get('dangxuat','pagesController@getDangXuat');

route::get('nguoidung','pagesController@getNguoiDung');
route::post('nguoidung','pagesController@postNguoiDung');

route::get('dangky','pagesController@getDangky');
route::post('dangky','pagesController@postDangky');

route::get('timkiem','pagesController@getTimkiem');
