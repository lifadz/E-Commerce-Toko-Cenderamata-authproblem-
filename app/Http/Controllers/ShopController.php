<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request,$categorySlug = null, $subCategorySlug = null){

        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];

        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status',1)->get();

        $products = Product::where('status',1);

        //Membuat filter produk
        if(!empty($categorySlug)){
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;

        }

        if(!empty($subCategorySlug)){
            $subCategory = SubCategory::where('slug',$subCategorySlug)->first();
            $products = $products->where('sub_category_id',$subCategory->id);
            $subCategorySelected = $subCategory->id;

        }

        if(!empty($request->get('brand'))){
            $brandsArray = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id',$brandsArray);    
        }
        
        if($request->get('harga_max') != '' && $request->get('harga_min') != ''){

            if($request->get('harga_max') == 500000){
                
                $products = $products->whereBetween('price',[intval($request->get('harga_min')), 1000000]);    
                
            } else {
                
                $products = $products->whereBetween('price',[intval($request->get('harga_min')),intval($request->get('harga_max'))]);    

            }
            

        }
        
        if($request->get('sort') != ''){
            if($request->get('sort') == 'terbaru'){
                $products = $products->orderBy('id', 'DESC');
            } else if($request->get('sort') == 'harga_terendah'){
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');

            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        $products = $products->paginate(6);
        
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMax'] = (intval($request->get('harga_max')) == 0) ? 500000 : $request->get('harga_max');
        $data['priceMin'] = intval($request->get('harga_min'));
        $data['sort'] = $request->get('sort');

        return view('front.shop',$data);
    }

    public function product($slug){
        // echo $slug;
        $product = Product::where('slug',$slug)->with('product_images')->first();
        if($product == null){
            abort(404);
        }

        $relatedProducts = [];
        //mengambil data produk terkait

        if($product->related_products != ''){
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;

        

        return view('front.product',$data);
    }
}