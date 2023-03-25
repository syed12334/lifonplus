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
                        <h3 class="text-themecolor mb-0">Service Fields Form</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Service Fields Form</li>
                        </ol>
                    </div>
                </div>
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->          
                    <?php
                    if( $this->session->flashdata('message') != null )
                        echo $this->session->flashdata('message');
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Service Fields Form</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" onsubmit="return validateForm();">
                                <input type="hidden" name="id" id="id" value="0" />
                                <div class="form-group row">
                                    <?php
                                    $cat_id = $subcat_id = $service_id = 0;
                                    if( count($service) ){
                                        $cat_id = $service->cat_id;
                                        $subcat_id = $service->subcat_id;
                                        $service_id = $service->id;
                                    }
                                    ?>
                                    <div class="col-md-4">
                                        <label for="cat_id">Select Category</label>
                                        <select name="cat_id" id="cat_id" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach($category as $item){
                                                ?>
                                                <option value="<?=$item->id?>" <?php if($item->id == $cat_id){ echo 'selected'; }?> ><?=$item->name?></option>
                                                <?php
                                            }    
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="cat_id">Select Sub Category</label>
                                        <select name="sub_cat_id" id="sub_cat_id" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            if(count($subcategory)){
                                                foreach($subcategory as $item){
                                                    ?>
                                                    <option value="<?=$item->id?>" <?php if($item->id == $subcat_id){ echo 'selected'; }?> ><?=$item->name?></option>
                                                    <?php
                                                }
                                            }                                                   
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="cat_id">Select Service</label>
                                        <select name="service_id" id="service_id" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            if(count($services)){
                                                foreach($services as $item){
                                                    ?>
                                                    <option value="<?=$item->id?>" <?php if($item->id == $service_id){ echo 'selected'; }?> ><?=$item->name?></option>
                                                    <?php
                                                }
                                            }                                                   
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="button" onclick="getServiceFields()" class="btn btn-success"><i class="fa fa-search"></i> Get Records</button>
                                        <a href="<?=base_url().'master/service_fields'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
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
        <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function(){

                var use = "<?=$type?>";
                if( use == 'edit' ){
                    getServiceFields();
                }

                var v = $("#category_form").validate({
                
                    errorClass: "help-block", 
                    errorElement: 'span',
                    onkeyup: false,
                    onblur: true,
                    rules: {
                        
                    },
                    messages: {
                        
                    },
                    onfocusout: function(element) {$(element).valid()},
                    errorElement: 'span',
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').addClass('has-error');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents('.form-group').removeClass('has-error');
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
                            $('#sub_cat_id').html(output);
                        });
                    }else{
                        $('#sub_cat_id').html(output);
                    }                    
                });

                $('#sub_cat_id').change(function(){
                    var output = '<option value="">--Select--</option>';
                    if( $('#cat_id').val() == '' ){
                        Swal.fire('Select Category');
                        $('#service_id').html(output);
                        return false;
                    }else{
                        if( this.value != '' ){
                            var str = "category="+$('#cat_id').val()+"&subcat="+this.value;
                            $.post("<?=base_url().'master/getServiceList'?>", str, function(data){
                                data = JSON.parse(data);
                                console.log(data.data)
                                $(data.data).each(function(){
                                    output +="<option value='"+this.id+"'>"+this.name+"</option>";
                                });
                                $('#service_id').html(output);
                            });
                        }else{
                            $('#service_id').html(output);
                        }       
                    }                                 
                });
            });

            function getServiceFields(){
                
                if( $('#cat_id').val() == '' ){
                    Swal.fire('Select Category');
                    return false;
                }else if( $('#sub_cat_id').val() == '' ){
                    Swal.fire('Select Sub Category');
                    return false;
                }else if( $('#service_id').val() == '' ){
                    Swal.fire('Select Service');
                    return false;
                }else{
                    var postdata = {cat_id:$('#cat_id').val(),sub_cat_id:$('#sub_cat_id').val(),service_id:$('#service_id').val()};
                    //console.log(postdata);
                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    });
                    $.ajax({
                        url: "<?=base_url().'master/getFieldList'?>",
                        type: "post",
                        data:  postdata ,
                        dataType : 'html',
                        success: function (response) {
                            $('.pagecontent').html(response);
                            Swal.close();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                type: 'error',
                                title: '',
                                text: 'Something went wrong!',
                            })
                        }
                    });
                }

            }

            function validateForm(){
                var cat_id = $.trim($('#cat_id').val());
                var color = $.trim($('#color').val());
                var card_type = $.trim($('#card_type').val());
                var name = $.trim($('#name').val());
                var validity = $.trim($('#validity').val());
                var price = $.trim($('#price').val());
                var descr = $.trim($('#descr').val());
                
                if( cat_id == '' ){
                    Swal.fire('Select Category');
                    return false;
                }

                if( color == '' ){
                    Swal.fire('Select Colour');
                    return false;
                }

                if( card_type == '' ){
                    Swal.fire('Select Card Type');
                    return false;
                }

                if( name == '' ){
                    Swal.fire('Enter Package Name');
                    return false;
                }

                if( validity == '' ){
                    Swal.fire('Enter Validay in days');
                    return false;
                }

                if( price == '' ){
                    Swal.fire('Enter Price');
                    return false;
                }

                if( descr == '' ){
                    Swal.fire('Enter Description');
                    return false;
                }

                var services = $("input[name='service[]']").map(function(){ return this.value; }).get();
                var postdata =  {   
                                    cat_id:cat_id,color:color,card_type:card_type,name:name,
                                    validity:validity,price:price,descr:descr,
                                    services:services
                                };                
                if( $('#servicetable tbody tr').length == 0 ){
                    Swal.fire('Select Service');
                    return false;
                }else{
                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Saving please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    })
                    console.log(postdata);

                    $.ajax({
                        url: "<?=base_url().'master/savePackage'?>",
                        type: "post",
                        data:  postdata ,
                        dataType : 'html',
                        success: function (response) {
                            console.log(response);
                            if( response == '1' ){
                                Swal.fire({
                                    type: 'success',
                                    text: 'Saved successfully',
                                }).then((result) => {
                                    window.location.href = "<?=base_url().'master/packages'?>";
                                });
                                
                            }else if( response == '-1' ){
                                Swal.fire({
                                    type: 'error',
                                    text: 'Package already exists!',
                                })
                            }else if( response == '-2' ){
                                Swal.fire({
                                    type: 'error',
                                    text: 'Required fields are missin',
                                })
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                type: 'error',
                                text: 'Something went wrong!',
                            })
                        }
                    });
                }
                return false;
            }
        </script>
    </body>

</html>