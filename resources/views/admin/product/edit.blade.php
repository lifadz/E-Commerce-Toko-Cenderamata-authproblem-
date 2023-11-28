@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Produk</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('products.index')}}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="post" name="productForm" id="productForm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Nama Produk</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Nama Produk" value="{{$product->title}}">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$product->slug}}">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Deskripsi</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Deskripsi Produk">{{$product->description}}</textarea>
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>								
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Drag file kesini atau klik untuk upload.<br><br>                                            
                                </div>
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="row" id="product-gallery">
                        @if ($productImages->isNotEmpty())
                            @foreach ($productImages as $image)
                            <div class="col-md-3" id="image-row-{{$image->id}}"> 
                                <div class="card">
                                    <input type="hidden" name="image_array[]" value="{{$image->id}}">
                                    <img src="{{asset('upload/produk/gambar_small/'.$image->image)}}" class="card-img-top" alt="">
                                    <div class="card-body">
                                        <a href="javascript:void(0)" onclick="deleteImage({{$image->id}})" class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Penetapan Harga</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Harga</label>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{$product->price}}">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Harga Perbandingan</label>
                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{$product->compare_price}}">
                                        <p class="text-muted mt-3">
                                            Untuk memberi kesan pada pelanggan seolah harga sedang turun, masukkan harga yang sedikit lebih tinggi dari harga asli produk pada bagian "Harga Perbandingan" dan masukkan harga asli produk pada bagian "Harga".
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventaris</h2>								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="SKU" value="{{$product->sku}}">
                                        <p class="error"></p>		
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{$product->barcode}}">	
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No">
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" {{($product->track_qty == 'Yes') ? 'checked' : ''}}>
                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Jumlah" value="{{$product->qty}}">
                                        <p class="error"></p>	
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{($product->status == 1) ? 'selected' : ''}} value="1">Aktif</option>
                                    <option {{($product->status == 0) ? 'selected' : ''}} value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Kategori Produk</h2>
                            <div class="mb-3">
                                <label for="category">Kategori</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Pilih Kategori</option>
                                    
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)

                                            <option {{($product->category_id == $category->id) ? 'selected' : ''}} value="{{ $category->id}}">{{$category->nama}}</option>
                                    
                                        @endforeach
                                    @endif
                                    
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3">
                                <label for="category">Sub-Kategori</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Pilih Sub-Kategori</option>

                                    @if ($subCategories->isNotEmpty())
                                        @foreach ($subCategories as $subCategory)

                                            <option {{($product->sub_category_id == $subCategory->id) ? 'selected' : ''}} value="{{ $subCategory->id}}">{{$subCategory->nama}}</option>
                                    
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Brand Produk</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">Pilih Brand</option>
                                    @if ($brands->isNotEmpty())
                                        @foreach ($brands as $brand)

                                            <option {{($product->brand_id == $brand->id) ? 'selected' : ''}}  value="{{ $brand->id}}">{{$brand->nama}}</option>
                                    
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Produk Unggulan</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option {{($product->is_featured == 'No') ? 'selected' : ''}} value="No">Tidak</option>
                                    <option {{($product->is_featured == 'Yes') ? 'selected' : ''}} value="Yes">Ya</option>                                                
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>                                 
                </div>
            </div>
            
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('products.index')}}" class="btn btn-danger ml-3">Batal</a>
            </div>
        </div>
    </form>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('editJs')
<script>
    $("#title").change(function () {
        element = $(this);
        $("button[type=submit]").prop("disabled", true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title:element.val()},
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop("disabled", false);
                
                if(response["status"] == true){
                    $("#slug").val(response["slug"]);
                }
                
            }
        }); 
    });
    
    $("#productForm").submit(function(event){
        event.preventDefault();
        var formArray = $(this).serializeArray();
        $("button[type='submit']").prop('disabled', true);


        $.ajax({
            url: '{{route("products.update",$product->id)}}',
            type: 'put',
            data: formArray,
            dataType: 'json',
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);

                if(response['status'] == true){
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'],select,input[type='number").removeClass('is-invalid');

                    window.location.href = "{{route('products.index')}}";
                } else {
                    var errors = response['errors'];

                    // if(errors['title']){
                    //     $("#title").addClass('is-invalid')
                    //     .siblings('p')
                    //     .addClass('invalid-feedback')
                    //     .html(errors['title']);
                    // } else{
                    //     $("#title").removeClass('is-invalid')
                    //     .siblings('p')
                    //     .removeClass('invalid-feedback')
                    //     .html("");
                    // }

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'],select,input[type='number").removeClass('is-invalid');

                    $.each(errors,function(key,value){
                        $(`#${key}`).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                    });

                }
            },
            error: function(){
                console.log("Terjadi Sesuatu Yang Salah");
            }
        });
    });

    $("#category").change(function(){
        var category_id = $(this).val();

        $.ajax({
            url: '{{route("product-sub_categories.index")}}',
            type: 'get',
            data: {category_id: category_id},
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                $("#sub_category").find("option").not(":first").remove();
                $.each(response["subCategories"],function(key,item){
                    $("#sub_category").append(`<option value='${item.id}'> ${item.nama} </option>`)
                });
            },
            error: function(){
                console.log("Terjadi Sesuatu Yang Salah");
            }
        });
    });

    Dropzone.autoDiscover = false;    
    const dropzone = $("#image").dropzone({ 
        url:  "{{ route('product-images.update') }}",
        maxFiles: 10,
        paramName: 'image',
        params:{'product_id': '{{$product->id}}'},
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            //$("#image_id").val(response.image_id);
            //console.log(response)

            var html = `<div class="col-md-3" id="image-row-${response.image_id}"> <div class="card">
                <input type="hidden" name="image_array[]" value="${response.image_id}">
                <img src="${response.ImagePath}" class="card-img-top" alt="">
                <div class="card-body">
                    <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Hapus</a>
                </div>
            </div></div>`;

            $("#product-gallery").append(html);
        },
        complete: function(file){
            this.removeFile(file);
        }
    });

    function deleteImage(id){
        // $("#image-row-"+id).remove();
        $("#image-row-"+id).remove();
        if (confirm("Apa kau yakin ingin menghapus gambar ?")){
                $.ajax({
                url: '{{route('product-images.destroy')}}',
                type: 'delete',
                data:{id:id},
                success: function(response){
                    if(response.status == true){
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);                    }
                }

            });
        }
    }
    
</script>
@endsection