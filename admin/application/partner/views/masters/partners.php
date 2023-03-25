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
                        <h3 class="text-themecolor mb-0">Channel Partners</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Channel Partners</li>
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

                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            <form id="searchForm"> 
                                <div class="row">

                                    <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="status">Partner Type</label> 
                                                <select class="form-control" id="type" name="type">
                                                    <option value="">--- Select --- </option>
                                                    <option value="1">COUNTRY PARTNER </option>
                                                    <option value="2">STOCKIST </option>
                                                    <option value="3">STATE C&amp;F </option>
                                                    <option value="4">DISTRIBUTOR </option>
                                                    <option value="5">DEALER </option>
                                                    <option value="6">RETAILER </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="status">Partner Type</label> 
                                                <select class="form-control" id="company_type" name="company_type">
                                                    <option value=""> --- Select --- </option>
                                                    <option value="1">PRIVATE LIMITED</option>
                                                    <option value="2">LIMITED </option>
                                                    <option value="3">PARTNERSHIP</option>
                                                    <option value="4">PROPRITOR</option>
                                                    <option value="5">LLP</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="to_date">Code</label>
                                                <input type="text" placeholder="Code" class="form-control" name="code" id="code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="status">Status</label> 
                                                <select name="status" id="status" class="form-control" style="width: 100%;">
                                                    <option value="">--Select--</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">In-Active</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="status">Payment Mode</label> 
                                                <select class="form-control" id="payment_mode" name="payment_mode">
                                                    <option value=""> --- Select --- </option>
                                                    <option value="1">Cheque </option>
                                                    <option value="2">Cash </option>
                                                    <option value="3">RTGS </option>
                                                    <option value="4">Already paid to C&amp;F/Distributor/Dealer </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-lg-2 mt-4">
                                        <button type="button" class="btn btn-success" title="Get Orders" onclick="reinitialsedata();"><i class="fa fa-search"></i></button>
                                        <!--
                                            <a class="btn btn-info" title="Export Excel" onclick="export_excel();"><i class="fa fa-file-excel"></i></a>
                                        -->
                                        <a class="btn btn-warning" title="Reset" onclick="window.location.reload();"><i class="fa fa-undo-alt"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Channel Partners</h4>
                            <div class="card-tools">
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Filter/Search</a>
                                <a class="btn btn-success" href="<?=base_url()?>master/save_partner" ><i class="fa fa-plus"></i> Add</a>
                            </div><hr>                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Channel Partner Type</th>
                                        <th>Code</th>
                                        <th>Company Name</th>
                                        <th>Company Type</th>
                                        <th>GST No</th>
                                        <th>Name</th>
                                        <tH>Contact No</th>
                                        <th>Status</th>     
                                        <th>Verified</th>    
                                        <th>Login Credentials</th>                               
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
        <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
        <script>

            var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({  
                    "scrollX":true,
                    "processing":true,  
                    "serverSide":true,
                    "ajax":{  
                        url:"<?=base_url().'master/partnerList'?>",  
                        type:"POST",
                        data: function(d){
                            d.form = $("#searchForm").serializeArray();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },"columnDefs":[  
                        {  
                            "targets":[0,1],  
                            "orderable":false,  
                        },  
                    ],'rowCallback': function(row, data, index){
                        //$(row).find('td:eq(3)').css('background-color', data[3]).html("");   
                    }
                }); 
            }

            $(document).ready(function(){ 
                initialiseData();
            });

            function reinitialsedata(){
                var dt = $("#category_table").DataTable();
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
                        });
                        var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/setPartnerStatus'?>",
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

            function viewRow(id){
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });
                $.get("<?=base_url().'master/getPartnerDetail/'?>"+id, '', function(data){
                    try{
                        console.log(data);
                        if( data != '' ){
                            $('#partnerModal').modal('show');
                            $('#partnerModal .modal-body').html(data);
                        }
                        Swal.close();
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

            function verifyPartner(id){
                    
                Swal.fire({
                    title: '',
                    text: 'Are you sure,you want to approve verification?',
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
                        });
                        var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/verifyPartner'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                if(response == '1'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Updated Successfully");
                                }else if(response == '0'){
                                    Swal.fire("Partner not found or already verified.");
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

            function createLogin(id){
                Swal.fire({
                    title: '',
                    text: 'Are you sure,you want to generate and share login credentials with partner?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.value) {
                        //console.log(id);return false;
                        Swal.fire({
                            allowOutsideClick: false,
                            html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                            buttons: false,
                            showConfirmButton: false,
                        });
                        var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({                        
                            url: "<?=base_url().'master/generateLogin'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                if(response == '1'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Updated Successfully");
                                }else if(response == '-1'){
                                    Swal.fire("Partner verification is pending.");
                                }else if(response == '0'){
                                    Swal.fire("Partner not found or already verified.");
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

        </script>

        <div id="partnerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width:80%;">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="addModalLabel">Channel Partner Details</h4>
                        <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </body>
</html>