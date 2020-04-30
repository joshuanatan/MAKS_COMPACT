<div class="site-menubar">
    <div class="site-menubar-header">
        <div class="cover overlay">
            <div class="overlay-panel vertical-align overlay-background">
                <div class="vertical-align-middle">
                    <a class="avatar avatar-lg" href="javascript:void(0)">
                        <img src="<?php echo base_url();?>assets/images/default.jpg" alt="...">
                    </a>
                    <div class="site-menubar-info">
                        <h5 class="site-menubar-user"><?php echo $this->session->nama_user;?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>user">
                            <i class="site-menu-icon wb-memory" aria-hidden="true"></i>
                            <span class="site-menu-title">User Administrator</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>result_type">
                            <i class="site-menu-icon wb-stats-bars" aria-hidden="true"></i>
                            <span class="site-menu-title">Result Type</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a href="<?php echo base_url();?>resultmapping">
                            <i class="site-menu-icon wb-share" aria-hidden="true"></i>
                            <span class="site-menu-title">Result Mapping</span>
                        </a>
                    </li>
                </ul> 
            </div>
        </div>
    </div>
</div>