<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TheLoai;
use App\Slide;
use App\TinTuc;
use App\LoaiTin;

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

    function lienhe()
    {
        return view('pages.lienhe');
    }

    function gioithieu()
    {
        return view('pages.gioithieu');
    }

    function getSearch(Request $req)
    {
        
        return view('pages.search');
    }

    function loaitin($id)
    {
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }

    function tintuc($id)
    {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = Tintuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }

    function getdangnhap()
    {
        return view('pages.dangnhap');
    }

    function postdangnhap(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required|min:3|max:32',
           ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min'=>'Mật khẩu có ít nhất 3 ký tự',
            'password.max'=>'Mật khẩu tối đa 32 ký tự',

            'passwordAgain.required'=>'Bạn chưa nhập lại email',
            'passwordAgain.same'=>'Mật khẩu nhập lại chưa khớp',

           ]);

        
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
               //dd(Auth::user());
           return redirect('trangchu');
        }
        else
        {
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }      
    }

    function getdangxuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }
}
