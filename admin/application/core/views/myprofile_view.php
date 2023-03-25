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
                        <li class="breadcrumb-item active">My Profile</li>
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
                        
                            <div class="row">
                                <div class="col-sm-12">
                                <?php echo $this->session->flashdata('message');?>
                                	<table id="example1" class="table table-bordered table-striped">
                						<thead>
                							<tr>
                							  <th>Sl No.</th>
                							  <th>User Id</th>
                							  <th>Actions</th>
                							</tr>
                						</thead>
                                    <tbody>
                    				<?php
                    				   $i=1;
                    				  foreach($detail as $b)
                    				  {	
											$user_name = $this->master_db->sqlExecute("select * from employee where id=$b->user_id");
                    				?>
                                    <tr>
                                      <td><?php echo $i;?></td>
                    				  <td><?php echo $user_name[0]->name;?></td>
                                      <td>
                                      	<button type="button" class="btn btn-primary btn-sm" title="Change Password" onclick="modifyRow('<?php echo $b->id;?>')"><i class="fa fa-lock"></i></button>
                                    </tr>
                                    <?php 
                    				  }
                    				?>
                                    </tbody>
                              </table>
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
   <script>
       function modifyRow(id){
    	   var base_url = '<?php echo base_url();?>';
    	   document.location.href =base_url+"myprofile/edit_profile";
       }

       
   </script>
</body>

</html>