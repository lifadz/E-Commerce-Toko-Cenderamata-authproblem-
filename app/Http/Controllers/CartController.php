<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
                // Cart::add([
                //     'id' => $product->id,
                //     'name' => $product->title,
                //     'qty' => 1,
                //     'price' => $product->price,
                //     'options' => [
                //         'user_id' => Auth::id(), // Menyimpan ID pengguna
                //         'productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '',
                //     ],
                // ]);
                
                $status = true;
                $message = '<strong>'.$product->title.'</strong> berhasil ditambahkan ke dalam keranjangmu!';
                session()->flash('success',$message);
                
            } else {
                $status = false;
                $message = $product->title.' sudah ada di dalam keranjangmu';
                
            }
            
        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            // Cart::add([
            //     'id' => $product->id,
            //     'name' => $product->title,
            //     'qty' => 1,
            //     'price' => $product->price,
            //     'options' => [
            //         'user_id' => Auth::id(), // Menyimpan ID pengguna
            //         'productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '',
            //     ],
            // ]);
            
            $status = true;
            $message = '<strong>'.$product->title.'</strong> berhasil ditambahkan ke dalam keranjangmu!';
        }
        if(Auth::check() == false){
            
            if(!session()->has('url.intended')){
                session(['url.intended' => url()->current()]);
            } 
            
            return redirect()->route('account.login'); //auth checking yg tidak berfungsi
            
        }
        
        session()->flash('success',$message);
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        
    }
    
    public function cart(){
        
        // $userId = Auth::id();

        $cartContent = Cart::content();
        // $cartContent = Cart::content()->filter(function ($item) use ($userId) {
        //     return $item->options->user_id == $userId;
        // });
        
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

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();


        session()->forget('url.intended');

        $provinces = Province::orderBy('id', 'ASC')->get();

        //Perhitungan pengiriman
        if($customerAddress != ''){

            $userProvince = $customerAddress->province_id;

            $shippingInfo = ShippingCharge::where('province_id',$userProvince,)->first();
            
            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }

            $totalShippingCharge = $totalQty * $shippingInfo->amount;

            $grandTotal = Cart::subtotal(3,'.','') + $totalShippingCharge;
                
        } else {
            
            $grandTotal = Cart::subtotal(3,'.','');
            $totalShippingCharge = 0;

        }

        return view('front.checkout',[
            'provinces' => $provinces,
            'customerAddress' => $customerAddress,
            'totalShippingCharge' => $totalShippingCharge,
            'grandTotal' => $grandTotal
        ]);
    }

    public function processCheckout(Request $request){
        //step1 validasi
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'address' => 'required',
            'city' => 'required',
            'district' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
            
        ]);

        if($validator->fails()){
           return response()->json([
                'message' => 'Please fix the errors',
                'status' => false,
                'errors' => $validator->errors()
           ]);
        }

         //step2 menyimpan alamat user
        // $customerAddress = CustomerAddress::find();

        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'province_id' => $request->province,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'district' => $request->district, 
                'zip' => $request->zip
            ],
        );

        //step3 menyimpan data ke dalam tabel pesanan
        if($request->payment_method == 'COD'){

            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(3,'.','');
            $grandTotal = $subTotal + $shipping;

            //Menghitung pengiriman
            $shippingInfo = ShippingCharge::where('province_id',$request->province)->first();

            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }

            if($shippingInfo != null){

                $shipping = $totalQty * $shippingInfo->amount;
                $grandTotal =  $subTotal + $shipping;

                // $shipping = number_format($totalQty * $shippingInfo->amount, 3, '.', '');
                // $grandTotal = number_format($subTotal + $shipping, 3, '.', '');
                
            } 

            $order = new Order;
            // $order->user_id = Auth::id(); // Menyimpan ID pengguna
            // $order->user_id = $userId; // Menyimpan ID pengguna
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->district = $request->district;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->notes;
            $order->province_id = $request->province;
            $order->save();

        //step 4 menyimpan item pesanan di tabel item pesanan
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                // $orderItem->user_id = Auth::id(); // Menyimpan ID pengguna
                // $orderItem->user_id = $userId; // Menyimpan ID pengguna
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();
            }

            session()->flash('success','Anda telah berhasil melakukan pemesanan.');

            Cart::destroy();

            return response()->json([
                'message' => 'Pesanan berhasil disimpan.',
                'orderId' => $order->id,
                'status' => true,
           ]);
        } else { 
            
        }

    }

    public function thankyou($id){
        return view('front.thanks',[
            'id' => $id
        ]);
    }

    public function getOrderSummary(Request $request){

        $subTotal = Cart::subtotal(3,'.','');
        
        if($request->province_id > 0){

            $shippingInfo = ShippingCharge::where('province_id',$request->province_id)->first();

            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;
            }
            
            if($shippingInfo != null){

                $shippingCharge = $totalQty * $shippingInfo->amount;
                $grandTotal =  $subTotal + $shippingCharge;

                return response()->json([
                    'status' => true,
                    // 'grandTotal' => $grandTotal,
                    'grandTotal' => number_format($grandTotal,3),
                    'shippingCharge' => number_format($shippingCharge,3)
                ]);
                
            } else {
                
            }
            
        } else {

            return response()->json([
                'status' => true,
                'grandTotal' => number_format($subTotal,3),
                // 'grandTotal' => $subTotal,
                'shippingCharge' => number_format(0,3)
            ]);
            
        }
    }
}