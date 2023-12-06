<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Province;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::with('product_images')->find($request->id);
        
        if($product == null){
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ]);
        }
        
        if(Cart::count() > 0){
            // echo "Produk sudah berada di dalam keranjang";
            //Produk sudah di dalam keranjang
            //check jika produk sudah di dalam keranjang
            //Return pesan bahwa produk sudah ada didalam
            //jika produk tidak ditemukan dikeranjang,maka tambahkan produk ke keranjang
            
            $cartContent = Cart::content();
            $productAlreadyExists = false;
            
            foreach($cartContent as $item){
                if($item->id == $product->id){
                    $productAlreadyExists = true;
                    
                }
            }
            
            if($productAlreadyExists == false){
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
                
                $status = true;
                $message = '<strong>'.$product->title.'</strong> berhasil ditambahkan ke dalam keranjangmu!';
                session()->flash('success',$message);
                
            } else {
                $status = false;
                $message = $product->title.' sudah ada di dalam keranjangmu';
            }
            
        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            
            $status = true;
            $message = '<strong>'.$product->title.'</strong> berhasil ditambahkan ke dalam keranjangmu!';
        }
        if(Auth::check() == false){
            
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            } 
            
            return redirect()->route('account.login');
            
        }
        session()->flash('success',$message);
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        
    }
    
    public function cart(){
        
        $cartContent = Cart::content();
        // dd($cartContent);
        $data['cartContent'] = $cartContent;
        
        
        return view('front.cart',$data);
    }
    
    public function updateCart(Request $request){
        
        $rowId = $request->rowId;
        $qty = $request->qty;
        
        $itemInfo = Cart::get($rowId);
        
        $product = Product::find($itemInfo->id);
        //Check jumlah tersedia dalam stok
        if($product->track_qty == 'Yes'){
            if ($qty <= $product->qty){
                Cart::update($rowId, $qty);
                
                $message = 'Keranjang berhasil diperbarui';
                $status = true;
                session()->flash('success',$message);
            } else {
                $message = 'Jumlah yang diinginkan ('.$qty.') tidak tersedia dalam stok';
                $status = false;
                session()->flash('error',$message);
            }
        } else {
            Cart::update($rowId, $qty);
            
            $message = 'Keranjang berhasil diperbarui';
            $status = true;
            session()->flash('success',$message);
        }                
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request){
        
        // $itemInfo = Cart::get($request->rowId);
        
        // iF($itemInfo == null){
        //     $errorMessage = 'Produk tidak ditemukan dikeranjang';
        //     session()->flash('error',$errorMessage);
            
        //     return response()->json([
        //         'status' => false,
        //         'message' => $errorMessage
        //     ]);
        // }

        // Cart::remove($request->rowId);
        
        // $message = 'Produk berhasil dihapus dari keranjang';
        
        // session()->flash('success',$message);
        // return response()->json([
        //     'status' => true,
        //     'message' => $message
        // ]);

        $itemInfo = Cart::get($request->rowId);

        if($itemInfo == null){
            $errorMessage = 'Produk tidak ditemukan dikeranjang';
            session()->flash('error',$errorMessage);

            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }

        Cart::remove($request->rowId);

        $message = 'Produk berhasil dihapus dari keranjang';

        // session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function checkout (){
        
        //Jika keranjang kosong, maka redirect ke halaman keranjang
        if(Cart::count() == 0){
            return redirect()->route('front.cart');
        }

        //Jika user belum login, maka akan diarahkan ke halaman login
        if(Auth::check() == false){
            
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            } 
            
            return redirect()->route('account.login');
            
        }

        session()->forget('url.intended');

        $provinces = Province::orderBy('id', 'ASC')->get();

        return view('front.checkout',[
            'provinces' => $provinces
        ]);
    }
}