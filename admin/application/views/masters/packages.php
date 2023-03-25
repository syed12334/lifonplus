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
                        <h3 class="text-themecolor mb-0">Packages</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Packages</li>
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
                            <h4 class="card-title">Packages</h4>
                            <div class="card-tools">
                            <a class="btn btn-success" href="<?=base_url().'master/addpackage'?>" ><i class="fa fa-plus"></i> Add</a>
                            </div><hr>
                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Package</th>
                                        <th>Category</th>
                                        <th>Card Type</th>
                                        <th>Price</th>
                                        <th>Validity</th>
                                        <th>Status</th>                                        
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

            var dataTable, edit_data;
            function initialiseData(){
                dataTable = $('#category_table').DataTable({ 
                    "scrollX":true, 
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'master/packageList'?>",  
                        type:"POST",
                        data: function(d){
                            //d.form = $("#searchForm").serializeArray();
                        },
                        error: function(){  // error handling
                            $(".user_data-error").html("");
                            $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="8">No data found in the server</th></tr></tbody>');
                            $("#user_data_processing").css("display","none");
                        }
                    },"columnDefs":[  
                        {  
                            "targets":[],  
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
                        })

                        var postdata = { id : id,status : status } ;
                        //console.log( postdata );
                        $.ajax({
                        
                            url: "<?=base_url().'master/setPackageStatus'?>",
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
			
			  function updatePublishStatus(id,status){
                switch(status){
                    case 1 : var msg="Are you sure,you want to Publish ?";break;
                    case 0 : var msg="Are you sure,you want to Unpublish ?";break;
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
                        
                            url: "<?=base_url().'master/setPublishStatus'?>",
                            type: "post",
                            data:  postdata ,
                            dataType : 'json',
                            success: function (response) {
                                //console.log(response);
                                if(response == '1'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Published Successfully");
                                }
								else if(response == '2'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Package Module is not assigned.");
                                }
								else if(response == '3'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Package Highlights is not assigned.");
                                }
								else if(response == '0'){
                                    //reinitialsedata();
                                    dataTable.ajax.reload( null, false ); 
                                    Swal.fire("Unpublished Successfully");
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

            function modifyRow(id){
                Swal.fire({
                    text: 'Are you sure want to edit?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "<?=base_url().'master/editpackage?id='?>"+id;
                    }
                });
            }

            function apppermission(id){                
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });
                $.ajax({                
                    url: "<?=base_url().'master/getPackageAppModules'?>",
                    type: "post",
                    data:  {package_id:id} ,
                    dataType : 'html',
                    success: function (response) {
                        if( response == '0' ){
                            Swal.fire('Required fields are missing.')
                        }else{
                            Swal.close();
                            $('#viewModal').modal('show');
                            $('#viewModal .modal-body').html(response);
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
        </script>

        <div id="viewModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="addModalLabel">Package App Modules</h4>
                        <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer text-right" style="display:block;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </body>
</html>