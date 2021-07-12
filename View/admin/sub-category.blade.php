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
                    url: 'add_sub_category',
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
                    url: 'edit_sub_category',
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
                url:"veiw_sub_category",
                type:"POST",
                data:{id:data, _token:"{{ csrf_token() }}"},
                success:function(data1)
                { //alert(JSON.stringify(data1));
                    $("#ids").val(data1.id);
                    document.getElementById('updateCategory').value = data1.cat_id;
                    $("#updateSubCategory").val(data1.sub_category);
                }
              });
        }
        function deletedata(data){
            var agree = confirm("Are you sure! you want to delete it");
            if(agree){
                $.ajax({
                    type:"POST",
                    url:"delete_sub_category",
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
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Sub Category</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td> {{ $item->id }} </td>
                                                    <td> {{ $item->category->category ?? '-' }} </td>
                                                    <td> {{ $item->sub_category }} </td>
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
                                            <select class="form-control" name="category" id="categories">
                                                <option value="">Choose category</option>
                                                @foreach ($category as $catData)
                                                    <option value=" {{ $catData->id }} ">{{ $catData->category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Sub Category</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="sub_category" name="sub_category" />
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
                                            <select class="form-control" name="category" id="updateCategory">
                                                <option value="">Choose category</option>
                                                @foreach ($category as $catData)
                                                    <option value="{{ $catData->id }}">{{ $catData->category }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>Sub Category</p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="updateSubCategory" name="sub_category" />
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

    </x-adminLayout>
