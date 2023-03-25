<?php
$im = explode("~", $this->session->userdata(ADMIN_SESSION));
//echo "<pre>";print_r($im);exit; ?>
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

                    <?php if($im[0] =='9123456789') {?> 
                            <div class="row">                        
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'master/partners'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-danger">
                                            <i class="fas fa-code-branch"></i></div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$partners[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total Partners</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'master/packages'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-info">
                                            <i class="fas fa-cart-plus"></i></div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$packages[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total Packages</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'master/country'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-info">
                                            <i class="mdi mdi-source-branch"></i>
                                        </div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$countries[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total Countries</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'master/state'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-warning">
                                            <i class="fas fa-building"></i></div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$states[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total States</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'home/district'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-primary">
                                            <i class="fas fa-building"></i></div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$districts[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total Districts</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <a class="d-flex flex-row" href="<?=base_url().'home/taluk'?>">
                                        <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-warning">
                                            <i class="fas fa-building"></i></div>
                                        <div class="ml-2 align-self-center">
                                            <h3 class="mb-0 font-weight-light"><?=$taluks[0]->count?></h3>
                                            <h5 class="text-muted mb-0">Total Taluks</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- Row -->
                        
                    <?php }else {}?>
                

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