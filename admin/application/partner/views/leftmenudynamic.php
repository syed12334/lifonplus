        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url()?>" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu"> Manage PINS</span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item"><a href="<?=base_url().'pin'?>" class="sidebar-link"><i class="mdi mdi-emoticon"></i> <span class="hide-menu"> PINS</span></a></li>
                                <?php if(is_array($detail)){
                                if($detail[0]->type == 6){
                           
                            }else {
                                 ?>

                                <li class="sidebar-item"><a href="<?=base_url().'pin/transfer'?>" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Transfer PINS</span></a></li>
                                <?php
                            }
                        }
                        ?>
                            </ul>
                        </li>
						<?php if(is_array($detail)){
							    if($detail[0]->type == 6){
							?>
						<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'end_users'?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">End Users</span></a></li>
						<?php }
						  }
						?>
						
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?=base_url().'login/logout'?>" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Log Out</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <?php /*?><div class="sidebar-footer">
                <!-- item-->
                <a href="<?=base_url()?>" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
                <!-- item-->
                <a href="<?=base_url()?>" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                <!-- item-->
                <a href="<?=base_url().'login/logout'?>" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
            </div>*/?>
            <!-- End Bottom points-->
        </aside>