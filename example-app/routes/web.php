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
use App\TheLoai;
Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dangnhap','UserController@getdangnhapAdmin');
Route::post('admin/dangnhap','UserController@postdangnhapAdmin');
Route::get('admin/logout','UserController@getdangxuatAdmin');


Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
    Route::group(['prefix'=>'theloai'],function(){
        //admin/theloai/danhsach 
        Route::get('danhsach','TheLoaiController@getDanhSach');

        Route::get('sua/{id}','TheLoaiController@getSua');
        Route::post('sua/{id}','TheLoaiController@postSua');

        Route::get('them','TheLoaiController@getThem');
        Route::post('them','TheLoaiController@postThem');
        
        Route::get('xoa/{id}','TheLoaiController@getXoa');
        
    });

    Route::group(['prefix'=>'loaitin'],function(){
        //admin/loaitin/danhsach 
        Route::get('danhsach','LoaiTinController@getDanhSach');

        Route::get('sua/{id}','LoaiTinController@getSua');
        Route::post('sua/{id}','LoaiTinController@postSua');

        Route::get('them','LoaiTinController@getThem');
        Route::post('them','LoaiTinController@postThem');

        Route::get('xoa/{id}','LoaiTinController@getXoa');
    });

    Route::group(['prefix'=>'tintuc'],function(){
        //admin/tintuc/danhsach 
        Route::get('danhsach','TinTucController@getDanhSach');

        Route::get('sua/{id}','TinTucController@getSua');
        Route::post('sua/{id}','TinTucController@postSua');
        
        Route::get('them','TinTucController@getThem');
        Route::post('them','TinTucController@postThem');

        Route::get('xoa/{id}','TinTucController@getXoa');
    });

    Route::group(['prefix'=>'comment'],function(){

        Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');

    });

    Route::group(['prefix'=>'slide'],function(){
        
        Route::get('danhsach','SlideController@getDanhSach');

        Route::get('sua/{id}','SlideController@getSua');
        Route::post('sua/{id}','SlideController@postSua');
        
        Route::get('them','SlideController@getThem');
        Route::post('them','SlideController@postThem');

        Route::get('xoa/{id}','SlideController@getXoa');
    });

    Route::group(['prefix'=>'user'],function(){
        
        Route::get('danhsach','UserController@getDanhSach');

        Route::get('sua/{id}','UserController@getSua');
        Route::post('sua/{id}','UserController@postSua');
        
        Route::get('them','UserController@getThem');
        Route::post('them','UserController@postThem');

        Route::get('xoa/{id}','UserController@getXoa');
    });

    Route::group(['prefix'=>'ajax'],function(){
        Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');

    });


});

    Route::get('trangchu','PagesController@trangchu');
    Route::get('lienhe','PagesController@lienhe');
    Route::get('gioithieu','PagesController@gioithieu');
    Route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
    Route::get('tintuc/{id}/{TieuDeKhongDau}.html','PagesController@tintuc');
    Route::get('dangnhap','PagesController@getdangnhap');
    Route::post('dangnhap','PagesController@postdangnhap');
    Route::get('dangxuat','PagesController@getdangxuat');
    Route::get('search','PagesController@getSearch');




