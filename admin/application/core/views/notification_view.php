<?php
    //echo "<pre>";print_r($notify);exit;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lifeon + Notification</title>
    <link rel="shortcut icon" href="<?=app_url()?>assets/img/logo/favicon.png">

    <!-- FONT_AWESOME -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?=app_url()?>assets/css/fontawesome.min.css">

    <!-- THEMIFY ICON -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/themify-icons.css">

    <!-- X-ICON -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/xicon.css">


    <!-- OWL CAROUSEL -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/owl.carousel.min.css">

    <!-- CORE NAVIGATION -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/coreNavigation-1.1.3.min.css">

    <!-- FANCY-BOX -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/jquery.fancybox.min.css">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="<?=app_url()?>assets/css/bootstrap.min.css">

    <!-- PERSONAL STYLE -->
    <link rel="stylesheet" href="<?=app_url()?>assets/scss/style.css">
    <link rel="stylesheet" href="<?=app_url()?>assets/css/responsive.css">
  </head>
  <body>

      <!-- Preloader -->

      <div id="preloader">
          <div id="status">
              <img src="<?=app_url()?>assets/img/logo/favicon.png" alt="perloader">
          </div>
      </div>

      <!-- SERVICE PAGE BANNER -->

      <div class="page-banner">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="page-banner-content">
                          <div class="d-sm-flex justify-content-between align-items-center">
                              <div class="title">
                                  <h6 class="text-left text-capitalized">Lifeon+</h6>
                                  <h2>Lifeon <span>Plus</span></h2>
                              </div>
                              <div class="link text-sm-right text-left">
                                  <a href="#">Home <i class="ti-angle-double-right"></i></a>
                                  <a href="#">Notification<i class="ti-angle-double-right"></i></a>
                                  Lifeon +
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <!-- SERVICE PAGE BANNER  END-->

      <!-- BLOG PAGE SECTION -->

      <section class="blog-page">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                    <?php 

                    if(!empty($notify)) {
                      ?>
 <div class="blog-single-page">
                          <div class="blog-item">
                              <div class="blog-bg">


                                <?php

                                if( !empty($notify[0]->image) ){
                                  ?>
                                  <img src="<?=app_asset_url().$notify[0]->image?>" alt="Notification">
                                  <?php
                                }
                                ?>
                                <div class="overlay">
                                  <i class="far fa-image"></i>
                                </div>
                              </div>
                              <div class="blog-content">
                                  <h4><a href="#"><?=$notify[0]->title?></a></h4>
                                  <div class="">
                                      <span><?=$notify[0]->datetime?></span>
                                      
                                  </div>
                                  <?=$notify[0]->descr?>
                              </div>
                          </div>
                      </div> 
                      <?php
                    }else {
                      echo "No data found";
                    }
                    ?>
                                           
                  </div>
              </div>
          </div>
      </section>
      
      <!-- FOOTER START -->
      
      <footer class="footer-section">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="footer-content d-md-flex justify-content-between align-items-center text-center">
                          <p>Copyright © 2021 <a href="https://lifeonplus.com">Lifeon Plus</a> All rights
                              reserved.
                          </p>
                      </div>
                  </div>
              </div>
          </div>
      </footer>

      <!-- FOOTER END -->
      <script src="<?=app_url()?>assets/js/jquery-3.3.1.min.js"></script>
      <script src="<?=app_url()?>assets/js/bootstrap.min.js"></script>
      <script src="<?=app_url()?>assets/js/owl.carousel.min.js"></script>
      <script src="<?=app_url()?>assets/js/coreNavigation-1.1.3.min.js"></script>
      <script src="<?=app_url()?>assets/js/jquery.fancybox.min.js"></script>
      <script src="<?=app_url()?>assets/js/mixitup.min.js"></script>
      <script src="<?=app_url()?>assets/js/popper.min.js"></script>
      <script src="<?=app_url()?>assets/js/script.js"></script>
  </body>
</html>