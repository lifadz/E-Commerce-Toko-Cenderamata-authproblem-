@extends('front.layout.app')

@section('content')
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
    data-bs-interval="false">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->
            
            <picture>
                {{-- <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-1-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                <img src="{{asset('front-assets/images/carousel-1.jpg')}}" alt="" /> --}}
                
                <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/karosel1-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/karosel1.jpg')}}" />
                <img  src="{{asset('front-assets/images/karosel1.jpg')}}" alt="" />
            </picture>
            
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3">
                    <h1 class="display-4 text-white mb-3">Selamat Datang</h1>
                    <p class="mx-md-5 px-5">Temukan berbagai produk cendera mata yang unik dan berkualitas untuk mempercantik momen istimewa Anda.</p>
                    <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Belanja Sekarang</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            
            {{-- <picture>
                <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-2-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-2.jpg')}}" />
                <img src="{{asset('front-assets/images/carousel-2.jpg')}}" alt="" />
            </picture> --}}
            
            <picture>
                <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/karosel2-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/karosel2.jpg')}}" />
                <img src="{{asset('front-assets/images/karosel2.jpg')}}" alt="" />
            </picture>
            
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3">
                    <h1 class="display-4 text-white mb-3">Eksplorasi Pesona Bengkulu</h1>
                    <p class="mx-md-5 px-5">Temukan keindahan dan keunikan cenderamata khas Bengkulu di toko kami.</p>
                    <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Belanja Sekarang</a>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->
            
            
            {{-- <picture>
                <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-3-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-3.jpg')}}" />
                <img src="{{asset('front-assets/images/carousel-3.jpg')}}" alt="" />
            </picture> --}}

            <picture>
                <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/karosel3-m.jpg')}}" />
                <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/karosel3.jpg')}}" />
                <img src="{{asset('front-assets/images/karosel3.jpg')}}" alt="" />
            </picture>
            
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3">
                    <h1 class="display-4 text-white mb-3">Oleh - Oleh Khas Bengkulu</h1>
                    <p class="mx-md-5 px-5">Temukan keindahan dan keunikan cenderamata khas Bengkulu di toko kami. Berbagai pilihan yang memukau menanti Anda.</p>
                    <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Belanja Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
    data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
data-bs-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Next</span>
</button>
</div>
</section>
<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Produk Asli Bengkulu</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Pengiriman Cepat</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">7 Hari Pengembalian   </h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Pelayanan Cepat</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-3">
            <div class="container">
                <div class="section-title">
                    <h2>Kategori</h2>
                </div>
                <div class="row pb-3">
                    @if (getCategories()->isNotEmpty())
                    @foreach (getCategories() as $category)
                    
                    <div class="col-lg-3">
                        <div class="cat-card">
                            <div class="left">
                                @if ($category->image != "")
                                
                                <img src="{{asset('upload/kategori/thumbnail/'.$category->image)}}" alt="" class="img-fluid">
                                
                                @endif
                            </div>
                            <div class="right">
                                <div class="cat-data">
                                    <h2>{{$category->name}}</h2>
                                    {{-- <p>100 Products</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </section>
        
        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Produk Unggulan </h2>
                </div>
                <div class="row pb-3">
                    @if ($featuredProducts->isNotEmpty())
                    @foreach ($featuredProducts as $product)
                    @php
                    $productImage = $product->product_images->first();
                    @endphp
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{route("front.product",$product->slug)}}" class="product-img">
                                    
                                    @if (!empty($productImage->image))
                                    
                                    <img class="card-img-top" src="{{asset('upload/produk/gambar_small/'.$productImage->image)}}" >
                                    
                                    @else
                                    
                                    <img src="{{asset('admin-assets/img/default-150x150.png')}}">
                                    
                                    @endif
                                    
                                </a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                
                                <div class="product-action">
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$product->id}});">
                                        <i class="fa fa-shopping-cart"></i> Tambah Keranjang
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="{{route("front.product",$product->slug)}}">{{$product->title}}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>Rp {{$product->price}}</strong></span>
                                    
                                    @if ($product->compare_price>0)
                                    <span class="h6 text-underline"><del>Rp {{$product->compare_price}}</del></span>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </section>
        
        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Produk Baru - Baru Ini</h2>
                </div>
                <div class="row pb-3">
                    @if ($latestProducts->isNotEmpty())
                    @foreach ($latestProducts as $product)
                    @php
                    $productImage = $product->product_images->first();
                    @endphp
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{route("front.product",$product->slug)}}" class="product-img">
                                    
                                    @if (!empty($productImage->image))
                                    
                                    <img class="card-img-top" src="{{asset('upload/produk/gambar_small/'.$productImage->image)}}" >
                                    
                                    @else
                                    
                                    <img src="{{asset('admin-assets/img/default-150x150.png')}}">
                                    
                                    @endif
                                    
                                </a>
                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                
                                <div class="product-action">
                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$product->id}});">
                                        <i class="fa fa-shopping-cart"></i> Tambah Keranjang
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="{{route("front.product",$product->slug)}}">{{$product->title}}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong>Rp {{$product->price}}</strong></span>
                                    
                                    @if ($product->compare_price>0)
                                    <span class="h6 text-underline"><del>Rp {{$product->compare_price}}</del></span>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif  
                </div>
            </div>
        </section>
        @endsection