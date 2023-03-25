<?php 
    $im = explode("~", $this->session->userdata(ADMIN_SESSION));

    if($im[0] =='9123456789') {
        ?>
           <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url()?>" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu"> Master</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="<?=base_url().'master/category'?>" class="sidebar-link"><i class="mdi mdi-emoticon"></i> <span class="hide-menu"> Category</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/country'?>" class="sidebar-link"><i class="mdi mdi-emoticon"></i> <span class="hide-menu"> Country</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/subcategory'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Sub-Category</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/services'?>" class="sidebar-link"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu"> Services</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/items'?>" class="sidebar-link"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu"> Equipment/Items</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/highlights'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Highlights</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/packages'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Packages</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'home/state'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> State</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'home/district'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> District</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'home/taluk'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Taluk</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'home/company_name'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Company Name</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/speciality'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Speciality</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/diagnostic'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Diagnostic Category</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/modules'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Modules</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/tests'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Tests</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/checkups'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Checkups</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/timeslot'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Time Slot</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'master/partners'?>" class="sidebar-link"><i class="mdi mdi-weather-cloudy"></i><span class="hide-menu"> Channel Partners</span></a></li>
                                
                                
                            </ul>
                        </li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'end_users'?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">End Users</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'master/videocall'?>" aria-expanded="false"><i class="mdi mdi-video"></i><span class="hide-menu">Video Call</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu"> Manage PINS</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="<?=base_url().'pin'?>" class="sidebar-link"><i class="mdi mdi-emoticon"></i> <span class="hide-menu"> PINS</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'pin/transfer'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Transfer PINS</span></a></li>
                            </ul>
                        </li>
                        
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu"> Settings</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                            
                                <li class="sidebar-item"><a href="<?=base_url().'others/points'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Points</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'others/aboutus'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i> <span class="hide-menu"> About Us</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'others/terms'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i> <span class="hide-menu"> Terms & Conditions</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'others/privacy'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i> <span class="hide-menu"> Privacy Policy</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'others/coupons'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Coupons</span></a></li>
                            </ul>
                        </li>
                         <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                         href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-notification-clear-all"></i><span class="hide-menu">Notifications</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                               
                                <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-playlist-plus"></i> <span class="hide-menu">Health Tips</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item"><a href="<?=base_url().'healthtips/category'?>" class="sidebar-link"><i class="mdi mdi-octagram"></i><span class="hide-menu"> Category</span></a></li>
                                        <li class="sidebar-item"><a href="<?=base_url().'healthtips'?>" class="sidebar-link"><i class="mdi mdi-octagram"></i><span class="hide-menu">Health Tips</span></a></li>
                                        
                                    </ul>
                                </li>
                                
                                 <li class="sidebar-item"> <a class="has-arrow sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-playlist-plus"></i> <span class="hide-menu">Flash News</span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item"><a href="<?=base_url().'flashnews/category'?>" class="sidebar-link"><i class="mdi mdi-octagram"></i><span class="hide-menu"> Category</span></a></li>
                                        <li class="sidebar-item"><a href="<?=base_url().'flashnews'?>" class="sidebar-link"><i class="mdi mdi-octagram"></i><span class="hide-menu">Flash News</span></a></li>
                                        
                                    </ul>
                                </li>
                                
                                <li class="sidebar-item"><a href="<?=base_url().'notifications'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Notify</span></a></li>
                                <li class="sidebar-item"><a href="<?=base_url().'popupalert'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Popup Alert</span></a></li>
                               
                            </ul>
                        </li>
                         <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'master/orders'?>" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">Orders</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'login/logout'?>" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Log Out</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
          
        </aside>
        <?php
    }else {
        ?>
           <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url()?>" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                       
                       
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'master/videocall'?>" aria-expanded="false"><i class="mdi mdi-video"></i><span class="hide-menu">Video Call</span></a></li>

                     
                        
             
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'login/logout'?>" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Log Out</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
          
        </aside>
        <?php
    }
    
?>

     