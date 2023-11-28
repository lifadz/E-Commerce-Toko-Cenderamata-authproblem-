<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $products = Product::latest('id')->with('product_images')->paginate();
        // dd('$products');
        
        // $data['products'] = $products;
        // return view('admin.product.list',$data);
        $products = Product::orderBy('id', $request->sort ?? 'asc')->with('product_images');
        $data['products'] = $products;
        
        if(!empty($request->get('keyword'))){
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }
        $products = $products->paginate(10);

        return view('admin.product.list',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('nama', 'ASC')->get();
        $brands = Brand::orderBy('nama', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // dd($request->image_array);
        // exit();
        
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(),$rules);
        
        if($validator->passes()) {

            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;

            $product->save();

            //Menyimpan galeri gambar
            if(!empty($request->image_array)){
                foreach($request->image_array as $temp_image_id){
                    
                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.',$tempImageInfo->nama);
                    $ext = last($extArray);

                    
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    //Menampilkan thumbnail produk
                    

                    //Gambar ukuran large

                    $sourcePath = public_path().'/temp/'.$tempImageInfo->nama;
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
                    
                }
            }

            session()->flash('success', 'Produk Berhasil Ditambahkan');

            return response()->json([
                'status' => true,
                'message' => 'Produk berhasil ditambahkan'
            ]);
                        
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,Request $request)
    {

        $product = Product::find($id);

        if(empty($product)){
            return redirect()->route('products.index')->with('error','Produk tidak ditemukan');
        }

        //Mengambil gambar produk
        $productImages = ProductImage::where('product_id',$product->id)->get();

        
        $subCategories = SubCategory::where('category_id',$product->category_id)->get();
        

        $data = [];
        $categories = Category::orderBy('nama', 'ASC')->get();
        $brands = Brand::orderBy('nama', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $data['productImages'] = $productImages;
        

        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {
        $product = Product::find($id);

        
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(),$rules);
        
        if($validator->passes()) {

            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;

            $product->save();

            //Menyimpan galeri gambar

            session()->flash('success', 'Produk berhasil diperbarui');

            return response()->json([
                'status' => true,
                'message' => 'Produk berhasil diperbarui'
            ]);
                        
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}