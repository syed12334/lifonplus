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
    <link href="<?php echo asset_url()?>js/extra-libs/css-chart/css-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    
    <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
    <?php echo $updatelogin?>
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
                    <h3 class="text-themecolor mb-0">My Profile</h3>
                    <ol class="breadcrumb mb-0 p-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url()?>myprofile">My Profile</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
                    <div class="card card-body">
                    <?php echo $this->session->flashdata('message');?>
                    <!-- form start -->
        			<form class="form-horizontal"  id="validate" >
        				
						<div class="form-group" id="title_div">
							<label class="col-sm-4 control-label">Old Password <font color="#FF0000">*</font></label>
							<div class="col-sm-6">
								<input type="password" class="form-control" placeholder="Old Password" required name="password" id="password" title="Enter Old Password" maxlength="20">
							</div>
                        </div>
						
						<div class="form-group" >
							<label class="col-sm-4 control-label">New Password <font color="#FF0000">*</font></label>
							<div class="col-sm-6">
								<input type="password" class="form-control" placeholder="New Password" required name="new_password" id="new_password" title="Enter New Password" maxlength="20">
							</div>
                        </div>
						
						<div class="form-group" >
							<label class="col-sm-4 control-label">Confirm Password <font color="#FF0000">*</font></label>
							<div class="col-sm-6">
								<input type="password" class="form-control" placeholder="Confirm Password" required name="confirm_password" id="confirm_password" title="Enter Confirm Password" maxlength="20">
							</div>
                        </div>
                        
                        <div class="form-group text-center" >
							<a href="<?php echo base_url()?>Myprofile" type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancel</a>
							<button type="button" class="btn btn-info pull-right" id="saveButton"><i class="fa fa-save"></i> Submit</button>
							
							<div id="msg_box"></div>
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
   <script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
      
	    <script type="text/javascript">
			 var v ;
			$(function () { 
			v = $("#validate").validate({
				errorClass: "help-block",
				errorElement: 'span',
				onkeyup: true,
				onblur: true,
				rules: {
					password :  {
                        minlength: 6
                    },
					new_password: {
                        minlength: 6
                    },
                    confirm_password : {
        	         minlength : 6,
        	         equalTo : "#new_password"
        	        },
				 
					
				},
				messages: {
					 password: {
                        minlength: "Please enter atleast 6 characters"
                    },
					
					 new_password: {
                        minlength: "Please enter atleast 6 characters"
                    },
                   
	                confirm_password: {
						minlength: "Please enter atleast 6 characters",
	                	equalTo: "Password and Confirm password does not match"
	                },
				},
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
		   		
	 				$("#msg_box").html('<div class="alert alert-warning alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>Please wait...</div>');
	 				var str = $("#validate").serialize();
	 				
	 				$.post("<?php echo base_url();?>myprofile/edit_profile", str, function(data){
	 				
	 					if(parseInt(data) == 1){
	 						window.location.href = "<?php echo base_url()?>myprofile";
	 					}
	 					else{
	 						$("#msg_box").html(data);
	 					}
	 					
	 				});	
		   		}
		   	 });
		});

	   </script>
</body>

</html>