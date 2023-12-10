@extends('admin.layout.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Biaya Pengiriman</h1>
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
                                        <option value="{{$province->id}}">{{$province->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <button type="submit" class="btn btn-primary mt-4">Tambah</button>
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount">Biaya Pengiriman</label>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Biaya Pengiriman">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                {{-- <button type="submit" class="btn btn-primary">Tambah</button> --}}
                            </div>
                        </div>
                    </div>
                </div>							
            </div>
        </form>
        <div class="card">
            <form action="{{ route('shipping.create') }}" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route("shipping.create") }}'" class="btn btn-secondary" btn-sm>Refresh</button>
                    </div>
            
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{ request()->get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
            
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        {{-- <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Biaya</th>
                                <th>Aksi</th>
                            </tr>
                            @if ($shippingCharges->isNotEmpty())
                                @foreach ($shippingCharges as $shippingCharge)
                                <tr>
                                    <td>{{$shippingCharge->id}}</td>
                                    <td>{{$shippingCharge->name}}</td>
                                    <td>Rp {{$shippingCharge->amount}}</td>
                                    <td>
                                        <a href="{{route('shipping.edit',$shippingCharge->id)}}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteRecord({{$shippingCharge->id}});" class="text-danger w-4 h-4 mr-1">
                                            <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </table> --}}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Biaya Pengiriman</th>
                                    <th class="text-right pr-4">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($shippingCharges->isNotEmpty())
                                    @foreach ($shippingCharges as $shippingCharge)
                                        <tr>
                                            <td>{{$shippingCharge->id}}</td>
                                            <td>{{$shippingCharge->name}}</td>
                                            <td class="pl-3">Rp {{$shippingCharge->amount}}</td>
                                            <td class="text-right">
                                                <a href="{{route('shipping.edit',$shippingCharge->id)}}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <a href="javascript:void(0);" onclick="deleteRecord({{$shippingCharge->id}});" class="text-danger w-4 h-4 mr-1">
                                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Data tidak ditemukan</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="card-footer clearfix">
                            {{ $shippingCharges->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                url: '{{ route("shipping.store") }}',
                type: 'post',
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
    
    function deleteRecord(id) {
        var url = '{{ route("shipping.delete", "ID") }}';
        var newUrl = url.replace("ID", id);
        
        Swal.fire({
            title: "Apa anda yakin untuk menghapusnya ?",
            text: "Anda tidak akan bisa mengembalikan data ini !!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus datanya",
            cancelButtonText: "Tidak, batalkan",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response["status"]) {
                            // SweetAlert untuk berhasil
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data telah dihapus",
                                icon: "success"
                                
                                
                            }).then(() => {
                                
                                // Toastr untuk menampilkan notifikasi
                                toastr.info("Data sedang dihapus");
                                
                                // Redirect setelah menutup notifikasi
                                setTimeout(function () {
                                    window.location.href = "{{ route('shipping.create') }}";
                                }, 1500);
                                
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // SweetAlert untuk dibatalkan
                Swal.fire({
                    title: "Dibatalkan",
                    text: "Data tidak dihapus",
                    icon: "error"
                });
            }
        });
    }
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