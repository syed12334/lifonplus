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
                    <h3 class="text-themecolor mb-0">Services</h3>
                    <ol class="breadcrumb mb-0 p-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Services</li>
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
                        <h4 class="card-title">Services</h4>
                        <div class="card-tools">
                        <button class="btn btn-success" onclick="addNew();" ><i class="fa fa-plus"></i> Add</button>
                        </div><hr>
                        
                        <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Action</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Service</th>
                                    <th>Price</th>
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
                    url:"<?=base_url().'master/serviceList'?>",  
                    type:"POST",
                    data: function(d){
                        //d.form = $("#searchForm").serializeArray();
                    },
                    error: function(){  // error handling
                        $(".user_data-error").html("");
                        $("#user_data").append('<tbody class="user_data-error"><tr><th colspan="7">No data found in the server</th></tr></tbody>');
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
                if(v.form()){
                    console.log( $("#category_form").serialize() )
                    $("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
                    var str = $("#category_form").serialize();
      				
      				$.post("<?=base_url().'master/saveService'?>", str, function(data){
      				
      					if(parseInt(data) == 1){
      						$("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully. Please wait loading...</div>');
      						window.setTimeout(function () { 
                                $('#addModal').modal('hide');  
                                $('#name').val('');
                                $('#msg_box').html('');
      						}, 1000); 
      						$("#category_table").dataTable().fnDestroy();
      						initialiseData();
                            
      					}else{
      						$("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>'+data+'</div>');
      					}
      					
      				});
                }
            });

            $('#resetButton').click(function(){
                $('#name').val('');
                $('#cat_id').val(0);
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

        function addNew(){
            $('#id').val(0);
            $('#category_form').trigger('reset');
            $('#addModal').modal('show')
            $('#addModalLabel').html('Add Service');
            var output = '<option value="">--Select--</option>';
            $('#subcat_id').html(output);
        }

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
                    
                        url: "<?=base_url().'master/setServiceStatus'?>",
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

        function modifyRow(id){
            console.log(id)
            $('#addModal').modal('show')
            $('#addModalLabel').html('Edit Service')

            $.get("<?=base_url().'master/getService/'?>"+id, {id:id}, function(data){
	    		try{
	    			var json = $.parseJSON(data);
                    console.log(json);
                    if( json.status == 'success' ){
                        $('#cat_id').val(json.data.cat_id);
                        var output = "<option value=''>--Select--</option>";
                        $(json.subcat).each(function(){
                            if( parseInt(json.data.subcat_id) == parseInt(this.id) ){
                                output = output +"<option selected value="+this.id+">"+this.name+"</option>";
                            }else{
                                output = output +"<option value="+this.id+">"+this.name+"</option>";
                            }
                        });
                        //console.log(output);
                        $('#subcat_id').html(output);
                        $('#subcat_id').val(json.data.subcat_id);
                        $('#name').val(json.data.name);
                        $('#descr').val(json.data.descr);
                        $('#price').val(json.data.price);
                        $('#id').val(json.data.id);
                    }else if( json.status == 'fail' ){
                        $('#addModal').modal('hide')
                        Swal.fire({
                            type: 'error',
                            title: '',
                            text: 'Service not found',
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
                        <form id="category_form">
                            <input type="hidden" name="id" id="id" value="0" />
                            <div class="form-group">
                                <label for="cat_id">Select Category</label>
                                <select name="cat_id" id="cat_id" class="form-control" required>
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

                            <div class="form-group">
                                <label for="cat_id">Select Sub-Category</label>
                                <select name="subcat_id" id="subcat_id" class="form-control" required>
                                    <option value="">--Select--</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Enter Service Name</label>
                                <input type="text" name="name" id="name" placeholder="Service Name" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label for="name">Enter Price</label>
                                <input type="text" name="price" id="price" placeholder="Price" class="form-control onlynumbers" required/>
                            </div>

                            <div class="form-group">
                                <label for="name">Service Description</label>
                                <textarea class="form-control" name="descr" id="descr" required maxlength="450" rows="3"></textarea>
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