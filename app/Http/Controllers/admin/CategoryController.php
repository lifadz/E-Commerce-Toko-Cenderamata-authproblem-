<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::orderBy('id', $request->sort ?? 'asc')
        ->paginate(8);
        
        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        return view('admin.category.list',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);
    
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            //Menyimpan gambar
            if(!empty($request->image_id)){
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/upload/kategori/'.$newImageName;
                File::copy($sPath,$dPath);

                //Menampilkan thumbnail
                $dPath = public_path().'/upload/kategori/thumbnail/'.$newImageName;

                $img = Image::make($sPath);
                // $img->resize(450,600);
                $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });
                
                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();
            }
            
    
            session()->flash('success', 'Kategori Berhasil Dibuat');
    
            return response()->json([
                'status' => true,
                'message' => 'Kategori Berhasil Diperbarui'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($categoryId,Request $request){        
        $category = Category::find($categoryId);

        if(empty($category)){
            return redirect()->route('categories.index');
        }
        
        return view('admin.category.edit',compact('category'));
        
    }

    public function update($categoryId,Request $request){

        $category = Category::find($categoryId);

        if(empty($category)){
            session()->flash('error', 'Kategori tidak ditemukan');

            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);
    
        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();
            

            $oldImage = $category->image;
            
            //Menyimpan gambar
            if(!empty($request->image_id)){
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/upload/kategori/'.$newImageName;
                File::copy($sPath,$dPath);

                //Menampilkan thumbnail
                $dPath = public_path().'/upload/kategori/thumbnail/'.$newImageName;

                $img = Image::make($sPath);
                // $img->resize(450,600);
                $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });

                $img->save($dPath);

                $category->image = $newImageName;
                $category->save();

                //menghapus gambar lama
                File::delete(public_path().'/upload/kategori/thumbnail/'.$oldImage);
                File::delete(public_path().'/upload/kategori/'.$oldImage);
            }
            
            session()->flash('success', 'Data tersimpan');
    
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

    public function destroy($categoryId,Request $request){

        $category = Category::find($categoryId);

        if(empty($category)){
            session()->flash('error','Kategori tidak ditemukan');
            return response()->json([
                'status' => true,
                'message' => 'Kategori tidak ditemukan'
            ]);
            // return redirect()->route('categories.index');
        }

        File::delete(public_path().'/upload/kategori/thumbnail/'.$category->image);
        File::delete(public_path().'/upload/kategori/'.$category->image);

        $category->delete();

        session()->flash('success','Kategori berhasil dihapus');

        return response()->json([
            'status' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
        
    }
}