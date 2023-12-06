@extends('front.layout.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Akun Saya</a></li>
                <li class="breadcrumb-item">Pengaturan</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Informasi Pribadi</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="mb-3">               
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" placeholder="Masukkan Nama anda" class="form-control">
                            </div>
                            <div class="mb-3">            
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" placeholder="Masukkan Email anda" class="form-control">
                            </div>
                            <div class="mb-3">                                    
                                <label for="phone">No HP</label>
                                <input type="text" name="phone" id="phone" placeholder="Masukkan No HP anda" class="form-control">
                            </div>

                            <div class="mb-3">                                    
                                <label for="phone">Alamat</label>
                                <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Masukkan alamat anda"></textarea>
                            </div>

                            <div class="d-flex">
                                <button class="btn btn-dark">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
    
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0, function(){
            $(this).remove(); 
        });
    }, 1500);

    // window.setTimeout(function() {
    //   $(".alert").fadeTo(500, 0).slideUp(500, function(){
    //     $(this).remove(); 
    //   });
    // }, 1500);
</script>