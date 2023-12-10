@extends('front.layout.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Beranda</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Toko</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form action="" id="orderForm" name="orderForm" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Alamat Pengiriman</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nama Depan" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                        <p></p>            
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Nama Belakang" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                                        <p></p>            
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                                        <p></p>        
                                    </div>    
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="province" id="province" class="form-control">
                                            <option value="">Pilih Provinsi</option>
                                            @if ($provinces->isNotEmpty())

                                            @foreach ($provinces as $province)
                                                <option {{ (!empty($customerAddress) && $customerAddress->province_id == $province->id) ? 'selected' : '' }} value="{{ $province->id}}">{{$province->name}}</option>
                                            @endforeach
                        
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Alamat" class="form-control">{{(!empty($customerAddress)) ? $customerAddress->address : ''}}</textarea>
                                        <p></p>
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Hotel, Penginapan, dll. (opsional)" value="{{(!empty($customerAddress)) ? $customerAddress->apartment : ''}}">
                                    </div>            
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" class="form-control" placeholder="Kota/Kabupaten" value="{{(!empty($customerAddress)) ? $customerAddress->city : ''}}">
                                        <p></p>            
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="district" id="district" class="form-control" placeholder="Kecamatan" value="{{(!empty($customerAddress)) ? $customerAddress->district : ''}}">
                                        <p></p>            
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" class="form-control" placeholder="Kode Pos" value="{{(!empty($customerAddress)) ? $customerAddress->zip : ''}}">
                                        <p></p>            
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="No Hp" value="{{(!empty($customerAddress)) ? $customerAddress->mobile : ''}}">
                                        <p></p>
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="notes" id="notes" cols="30" rows="2" placeholder="Catatan Pengiriman (opsional)" class="form-control"></textarea>
                                    </div>            
                                </div>

                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Rincian Pesanan</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">

                            @foreach(Cart::content() as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                <div class="h6">Rp {{$item->price * $item->qty}}</div>
                            </div>
                            @endforeach
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>Rp {{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Biaya Pengiriman</strong></div>
                                <div class="h6"><strong id="shippingAmount">Rp {{number_format($totalShippingCharge,3)}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong id="grandTotal">Rp {{number_format($grandTotal,3)}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form ">    
                        
                        <h3 class="card-title h5 mb-3">Metode Pembayaran</h3>

                        <div class="">
                            <input checked type="radio" name="payment_method" value="COD" id="payment_method_one">
                            <label for="payment_method_one" class="form-check-label">COD</label>
                        </div>

                        <div class="">
                            <input type="radio" name="payment_method" value="Transfer_Bank" id="payment_method_two">
                            <label for="payment_method_two" class="form-check-label">Transfer Bank</label>
                        </div>


                        <div class="card-body p-0 d-none mt-3" id="card_payment_form">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            {{-- <a href="#" class="btn-dark btn btn-block w-100">Bayar Sekarang</a> --}}
                            <button type="submit" class="btn-dark btn btn-block w-100">Bayar Sekarang</button>
                        </div>                        
                    </div>

                        
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('paymentJs')
<script>
    $("#payment_method_one").click(function(){
        if($(this).is(":checked") == true){

            $("#card_payment_form").addClass('d-none');
        }
    });

    $("#payment_method_two").click(function(){
        if($(this).is(":checked") == true){

            $("#card_payment_form").removeClass('d-none');
        }
    });

    $("#orderForm").submit(function(event){
        event.preventDefault();

        $('button[type="submit"]').prop('disabled',true);

        $.ajax({
            url:'{{route("front.processCheckout")}}',
            type:'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                var errors = response.errors;
                $('button[type="submit"]').prop('disabled',false);


                if(response.status == false){

                        if(errors.first_name){
                            $("#first_name").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.first_name)

                        } else {
                            $("#first_name").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.last_name){
                            $("#last_name").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.last_name)

                        } else {
                            $("#last_name").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.email){
                            $("#email").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.email)

                        } else {
                            $("#email").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.province){
                            $("#province").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.province)

                        } else {
                            $("#province").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.address){
                            $("#address").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.address)

                        } else {
                            $("#address").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.district){
                            $("#district").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.district)

                        } else {
                            $("#district").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.city){
                            $("#city").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.city)

                        } else {
                            $("#city").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.zip){
                            $("#zip").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.zip)

                        } else {
                            $("#zip").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                        if(errors.mobile){
                            $("#mobile").addClass('is-invalid')
                                .siblings("p")
                                .addClass('invalid-feedback')
                                .html(errors.mobile)

                        } else {
                            $("#mobile").removeClass('is-invalid')
                                .siblings("p")
                                .removeClass('invalid-feedback')
                                .html('')
                        }

                } else {
                    window.location.href = "{{ url('/terimakasih/') }}/"+response.orderId;
                }

                
            }
        })
    })

    $("#province").change(function() {
        $.ajax({
            url: '{{route("front.getOrderSummary")}}',
            type: 'post',
            data: {province_id: $(this).val()},
            dataType: 'json',
            success: function(response) {

                if(response.status == true){
                    $("#shippingAmount").html('Rp ' + response.shippingCharge);
                    $("#grandTotal").html('Rp ' + response.grandTotal);
                }

            }
        })
    })
</script>
@endsection