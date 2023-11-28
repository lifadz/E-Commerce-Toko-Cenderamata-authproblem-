<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class ProductImageController extends Controller
{
    
    public function update(Request $request)
    {
        
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $sourcePath = $image->getPathName();
        
        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();
        
        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();
        
        //Gambar ukuran large
        $destPath = public_path().'/upload/produk/gambar_large/'.$imageName;
        $image = Image::make($sourcePath);
        $image->resize(1400,null,function($constraint){
            $constraint->aspectRatio();
        });
        $image->save($destPath);
        
        
        //Gambar ukuran small
        $destPath = public_path().'/upload/produk/gambar_small/'.$imageName;
        $image = Image::make($sourcePath);
        $image->fit(300,300);
        $image->save($destPath);

        return response()->json([
            'status' => true,   
            'image_id' => $productImage->id,
            'ImagePath' => asset('upload/produk/gambar_small/'.$productImage->image),
            'message' => 'Gambar berhasil disimpan'
        ]);
    }

    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);
        
        if(empty($productImage)){
            return response()->json([
                'status' => false,   
                'message' => 'Gambar tidak ditemukan'
            ]);
        }
        
        // Menghapus gambar dari folder
        File::delete(public_path('upload/produk/gambar_large/'.$productImage->image));
        File::delete(public_path('upload/produk/gambar_small/'.$productImage->image));

        $productImage->delete();

        return response()->json([
            'status' => true,   
            'message' => 'Gambar berhasil dihapus'
        ]);
    }
        
}