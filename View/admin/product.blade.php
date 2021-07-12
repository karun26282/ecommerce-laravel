<x-adminLayout>
    <script>

        $(document).ready(function(){
            $('#Testimonial').DataTable();
        });

        function submitform(){
            $("#addform").submit(function(event) {
                $("#show2").show();
                var abc = event.preventDefault();
                event.stopImmediatePropagation();
                $.ajax({
                    url: 'addProduct',
                    type:'POST',
                    data: new FormData(this),
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {   //alert(JSON.stringify(data.error));
                        $("#show2").hide();
                        if(data.error){
                            $.each(data.error, function(key, value){
                                if(key == 'category'){
                                    $('#categories').val('');
                                    $('#categories').find("input[type=text][placeholder].error").removeAttr( 'placeholder');
                                    $('input[name=category]').addClass("error");
                                    $('#categories').attr('placeholder',value);
                                    setTimeout(function(){
                                        $('#categories').removeAttr('placeholder',value);
                                    }, 3000);
                                }
                                if(key == 'image'){
                                    $('#error').show();
                                    $('#errMsg').html(value);
                                    setTimeout(function(){
                                        $('#error').hide();
                                    }, 3000);
                                }
                            });
                        }
                        if(data.status == '1'){
                            $('#addform').each(function(){
                                this.reset();
                            });
                            $("#success").show();
                            $("#msg").html('YOUR RECORD HAS BEEN SUCCESSFULLY ADDED');
                            setTimeout(function(){
                                $("#success").hide();
                            },3000);
                            //location.reload();
                        }

                    }
                });
            });
        }
        function updateform(){
            $("#updateform").submit(function(event) {
                $("#show").show();
                var abc = event.preventDefault();
                event.stopImmediatePropagation();
                $.ajax({
                    url: 'editProduct',
                    type:'POST',
                    data: new FormData(this),
                    cache:false,
                    contentType:false,
                    processData:false,
                    success:function(data)
                    {   //alert(JSON.stringify(data));
                        $("#show").hide();
                        if(data.error){
                            $.each(data.error, function(key, value){
                                if(key == 'category'){
                                    $('#updateCategory').val('');
                                    $('#updateCategory').find("input[type=text][placeholder].error").removeAttr( 'placeholder');
                                    $('input[name=category]').addClass("error");
                                    $('#updateCategory').attr('placeholder',value);
                                    setTimeout(function(){
                                        $('#updateCategory').removeAttr('placeholder',value);
                                    }, 3000);
                                }
                                if(key == 'id'){
                                    $('#updateError').show();
                                    $('#updateErrMsg').html('something went wrong please refresh or try again letter !');
                                    setTimeout(function(){
                                        $('#error-').hide();
                                    }, 3000);
                                }
                            });
                        }
                        if(data.status  == 1 ){ //alert(JSON.stringify(data));
                            $('#updateform' ).each(function(){
                                this.reset();
                            });
                            $("#updateSuccess").show();
                            $("#msg3").html('YOUR DATA HAS BEEN SUCCESSFULLY UPDATED');
                            setTimeout(function(){
                                $("#updateSuccess").hide();
                                location.reload();
                            },3000);
                        }
                    }
                });
            });
        }
        function Edit(data){
            $.ajax({
                url:"viewProduct",
                type:"POST",
                data:{id:data, _token:"{{ csrf_token() }}"},
                success:function(data1)
                { //alert(JSON.stringify(data1));
                    $("#ids").val(data1.id);
                    document.getElementById('updateCategory').value = data1.cat_id;
                    document.getElementById('updateSub').value = data1.sub_cat_id;
                    document.getElementById('updateType').value = data1.type_id;
                    document.getElementById('updateMain').value = data1.main_cat_id;
                    document.getElementById('updateBrand').value = data1.brand_id;
                    $("#updateTitle").val(data1.title);
                    $("#updateSku").val(data1.sku);
                    $("#updatePrice").val(data1.price);
                    $("#updateColor").val(data1.color);
                    $("#updateFeatures").val(data1.features);
                    $("#updateQuantity").val(data1.quantity);
                    $("#updateDescription").val(data1.description);
                    $("#img").html("<img src='/storage/"+data1.image+"'  width='50px'>");
                    $("#img2").html("<img src='/storage/"+data1.image2+"'  width='80px'>");
                    $("#img3").html("<img src='/storage/"+data1.image3+"'  width='80px'>");
                }
              });
        }
        function deletedata(data){
            var agree = confirm("Are you sure! you want to delete it");
            if(agree){
                $.ajax({
                    type:"POST",
                    url:"deleteProduct",
                    data:{id:data, _token:"{{ csrf_token() }}"},
                    success:function(data1)
                    {
                      if(data1.status == '1')
                      {
                        alert('Record has been successfully deleted !...');
                        location.reload();
                      }else{
                        alert('Please try again !...');
                      }
                    }
                });
            }
        }
    </script>
    <section class="au-breadcrumb m-t-75">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button id="sample_editable_1_new" data-toggle="modal" href="#catModel" class="btn btn-success">
                            Add New <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">Tools</button>
                        <ul class="dropdown-menu pull-right">
                            <li onclick="javascript:window.print();">
                                <a href="javascript:;">
                                Print </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                Export to Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="statistic">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="portlet-body">
                            <div id="sample_editable_1_wrapper" class="dataTables_wrapper no-footer">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12"></div>
                                    <div class="col-md-6 col-sm-12"></div>
                                </div>

                                <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover" id="Testimonial">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Color</th>
                                                <th class="text-center">Feature</th>
                                                <th class="text-center">Image</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td> {{ $item->id }} </td>
                                                    <td> {{ $item->title }} </td>
                                                    <td> {{ $item->price }} </td>
                                                    <td> {{ $item->color }} </td>
                                                    <td> {{ $item->features }} </td>
                                                    <td><img src="{{ asset('/storage/'.$item->image) }}"  width="50px"></td>
                                                    <td>
                                                        <a data-toggle='modal' href='#viewUser' onclick='Edit({{ $item->id }})' title='View'  class='btn btn-icon-only green'> <i class='fa fa-pencil-square' style='font-size: 24px;'></i></a>
                                                        <a data-toggle='modal' onclick='deletedata({{ $item->id }})' title='Delete'  class='btn btn-icon-only purple'> <i class='fa fa-trash' style='color: red;font-size:20px'></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="catModel" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">ADD CATEGORY</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="error" style="display:none;">
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span id="errMsg"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div id="success" style="display:none;">
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                        <span id="msg"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" name="myform" method="POST" action="" id="addform" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>CATEGORY</p>
                                        <div class="form-group">
                                            <select class="form-control" name="cat_id" onchange="getSubCat()" id='categories'>
                                                <option value="">Choose category</option>
                                                @foreach ($category as $catData)
                                                    <option value=" {{ $catData->id }} ">{{ $catData->category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="sub_cat1" style="display:none">
                                        <p>Sub Category</p>
                                        <div class="form-group">
                                            <select class="form-control" name="sub_cat_id" onchange="getType()" id="sub_cat">
                                                <option value="">Choose sub category</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="type1" style="display:none">
                                        <p>Type</p>
                                        <div class="form-group">
                                            <select class="form-control" name="type_id" onchange="getMainCat()" id="type">
                                                <option value="">Choose Type</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="main_cat1" style="display:none">
                                        <p>Main Category</p>
                                        <div class="form-group">
                                            <select class="form-control" name="main_cat_id" onchange="getBrand()" id="main_cat">
                                                <option value="">Choose Type</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="brand1" style="display:none">
                                        <p>Brand</p>
                                        <div class="form-group">
                                            <select class="form-control" name="brand_id" id="brand">
                                                <option value="">Choose Type</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <p>Title</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="title" id="title" value="" placeholder="Enter new Title" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>SKU</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="sku" id="sku" value="" placeholder="Enter new SKU" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Price</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="price" id="price" value="" placeholder="Enter new Price" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Quantity</p>
                                        <div class="form-group">
                                            <select name="qty" class="form-control" id="quantity">
                                                <option value="1">1 quantity</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Image</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image" id="image" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Images-2</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image2" id="image2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Images-3</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image3" id="image3" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Color</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="color" id="color" value="" placeholder="Enter new color" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Feature</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="features" id="features" value="" placeholder="Enter new features" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Description</p>
                                        <div class="form-group">
                                            <textarea class="form-control" name="desc" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="add" value="add">
                            <div id="show2"style="padding-left: 65%; display:none;margin-right: 10px;float:left"><img src="/loader.gif" style="height:35px" /></div>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <input type="submit" onclick="submitform()" class="btn blue" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewUser" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">UPDATE CATEGORY</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="updateError" style="display:none;">
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span id="updateErrMsg"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div id="updateSuccess" style="display:none;">
                    <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                        <span id="msg3"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form role="form" name="myform" method="POST" action="" id="updateform" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>CATEGORY</p>
                                        <div class="form-group">
                                            <select class="form-control categories" name="cat_id" onchange="getSubCat()" id="updateCategory">
                                                @foreach ($category as $catData)
                                                    <option value="{{ $catData->id }}">{{ $catData->category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Sub Category</p>
                                        <div class="form-group">
                                            <select class="form-control sub_cat" name="sub_cat_id" onchange="getType()" id="updateSub">
                                                @foreach ($sub_category as $sub_cat)
                                                    <option value="{{ $sub_cat->id }}">{{ $sub_cat->sub_category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Type</p>
                                        <div class="form-group">
                                            <select class="form-control type" name="type_id" onchange="getMainCat()" id="updateType">
                                                @foreach ($type as $typeData)
                                                    <option value="{{ $typeData->id }}">{{ $typeData->type }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Main Category</p>
                                        <div class="form-group">
                                            <select class="form-control main_cat" name="main_cat_id" onchange="getBrand()" id="updateMain">
                                                @foreach ($main_category as $main_cat)
                                                    <option value="{{ $main_cat->id }}">{{ $main_cat->main_category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <p>Brand</p>
                                        <div class="form-group">
                                            <select class="form-control brand" name="brand_id" id="updateBrand">
                                                @foreach ($brand as $brandData)
                                                    <option value="{{ $brandData->id }}">{{ $brandData->brand }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <p>Title</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="title" id="updateTitle" value="" placeholder="Enter new Title" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>SKU</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="sku" id="updateSku" value="" placeholder="Enter new SKU" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Price</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="price" id="updatePrice" value="" placeholder="Enter new Price" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Quantity</p>
                                        <div class="form-group">
                                            <select name="qty" class="form-control" id="updateQuantity">
                                                <option value="1">1 quantity</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="img"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="img2"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="img3"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Image</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Images-2</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Images-3</p>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="image3" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Color</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="color" id="updateColor" value="" placeholder="Enter new color" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Feature</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="features" id="updateFeatures" value="" placeholder="Enter new features" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Description</p>
                                        <div class="form-group">
                                            <textarea class="form-control" name="desc" id="updateDescription" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="ids" value="">
                            <div id="show"style="padding-left: 65%; display:none;margin-right: 10px;float:left"><img src="/loader.gif" style="height:30px" /></div>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <input type="submit" onclick="updateform()" class="btn blue" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-----------Update User Modal End---------------->

    <script>
        function getSubCat()
        { //alert('hi'); return false;
            var categories = $('#categories').val();
            $.ajax({
                'url' : "getSubCat",
                'type' : "POST",
                'data' : {id:categories, _token:"{{ csrf_token() }}"},
                success : function(data)
                {
                    $('#sub_cat1').show();
                    $('#type').empty();
                    $('#main_cat').empty();
                    $('#brand').empty();
                    $('#sub_cat').html('<option value="">Choose sub category</option>');
                    $.each(data, function(i, item){
                        $('#sub_cat').append('<option value="'+item.id+'">'+item.sub_category+'</option>');
                    });
                }
            });
        }
        function getType()
        { //alert('hi'); return false;
            var sub_cat = $('#sub_cat').val();
            $.ajax({
                'url' : "getType",
                'type' : "POST",
                'data' : {id:sub_cat, _token:"{{ csrf_token() }}"},
                success : function(data)
                {
                    $('#type1').show();
                    $('#type').empty();
                    $('#main_cat').empty();
                    $('#brand').empty();
                    $('#type').html('<option value="">Choose Type</option>');
                    $.each(data, function(i, item){
                        $('#type').append('<option value="'+item.id+'">'+item.type+'</option>');
                    });
                }
            });
        }
        function getMainCat()
        { //alert('hi'); return false;
            var type = $('#type').val();
            $.ajax({
                'url' : "getMainCat",
                'type' : "POST",
                'data' : {id:type, _token:"{{ csrf_token() }}"},
                success : function(data)
                {
                    $('#main_cat1').show();
                    $('#main_cat').empty();
                    $('#brand').empty();
                    $('#main_cat').html('<option value="">Choose Type</option>');
                    $.each(data, function(i, item){
                        $('#main_cat').append('<option value="'+item.id+'">'+item.main_category+'</option>');
                    });
                }
            });
        }

        function getBrand()
        { //alert('hi'); return false;
            var main_cat = $('#main_cat').val();
            $.ajax({
                'url' : "getBrand",
                'type' : "POST",
                'data' : {id:main_cat, _token:"{{ csrf_token() }}"},
                success : function(data)
                {
                    $('#brand1').show();
                    $('#brand').empty();
                    $('#brand').html('<option value="">Choose Type</option>');
                    $.each(data, function(i, item){
                        $('#brand').append('<option value="'+item.id+'">'+item.brand+'</option>');
                    });
                }
            });
        }
    </script>
</x-adminLayout>
