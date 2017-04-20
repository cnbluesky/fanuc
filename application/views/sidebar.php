<header class="main-header"> <a href="#" class="logo"> <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/logo-sm.png" alt=""></span> <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/logo-bg.png" alt=""></span> </a>
    <nav class="navbar navbar-static-top">
      <div class="header-top-clear">
        <div class="clearfix"> <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="logout dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="text">Admin</span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url().'user/change_password'?>">Change Password</a></li>
                  <li><a href="<?php echo base_url().'user/settings'?>">Settings</a></li>
                  <li><a href="<?php echo base_url().'logout'?>">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="treeview <?php if($this->uri->segment('1') == 'user'){?>active<?php }?>">
            <a href="<?php echo base_url().'user'?>"> <i class="fa fa-user"></i><span>Users</span></a></li>
        <li class="treeview <?php if($this->uri->segment('1') == 'product' || $this->uri->segment('1') == 'product_registration_details'){?>active<?php }?>">
            <a href="<?php echo base_url().'product'?>"><i class="fa fa-user"></i><span>Product Registration</span></a></li>
        <li class="treeview <?php if($this->uri->segment('1') == 'service' || $this->uri->segment('1') == 'service_request_detail'){?>active<?php }?>">
            <a href="<?php echo base_url().'service'?>"><i class="fa fa-user"></i><span>Service Requests</span></a></li>
        <li class="treeview <?php if($this->uri->segment('1') == 'foc' || $this->uri->segment('1') == 'foc_request_detail'){?>active<?php }?>">
            <a href="<?php echo base_url().'foc'?>"><i class="fa fa-user"></i><span>Follow-on-contract <br>
          Request (FOC)</span></a></li>
        <li class="treeview <?php if($this->uri->segment('1') == 'general' || $this->uri->segment('1') == 'enquiry_details'){?>active<?php }?>">
            <a href="<?php echo base_url().'general'?>"><i class="fa fa-user"></i><span>General Enquiry</span></a></li>
        
        <li class="treeview <?php if($this->uri->segment('1') == 'country' || $this->uri->segment('1') == 'add_country' || $this->uri->segment('1') == 'edit_country'){?>active<?php }?>">
            <a href="<?php echo base_url().'country'?>"><i class="fa fa-user"></i><span>Country List</span></a></li>
        
        <li class="treeview <?php if($this->uri->segment('1') == 'state' || $this->uri->segment('1') == 'add_state' || $this->uri->segment('1') == 'edit_state'){?>active<?php }?>">
            <a href="<?php echo base_url().'state'?>"><i class="fa fa-user"></i><span>State List</span></a></li>
        
        <li class="treeview <?php if($this->uri->segment('1') == 'city' || $this->uri->segment('1') == 'add_city' || $this->uri->segment('1') == 'edit_city'){?>active<?php }?>">
            <a href="<?php echo base_url().'city'?>"><i class="fa fa-user"></i><span>City List</span></a></li>
        
        <li class="treeview <?php if($this->uri->segment('1') == 'category' || $this->uri->segment('1') == 'add_category' || $this->uri->segment('1') == 'edit_category'){?>active<?php }?>">
            <a href="<?php echo base_url().'category'?>"><i class="fa fa-user"></i><span>Category</span></a></li>
      </ul>
    </section>
  </aside>