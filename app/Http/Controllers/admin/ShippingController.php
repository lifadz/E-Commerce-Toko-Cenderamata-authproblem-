<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create(Request $request){
        // $provinces = Province::get();
        // $data['provinces'] = $provinces;

        // $shippingCharges = ShippingCharge::select('shipping_charges.*','provinces.name')
        //                    ->leftJoin('provinces','provinces.id','shipping_charges.province_id')
        //                    ->get();
        
        // $data['shippingCharges'] = $shippingCharges;
        
        // return view('admin.shipping.create',$data);

        $provinces = Province::get();
        $data['provinces'] = $provinces;
    
        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'provinces.name')
            ->leftJoin('provinces', 'provinces.id', 'shipping_charges.province_id');
    
        if (!empty($request->get('keyword'))) {
            $shippingCharges = $shippingCharges->where('provinces.name', 'like', '%' . $request->get('keyword') . '%');
        }
    
        $shippingCharges = $shippingCharges->paginate(3);
    
        $data['shippingCharges'] = $shippingCharges;
    
        return view('admin.shipping.create', $data);
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(),[
           'province' => 'required',
           'amount' => 'required|numeric'
        ]);

        if($validator->passes()){

            $count = ShippingCharge::where('province_id',$request->province)->count();
            
            if($count > 0){
            Session()->flash('error','Biaya Pengiriman sudah ada!');
            return response()->json([
                'status' => true
            ]);
        }

            $shipping = new ShippingCharge;
            $shipping->province_id = $request->province; 
            $shipping->amount = $request->amount; 
            $shipping->save();
            
            Session()->flash('success','Biaya Pengiriman berhasil ditambahkan');

            return response()->json([
                'status' => true,
            ]);
            
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id) {

        $shippingCharge = ShippingCharge::find($id);
        
        $provinces = Province::get();
        $data['provinces'] = $provinces;
        $data['shippingCharge'] = $shippingCharge;
        
        return view('admin.shipping.edit',$data);
    }

    public function update($id,Request $request){
        $shipping = ShippingCharge::find($id);

        
        $validator = Validator::make($request->all(),[
           'province' => 'required',
           'amount' => 'required|numeric'
        ]);

        if($validator->passes()){

            if($shipping == null) {
                Session()->flash('success','Biaya Pengiriman tidak ditemukan!');
    
                return response()->json([
                    'status' => true,
                ]);
            }

            $shipping->province_id = $request->province; 
            $shipping->amount = $request->amount; 
            $shipping->save();
            
            Session()->flash('success','Biaya Pengiriman berhasil diperbarui');

            return response()->json([
                'status' => true,
            ]);
            
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy($id) {
        $shippingCharge =  ShippingCharge::find($id);

        if($shippingCharge == null) {
            Session()->flash('success','Biaya Pengiriman tidak ditemukan!');

            return response()->json([
                'status' => true,
            ]);
        }

        $shippingCharge->delete();

        Session()->flash('success','Biaya Pengiriman berhasil dihapus');

        return response()->json([
            'status' => true,
        ]);
    }
}