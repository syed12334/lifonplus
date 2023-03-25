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
	
    <!-- Custom CSS -->
    <link href="<?=asset_url()?>css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
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
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?=$header?>
        <?=$leftmain?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
		  <div class="row page-titles">
				<div class="col-md-5 col-12 align-self-center">
					<h3 class="text-themecolor mb-0">Points</h3>
					<ol class="breadcrumb mb-0 p-0 bg-transparent">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Settings</a></li>
						<li class="breadcrumb-item active">Points</li>
					</ol>
				</div>
			</div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
						   <?php echo $this->session->flashdata('message');?>
                            <div class="card-body">
                                <h4 class="card-title">Points</h4>
                               
                                <form method="post" action="<?php echo base_url();?>others/savepoints">
								   <div class="form-group">
                                    <label class="col-4" for="signup">Enter Sign Up Amount(Rs.)</label>
									  <div class="col-4">
                                        <input type="text" name="signup" id="signup" placeholder="Sign Up Amount(Rs.)" class="form-control onlynumbers" maxlength="4" />
                                      </div>
								   </div>
									
									 <div class="form-group">
                                       <label class="col-4" for="referral">Enter Referral Amount(Rs.)</label>
									    <div class="col-4">
                                           <input type="text" name="referral" id="referral" placeholder="Referral Amount(Rs.)" class="form-control onlynumbers"  maxlength="4" />
										</div>
                                    </div>
									
								  <div class="form-group mb-0 text-center">
										 <button type="submit" class="btn btn-info" id="saveButton"><i class="fa fa-check"></i> Submit</button>
										 <a href="<?php echo base_url();?>others/points" class="btn btn-dark waves-effect waves-light">Cancel</a>
									</div>
									 
									   
									
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?=$footer?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->
    
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?=$jsfile?>
    <!-- This Page JS -->
    
    <script>
        function validate()
		{
			if( $.trim($('#signup').val()) == '' ){
				Swal.fire('Enter Sign Up Amount');
				return false;
			}
			if( $.trim($('#referral').val()) == '' ){
				Swal.fire('Enter Referral Amount');
				return false;
			}
		   return true;				
		}
    </script>
</body>

</html>