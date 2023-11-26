@extends('admin.layout.app')

@section('content')

@extends('admin.message')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('brands.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" id="editBrandForm" name="editBrandForm" method="post">
            
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Brand" value="{{$brand->nama}}">	
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Slug</label>
                                <input type="text"  name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$brand->slug}}">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($brand->status == 1) ? 'selected' : ''}} value="1">Aktif</option>
                                    <option {{($brand->status == 0) ? 'selected' : ''}} value="0">Blok</option>
                                </select>
                                <p></p>	
                            </div>
                        </div>											
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type ="submit" class="btn btn-primary">Update</button>
                <a href="{{route('brands.index')}}" class="btn btn-danger ml-3">Batal</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')

<script>
    $(document).ready(function () {
        $("#editBrandForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);

            $("button[type=submit]").prop("disabled", true);
            
            $.ajax({
                // url: '{{ route("brands.update", ["brand" => $brand->id]) }}',
                url: '{{ route("brands.update",$brand->id) }}',
                type: 'put',
                data: element.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop("disabled", false);
                    
                    if (response.status === true) {
                        
                        window.location.href="{{route('brands.index')}}";
                        
                        $("#nama").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                        
                        $("#slug").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                        
                        
                        // Reset the form or perform any other actions on success
                    } else {

                        if(response['notFound'] == true){
                            window.location.href = "{{route('brands.index')}}";
                        }

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
                    }
                }, error: function (jqXHR, exception) {
                    console.log("Terjadi Sesuatu yang Salah");
                }
            });
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