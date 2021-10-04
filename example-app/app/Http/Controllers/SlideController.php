<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;//phiên bản mới pahir cần use cái này.

use App\Slide;

class SlideController extends Controller
{
    public function getDanhSach()
    {
        $slide = Slide::all();
        return view('admin.slide.danhsach',['slide'=>$slide]);
    }

    public function getThem()
    {
        return view('admin.slide.them');
    }

    public function postThem(Request $request)
    {
        $this->validate($request,[
            'Ten'=>'required',
            'NoiDung'=>'required',

           ],[
            'Ten.required'=>'Bạn chưa nhập tên',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
           ]);

        $slide = new Slide;
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if($request->has('link'))
           $slide->link = $request->link;
           
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'ipg' && $duoi != 'png' && $duoi != 'jpeg')
            {
                return redirect('admin/slide/them')->with('loi','Bạn chỉ được thêm file có đuôi jpg, png, jpeg');
   
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;// vì mình đang sài php phiên bản mới nên phải sửa lại như vầy mới đúng e nha.
               //str_random(4)."_".$name;// phiên bản php cũ thỳ nó sẽ dùng hàm random như vầy. (vì là phiên bản cũ nên hk cần use cái str ở trên)
            while(file_exists("upload/slide/".$Hinh))
            {
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/slide",$Hinh);
            // unlink("upload/slide/".$slide->Hinh);
            $slide->Hinh = $Hinh;
        }
        else
        {
            $slide->Hinh = "";
        }
           
           dd($slide); //này gọi là debug (kiểm tra lỗi bằng cách xuất nó ra xem thử)
        $slide->save();
        return redirect('admin/slide/them')->with('thongbao','Thêm slide thành công');
    }

    public function getSua($id)
    {
        $slide = Slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide]);
    }

    public function postSua(Request $request,$id)
    {
        $this->validate($request,[
            'Ten'=>'required',
            'NoiDung'=>'required',

           ],[
            'Ten.required'=>'Bạn chưa nhập tên',
            'NoiDung.required'=>'Bạn chưa nhập nội dung',
           ]);

        $slide = Slide::find($id);
        $slide->Ten = $request->Ten;
        $slide->NoiDung = $request->NoiDung;
        if($request->has('link'))
           $slide->link = $request->link;
           
        if($request->hasFile('Hinh'))
        {
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'ipg' && $duoi != 'png' && $duoi != 'jpeg')
            {
                return redirect('admin/slide/them')->with('loi','Bạn chỉ được thêm file có đuôi jpg, png, jpeg');
   
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;// vì mình đang sài php phiên bản mới nên phải sửa lại như vầy mới đúng e nha.
               //str_random(4)."_".$name;// phiên bản php cũ thỳ nó sẽ dùng hàm random như vầy. (vì là phiên bản cũ nên hk cần use cái str ở trên)
            while(file_exists("upload/slide/".$Hinh))
            {
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/slide",$Hinh);
            unlink("upload/slide/".$slide->Hinh);
            $slide->Hinh = $Hinh;
        }
    
           
           //dd($tintuc); này gọi là debug (kiểm tra lỗi bằng cách xuất nó ra xem thử)
        $slide->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','Sửa slide thành công');
    
    }

    public function getXoa($id)
    {
        $slide = Slide::find($id);
        $slide->delete();

        return redirect('admin/slide/danhsach')->with('thongbao','Xóa thành công');
    }
}
