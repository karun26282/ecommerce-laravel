<x-layout>

    <section class="row contentRowPad">
        <div class="container-fluid body-container">
            @if($product->count())
                <div class="row">
                    <div class="col-md-2" style="padding-right:50px;border-right:1px solid #e2e2e2">
                        <div class="row">
                            <div class="product-head">
                                <p class="prd-main-heading1">FILTER <span style="float:right"><i class="fa fa-filter" aria-hidden="true"></i></span></p>
                            </div>
                            <div class="filter">
                                <form id="filter" method="get">
                                    <p class="sortBy-head">SORT BY </p>
                                    <div class="sortBy-panel">
                                        <input type="radio" name='sort_by' onchange="filter()" value="low-to-high" class="check-input"
                                            @php if(@$_GET['sort_by'] == "low-to-high"){ echo 'checked'; } @endphp
                                        >
                                        <span class="input-label">Low to high </span> <br />

                                        <input type="radio" name='sort_by' onchange="filter()" value="high-to-low" class="check-input"
                                        @php if(@$_GET['sort_by'] == "high-to-low"){ echo 'checked'; } @endphp
                                        >
                                        <span class="input-label">High to low</span> <br />
                                    </div>
                                    <p class="color-head">COLOR</p>
                                    <div class="color-panel">
                                        @foreach ($colors->unique('color') as $color)
                                            @php
                                                $checked = [];
                                                if(isset($_GET['color']))
                                                {
                                                    $checked = $_GET['color'];
                                                }
                                            @endphp
                                            <input type="checkbox" name='color[]' onchange="filter()" value="{{ $color->color }}" class="check-input"
                                                @if (in_array($color->color, $checked)) checked @endif
                                            >
                                            <span class="input-label">{{ strtoupper($color->color) }} </span> <br />
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10" style="padding-left: 40px;">
                        <div class="row">
                            <div class="product-head">
                                <p class="prd-main-heading">{{ strtoupper($product[0]->brand).' ('.count($product).')' }}</p>
                            </div>
                            @foreach ($product as $prd)
                                <div class="col-sm-3 product2">
                                    <div class="thumbnail">
                                        <div class="imgD">
                                            <img src="/storage/{{ $prd->image }}" alt="">
                                        </div>
                                        <div class="row m0 productIntro" style="text-align:center">
                                            <h5 class="heading"><a href="#">{{ $prd->brand}}</a></h5>
                                            <h5 class="proCat" style="height:60px;"> {{ $prd->title }} </h5>
                                            <p class="prdPrice"> ₹ {{ number_format($prd->price) }} </p>

                                        </div>
                                        <div class="addCart-btn">
                                            <button class="btn btn-default" onclick="addToCart({{ $prd->id }})" type="submit">Add to cart</button>
                                        </div>
                                    </div>
                                </div> <!--Product-->
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="not-found">
                    <img src="/images/shopping-cart-logo.PNG" alt="shopping-cart-logo" width="15%">
                    <p>Product Not Found</p>
                </div>
            @endif
        </div>
    </section>
<script>
    $('.color-head').click(function(){
        $('.color-panel').toggle();
        $('.color-head').css({'border-bottom' : 'none','padding-bottom' : '2%'});
    });
    $('.sortBy-head').click(function(){
        $('.sortBy-panel').toggle();
        $('.sortBy-head').css({'border-bottom' : 'none','padding-bottom' : '2%'});
    });
    function filter(){
        var form = document.getElementById("filter");
        form.submit();
    }
</script>
</x-layout>
