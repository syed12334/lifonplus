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
		<style>
			* {box-sizing: border-box}
			body {font-family: "Lato", sans-serif;}

			/* Style the tab */
			.tab {
			  float: left;
			  border: 1px solid #ccc;
			  background-color: #f1f1f1;
			  width: 30%;
			  /*height: 300px;*/
			}

			/* Style the buttons inside the tab */
			.tab button {
			  display: block;
			  background-color: inherit;
			  color: black;
			  padding: 22px 16px;
			  width: 100%;
			  border: none;
			  outline: none;
			  text-align: left;
			  cursor: pointer;
			  transition: 0.3s;
			  font-size: 17px;
			}

			/* Change background color of buttons on hover */
			.tab button:hover {
			  background-color: #ddd;
			}

			/* Create an active/current "tab button" class */
			.tab button.active {
			  background-color: #ccc;
			}

			/* Style the tab content */
			.tabcontent {
			  float: left;
			  padding: 0px 12px;
			  border: 1px solid #ccc;
			  width: 70%;
			  border-left: none;
			  /*height: 300px;*/
			}
	    </style>
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
                        <h3 class="text-themecolor mb-0">End Users</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">End Users</li>
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
                                                <label for="to_date">Code</label>
                                                <input type="text" placeholder="Code" class="form-control" name="code" id="code">
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="to_date">Name</label>
                                                <input type="text" placeholder="Name" class="form-control" name="name" id="name">
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="to_date">Email ID</label>
                                                <input type="text" placeholder="Email" class="form-control" name="email" id="email">
                                            </div>
                                        </div>
                                    </div>
									
									 <div class="col-sm-12 col-lg-2">
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <label for="to_date">Phone No</label>
                                                <input type="text" placeholder="Phone No" class="form-control onlynumbers" name="mobileno" id="mobileno" maxlength="10">
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
                            <h4 class="card-title">End Users</h4>
                            <div class="card-tools">
                                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Filter/Search</a>
                              <a class="btn btn-success" href="<?=base_url()?>end_users/add_user" ><i class="fa fa-plus"></i> Add</a>
                            </div><hr>                            
                            <table id="category_table" class="table display table-bordered table-striped no-wrap" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Action</th>
                                        <th>Card Image</th>
                                        <th>Card Number</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Mobile No</th>
                                        <th>Package Name</th>
                                        <th>Email ID</th>
                                        <th>Country</th>
										<th>State</th>
										<th>District</th>
										<th>Taluk</th>
                                        <th>Photo</th>
										<th>Referral Code</th>
                                                                     
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
                    "order":[],
                    "ajax":{  
                        url:"<?=base_url().'end_users/usersList'?>",  
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
                            url: "<?=base_url().'end_users/setuserStatus'?>",
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
                console.log(id);
                Swal.fire({
                    allowOutsideClick: false,
                    html : '<i class="fas fa-spinner fa-spin"></i> Loading please wait...',
                    buttons: false,
                    showConfirmButton: false,
                });
                $.get("<?=base_url().'end_users/getuserDetail/'?>"+id, '', function(data){
                    try{
                        //console.log(data);
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
                console.log(id);
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
                            url: "<?=base_url().'end_users/verifyPartner'?>",
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
			
			 function loademergency_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/emergency", "user_id="+id, function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						var location,sms="No";
						if(this.sms == 1){
							sms="Yes";
						}
						
						if(this.location == 1){
							location="Yes";
						}
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.name+"</td>";
						output += "<td>"+this.phone+"</td>";
						output += "<td>"+this.relation+"</td>";
						output += "<td>"+sms+"</td>";
						output += "<td>"+location+"</td></tr>";
						i++;
                    });
                    $('#emgid').html(output);
                });
                $('#emgid').html(output);
            } 
			
			
			function loadservicedata_post(id){
                var output = "";
				var row = "";	
                $.post("<?=base_url()?>v1/servicedatalist", "user_id="+id, function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var i=1;
                    row = "<div class='tab'>";         
                    $(data.data).each(function(){
						
			            row += "<button class='tablinks' onclick='openCity(event, "+i+")' id='defaultOpen'>"+this.title+"</button>";
						output += "<div id="+i+" class='tabcontent'>";
                       	var fields ="";	
						$(this.service).each(function(){
							
			              fields += "<h4>"+this.title+"</h4>";
						  fields += "<table class='table table-bordered'>";
                            fields += "<tr>";  
							  $(this.fields).each(function(index,value){
								   /* if(index == 0){
										fields += "<th>Order</th>";
									}*/
									fields += "<th>"+this.label+"</th>";
							  });
						    fields += "</tr>";
						  
			                fields += "<tr>";
							  $(this.fields).each(function(index,value){
								 /* if(index == 0){
										fields += "<td>"+this.order+"</td>";
									}*/
								  fields += "<td>"+this.value+" "+this.note+"</td>";
							  });
						    fields +="</tr>";
						  fields +="</table>";
						  
						});
						output += fields+"</div>";
						i++;
                    });
					row += "</div>";
					 
                    $('#emgid').html(row+output);
                });
                $('#emgid').html(row);
            }
			
			
			function loadconsult_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/consult", "user_id="+id, function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.doctor_name+"</td>";
						output += "<td>"+this.specialty+"</td>";
						output += "<td>"+this.phone+"</td>";
						output += "<td>"+this.experience+"</td>";
						output += "<td>"+this.consulted_on+"</td>";
						output += "<td>"+this.comments+"</td></tr>";
						i++;
                    });
                    $('#consultid').html(output);
                });
                $('#consultid').html(output);
            }
			
			
			function loadDiagnosis_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/diagnosis", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.medical_diagnosis+"</td>";
						output += "<td>"+this.note+"</td>";
						output += "<td>"+this.special_diagnosis+"</td>";
						output += "<td>"+this.special_note+"</td>";
						output += "<td>"+this.conducted_on+"</td></tr>";
						
						i++;
                    });
                    $('#diagid').html(output);
                });
                $('#diagid').html(output);
            }
			
			
			function loadInsurance_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/insurance", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.insurance_name+"</td>";
						output += "<td>"+this.policy_number+"</td>";
						output += "<td>"+this.plan_date+"</td>";
						output += "<td>"+this.expiry_date+"</td>";
						output += "<td>"+this.amount+"</td></tr>";
						
						i++;
                    });
                    $('#insuranceid').html(output);
                });
                $('#insuranceid').html(output);
            }
			
			
			
			function loadSurgery_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/surgery", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.procedure_name+"</td>";
						output += "<td>"+this.procedure_comment+"</td>";
						output += "<td>"+this.special_procedure+"</td>";
						output += "<td>"+this.special_comment+"</td>";
						output += "<td>"+this.conducted_on+"</td></tr>";
						
						i++;
                    });
                    $('#surgeryid').html(output);
                });
                $('#surgeryid').html(output);
            }
			
			
			function loadRadiology_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/radiology", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.title+"</td>";
						output += "<td>"+this.result+"</td>";
						output += "<td>"+this.doctor+"</td>";
						output += "<td>"+this.date+"</td>";
						output += "<td><a href="+this.image+" target='_blank'><img src="+this.image+" width='90px' height='90px'></a></td></tr>";
						
						i++;
                    });
                    $('#radiologyid').html(output);
                });
                $('#radiologyid').html(output);
            }
			
			
			function loadPathology_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/pathology", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.title+"</td>";
						output += "<td>"+this.result+"</td>";
						output += "<td>"+this.doctor+"</td>";
						output += "<td>"+this.date+"</td>";
						output += "<td><a href="+this.image+" target='_blank'><img src="+this.image+" width='90px' height='90px'></a></td></tr>";
						
						i++;
                    });
                    $('#pathologyid').html(output);
                });
                $('#pathologyid').html(output);
            }
			
			
			function loadlabtest_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/labtest", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.test_name+"</td>";
						output += "<td>"+this.test_result+"</td>";
						output += "<td>"+this.note+"</td>";
						
						output += "<td><a href="+this.image+" target='_blank'><img src="+this.image+" width='90px' height='90px'></a></td>";
						output += "<td>"+this.date+"</td></tr>";
						
						i++;
                    });
                    $('#labtestid').html(output);
                });
                $('#labtestid').html(output);
            }
			
			
			function loadBills_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/bill", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.title+"</td>";
						
						output += "<td>"+this.note+"</td>";
						output += "<td>"+this.date+"</td>";
						output += "<td><a href="+this.image+" target='_blank'><img src="+this.image+" width='90px' height='90px'></a></td></tr>";
						
						
						i++;
                    });
                    $('#billid').html(output);
                });
                $('#billid').html(output);//prescrid
            }
			
			function loadprescrid_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/prescription", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.doctor+"</td>";
						
						output += "<td>"+this.message+"</td>";
						output += "<td>"+this.date+"</td>";
						output += "<td><a href="+this.image+" target='_blank'><img src="+this.image+" width='90px' height='90px'></a></td></tr>";
						
						
						i++;
                    });
                    $('#prescrid').html(output);
                });
                $('#prescrid').html(output);//prescrid
            }
			
			
			
			function loadexam_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/exam", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.temp+' '+this.temp_unit+"</td>";
						output += "<td>"+this.weight+' '+this.weight_unit+"</td>";
						output += "<td>"+this.height+' '+this.height_unit+"</td>";
						output += "<td>"+this.symptoms+"</td>";
						output += "<td>"+this.diagnosis+"</td>";
						output += "<td>"+this.note+"</td>";
						output += "<td>"+this.doctor+"</td>";
						output += "<td>"+this.date+"</td></tr>";
						
						
						i++;
                    });
                    $('#examid').html(output);
                });
                $('#examid').html(output);//prescrid
            }
			
			
			function loadAllergy_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/allergy", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
                        output += "<td>"+this.allergy_name+"</td>";
						
						output += "<td>"+this.date+"</td>";
						output += "<td>"+this.note+"</td></tr>";
						
						
						i++;
                    });
                    $('#allergyid').html(output);
                });
                $('#allergyid').html(output);//prescrid
            }
			
			
			function loadVaccine_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/vaccine", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
						output += "<td>"+this.date+"</td>";
                        output += "<td>"+this.vaccine_name+"</td>";
						output += "<td>"+this.dose+"</td>";
						output += "<td>"+this.note+"</td></tr>";
						
						
						i++;
                    });
                    $('#vaccineid').html(output);
                });
                $('#vaccineid').html(output);//prefid
            }
			
			
			function loadPreference_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/hospital", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
						output += "<td>"+this.hospital+"</td>";
                        output += "<td>"+this.medical_note+"</td>";
						output += "<td>"+this.admit_date+"</td></tr>";
						
						
						i++;
                    });
                    $('#prefid').html(output);
                });
                $('#prefid').html(output);//prefid
            }
			
			
			function loadMedicalVisit_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/medical", "user_id="+id, function(data){
                   // console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
						output += "<td>"+this.visit_date+"</td>";
                        output += "<td>"+this.visit_type+"</td>";
						output += "<td>"+this.consulted_doctor+"</td>";
						output += "<td>"+this.reason+"</td></tr>";
						
						
						i++;
                    });
                    $('#visitid').html(output);
                });
                $('#visitid').html(output);//prefid
            }
			
			
			function loadVitals_post(id){
                var output = "";
                $.post("<?=base_url()?>v1/vitals", "user_id="+id, function(data){
                    //console.log(''+data);
                    data = JSON.parse(data);
                    var i=1;                    
                    $(data.data).each(function(){
						//console.log(data);
						//console.log(data.service);
						output += "<tr><td>"+i+"</td>";
						output += "<td>"+this.height+"</td>";
                        output += "<td>"+this.weight+"</td>";
						output += "<td>"+this.bmi+"</td>";
						output += "<td>"+this.spo2+"</td>";
                        output += "<td>"+this.pulse+"</td>";
						output += "<td>"+this.bp+"</td>";
						output += "<td>"+this.sugar_level+"</td>";
                        output += "<td>"+this.ecg+"</td>";
						output += "<td>"+this.hemoglobin+"</td>";
						output += "<td>"+this.tds+"</td>";
                        output += "<td>"+this.mac+"</td>";
						output += "<td>"+this.distance_test+"</td>";
						output += "<td>"+this.near_vision_test+"</td>";
                        output += "<td>"+this.astigmatism+"</td>";
						output += "<td>"+this.cvd_test+"</td>";
						output += "<td>"+this.cholesterol+"</td>";
                        output += "<td>"+this.vascular_age+"</td>";
						output += "<td>"+this.skin_carotenoid+"</td>";
						output += "<td>"+this.capillary_shape+"</td>";
                        output += "<td>"+this.heart_rate+"</td>";
						output += "<td>"+this.report_date+"</td></tr>";
						
						
						i++;
                    });
                    $('#vitalsid').html(output);
                });
                $('#vitalsid').html(output);//prefid
            }


        </script>
		
		
		<script>
			function openCity(evt, cityName) {
			  var i, tabcontent, tablinks;
			  tabcontent = document.getElementsByClassName("tabcontent");
			  for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			  }
			  tablinks = document.getElementsByClassName("tablinks");
			  for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			  }
			  document.getElementById(cityName).style.display = "block";
			  evt.currentTarget.className += " active";
			}

			// Get the element with id="defaultOpen" and click on it
			document.getElementById("defaultOpen").click();
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