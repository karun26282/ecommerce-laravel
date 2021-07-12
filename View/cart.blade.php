<x-layout>
    @if(session('cart'))
    @php
    $total_price = 0;
    foreach (session('cart') as $id => $details){
        $total_price = $total_price + ($details['quantity'] * $details['price']);
    }

    @endphp
    <section class="row contentRowPad">
        <div class="container">
            <div class="row cartPage">
                <h3 class="heading pageHeading">Shopping cart</h3>
                <div class="table-responsive cartTable row m0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="productImage">Product image</th>
                                <th class="productName">Product name</th>
                                <th>price</th>
                                <th>quantity</th>
                                <th>total</th>
                                <th>remove</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(session('cart'))
                            @foreach (session('cart') as $id => $details)

                                <tr class="alert" role="alert">
                                    <td class="productImage"><img src="/storage/{{ $details['image'] }}" alt=""></td>
                                    <td class="productName">
                                        <h6 class="heading">{{ $details['title'] }}</h6>
                                        <div class="row descList m0">
                                            <dl class="dl-horizontal">
                                                <dt>product code :</dt>
                                                <dd>{{ $details['sku'] }}</dd>
                                                <dt>color :</dt>
                                                <dd>{{ $details['color'] }}</dd>
                                            </dl>
                                        </div>
                                    </td>
                                    <td class="price">₹{{ number_format($details['price']) }}</td>
                                    <td>
                                        <div class="input-group spinner">
                                            <input type="text" class="form-control qty{{ $id }}" value="{{ $details['quantity'] }}">
                                            <div class="input-group-btn-vertical">
                                                <button class="btn btn-default" onclick="add({{ $id }})"><i class="fa fa-angle-up"></i></button>
                                                <button class="btn btn-default" onclick="minus({{ $id }})"><i class="fa fa-angle-down"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price">₹{{ number_format($details['price'] * $details['quantity']) }}</td>
                                    <td><a href="javascript:void()" onclick="deleteItem({{ $id }})" class="edit" data-dismiss="alert" aria-label="Close"><i class="fa fa-trash-o"></i></a></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg ">continue shopping</a>
                                    <a href="{{ url()->previous() }}" class="fright">
                                        <form action="#" method="get">
                                            <h5 class="heading">Discount codes</h5>
                                            <p>Enter your coupon code</p>
                                            <input type="text" class="form-control" name="cuponCode" id="cuponCode">
                                            <input type="submit" class="btn btn-default btn-sm" value="apply code">
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row m0">
                    <div class="col-sm-12" style="float: right">
                        <div class="row m0 totalCheckout">
                            <div class="descList row m0">
                                <dl class="dl-horizontal">
                                    <dt class="gt">Grand Total</dt>
                                    <dd>₹{{ number_format($total_price) }}</dd>
                                </dl>
                            </div>
                            <a href="/checkout" class="btn btn-default btn-sm">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    function add(data){
        var testqty = +$('.qty'+data+'').val();
        var qty = testqty + 1;
        $.ajax({
            url : "addQty",
            type : "POST",
            data : {qty:qty,id:data, _token:"{{ csrf_token() }}"},
            success : function(data1){
                location.reload();
            }
        });
    }
    function minus(data){
        var testqty = +$('.qty'+data+'').val();
        var qty = testqty - 1;
        $.ajax({
            url : "addQty",
            type : "POST",
            data : {qty:qty,id:data, _token:"{{ csrf_token() }}"},
            success : function(data1){
                location.reload();
            }
        });
    }
    function deleteItem(data){
        $.ajax({
            url : "deleteItem",
            type : "POST",
            data : {id:data, _token:"{{ csrf_token() }}"},
            success : function(data1){
                location.reload();
            }
        });
    }
</script>

@else
<div class="not-found">
    <img src="/images/shopping-cart-logo.PNG" alt="shopping-cart-logo" width="15%">
    <p>Cart is Empty</p>
    <a href="{{ url()->previous() }}" class="btn btn-default">Go Back</a>
</div>
@endif
</x-layout>
