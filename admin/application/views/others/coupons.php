<?php
    //echo "<pre>";print_r($state);exit;
?>
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
                        <h3 class="text-themecolor mb-0">Coupons</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
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
                            <h4 class="card-title">Coupons</h4>
                            <div class="card-tools">
                            <button class="btn btn-success" onclick="addNew();" ><i class="fa fa-plus"></i> Add</button>
                            </div><hr>
                            <div class="table-responsive">
                            <table id="coupon_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Coupon Title</th>
                                       <!--  <th>Customer Name</th>
                                        <th>Customer Mobile Number</th>
                                        <th>Customer State</th>
                                        <th>Customer District</th>
                                        <th>Customer Taluk</th> -->
                                  
                                        <th>Coupon Code</th>
										<th>From Date</th>
                                        <th>To Date</th>
										<th>Discount Type</th>
										<th>Amount/Percentage</th>
                                        <th>Status</th>                                        
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            </div>
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
$(document).ready(function() {
    $('#cname').select2();
});
            var dataTable, edit_data;
            function initialiseData(){
				
                dataTable = $('#coupon_table').DataTable({  
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'others/couponsList'?>",  
                        type:"POST",
                        data: function(d){
                            //d.form = $("#searchForm").serializeArray();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="5">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },"columnDefs":[  
                        {  
                            "targets":[2],  
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

                $("#saveButton").click(function(evt){
                    if( $.trim($('#coupon_code').val()) == '' ){
                        Swal.fire('Enter Coupon Code');
                        return false;
                    }

                    if( $.trim($('#coupon_title').val()) == '' ){
                        Swal.fire('Select Coupon Title');
                        return false;
                    }
                  
					 if( $.trim($('#from_date').val()) == '' ){
                        Swal.fire('Select From Date');
                        return false;
                    }
					if( $.trim($('#to_date').val()) == '' ){
                        Swal.fire('Select To Date');
                        return false;
                    }
					if( $.trim($('#discount_type').val()) == '' ){
                        Swal.fire('Select Discount Type');
                        return false;
                    }
					
					if( $.trim($('#amount').val()) == '' ){
                        Swal.fire('Select Amount/Percentage');
                        return false;
                    }


                   

                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    });
                   
                        //console.log( $("#category_form").serialize() )
                        $("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
                        var str = $("#coupon_form").serialize();
                        
                        $.post("<?=base_url().'others/saveCoupon'?>", str, function(data){
                        
                            if(parseInt(data) == 1){
                                $("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully. Please wait loading...</div>');
                                window.setTimeout(function () { 
                                    $('#addModal').modal('hide');  
                                    $('#coupon_code').val('');
                                    $('#coupon_title').val('');
									$('#from_date').val('');
									$('#to_date').val('');
									$('#no_of_users').val('');
									$('#discount_type').val('');
							        $('#amount').val('');
                                    $('#msg_box').html('');
                                }, 1000); 
                                $("#coupon_table").dataTable().fnDestroy();
                                initialiseData();                            
                            }else{
                                $("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>'+data+'</div>');
                            }
                            Swal.close();
                            
                        });
                    
                });

                $('#resetButton').click(function(){
                    $('#coupon_code').val('');
					$('#coupon_title').val('');
					$('#from_date').val('');
					$('#to_date').val('');
					$('#no_of_users').val('');
					$('#discount_type').val(0);
					$('#amount').val('');
                });

            });

            function addNew(){
                $('#addModal').modal('show')
                $('#addModalLabel').html('Add Coupon')
            }

            function reinitialsedata(){
                var dt = $("#coupon_table").DataTable();
                dt.ajax.reload(null, false);
            }

            function updateStatus(id,status){
                switch(status){
                    case 1 : var msg="Are you sure,you want to activate ?";break;
                    case 0 : var msg="Are you sure,you want to deactivate ?";break;
                    case -1 : var msg="Are you sure,you want to delete ?";break;
                    default : var msg=""; break;
                }
                    
                Swal.fire({

                    title: '',
                    text: msg,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            allowOutsideClick: false,
                            html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                            buttons: false,
                            showConfirmButton: false,
                        })

                        var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({
                        
                            url: "<?=base_url().'others/setCouponStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                //console.log(response);
                                if(response == '1'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Updated Successfully");
                                }else{
                                    Swal.fire({
                                        type: 'error',
                                        title: '',
                                        text: 'Failed try again!',
                                    })
                                }
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
                })
            }

            $(document).on("change","#state",function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url:"<?= base_url().'others/states'; ?>",
                    type :"post",
                    dataType:"html",
                    data :{
                        id:id
                    },
                    success:function(data) {
                        $("#district").html(data);
                    }
                });
            });

             $(document).on("change","#district",function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url:"<?= base_url().'others/taluks'; ?>",
                    type :"post",
                    dataType:"html",
                    data :{
                        id:id
                    },
                    success:function(data) {
                        $("#taluk").html(data);
                    }
                });
            });

              $(document).on("change","#taluk",function(e) {
                e.preventDefault();
                var district = $("#district").val();
                var state = $("#state").val();
                var id = $(this).val();
                $.ajax({
                    url:"<?= base_url().'others/custmer_names'; ?>",
                    type :"post",
                    dataType:"html",
                    data :{
                        taluk:id,
                        dis:district,
                        state:state
                    },
                    success:function(data) {
                        $("#cname").html(data);
                    }
                });
            });

             

            function modifyRow(id){
               // console.log(id)
                $('#addModal').modal('show')
                $('#addModalLabel').html('Edit Coupon')

                $.get("<?=base_url().'others/getCoupon/'?>"+id, {id:id}, function(data){
                    try{
                        var json = $.parseJSON(data);
                        console.log(json.data.cname);
                        if( json.status == 'success' ){
                            $('#coupon_code').val(json.data.coupon_code);
                            $('#coupon_title').val(json.data.coupon_title);
							$('#id').val(json.data.id);
                            $('#from_date').val(json.data.from_date);
							$('#to_date').val(json.data.to_date);
							$('#no_of_users').val(json.data.no_of_users);
							$('#discount_type').val(json.data.discount_type);
							$('#amount').val(json.data.amount);
                            $('#cname').val(json.data.cname);
                            $('#phone').val(json.data.mphone);
                            $('#state').val(json.data.state);
                            $('#district').val(json.data.district);
                            $('#taluk').val(json.data.taluk);
                            Swal.close();
                        }else if( json.status == 'fail' ){
                            $('#addModal').modal('hide')
                            Swal.fire({
                                type: 'error',
                                title: '',
                                text: 'Coupon not found',
                            })
                        }
                    }catch (err) {
                        console.log(err);	
                        Swal.fire({
                            type: 'error',
                            title: '',
                            text: 'Something went wrong!',
                        })			
                    }
                });
            }

        </script>

            <div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="addModalLabel">Modal Heading</h4>
                            <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form id="coupon_form">
                                <div class="form-group">
                                    <label for="coupon_code">Enter Coupon Code</label>
                                    <input type="text" name="coupon_code" id="coupon_code" placeholder="Coupon Code" class="form-control" required />
                                    <input type="hidden" name="id" id="id" value="0" />
                                </div>

                                <div class="form-group">
                                    <label for="type">Enter Coupon Title</label>
                                     <input type="text" name="coupon_title" id="coupon_title" placeholder="Coupon Title" class="form-control" required />
                                </div>

								 <div class="form-group">
                                    <label for="type">Enter From Date</label>
                                     <input type="date" name="from_date" id="from_date" placeholder="From Date" class="form-control" required />
                                </div>
								
								
								 <div class="form-group">
                                    <label for="type">Enter To Date</label>
                                     <input type="date" name="to_date" id="to_date" placeholder="To Date" class="form-control" required />
                                </div>
								
								<div class="form-group">
                                    <label for="type">Enter No of users</label>
                                     <input type="text" name="no_of_users" id="no_of_users" placeholder="Enter No of users" class="form-control onlynumbers" required maxlength="4"/>
                                </div>
								 <div class="form-group">
                                    <label for="type">Select Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-control" required>
                                        <option value=''>--Select--</option>
                                        <option value="1">Flat Discount</option>
                                        <option value="2">Percentage Discount</option>
                                    <select>
                                </div>
								
								<div class="form-group">
                                     <label for="type">Enter Amount/Percentage</label>
                                     <input type="text" name="amount" id="amount" placeholder="Enter Amount/Percentage" class="form-control onlynumbers" required maxlength="4"/>
                                </div>
                                <div class="form-group">
                                    <label>Select State</label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="">Select State</option>
                                        <?php
                                            if(count($state)) {
                                                foreach ($state as $key => $value) {
                                                   ?>
                                                   <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                   <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                     <div class="form-group">
                                    <label>District</label>
                                   
                                       <select name="district" id="district" class="form-control">
                                        <option value="">Select District</option>
                                        <?php
                                            if(count($district)) {
                                                foreach ($district as $key => $value) {
                                                   ?>
                                                   <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                   <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                     <div class="form-group">
                                 <label>Taluk</label>
                                  
                                   
                                       <select name="taluk" id="taluk" class="form-control">
                                        <option value="">Select Taluk</option>
                                        <?php
                                            if(count($taluk)) {
                                                foreach ($taluk as $key => $value) {
                                                   ?>
                                                   <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                   <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                    <div class="form-group">
                                 <label>Customers</label>
                                    <select name="customer[]" id="cname" class="form-control" multiple="multiple">
                                        <option value="">Select Customer</option>
                                           <?php
                                            if(count($customers)) {
                                                foreach ($customers as $key => $value) {
                                                   ?>
                                                   <option value="<?= $value->id;?>"><?= $value->name;?></option>
                                                   <?php
                                                }
                                            }
                                        ?>
                                      
                                    </select>
                                </div>
                                
								
								
                            </form>
                            <div id="msg_box"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            <button type="button" class="btn btn-warning" id="resetButton"><i class="fa fa-undo-alt"></i> Reset</button>
                            <button type="button" class="btn btn-info" id="saveButton"><i class="fa fa-check"></i> Submit</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

    </body>
</html>