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
        <?php echo $style; ?>
        <title><?php echo title; ?></title>
        <!-- This page plugin CSS -->
        <link href="<?php echo asset_url() ?>js/extra-libs/css-chart/css-chart.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo asset_url() ?>css/extra-libs/c3/c3.min.css">
        <link rel="stylesheet" type="text/css" href="<?= asset_url() ?>libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css">
        <!-- Custom CSS -->
        <link href="<?= asset_url() ?>css/style.min.css" rel="stylesheet">
        <?php echo $updatelogin ?>
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
            <?= $header ?>
            <?= $leftmain ?>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-center">
                        <h3 class="text-themecolor mb-0">Dashboard</h3>

                    </div>
                </div>
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header customhead">
                                    <h4 class="card-title text-white">Products & Services</h4>
                                </div>
                                <div class="card-body overflow-auto">
                                    <table class="table table-bordered table-striped mytable">
                                        <thead>
                                            <!--<tr>
                                                <th>Sl.No.</th>
                                                <th>Category</th>
                                                <th>Received From</th>
                                                <th>Sold To</th>
                                                <th>Balance</th>
                                                <th>Party Name</th>
                                                <th>Date</th>
                                                <th>Invoice No</th>
                                                <th>Balance</th>
                                            </tr>-->
											<tr>
                                                <th>Sl.No.</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Pin Amount</th>
                                                <th>Total Amount</th>
                                                
                                            </tr>
											
                                        </thead>
                                        <tbody>
										
										   <?php

										   $i=1;
										   if(count($pin_list))
										   {
											   foreach($pin_list as $p)
											   {
												   $name = '';
													switch($p->type){
														case 1: $name = $p->package;break;
														case 2: $name = $p->service;break;
														case 3: $name = $p->item;break;
														default:$name = '';
													}
											?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$p->pintype;?></td>
                                                <td><?=$name;?></td>
                                                <td><?=$p->qty;?></td>
                                                <td><?=$p->pin_amt;?></td>
                                                <td><?=$p->total_amt;?></td>
                                                
                                            </tr>
										<?php 
										    $i++;
										       
											  }
										  }
										 ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                               <!--  <div class="card-header customhead">
                                    <h4 class="card-title text-white">Transaction History</h4>
                                </div> -->
                               <!--  <div class="card-body overflow-auto">
                                    <table class="table table-bordered table-striped mytable">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Client Name</th>
                                                <th>Product/Service</th>
                                                <th>Qty</th>
                                                <th>City</th>
                                                <th>Email ID</th>
                                                <th>Phone No</th>
                                                <th>Txn ID</th>
                                                <th>Datetime</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

										   $si=1;
										   if(count($transfer_list))
										   {
											   foreach($transfer_list as $t)
											   {
												   
												    $name = '';
													switch($t->type){
														case 1: $name = $t->package;break;
														case 2: $name = $t->service;break;
														case 3: $name = $t->item;break;
														default:$name = '';
													}
													$company = ' --- ';
                                                    if( $t->transfer_type == 2 ){ $company = $t->code.' - '.$t->company_name; }
												  
											?>
                                            <tr>
                                                <td><?=$si;?></td>
                                                <td><?=$company;?></td>
                                                <td><?=$t->pintype;?></td>
                                                <td><?=$t->qty;?></td>
                                                <td><?=$t->taluk_name;?></td>
                                                <td><?=$t->emailid;?></td>
												<td><?=$t->contactno;?></td>
                                                <td><?=$t->txn_no;?></td>
                                                <td><?=$t->created_at;?></td>
                                                
                                                
                                            </tr>
										<?php 
										       $si++;
											  }
										  }
										 ?>
                                        </tbody>
                                    </table>
                                </div> -->
                            </div>
                        </div>                       
                    </div>
                    <!-- Row -->

                </div>
                <!-- End Container fluid  -->
                <!-- footer -->
                <?= $footer ?>
                <!-- End footer -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->

        <div class="chat-windows"></div>
        <?= $jsfile ?>
        <!--Morris JavaScript -->
        <script src="<?php echo asset_url(); ?>libs/raphael/raphael.min.js"></script>
        <script src="<?php echo asset_url(); ?>libs/morris.js/morris.min.js"></script>
        <script src="<?php echo asset_url(); ?>js/extra-libs/sparkline/sparkline.js"></script>


        <script src="<?php echo asset_url(); ?>extra-libs/c3/d3.min.js"></script>
        <script src="<?php echo asset_url(); ?>extra-libs/c3/c3.min.js"></script>
        <!-- line chart -->
        <script src="<?php echo asset_url(); ?>libs/bar-pie/c3-donut.js"></script>
        <script src="<?php echo asset_url(); ?>libs/data/c3-data-color.js"></script>

        <script src="<?=asset_url()?>/select2/dist/js/select2.full.min.js"></script>
        <script src="<?=asset_url()?>/select2/dist/js/select2.min.js"></script>
        <script src="<?=asset_url()?>select2/select2.init.js"></script>
        
        <script src="<?=asset_url()?>libs/moment/moment.js"></script>
        <script src="<?=asset_url()?>libs/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker-custom.js"></script>

    </body>
</html>