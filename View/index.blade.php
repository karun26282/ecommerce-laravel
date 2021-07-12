<x-layout>

    <section id="slider" class="row">
        <div class="row sliderCont flexslider m0">
            <ul class="slides nav">
                @foreach ($banners as $banner)
                    <li>
                        <img src="/storage/{{ $banner->image }}" width="100%" alt="">
                    </li>
                @endforeach
            </ul>
        </div>
    </section> <!--Slider-->



    <section id="newProducts" class="row contentRowPad">
        <div class="container-fluid dummy-container">
            <h3 class="heading">new products</h3>
            <div class="row">
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
    </section>

    <section id="productOnTab" class="row contentRowPad">
        <div class="container-fluid dummy-container">
            <div class="row">
                <ul class="nav nav-tabs centeredTabMenu" role="tablist" id="productTab">
                    <li role="presentation"><a href="#proT1" aria-controls="proT1" role="tab" data-toggle="tab">ELECTRONICS</a></li>
                    <li role="presentation" class="active"><a href="#proT2" aria-controls="proT2" role="tab" data-toggle="tab">Men</a></li>
                    <li role="presentation"><a href="#proT3" aria-controls="proT3" role="tab" data-toggle="tab">Women</a></li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane" id="proT1">
                      <div class="row">
                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/1.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane active" id="proT2">
                      <div class="row">
                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/1.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->

                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/2.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->
                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/3.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->
                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/4.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="proT3">
                      <div class="row">
                        <div class="col-sm-3 product2">
                            <div class="row m0 thumbnail">
                                <div class="row m0 imgHov">
                                    <img src="images/product/pro2p/1.png" alt="">
                                </div>
                            </div>
                        </div> <!--Product 2-->
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonialTabs" class="row  contentRowPad">
        <div class="container">
            <h3 class="heading text-center">our happy clients</h3>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row m0 testimonialStyle3">
                        <div class="testiText row m0">FurnitureHouse is really excellent site for furnitures.I am very happy with the FurnitureHouse products and dedicated services from them. FurnitureHouse is really excellent site for furnitures.</div>
                        <div class="row m0 clientInfo text-center">
                            <img src="images/testimonial/5.png" alt="">
                            <div class="clientName">Chris evans</div>
                            <ul class="stars list-inline">
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row m0 testimonialStyle3">
                        <div class="testiText row m0">FurnitureHouse is really excellent site for furnitures.I am very happy with the FurnitureHouse products and dedicated services from them. FurnitureHouse is really excellent site for furnitures.</div>
                        <div class="row m0 clientInfo text-center">
                            <img src="images/testimonial/4.png" alt="">
                            <div class="clientName">katrin lisa</div>
                            <ul class="stars list-inline">
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class=""><i class="fa fa-star"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row m0 testimonialStyle3">
                        <div class="testiText row m0">FurnitureHouse is really excellent site for furnitures.I am very happy with the FurnitureHouse products and dedicated services from them. FurnitureHouse is really excellent site for furnitures.</div>
                        <div class="row m0 clientInfo text-center">
                            <img src="images/testimonial/3.png" alt="">
                            <div class="clientName">williams</div>
                            <ul class="stars list-inline">
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class="stared"><i class="fa fa-star"></i></li>
                                <li class=""><i class="fa fa-star"></i></li>
                                <li class=""><i class="fa fa-star"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!--Testimonial Tabs-->

    <section id="fromBlogs" class="row contentRowPad">
        <div class="container">
            <div class="row sectionTitle">
                <h3>from our blog</h3>
                <h5>get latest updates from our blog</h5>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="blog row m0">
                        <div class="row m0 featureImg">
                            <img src="images/blog/6.png" alt="">
                        </div>
                        <div class="row m0 titleRow">
                            <div class="fleft date">29<span>Dec</span></div>
                            <div class="fleft titlePart">
                                <a href="single-post.html"><h6 class="blogTitle heading">win gifts on every items</h6></a>
                                <p class="m0">By <a href="#">Admin</a><span>|</span><a href="#">5 Comments</a></p>
                            </div>
                        </div>
                        <div class="row m0 excerpt">
                            Feels so right it cant be wrong. Rockin' and rollin' all week long. Straightnin' the curves. Flatnin' the hills Someday the mountain might.
                        </div>
                    </div> <!--Blog Row End-->
                </div>
                <div class="col-sm-4">
                    <div class="blog row m0">
                        <div class="row m0 featureImg">
                            <img src="images/blog/7.png" alt="">
                        </div>
                        <div class="row m0 titleRow">
                            <div class="fleft date">29<span>Dec</span></div>
                            <div class="fleft titlePart">
                                <a href="single-post.html"><h6 class="blogTitle heading">newyear sales are fun</h6></a>
                                <p class="m0">By <a href="#">Admin</a><span>|</span><a href="#">5 Comments</a></p>
                            </div>
                        </div>
                        <div class="row m0 excerpt">
                              A shadowy flight into the dangerous world of a man who does not exist. Just two good ol' boys Wouldn't change if they could.
                        </div>
                    </div> <!--Blog Row End-->
                </div>
                <div class="col-sm-4">
                    <div class="blog row m0">
                        <div class="row m0 featureImg">
                            <img src="images/blog/8.png" alt="">
                        </div>
                        <div class="row m0 titleRow">
                            <div class="fleft date">30<span>Dec</span></div>
                            <div class="fleft titlePart">
                                <a href="single-post.html"><h6 class="blogTitle heading">are you ready for enjoyment</h6></a>
                                <p class="m0">By <a href="#">Admin</a><span>|</span><a href="#">5 Comments</a></p>
                            </div>
                        </div>
                        <div class="row m0 excerpt">
                            I have always wanted to have a neighbor just like you. I've always wanted to live in a neighborhood with you.I have always wanted.
                        </div>
                    </div> <!--Blog Row End-->
                </div>
            </div>
        </div>
    </section>
</x-layout>
