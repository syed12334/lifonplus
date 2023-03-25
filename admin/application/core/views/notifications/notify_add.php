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
        <link href="<?=asset_url()?>css/multiple-select.css" rel="stylesheet" />
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
                        <h3 class="text-themecolor mb-0">Notifiations</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Notifiations</li>
							<li class="breadcrumb-item active"><?php if($type == 1){?>Add<?php }else{?>Edit<?php }?>Notify</li>
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
					<?php if($type ==1){?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Notify</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" method="post" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>notifications/saveNotify">
                                <input type="hidden" name="id" id="id" value="0" />
                                

							  
                                
                                <div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" id="title"/>
                                    </div>
                                </div>
								
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="descr" id="descr" ></textarea>
                                    </div>
                                </div>
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Image</label>
                                    <div class="col-sm-4">
									    <input type="hidden" name="imgstat" id="imgstat" value="0">
                                        <input type="file" class="form-control" name="image_path" id="image_path" />
                                    </div>
                                
                                    <label class="col-sm-2 text-right control-label col-form-label" style="display:none;">Enter Date & Time</label>
                                    <div class="col-sm-4" style="display:none;">
                                        <input type="text" class="form-control datetimepicker" name="date_time" id="date_time" />
                                    </div>
                                </div>
								
								<div class="form-group row">
								  <label class="col-sm-2 text-right control-label col-form-label state">Select State</label>
                                    <div class="col-sm-4 state">
                                        <select class="form-control" id="state" name="state_id" onchange="loadUsers();">
                                                <option value=""> --- Select State --- </option>
                                         </select>  
                                    </div>
                                
                                    <label class="col-sm-2 text-right control-label col-form-label district">Select District</label>
                                    <div class="col-sm-4 district">
                                        <select class="form-control" id="district" name="district_id" onchange="loadUsers();">
                                                <option value="">--- Select District --- </option>
                                            </select>
                                    </div>
								</div>
								
								<div class="form-group row">
									 <label class="col-sm-2 text-right control-label col-form-label taluk">Select Taluk</label>
                                    <div class="col-sm-4 taluk">
                                         <select class="form-control" id="taluk" name="taluk_id" onchange="loadUsers();">
                                                <option value="">--- Select Taluk--- </option>
                                            </select>
                                    </div>
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select End Users</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="user_id" name="user_id[]" multiple="multiple">
                                               
                                        </select>
                                    </div>
								</div>
								
								<div class="form-group row">
									 <label class="col-sm-2 text-right control-label col-form-label">Notify?</label>
                                    <div class="col-sm-4">
                                         <input type="checkbox" name="notify" id="notify"> App Notify
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'notifications'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
                        </div>
                    </div>
					
					<?php }else{?>
					 <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Notify</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>notifications/saveNotify" method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo $details[0]->id;?>" />
                                

                                <div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Title</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $details[0]->title;?>"/>
                                    </div>
                                </div>
								
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Enter Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="descr" id="descr" ><?php echo $details[0]->descr;?></textarea>
                                    </div>
                                </div>
								
								<div class="form-group row">
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Image</label>
									<div class="col-sm-4">
                                      <input type="file" class="form-control" name="image_path" id="image_path" />
									</div>
									<input type="hidden" name="imgstat" id="imgstat" value="1">
									<img src="<?php echo app_asset_url().$details[0]->image_path;?>" width="70px" height="70px">
                                
                                    <label class="col-sm-2 text-right control-label col-form-label" style="display:none;">Enter Date & Time</label>
                                    <div class="col-sm-4" style="display:none;">
                                        <input type="text" class="form-control datetimepicker" name="date_time" id="date_time" value=""/>
                                    </div>
                                </div>
								
								<div class="form-group row">
								  <label class="col-sm-2 text-right control-label col-form-label state">Select State</label>
                                    <div class="col-sm-4 state">
                                        <select class="form-control" id="state" name="state_id" onchange="loadUsers();">
										  <?php 
										    $state_list = $this->master_db->getRecords('states',array('country_id'=>1,'status'=>1),'id,name','name asc');
										    if(count($state_list))
											{
												foreach($state_list as $s)
												{
										   ?>
										  
                                                <option value="<?=$s->id;?>" <?php if($s->id==$details[0]->state_id){?>selected<?php }?>><?=$s->name;?></option>
										    <?php 
												}
											}
											?>
                                         </select>  
                                    </div>
                                
                                    <label class="col-sm-2 text-right control-label col-form-label district">Select District</label>
                                    <div class="col-sm-4 district">
                                        <select class="form-control" id="district" name="district_id" onchange="loadUsers();">
                                           <?php 
										    $district_list = $this->master_db->getRecords('districts',array('state_id'=>$details[0]->state_id,'status'=>1),'id,name','name asc');
										    if(count($district_list))
											{
												foreach($district_list as $d)
												{
										   ?>
										  
                                                <option value="<?=$d->id;?>" <?php if($d->id==$details[0]->district_id){?>selected<?php }?>><?=$d->name;?></option>
										    <?php 
												}
											}
											?>
                                        </select>
                                    </div>
								</div>
								
								<div class="form-group row">
									 <label class="col-sm-2 text-right control-label col-form-label taluk">Select Taluk</label>
                                    <div class="col-sm-4 taluk">
                                         <select class="form-control" id="taluk" name="taluk_id" onchange="loadUsers();">
                                               <?php 
			                               $taluk_list=$this->master_db->getRecords('cities',array('district_id'=>$details[0]->district_id,'status'=>1),'id,name','name asc');
										    if(count($taluk_list))
											{
												foreach($taluk_list as $t)
												{
										   ?>
										  
                                                <option value="<?=$t->id;?>" <?php if($t->id==$details[0]->taluk_id){?>selected<?php }?>><?=$t->name;?></option>
										    <?php 
												}
											}
											?>
                                            </select>
                                    </div>
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select End Users</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="user_id" name="user_id[]" multiple="multiple">
                                          <?php 
										    $user_list = $this->web_db->getCustomers($details[0]->state_id,$details[0]->district_id,$details[0]->taluk_id);
											
											$recipients = $this->master_db->getRecords('recipient_notify',array('notify_id'=>$details[0]->id,'status'=>1),'GROUP_CONCAT(user_id) as user_id');
											
											$users = count($recipients) ?  explode(',',$recipients[0]->user_id) : array();
										
										    if(count($user_list))
											{
												foreach($user_list as $u)
												{
										   ?>
										  
                                                <option value="<?=$u->id;?>" <?php if(in_array($u->id,$users)){?>selected<?php }?>><?=$u->name;?></option>
										    <?php 
												}
											}
											?>     
                                        </select>
                                    </div>
								</div>
								
								<div class="form-group row">
									 <label class="col-sm-2 text-right control-label col-form-label">Notify?</label>
                                    <div class="col-sm-4">
                                         <input type="checkbox" name="notify" id="notify" <?php if($details[0]->notify == 1){?>checked<?php }?>> App Notify
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'notifications'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
                        </div>
                    </div>
					
					<?php }?>
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
                <?php if($type == 1){?>
                loadStates();
				<?php }?>
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

               
            });

            function validateForm(){

                var state = $.trim($('#state').val());
				var district = $.trim($('#district').val());
				var title = $.trim($('#title').val());
				var image_path = $.trim($('#image_path').val());
				//var date_time = $.trim($('#date_time').val());
				var imgstat = $.trim($('#imgstat').val());
                
				if( title == '' ){
                    Swal.fire('Select Title');
                    return false;
                }
                if( $.trim(tinyMCE.get('descr').getContent()) == '' ){
					Swal.fire('Enter Description');
					return false;
				}
				
				if( image_path == '' && imgstat ==0){
                    Swal.fire('Select Image Upload');
                    return false;
                }
				/*if( date_time == '' ){
                    Swal.fire('Enter Date & Time');
                    return false;
                }*/
				if( state == '' ){
                    Swal.fire('Select State');
                    return false;
                }
				
				if( district == '' ){
                    Swal.fire('Select District');
                    return false;
                }
                return true;
            }
			
			
			 function loadUsers(){
				 
				var state = $.trim($('#state').val());
				var district = $.trim($('#district').val());
				var taluk = $.trim($('#taluk').val());
                $.post("<?=base_url()?>notifications/getUsers", {country_id:1,state:state,district:district,taluk:taluk}, function(data){
                    //console.log(data);
                    data = JSON.parse(data);
                    var output = "";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+" - "+this.code+"</option>";
                    });
                    $('#user_id').html(output);
                    $('#user_id').multipleSelect({
						filter: true
					});
                });
            }
			
			
            function loadStates(){
                $.get("<?=base_url()?>app/states", "country_id=1", function(data){
                    
                    data = JSON.parse(data);
                    var output = "<option value=''>--Select State--</option>";
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#state').html(output);
                    $('#pstate').html(output);
                });
            }

            function loadDistricts(ele){
                var output = "<option value=''>--Select District--</option>";
                $.get("<?=base_url()?>app/districts", "state_id="+ele.value, function(data){
                    //console.log(data);
                    data = JSON.parse(data);                    
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#district').html(output);
                });
                $('#district').html(output);
            }

            function loadTaluks(ele){
                var output = "<option value=''>--Select Taluk--</option>";
                $.get("<?=base_url()?>app/taluks", "district_id="+ele.value, function(data){
                    //console.log(data);
                    data = JSON.parse(data);                    
                    $(data.data).each(function(){
                        output += "<option value='"+this.id+"'>"+this.name+"</option>";
                    });
                    $('#taluk').html(output);
                });
                $('#taluk').html(output);
            } 


               $('#state').change(function(){
                    if( this.value != '' ){
                       
                        var data = "country=1&state="+this.value;
                           
                        loadDistricts(this);
                    }else{
                        $('#district').html("<option>--Select District/Town/City--</option>");
                    }
                });

                $('#district').change(function(){
                    if( this.value != '' ){

                        var state = $.trim($('#state').val());
                        if( state == '' ){
                            Swal.fire('Select state');
                            return false;
                        }

                        var data = "country=1&state="+state+"&district="+this.value;
                        
                        loadTaluks(this);
                    }else{
                        $('#taluk').html("<option>--Select Taluk--</option>");
                    }
                });			
        </script>
		<script src="<?=asset_url();?>js/tinymce/tinymce.min.js"></script>
    <script>
        $(function () {
            if ($("#descr").length > 0) {
                tinymce.init({
                    selector: "textarea#descr",
                    theme: "modern",
                    height: 200,
					
                    plugins: [
                        "advlist autolink link image lists  print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars   insertdatetime ",
                        "save contextmenu directionality  paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent  | print preview  fullpage | forecolor backcolor emoticons",
                });
            }
        });
		
		$(function () { 
		    $('#user_id').multipleSelect({
	    		filter: true
	    	});
			
		});
				
				
    </script>
	
	<script src="<?=asset_url()?>js/multiple-select.js"></script>
    </body>

</html>