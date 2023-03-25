<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <?php echo $style;?>
        <title><?php echo title;?></title>
        <!-- This page plugin CSS -->
        <link href="<?=asset_url()?>css/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?=asset_url()?>select2/dist/css/select2.min.css">
    </head>
    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <?=$header?>
            <?=$leftmain?>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">PINS Transfer</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">PINS Transfer</li>
                        </ol>
                    </div>
                </div>
                <div class="container-fluid">
                    <?php
                    if( $this->session->flashdata('message') != null )
                        echo $this->session->flashdata('message');
                    ?>

                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <form id="searchForm"> 
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Pin Type</label> 
                                                <select name="type" id="type" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                    <option value="1">Package</option>
                                                    <option value="2">Service</option>
                                                    <option value="3">Equipment</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Select Partner</label> 
                                                <select name="partner" id="partner" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    foreach($partners as $item){
                                                        ?>
                                                        <option value="<?=$item->id?>"><?=$item->company_name.' - '.$item->code?></option>
                                                        <?php
                                                    }    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>TXN No</label> 
                                                <input type="text" name="txnno" id="txnno" class="form-control" placeholder="TXN No" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>From date</label> 
                                                <input type="date" name="fromdate" id="fromdate" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>To date</label> 
                                                <input type="date" name="todate" id="todate" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3 packageinput">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Select Package</label> 
                                                <select name="package_id" id="package_id" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row otherinput">                                    
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Select Category</label> 
                                                <select name="cat_id" id="cat_id" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    foreach($category as $item){
                                                        ?>
                                                        <option value="<?=$item->id?>"><?=$item->name?></option>
                                                        <?php
                                                    }    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Select Sub Category</label> 
                                                <select name="subcat_id" id="subcat_id" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3 iteminput">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label>Select Item</label> 
                                                <select name="item_id" id="item_id" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-3 serviceinput">
                                        <div class="form-group row">
                                            <div class="col-lg-12 col-sm-12">
                                                <label>Select Service</label> 
                                                <select name="service" id="service" class="form-control select2">
                                                    <option value="">--Select--</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-12 text-center">
                                        <button type="button" class="btn btn-success" title="Get Records" onclick="reinitialsedata();"><i class="fa fa-search"></i> Get Records</button>
                                        <a class="btn btn-warning" title="Reset" onclick="window.location.reload();"><i class="fa fa-undo-alt"></i> Clear All</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">PINS Transfer</h4>
                            <div class="card-tools">
                                <a class="btn btn-success" href="<?=base_url().'pin/transfer_pin'?>" ><i class="fa fa-plus"></i> Add Transfer</a>
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Filter/Search</a>
                            </div><hr>                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>TXN No</th>
                                        <th>Package/Item/Service</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Qty</th>  
                                        <th>Pin Amount</th>
                                        <th>Total Amount</th>
                                        <th>Date Time</th>   
                                        <th>Transfered To</th>                               
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>                            
                        </div>
                    </div>
                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <?=$footer?>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
    
        <div class="chat-windows"></div>
        <?=$jsfile?>
        <!--This page plugins -->
        <script src="<?=asset_url()?>js/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?=asset_url()?>js/datatable/custom-datatable.js"></script>
        <script src="<?=asset_url()?>js/datatable/datatable-basic.init.js"></script>

        <script src="<?=asset_url()?>/select2/dist/js/select2.full.min.js"></script>
        <script src="<?=asset_url()?>/select2/dist/js/select2.min.js"></script>
        <script src="<?=asset_url()?>select2/select2.init.js"></script>
        
        <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>

        <script>

            var category = <?php echo json_encode($category) ?>;
            $(document).ready(function(){
                $('.packageinput').css('display','none');
                $('.otherinput').css('display','none');

                $('#type').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value == 1 ){
                        $('.packageinput').css('display','block');
                        $('.otherinput').css('display','none');
                        var str = "";
                        $.post("<?=base_url().'pin/getPackages'?>", str, function(data){
                            data = JSON.parse(data);
                            //console.log(data);return false;
                            $(data).each(function(){
                                output += "<option value="+this.id+">"+this.name+"</option>";
                            });
                            $('#package_id').html(output);
                        });

                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            catoutput += "<option value="+this.id+">"+this.name+"</option>";
                        });
                        $('#cat_id').html(catoutput);

                    }else if( this.value == 2 ){
                        $('.packageinput').css('display','none');
                        $('.otherinput').css('display','flex');
                        $('.serviceinput').css('display','flex');
                        $('.iteminput').css('display','none');
                        $('#package_id').html(output);
                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            if( this.type == 1 ){
                                catoutput += "<option value="+this.id+">"+this.name+"</option>";
                            }                            
                        });
                        $('#cat_id').html(catoutput);
                    }else if( this.value == 3 ){
                        $('.packageinput').css('display','none');
                        $('.otherinput').css('display','flex');
                        $('.serviceinput').css('display','none');
                        $('.iteminput').css('display','flex');
                        var catoutput = '<option value="">--Select--</option>';
                        $(category).each(function(){
                            if( this.type == 2 ){
                                catoutput += "<option value="+this.id+">"+this.name+"</option>";
                            }                            
                        });
                        $('#cat_id').html(catoutput);
                    }
                });

                $('#cat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value != '' ){
                        var str = "category="+this.value;
                        $.post("<?=base_url().'master/getSubCategoryList'?>", str, function(data){
                            data = JSON.parse(data);
                            //console.log(data.data)
                            $(data.data).each(function(){
                                output += "<option value="+this.id+">"+this.name+"</option>";
                            });
                            $('#subcat_id').html(output);
                        });
                    }else{
                        $('#subcat_id').html(output);
                    }                    
                });

                $('#subcat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( $('#type').val() == '' ){
                        Swal.fire('Select pin type');
                        return false;
                    }else if( $('#cat_id').val() == '' ){
                        Swal.fire('Select category');
                        return false;
                    }else if( $('#subcat_id').val() == '' ){
                        Swal.fire('Select sub category');
                        return false;
                    }else{
                        if( this.value != '' ){
                            var str = "cat_id="+$('#cat_id').val()+"&subcat_id="+this.value;
                            var type = $.trim($('#type').val());
                            var url = "";
                            if( type == 2 ){
                                var url = "<?=base_url().'pin/getServices'?>";
                            }else if( type == 3 ){
                                var url = "<?=base_url().'pin/getItems'?>";
                            }                            
                            $.post(url, str, function(data){
                                data = JSON.parse(data);
                                //console.log(data.data);return false;
                                $(data.data).each(function(){
                                    output +="<option value='"+this.id+"'>"+this.name+"</option>";
                                });
                                if( type == 2 ){
                                    $('#service').html(output);
                                }else if( type == 3 ){
                                    $('#item_id').html(output);
                                }   
                            });
                        }else{
                            if( type == 2 ){
                                $('#service').html(output);
                            }else if( type == 3 ){
                                $('#item_id').html(output);
                            }   
                        }       
                    }                                 
                });

                $('#fromdate').change(function(){
                    if( this.value != '' ){ $('#todate').attr('min',this.value); }
                    else{ $('#todate').removeAttr('min'); }
                });
            });

            var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({  
                    "scrollX":true,
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'pin/pinTransferList'?>",  
                        type:"POST",
                        data: function(d){
                            d.form = $("#searchForm").serializeArray();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="11">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },"columnDefs":[  
                        {  
                            "targets":[1],  
                            "orderable":false,  
                        },  
                    ],'rowCallback': function(row, data, index){
                        //$(row).find('td:eq(3)').css('background-color', data[3]).html("");   
                    }
                }); 
            }

            $(document).ready(function(){ 
                initialiseData();
                var v = $("#category_form").validate({                
                    errorClass: "help-block", 
                    errorElement: 'span',
                    onkeyup: false,
                    onblur: true,
                    rules: {},
                    messages: {},
                    onfocusout: function(element) {$(element).valid()},
                    errorElement: 'span',
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').removeClass('has-error');
                    }			        		    
                });

                $("#saveButton").click(function(evt){
                    
                    if( $.trim($('#cat_id').val()) == '' ){
                        Swal.fire('Select category');
                        return false;
                    }

                    if( $.trim($('#subcat_id').val()) == '' ){
                        Swal.fire('Select sub category');
                        return false;
                    }

                    if( $.trim($('#name').val()) == '' ){
                        Swal.fire('Enter Name');
                        return false;
                    }

                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    });
                    if(v.form()){
                        var str = $("#category_form").serialize();
                        $.post("<?=base_url().'master/saveItem'?>", str, function(data){
                            if(parseInt(data) == 1){
                                $('#addModal').modal('hide'); 
                                $('#category_form').trigger('reset');
                                $('#item_id').val(0);
                                $("#category_table").dataTable().fnDestroy();
                                initialiseData();   
                                Swal.fire('Saved successfully');                         
                            }else{
                                Swal.fire(data);
                            }                            
                        });
                    }
                });

                $('#cat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( this.value != '' ){
                        var str = "category="+this.value;
                        $.post("<?=base_url().'master/getSubCategoryList'?>", str, function(data){
                            data = JSON.parse(data);
                            console.log(data.data)
                            $(data.data).each(function(){
                                output += "<option value="+this.id+">"+this.name+"</option>";
                            });
                            $('#subcat_id').html(output);
                        });
                    }else{
                        $('#subcat_id').html(output);
                    }
                    
                });

            });

            function reinitialsedata(){
                var dt = $("#category_table").DataTable();
                dt.ajax.reload(null, false);
            }

            function viewInvoice(id,type){
                console.log(id);
                var url = "<?=base_url()?>pin/view_transfer/"+id;
                window.open(url);
            }            
        </script>
    </body>
</html>