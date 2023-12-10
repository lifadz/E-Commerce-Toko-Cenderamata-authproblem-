<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    public function index(Request $request) {

        $discountCoupons = DiscountCoupon::orderBy('id', $request->sort ?? 'asc');
        
        if(!empty($request->get('keyword'))){
            $discountCoupons = $discountCoupons->where('name','like','%'.$request->get('keyword').'%');
        }

        $discountCoupons = $discountCoupons->paginate(8);

        return view('admin.voucher.list',compact('discountCoupons'));
        
    }

    public function create() {
        return view('admin.voucher.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' => 'required',
            'discount_amount' => 'required|numeric',
            'status' => 'required',
            
        ]);

        if ($validator->passes()){

            //Tanggal berlaku harus lebih dari tanggal sekarang
            if(!empty($request->starts_at)){
                $now = Carbon::now();
                $startsAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

                if($startsAt->lte($now) == true){
                    return response()->json([
                        'status' => false,
                        'errors' => ['starts_at'=>'Start date can not be less than current date time'],
                    ]); 
                }
            }

            //tanggal berakhir harus
            if(!empty($request->starts_at) && !empty($request->expires_at)){
                $expiresAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);
                $startsAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);

                if($expiresAt->gt($startsAt) == false){
                    return response()->json([
                        'status' => false,
                        'errors' => ['expires_at'=>'Expiry date must be greator than current date time'],
                    ]); 
                }
            } 

            $discountCode = new DiscountCoupon();
            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->starts_at = $request->starts_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            $message = 'Voucher Diskon berhasil ditambahkan.';
            session()->flash('success',$message);

            return response()->json([
                'status' => true,
                'message' => $message,
            ]); 
            
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]); 
        }
        
    }

    public function edit(Request $request, $id){

        $coupon = DiscountCoupon::find($id);

        if($coupon == null){
            session()->flash('error','Voucher tidak ditemukan');
            return redirect()->route('voucher.index');
        }

        $data['coupon'] = $coupon;

        return view('admin.voucher.edit',$data);
        
    }
    public function update(){
        
        

    }

    public function destroy(){
        
    }
}