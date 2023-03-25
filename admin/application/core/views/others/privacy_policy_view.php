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
					<h3 class="text-themecolor mb-0">Privacy Policy</h3>
					<ol class="breadcrumb mb-0 p-0 bg-transparent">
						<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Settings</a></li>
						<li class="breadcrumb-item active">Privacy Policy</li>
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
                                <h4 class="card-title">Privacy Policy</h4>
                               
                                <form method="post" action="<?php echo base_url();?>others/saveprivacy" >
								  <div class="form-group">
								   <div class="col-8">
                                       <textarea id="mymce" name="privacy"><?=$privacy[0]->privacy;?></textarea>
									</div>
								   </div>
									<div class="form-group">
									  <div class="form-group mb-0 text-center">
                                             <button type="submit" class="btn btn-info" id="saveButton" onclick="return validate();"><i class="fa fa-check"></i> Submit</button>
                                             <a href="<?php echo base_url();?>others/privacy" class="btn btn-dark waves-effect waves-light">Cancel</a>
                                        </div>
									 
									   
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
    <script src="<?=asset_url();?>js/tinymce/tinymce.min.js"></script>
    <script>
        $(function () {
            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 200,
					
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars   insertdatetime ",
                        "save contextmenu directionality  paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                });
            }
        });
		
		function validate()
		{
			if( $.trim(tinyMCE.get('mymce').getContent()) == '' ){
				Swal.fire('Enter Privacy Policy');
				return false;
			}
		   return true;				
		}
					
    </script>
</body>

</html>