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
                        <h3 class="text-themecolor mb-0">Edit Package</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Package</li>
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
                            <h4 class="card-title">Package Form</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" onsubmit="return validateForm();">
                                <input type="hidden" name="package_id" id="package_id" value="<?=$package->id?>" />
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="cat_id">Select Category</label>
                                        <select name="cat_id" id="cat_id" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach($category as $item){
                                                ?>
                                                <option value="<?=$item->id?>" <?php if( $item->id == $package->cat_id ){ echo 'selected'; } ?> ><?=$item->name?></option>
                                                <?php
                                            }    
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="color">Select Card Colour</label>
                                        <input type="color" name="color" id="color" placeholder="Select Colour" class="form-control" required value="<?=$package->color?>" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="card_type">Select Card Type</label>
                                        <select name="card_type" id="card_type" class="form-control" required>
                                            <option value="">--Select--</option>
                                            <option value="1" <?php if( $package->card_type == 1 ){ echo 'selected'; } ?> >Instant Digital Card</option>
                                            <option value="2" <?php if( $package->card_type == 2 ){ echo 'selected'; } ?> >Physical Card</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="name">Enter Package Name</label>
                                        <input type="text" name="name" id="name" placeholder="Package Name" class="form-control" required value="<?=$package->package?>" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="validity">Enter Validity(No of Days)</label>
                                        <input type="text" name="validity" id="validity" placeholder="Validity(No of Days)" class="form-control onlynumbers" required value="<?=$package->validity?>" />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="price">Enter Package Price</label>
                                        <input type="text" name="price" id="price" placeholder="Package Price" class="form-control onlynumbers" required value="<?=$package->price?>" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="descr">Enter Package Description</label>
                                        <textarea name="descr" id="descr" placeholder="Description" class="form-control" maxlength="450" rows="3" required><?=$package->descr?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <h4 class="card-title col-md-12">Package Services</h4>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label for="cat_id">Select Category</label>
                                        <select name="scat_id" id="scat_id" class="form-control">
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach($pcategory as $item){
                                                ?>
                                                <option value="<?=$item->id?>"><?=$item->name?></option>
                                                <?php
                                            }    
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cat_id">Select Sub-Category</label>
                                        <select name="subcat_id" id="subcat_id" class="form-control">
                                            <option value="">--Select--</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h3>Package Service List</h3>
                                        <table class="table table-bordered text-center" id="servicetable">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No</th>
                                                    <th>Service</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach($package->services as $row){
                                                    ?>
                                                    <tr id="row_<?=$row->service_id?>">
                                                        <td><input type='hidden' name='service[]' value='<?=$row->service_id?>' /><?=$i?></td>
                                                        <td><?=$row->name?></td>
                                                        <td><a onclick='removeService(<?=$row->service_id?>)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-6" id="servicelist">
                                        <h3>Service List</h3>
                                        <ul class="services"></ul>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'master/packages'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>                           
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

                $('#scat_id').change(function(){
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
                    var output = '';
                    if( $('#scat_id').val() == '' ){
                        Swal.fire('Select Category');
                        $('.services').html(output);
                        return false;
                    }else{
                        if( this.value != '' ){
                            var str = "category="+$('#scat_id').val()+"&subcat="+this.value;
                            $.post("<?=base_url().'master/getServiceList'?>", str, function(data){
                                data = JSON.parse(data);
                                console.log(data.data)
                                $(data.data).each(function(){
                                    output +="<li><label><input type='checkbox' id='service_"+this.id+"' class='servicelist' label='"+this.name+"' onchange='addService(this)' name='servicelist[]' value='"+this.id+"' /> "+this.name+"</label></li>";
                                });
                                $('.services').html(output);
                            });
                        }else{
                            $('.services').html(output);
                        }       
                    }                                 
                });
            });

            function addService(ele){
                console.log(ele.value)
                if( $('#servicetable tbody #row_'+ele.value).length == 1 ){
                    //Swal.fire('Service already added');
                    //$(ele).prop('checked',false);
                    //return false;
                    refershTable();
                    $('#row_'+ele.value).remove();
                }else if( $(ele).prop('checked') == true ){
                    var rows = $('#servicetable tbody tr').length+1;
                    var output = "<tr id='row_"+ele.value+"'>";
                    output += "<td><input type='hidden' name='service[]' value='"+ele.value+"' />"+rows+"</td>";
                    output += "<td>"+$(ele).attr('label')+"</td>";
                    output += "<td><a onclick='removeService("+ele.value+")' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a></td>";
                    output += "</tr>";
                    $('#servicetable tbody').append(output);
                }
            }

            function removeService(ele){
                //console.log(ele)
                Swal.fire({
                    title: '',
                    text: 'Are you sure want to remove service?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    $('#row_'+ele).remove();
                    if( $('#service_'+ele).length ){ $('#service_'+ele).prop('checked',false); }
                    refershTable();
                });
            }

            function refershTable(){
                var i = 1;
                $('#servicetable tbody tr').each(function(){
                    var row_id = this.id.split('_');
                    var output = "<input type='hidden' name='service[]' value='"+row_id[1]+"' /> "+i;
                    $('#'+this.id+' td:first-child').html(output);
                    i++;
                });
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
                                    package_id:$('#package_id').val(),
                                    cat_id:cat_id,color:color,card_type:card_type,name:name,
                                    validity:validity,price:price,descr:descr,
                                    services:services
                                };   

                //console.log(postdata);return false;
                if( $('#servicetable tbody tr').length == 0 ){
                    Swal.fire('Select Service');
                    return false;
                }else{
                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Saving please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    });

                    $.ajax({
                        url: "<?=base_url().'master/editpackage'?>",
                        type: "post",
                        data:  postdata ,
                        dataType : 'html',
                        success: function (response) {
                            //console.log(response);
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