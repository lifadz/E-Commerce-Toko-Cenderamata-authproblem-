<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::orderBy('id', $request->sort ?? 'asc');
        
        if(!empty($request->get('keyword'))){
            $categories = $categories->where('nama','like','%'.$request->get('keyword').'%');
        }
        $categories = $categories->paginate(10);

        return view('admin.category.list',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'slug' => 'required|unique:categories',
        ]);
    
        if ($validator->passes()) {
            $category = new Category();
            $category->nama = $request->nama;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            //Menyimpan gambar
            if(!empty($request->image_id)){
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->nama);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->nama;
                $dPath = public_path().'/upload/kategori'.$newImageName;
                File::copy($sPath,$dPath);

                //Menampilkan thumbnail
                $dPath = public_path().'/upload/kategori/thumbnail/'.$newImageName;

                $img = Image::make($sPath);
                $img->resize(450,600);
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }
            
    
            session()->flash('success', 'Kategori Berhasil Dibuat');
    
            return response()->json([
                'status' => true,
                'message' => 'Kategori Berhasil Dibuat'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(){
        
    }

    public function update(){
        
    }

    public function destroy(){
        
    }
}