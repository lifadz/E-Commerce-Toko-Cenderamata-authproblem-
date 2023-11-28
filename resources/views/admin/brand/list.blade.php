@extends('admin.layout.app')

@section('content')

@include('admin.message')

<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('brands.create')}}" class="btn btn-primary">Tambah Brand</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <form action="" method="get">
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{route("brands.index")}}'" class="btn btn-secondary" btn-sm>Refresh</button>
                    </div>
                    
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{Request::get('keyword')}}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                            
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="card-body table-responsive p-0">								
                <table id="kategoriTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="70">
                                ID
                                {{-- <a href="{{ route('kategori.index', ['sort' => 'asc']) }}">▲</a>    
                                <a href="{{ route('kategori.index', ['sort' => 'desc']) }}">▼</a> --}} 
                            </th>
                            <th>Brand</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($brands->isnotempty())
                        @foreach($brands as $brand)
                        <tr>
                            <td>{{$brand->id}}</td>
                            <td>{{$brand->nama}}</td>
                            <td>{{$brand->slug}}</td>
                            <td>
                                
                                @if($brand->status == 1)
                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @else
                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('brands.edit',$brand->id)}}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <a href="#" onclick="deleteCategory({{$brand->id}})" class="text-danger w-4 h-4 mr-1">
                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">Data tidak ditemukan</td>
                        </tr>
                        @endif
                    </tbody>
                </table>										
            </div>
            <div class="card-footer clearfix">
                {{$brands->links()}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

{{-- auto close alert notification --}}
<script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 1500);
  </script>


@section('delete-Js')
<script>
     function deleteCategory(id) {
        var url = '{{ route("brands.delete", "ID") }}';
        var newUrl = url.replace("ID", id);
        
        Swal.fire({
            title: "Apa anda yakin ?",
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
                                    window.location.href = "{{ route('brands.index') }}";
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
    // function deleteCategory(id){
    //         var url = '{{route("categories.delete","ID")}}';
    //         var newUrl = url.replace("ID",id)
        
    //         if(confirm("Apa kau yakin ingin menghapusnya ?")){
    //                 $.ajax({
    //                         url: newUrl,
    //                         type: 'delete',
    //                         data: {},
    //                         dataType: 'json',
    //                         headers: {
    //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //                             },
    //                             success: function (response) {
                        
    //                                     if (response["status"] ) {
                            
    //                                             window.location.href="{{route('categories.index')}}";
    //                                         } 
    //                                     }
    //                                 })
    //                             }
    //                         }
</script>
@endsection


                    
                        
                        
                        
                        