<?php 
    //echo "<pre>";print_r($details);exit;
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
		<link href="<?=asset_url()?>css/multiple-select.css" rel="stylesheet" />
        <style type="text/css">
            #packages {
                display: none;
            }
             #customers {
                display: none;
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
                        <h3 class="text-themecolor mb-0">Popup Alert</h3>
                        <ol class="breadcrumb mb-0 p-0 bg-transparent">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Popup Alert</li>
							<li class="breadcrumb-item active"><?php if($type == 1){?>Add<?php }else{?>Edit<?php }?>Popup Alert</li>
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
                            <h4 class="card-title">Add Popupalert</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" method="post" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>popupalert/savePopupalerts">
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
                                    <div class="col-sm-6">
									    <input type="hidden" name="imgstat" id="imgstat" value="0">
                                        <input type="file" class="form-control" name="image_path" id="image_path" />
                                    </div>
                                </div>
								
							
								    <div class="form-group row">
                                 <label class="col-sm-2 text-right control-label col-form-label">Select Type</label>
                                 <div class="col-sm-6">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="1">Package </option>
                                        <option value="2">Individuals</option>
                                    </select>   
                                    </div>                     
                                </div>


                                        <div class="form-group row" id="packages">
                                    
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Package</label>
                                    <div class="col-sm-4">
                                          <?php 
                                                if(count($package)) {
                                                    foreach ($package as $key => $pack) {
                                                       ?>
                                       <input type="radio" name="package" id="package" value="<?= $pack->id?>"> <?= $pack->name;?>

                                       <?php
                                   }
                               }
                                   ?>
                                    </div>
                                </div>
							
								
								<div class="form-group row" id="customers">
								
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select End Users</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="user_id" name="user_id[]" multiple="multiple">
                                               <?php 
                                                if(count($customer)) {
                                                    foreach ($customer as $key => $value) {
                                                       ?>
                                                       <option value="<?= $value->id ?>"><?= $value->name?></option>
                                                       <?php
                                                    }
                                                }
                                               ?>
                                        </select>
                                    </div>
								</div>
								
								

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'popupalert'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>            

                                <div class="pagecontent"></div>               
                            </form>
                            
                        </div>
                    </div>
					
					<?php }else{?>
					 <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Popup Alert</h4>
                            <div class="card-tools"></div><hr> 
                            <form id="category_form" onsubmit="return validateForm();" enctype="multipart/form-data" action="<?php echo base_url();?>popupalert/savePopupalerts" method="post">
                                <input type="hidden" name="id" id="id" value="<?php echo $details[0]->id;?>" />
                                
                                <?php
                                    $pop = $this->master_db->getRecords('popup_notify',array('popup_id'=>$details[0]->id,'status'=>1),'pid');
                                ?>
                                

                                
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
									<div class="col-sm-6">
                                      <input type="file" class="form-control" name="image_path" id="image_path" />
									</div>
									<input type="hidden" name="imgstat" id="imgstat" value="1">
									<img src="<?php echo app_asset_url().$details[0]->image_path;?>" width="70px" height="70px">
                                </div>
								
								
							<div class="form-group row">
                                 <label class="col-sm-2 text-right control-label col-form-label">Select Type</label>
                                 <div class="col-sm-6">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="1" <?php if($pop[0]->pid ==1) {echo "selected";}?>>Package </option>
                                        <option value="2" <?php if($pop[0]->pid ==2) {echo "selected";}?>>Individuals</option>
                                    </select>   
                                    </div>                     
                                </div>
								<?php  $recipients = $this->master_db->getRecords('popup_notify',array('popup_id'=>$details[0]->id,'status'=>1),'GROUP_CONCAT(user_id) as user_id');
                                ?>
								<div class="form-group row" id="customers" style="<?php if($pop[0]->pid ==2) { echo 'display: block'; }?>">
									
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select End Users</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="user_id" name="user_id[]" multiple="multiple">
                                                   <?php 
                                           
                                           
                                            $users = count($recipients) ?  explode(',',$recipients[0]->user_id) : array();
                                            if(count($customer))
                                            {
                                                foreach($customer as $u)
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

                                        <div class="form-group row" id="packages" style="<?php if($pop[0]->pid ==1) { echo 'display: block'; }?>">
                                    
                                
                                    <label class="col-sm-2 text-right control-label col-form-label">Select Package</label>
                                    <div class="col-sm-4">
                                         <?php 
                                                if(count($package)) {
                                                    foreach ($package as $key => $pack) {
                                                       ?>
                                       <input type="radio" name="package" id="package" value="<?= $pack->id?>" <?php if($pop[0]->pid == $pack->id) {echo "selected";}?>> <?= $pack->name;?>

                                       <?php
                                   }
                               }
                                   ?>
                                      
                                    </div>
                                </div>
								
							

                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
                                        <a href="<?=base_url().'popupalert'?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancel</a>
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

				var title = $.trim($('#title').val());
				var image_path = $.trim($('#image_path').val());
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
				
                return true;
            }
			
			
			 function loadUsers(){
				 
				
                $.post("<?=base_url()?>popupalert/getUsers", {}, function(data){
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

    $(document).ready(function() {
        $("#type").on("change",function() {
                var type = $(this).val();
                if(type ==1) {
                    $("#packages").show();
                    $("#customers").hide();
                }else if(type ==2) {
                    $("#packages").hide();
                    $("#customers").show();
                }
        });
    })
				
				
    </script>
	
	<script src="<?=asset_url()?>js/multiple-select.js"></script>
    </body>

</html>