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
        #app{
            margin-top: 5%;
            margin-bottom: 5%;
        }
        .card{
            border: 1px solid #000;
            text-align: center;
        }
        .card-header{
            border-bottom: 1px solid #000;
            padding: 2%;
            font-size: 19px;
        }
        .card-body{
            padding: 10%;
        }
    </style>
    <section>
        <div id="app">
            <main class="py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-3 col-md-offset-3">

                            @if($message = session('error'))
                                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Error!</strong> {{ $message }}
                                </div>
                            @endif

                            @if($message = session('success'))
                                <div class="alert alert-success alert-dismissible fade {{ session('success') ? 'show' : 'in' }}" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <strong>Success!</strong> {{ $message }}
                                </div>
                            @endif

                            <div class="card card-default">
                                <div class="card-header">
                                    Proceed To pay with Razorpay
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('razorpay-payment.payment') }}" method="POST" >
                                        @csrf
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                data-key="{{ env('RAZORPAY_KEY') }}"
                                                data-amount= {{ session('amount') }}
                                                data-order_id= {{ session('order_id') }}
                                                data-currency="INR"
                                                data-buttontext="PAY WITH RAZORPAY"
                                                data-name="127.0.0.1"
                                                data-description="Rozerpay"
                                                data-prefill.name="{{ Auth::user()->name }}"
                                                data-prefill.email="{{ Auth::user()->email }}"
                                                data-prefill.contact="{{ session('phone') }}">
                                        </script>
                                    </form>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
    <script>
        $(document).ready(function(){
            $('.razorpay-payment-button').addClass('btn');
            $('.razorpay-payment-button').addClass('btn-default');
        });
    </script>

</x-layout>
