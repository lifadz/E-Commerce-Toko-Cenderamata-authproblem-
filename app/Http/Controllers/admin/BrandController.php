<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::orderBy('id', $request->sort ?? 'asc');
        
        if(!empty($request->get('keyword'))){
            $brand = $brands->where('nama','like','%'.$request->get('keyword').'%');
        }
        $brands = $brands->paginate(10);

        return view('admin.brand.list',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        if($validator->passes()){
            $brand = new Brand();
            $brand->nama = $request->nama;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brand berhasil ditambahkan'
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
    
    public function edit($id,Request $request)
    {
        $brand = Brand::find($id);
        
        if(empty($brand)){
            session()->flash('error','Data tidak ditemukan');
            return redirect()->route('brands.index');
        }
        
        $data['brand'] = $brand;

        return view('admin.brand.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {

        $brand = Brand::find($id);
        
        if(empty($brand)){
            session()->flash('error','Data tidak ditemukan');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
        ]);

        if($validator->passes()){
            $brand->nama = $request->nama;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            session()->flash('success', 'Brand Berhasil Diperbarui');


            return response()->json([
                'status' => true,
                'message' => 'Brand berhasil diperbarui'
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
    public function destroy($id,Request $request)
    {
        $brand = Brand::find($id);


        if(empty($brand)){
            session()->flash('error','Data tidak ditemukan');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $brand->delete();

        session()->flash('success', 'Brand berhasil dihapus');

        return response()->json([
            'status' => true,
            'message'=> 'Brand berhasil dihapus'
        ]);
    }
}