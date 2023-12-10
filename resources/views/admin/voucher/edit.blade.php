@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Voucher Diskon</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('voucher.index')}}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="discountForm" name="discountForm">
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Kode Voucher</label>
                                <input value="{{$coupon->code}}" type="text" name="code" id="code" class="form-control" placeholder="Kode Voucher">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Nama Voucher</label>
                                <input value="{{$coupon->name}}" type="text"  name="name" id="name" class="form-control" placeholder="Nama Voucher">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_uses">Maksimal Pemakaian</label>
                                <input value="{{$coupon->max_uses}}" type="text"  name="max_uses" id="max_uses" class="form-control" placeholder="Maksimal Pemakaian">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_uses_user">Jumlah Pemakaian Maksimal oleh Pengguna</label>
                                <input value="{{$coupon->max_uses_user}}" type="number"  name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Jumlah Maksimal Pengguna">
                                <p></p>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type">Tipe</label>
                                <select name="type" id="type" class="form-control">
                                    <option {{($coupon->type == 'percent') ? 'selected' : ''}} value="percent">Persentasi</option>
                                    <option {{($coupon->type == 'fixed') ? 'selected' : ''}} value="fixed">Harga Tetap</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="discount_amount">Besaran Diskon</label>
                                <input value="{{$coupon->discount_amount}}" type="number"  name="discount_amount" id="discount_amount" class="form-control" placeholder="Besaran Diskon">
                                <p></p>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="min_amount">Besaran Minimal</label>
                                <input value="{{$coupon->min_amount}}" type="number"  name="min_amount" id="min_amount" class="form-control" placeholder="Besaran Minimal">
                                <p></p>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status Voucher</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($coupon->status == 1) ? 'selected' : ''}} value="1">Aktif</option>
                                    <option {{($coupon->type == 2) ? 'selected' : ''}} value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="starts_at">Tanggal Mulai Berlaku</label>
                                <input value="{{$coupon->starts_at}}" type="text" autocomplete="off"  name="starts_at" id="starts_at" class="form-control" placeholder="Tanggal Awal">
                                <p></p>	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expires_at">Tanggal Berakhir</label>
                                <input value="{{$coupon->expires_at}}" type="text" autocomplete="off"  name="expires_at" id="expires_at" class="form-control" placeholder="Tanggal Akhir">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description">Deskripsi Voucher</label>
                                <textarea class="form-control"  name="description" id="description" cols="30" rows="5">{{$coupon->description}}</textarea>
                                <p></p>	
                            </div>
                        </div>										
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('voucher.index')}}" class="btn btn-danger ml-3">Batal</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content --> 
@endsection

@section('createJs')

<script>
    $(document).ready(function(){
        $('#starts_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });

        $('#expires_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
    });
    $(document).ready(function () {
        $("#discountForm").submit(function (event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop("disabled", true);

            $.ajax({
                url: '{{ route("voucher.store") }}',
                type: 'post',
                data: element.serialize(),
                dataType: 'json',
                success: function (response) {
                    $("button[type=submit]").prop("disabled", false);
                    
                    if (response.status === true) {
                        
                        window.location.href="{{route('voucher.index')}}";
                        
                        $("#code").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                        
                        $("#discount_amount").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#starts_at").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#expires_at").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
        
                        // Reset the form or perform any other actions on success
                    } else {
                        var errors = response.errors;
                        if (errors['code']) {
                            $("#code").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['code']);
                        } else {
                            $("#code").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }
                        
                        if (errors['discount_amount']) {
                            $("#discount_amount").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['discount_amount']);
                        } else {
                            $("#discount_amount").removeClass('is-invalid')
                            .siblings('p')  
                            .removeClass('invalid-feedback').html("");
                        }

                        if (errors['starts_at']) {
                            $("#starts_at").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['starts_at']);
                        } else {
                            $("#starts_at").removeClass('is-invalid')
                            .siblings('p')  
                            .removeClass('invalid-feedback').html("");
                        }

                        if (errors['expires_at']) {
                            $("#expires_at").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['expires_at']);
                        } else {
                            $("#expires_at").removeClass('is-invalid')
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