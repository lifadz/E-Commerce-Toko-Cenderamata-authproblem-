@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Biaya Pengiriman</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('shipping.create')}}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        @include('admin.message')
        <form action="" method="post" id="shippingForm" name="shippingForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="province">Pilih Provinsi</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="">Provinsi</option>
                                    @if ($provinces->isNotEmpty())
                                        @foreach ($provinces as $province)
                                        <option {{($shippingCharge->province_id == $province->id) ? 'selected' : ''}} value="{{$province->id}}">{{$province->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" class="btn btn-primary mt-5">Update</button>
                                <a href="{{route('shipping.create')}}" class="btn btn-danger ml-3 mt-5">Batal</a>
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount">Biaya Pengiriman</label>
                                <input value="{{$shippingCharge->amount}}" type="text" name="amount" id="amount" class="form-control" placeholder="Biaya">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                {{-- <button type="submit" class="btn btn-primary mt-5">Update</button> --}}
                            </div>
                        </div>
                    </div>
                </div>							
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content --> 
@endsection

@section('createJs')

<script>
    $(document).ready(function () {
        $("#shippingForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop("disabled", true);
            $.ajax({
                url: '{{ route("shipping.update",$shippingCharge->id) }}',
                type: 'put',
                data: element.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop("disabled", false);
                    
                    if (response.status === true) {
                        
                        window.location.href="{{route('shipping.create')}}";

                    } else {
                        var errors = response.errors;
                        if (errors['province']) {
                            $("#province").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['province']);
                        } else {
                            $("#province").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }
                        
                        if (errors['amount']) {
                            $("#amount").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['amount']);
                        } else {
                            $("#amount").removeClass('is-invalid')
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
</script>


@endsection

<script>
    
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0, function(){
            $(this).remove(); 
        });
    }, 1600);

    // window.setTimeout(function() {
    //   $(".alert").fadeTo(500, 0).slideUp(500, function(){
    //     $(this).remove(); 
    //   });
    // }, 1500);
</script>