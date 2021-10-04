<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;//phiên bản mới pahir cần use cái này.
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;


class TinTucController extends Controller
{
    public function getDanhSach()
    {
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);   
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request)
    {
         $this->validate($request,[
             'LoaiTin'=>'required',
             'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
             'TomTat'=>'required',
             'NoiDung'=>'required',

            ],[
             'LoaiTin.required'=>'Bạn chưa chọn loại tin',
             'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
             'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 ký tự',
             'TieuDe.unique'=>'Tiêu đề đã tồn tại',
             'TomTat.required'=>'Bạn chưa nhập tóm tắt',
             'NoiDung.required'=>'Bạn chưa nhập nội dung',
            ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;
        
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'ipg' && $duoi != 'png' && $duoi != 'jpeg')
            {
                return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được thêm file có đuôi jpg, png, jpeg');

            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;// vì mình đang sài php phiên bản mới nên phải sửa lại như vầy mới đúng e nha.
            //str_random(4)."_".$name;// phiên bản php cũ thỳ nó sẽ dùng hàm random như vầy. (vì là phiên bản cũ nên hk cần use cái str ở trên)
            while(file_exists("upload/tintuc/".$Hinh))
            {
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else
        {
            $tintuc->Hinh = "";
        }
        //dd($tintuc); này gọi là debug (kiểm tra lỗi bằng cách xuất nó ra xem thử)
        $tintuc->save();
        return redirect('admin/tintuc/them')->with('thongbao','Thêm tin thành công');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);   
        return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postSua(Request $request,$id)
    {
        $tintuc = TinTuc::find($id);
        $this->validate($request,[
            'LoaiTin'=>'required',
            'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe',
            'TomTat'=>'required',
            'NoiDung'=>'required',

           ],[
            'LoaiTin.required'=>'Bạn chưa chọn loại tin',
            'TieuDe.required'=>'Bạn chưa nhập tiêu đề',
            'TieuDe.min'=>'Tiêu đề phải có ít nhất 3 ký tự',
            'TieuDe.unique'=>'Tiêu đề đã tồn tại',
            'TomTat.required'=>'Bạn chưa nhập tóm tắt',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
           ]);

        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
           
           if($request->hasFile('Hinh'))
           {
               $file = $request->file('Hinh');
               $duoi = $file->getClientOriginalExtension();
               if($duoi != 'ipg' && $duoi != 'png' && $duoi != 'jpeg')
               {
                   return redirect('admin/tintuc/them')->with('loi','Bạn chỉ được thêm file có đuôi jpg, png, jpeg');
   
               }
               $name = $file->getClientOriginalName();
               $Hinh = Str::random(4)."_".$name;// vì mình đang sài php phiên bản mới nên phải sửa lại như vầy mới đúng e nha.
               //str_random(4)."_".$name;// phiên bản php cũ thỳ nó sẽ dùng hàm random như vầy. (vì là phiên bản cũ nên hk cần use cái str ở trên)
               while(file_exists("upload/tintuc/".$Hinh))
               {
                   $Hinh = Str::random(4)."_".$name;
               }
               $file->move("upload/tintuc",$Hinh);
               unlink("upload/tintuc/".$tintuc->Hinh);
               $tintuc->Hinh = $Hinh;
           }
           
           //dd($tintuc); này gọi là debug (kiểm tra lỗi bằng cách xuất nó ra xem thử)
           $tintuc->save();
           return redirect('admin/tintuc/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
    }

    public function getXoa($id)
    {
        $tintuc = TinTuc::find($id);
        $tintuc->delete();
        return redirect('admin/tintuc/danhsach')->with('thongbao','Xóa thành công');
    }
}
