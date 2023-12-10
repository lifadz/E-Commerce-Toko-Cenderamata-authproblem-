@extends('front.layout.app')

@section('content')
<section class="container">
    <div class="col-md-12 text-center py-5">

        @if (Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @endif

        <h1>Terima Kasih !</h1>
        <p>ID Pesanan Anda Adalah: {{$id}}</p>
    </div>
</section>
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
    // }, 1000);
</script>