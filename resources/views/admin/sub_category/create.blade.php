@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Membuat Sub-Kategori</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('sub-categories.index')}}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" name="SubCategoryForm" id="SubCategoryForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nama">Kategori</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Pilih Kategori</option>

                                    @if($categories->isNotEmpty())
                                    
                                    @foreach($categories as $category)
                                    
                                    <option value="{{$category->id}}">{{$category->nama}}</option>
                                    
                                    @endforeach
                                    
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama">Nama Sub-Kategori</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Sub-Kategori">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status Sub-Kategori</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                                <p></p>
                            </div>
                        </div>												
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="{{route('sub-categories.index')}}" class="btn btn-danger ml-3">Batal</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('createJs')

<script>
    
    $("#SubCategoryForm").submit(function (event) {
        event.preventDefault();
        
        var element = $("#SubCategoryForm");
        $("button[type=submit]").prop("disabled", true);

        $.ajax({
            url: '{{ route("sub-categories.store") }}',
            type: 'post',
            data: element.serialize(),
            dataType: 'json',
            success: function (response) {
                $("button[type=submit]").prop("disabled", false);
                
                if (response.status === true) {
                    
                    window.location.href="{{route('sub-categories.index')}}";
                    
                    $("#nama").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    
                    $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    
                    $("#category").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    
                    // Reset the form or perform any other actions on success
                } else {
                    var errors = response.errors;
                    if (errors['nama']) {
                        $("#nama").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['nama']);
                    } else {
                        $("#nama").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                    
                    if (errors['slug']) {
                        $("#slug").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['slug']);
                    } else {
                        $("#slug").removeClass('is-invalid')
                        .siblings('p')  
                        .removeClass('invalid-feedback').html("");
                    }

                    if (errors['category']) {
                        $("#category").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['category']);
                    } else {
                        $("#category").removeClass('is-invalid')
                        .siblings('p')  
                        .removeClass('invalid-feedback').html("");
                    }

                    


                }
            }, error: function (jqXHR, exception) {
                console.log("Terjadi Sesuatu yang Salah");
            }
        });
    });
    
    $("#nama").change(function () {
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
    
</script>


@endsection