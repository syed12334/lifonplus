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
                        <h3 class="text-themecolor mb-0">Tests</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tests</li>
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
                            <h4 class="card-title">Checkups</h4>
                            <div class="card-tools">
                            <button class="btn btn-success" onclick="addNew();" ><i class="fa fa-plus"></i> Add</button>
                            </div><hr>
                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Diagnostic Category</th>
                                        <th>Test Name</th>
                                        <th>MRP</th>
                                        <th>Price</th>                                        
                                        <th>Special Note</th>                                        
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
                    "processing":true,  
                    "serverSide":true,  
                    "searching": true,
                    "order":[],  
                    "ajax":{  
                        url:"<?=base_url().'master/checkupList'?>",  
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
                    if( $.trim($('#test_name').val()) == '' ){
                        Swal.fire('Enter Test Name');
                        return false;
                    }
                    if( $.trim($('#mrp').val()) == '' ){
                        Swal.fire('Enter Mrp');
                        return false;
                    }

                    if( $.trim($('#price').val()) == '' ){
                        Swal.fire('Enter Price');
                        return false;
                    }

                      if( $.trim($('#dcategory').val()) == '' ){
                        Swal.fire('Select Diagnostic Category');
                        return false;
                    }
                    Swal.fire({
                        allowOutsideClick: false,
                        html : '<i class="fas fa-spinner fa-spin"></i> Updating please wait...',
                        buttons: false,
                        showConfirmButton: false,
                    });
                    if(v.form()){
                        console.log( $("#category_form").serialize() )
                        $("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
                        var str = $("#category_form").serialize();
                        $.post("<?=base_url().'master/saveCheckups'?>", str, function(data){
                            if(parseInt(data) == 1){
                                $("#msg_box").html('<div class="alert alert-success alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Saved Successfully. Please wait loading...</div>');
                                window.setTimeout(function () { 
                                    $('#addModal').modal('hide');  
                                    $('#module_name').val('');
                                    $('#morder_no').val('');
                                    $('#msg_box').html('');
                                }, 1000); 
                                $("#category_table").dataTable().fnDestroy();
                                initialiseData();                            
                            }else{
                                $("#msg_box").html('<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>'+data+'</div>');
                            }
                            Swal.close();
                            
                        });
                    }
                });

                $('#resetButton').click(function(){
                    $('#module_name').val('');
                    $('#morder_no').val('');
                });

            });

            function addNew(){
                $('#addModal').modal('show')
                $('#addModalLabel').html('Add Module');
                $('#id').val(0);
                
                row ="<tr id='trs-0'>";
                row +="<td><input type='text' ' name='name[]' id='name0' class='form-control' maxlenth='400'></td>";
                row +="<td><a class='btn btn-sm btn-primary' onclick='addrow();' style='cursor: pointer;'><i class='fa fa-plus'></i></a></td>";
                row +="</tr>";
                $('#attctbl').html(row);
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
                        
                            url: "<?=base_url().'master/setCheckupsStatus'?>",
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
                $('#addModalLabel').html('Edit Checkups')

                $.get("<?=base_url().'master/getCheckups/'?>"+id, {id:id}, function(data){
                    try{
                        var json = $.parseJSON(data);
                       // console.log(json);
                        if( json.status == 'success' ){
                            $('#test_name').val(json.data.test_name);
                            $('#mrp').val(json.data.mrp);
                            $('#price').val(json.data.price);
                            $('#specialnote').val(json.data.special_note);
                            $('#time').val(json.data.report_datetime);
                            $('#id').val(json.data.id);
                            var row='';
                            console.log('_____'+$.isArray(json.subdata));
                            if((json.subdata).length !=0)
                            {
                                 $.each(json.subdata, function (i) {
                                
                                //$.each(json.subdata[i], function (key, val) {
                                    
                                    row +="<tr id='trs-"+json.subdata[i].id+"'>";
                                    row +="<td><input type='hidden'  name='subid[]' value="+json.subdata[i].id+"><input type='text'  name='name[]' id='name' maxlenth='400' class='form-control' value='"+json.subdata[i].title+"'></td>";
                                    if(i==0)
                                    {
                                       row +="<td><a class='btn btn-sm btn-primary' onclick='addrow();' style='cursor: pointer;'><i class='fa fa-plus'></i></a></td>";
                                    }
                                    else{
                                        row +="<td><a class='btn btn-sm btn-danger' onclick='removedata("+json.subdata[i].id+",);' style='cursor: pointer;'><i class='fa fa-minus'></i></a></td>";
                                    }
                                    
                                    row +="</tr>";
                                //});
                                });
                            }
                            else{
                                row +="<tr id='trs-0'>";
                                row +="<td><input type='text' ' name='name[]' id='name0' class='form-control'></td>";
                                row +="<td><a class='btn btn-sm btn-primary' onclick='addrow();' style='cursor: pointer;'><i class='fa fa-plus'></i></a></td>";
                                row +="</tr>";
                            }
                            
                            
                            $('#attctbl').html(row);
                            Swal.close();
                        }else if( json.status == 'fail' ){
                            $('#addModal').modal('hide')
                            Swal.fire({
                                type: 'error',
                                title: '',
                                text: 'Tests not found',
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
            
        function addrow()
        {
            $("#err").html('');
            var rand = Math.floor(Math.random() * 100);;
            var vals="";
            vals +="<tr id='trs-"+rand+"'>";
            vals +="<td><input type='text' name='name[]' id='name"+rand+"' class='form-control'></td>";
            vals +="<td><a class='btn btn-sm btn-danger' onclick='removedata("+rand+");' style='cursor:pointer;'><i class='fa fa-minus'></i></a></td>";
            vals +="</tr>";
            $('#attctbl').append(vals);
        }

        function removedata(id)
        {
            $("#err").html('');
            $("#trs-"+id).css('background-color', '#ff9999');
            if(confirm('Are you sure want to delete?'))
            {   
            
                $("#trs-"+id).remove(); 
                 $.ajax({
                url :"<?= base_url().'master/deleteCheckups'; ?>",
                method:"post",
                dataType:"json",
                data :{
                    id:id
                },
                success:function(data) {
                   if(data.status =='success') {
                    console.log(data.msg);
                   }else {
                    console.log(data.msg);
                   }
                }
            });
            }
            else 
            {
                $("#trs-"+id).css('background-color', '');
            }
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

                                    <div class="form-group">
                                    <label for="name">Select Diagnostic Category</label>
                                    <select class="form-control" name="dcategory" id="dcategory">
                                        <option value="">Select Diagnostic Category</option>
                                        <?php 
                                            if(count($category) >0) {
                                                foreach ($category as $cat) {
                                                    ?>
                                                    <option value="<?= $cat->id?>"><?= $cat->name?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <label for="name">Enter Checkup Name</label>
                                    <input type="text" name="test_name" id="test_name" placeholder="Test Name" class="form-control " required title="Enter Checkup Name"/>
                                    <input type="hidden" name="id" id="id" value="0" />
                                </div>
                                <div class="form-group">
                                    <label for="mrp">Enter MRP</label>
                                    <input type="text" name="mrp" id="mrp" placeholder="MRP" class="form-control onlynumbers" required title="Enter MRP"/>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="price">Enter Price</label>
                                    <input type="text" name="price" id="price" placeholder="Enter Price" class="form-control onlynumbers" required title="Enter Price"/>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="name">Enter Reports Within Hours</label>
                                    <input type="text" name="time" id="time" placeholder="Ex:reports within 6 working hours" class="form-control"  title="Enter Report Time"/>
                                   
                                </div>

                                  <div class="form-group">
                                    <label for="name">Enter Special Note</label>
                                    <textarea cols="3" rows="3" id="specialnote" name="specialnote" class="form-control" placeholder="Ex: Requires Fasting"></textarea>
                                   
                                </div>


                                <div class="form-group">
                                    <label for="type">Includes</label>
                                     <table class="table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Title</th>
                                            
                                          </tr>
                                        </thead>
                                        <tbody id="attctbl">
                                        
                                        </tbody>
                                     </table>
                                    
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