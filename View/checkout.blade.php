<x-layout>
@php
    $total_price = 0;
    $total_item = 0;
    foreach (session('cart') as $id => $details){
        $total_price = $total_price + ($details['quantity'] * $details['price']);
        $total_item = $total_item + $details["quantity"];
    }
@endphp
<style>
    .error{
        border-color: red;
    }
</style>
    <section class="row contentRowPad">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 loginRow">
                    <form action="{{ route('checkout.shipping') }}" method="post" role="form" class="row checkoutForm">
                        @csrf
                        <div class="row m0">
                            <div class="col-sm-12" id="billingAddress">
                                <h4 class="heading">Shipping Address</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            placeholder="@error('name') {{ $message }} @else Your Name @enderror"
                                            @error('name') value="" @else value="{{ old('name') }}" @enderror
                                            class="form-control @error('name') error @enderror">
                                    </div>
                                    <div class="col-sm-6">
                                        <input
                                            type="text"
                                            name="email"
                                            id="lastName"
                                            placeholder="@error('email') {{ $message }} @else Email @enderror"
                                            @error('email') value="" @else value="{{ old('email') }}" @enderror
                                            class="form-control @error('email') error @enderror ">
                                    </div>
                                </div>
                                <input
                                    type="text"
                                    name="country"
                                    id="country"
                                    placeholder="@error('country') {{ $message }} @else Country @enderror"
                                    @error('country') value="" @else value="{{ old('country') }}" @enderror
                                    class="form-control  @error('country') error @enderror ">

                                <input
                                    type="text"
                                    name="address"
                                    id="address"
                                    placeholder="@error('address') {{ $message }} @else Address @enderror"
                                    @error('address') value="" @else value="{{ old('address') }}" @enderror
                                    class="form-control @error('address') error @enderror ">

                                <input
                                    type="text"
                                    name="city"
                                    id="townCity"
                                    placeholder="@error('city') {{ $message }} @else City @enderror"
                                    @error('city') value="" @else value="{{ old('city') }}" @enderror
                                    class="form-control @error('city') error @enderror ">

                                <input
                                    type="text"
                                    name="state"
                                    id="stateCountry"
                                    placeholder="@error('state') {{ $message }} @else State @enderror"
                                    @error('state') value="" @else value="{{ old('state') }}" @enderror
                                    class="form-control @error('state') error @enderror ">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input
                                            type="text"
                                            name="zipcode"
                                            id="zipcode"
                                            placeholder="@error('zipcode') {{ $message }} @else Zip Code @enderror"
                                            @error('zipcode') value="" @else value="{{ old('zipcode') }}" @enderror
                                            class="form-control @error('zipcode') error @enderror ">
                                    </div>
                                    <div class="col-sm-6">
                                        <input
                                            type="tel"
                                            name="phone"
                                            id="phone"
                                            placeholder="@error('phone') {{ $message }} @else Phone No. @enderror"
                                            @error('phone') value="" @else value="{{ old('phone') }}" @enderror
                                            class="form-control @error('phone') error @enderror ">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row m0">
                            <div class="col-sm-12">
                                <button class="btn btn-primary filled btn-sm" type="submit">submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <style>
                    .card {
                        padding: 23px 7px 23px 7px;
                        background-color: #f4f4f4;
                    }
                    .order {
                        border-bottom: 1px solid #e4e4e4;
                        color: #000000;
                        display: block;
                        font-size: 14px;
                        margin-top: 0px;
                        margin-bottom: 28px;
                        padding-bottom: 15px;
                    }
                    .item {
                        color: #000000;
                        font-size: 14px;
                        font-weight: 400;
                        letter-spacing: .5px;
                    }
                </style>
                <div class="col-sm-5 orderSummaryRow">
                    <div class="row orderSummary m0">
                        <div class="row m0 orderSummaryInner table-responsive">
                            <div class="col-md-12 card">
                                <div class="col-md-12">
                                    <h5 class="order">ORDER SUMMARY <span class="item"> item({{ $total_item }})</span></h5>
                                </div>
                                @foreach (session('cart') as $id => $values)
                                    <div class="col-md-12 order">
                                        <div class="col-md-3">
                                            <img src="/storage/{{ $values['image'] }}" alt="" width="50px" height="100px">
                                        </div>
                                        <div class="col-md-9">
                                            <h5>{{ $values['title'] }} </h5>
                                            <p style="line-height: 1px;">Qty {{ $values['quantity'] }}</p>
                                            <p>₹{{ number_format($values['quantity'] * $values['price']) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-12 order">
                                    <p>Cart Subtotal <span style="float:right">₹{{ number_format($total_price) }}</span></p>
                                    <p>Shipping <span style="float:right">₹0.00</span></p>
                                </div>
                                <div class="col-md-12 order1">
                                    <p>ORDER TOTAL	 <span style="float:right">₹{{ number_format($total_price) }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    $("input").keyup(function(){
        if($(this).val() != ''){
            $(this).removeClass("error");
        }
    });
</script>
</x-layout>
