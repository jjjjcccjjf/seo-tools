
<section id="container" class="">
  <!--header start-->
  <header class="header white-bg">
    <div class="sidebar-toggle-box">
      <i class="fa fa-bars"></i>
    </div>
    <!--logo start-->
    <a href="<?php echo base_url() ?>" class="logo" >OPTIMIND<span>SEO</span></a>
    <!--logo end-->
    <div class="top-nav ">
      <ul class="nav pull-right top-menu">
        <li class="dropdown">
          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <img alt="" style="max-height:25px" onerror="this.src='<?php echo base_url('public/admin/img/account.png') ?>'" src="<?php echo $this->session->userdata('profile_pic'); ?>">
            <span class="username">Welcome back, <?php echo $this->session->userdata('name'); ?></span>
            <b class="caret"></b>
          </a>
          <ul class="dropdown-menu extended logout">
            <li><a href="<?php echo base_url('cms/login/logout') ?>"><i class="fa fa-key"></i> Log Out</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </header>
  <!--header end-->
  <!--sidebar start-->
  <aside>
    <div id="sidebar"  class="nav-collapse ">
      <!-- sidebar menu start-->
      <ul class="sidebar-menu" id="nav-accordion">
        <li>
          <a href="<?php echo base_url('cms') ?>"
            class="<?php echo $this->uri->segment(1) === 'cms' && ($this->uri->segment(2) === null || $this->uri->segment(2) === 'dashboard') ? 'active': ''; ?>">
            <i class="fa fa-dashboard"></i>
            <span>Admin Management</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('cms/users') ?>"
            class="<?php echo $this->uri->segment(1) === 'cms' && $this->uri->segment(2) === 'users' ? 'active': ''; ?>">
            <i class="fa fa-users"></i>
            <span>Users Management</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('cms/link_builds') ?>"
            class="<?php echo $this->uri->segment(2) === 'link_builds' ? 'active': ''; ?>">
            <i class="fa fa-link"></i>
            <span>My Link Builds</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url('cms/link-builder-tool') ?>"
            class="<?php echo $this->uri->segment(2) === 'link-builder-tool' ? 'active': ''; ?>">
            <i class="fa fa-link"></i>
            <span>Link Builder Tool</span>
          </a>
        </li>

        <!-- <li class="sub-menu">
          <a href="javascript:;" class="<?php echo (in_array($this->uri->segment(2), ['link-builder-tool']))  ? 'active': ''; ?>">
            <i class="fa fa-tasks"></i>
            <span>Link Builder Tool</span>
          </a>
          <ul class="sub" >
            <li><a <?php echo $this->uri->segment(2) === 'news' ? 'style="color:#ff6c60"': ''; ?> href="<?php echo base_url('admin/news') ?>">News</a></li>
            <li><a <?php echo $this->uri->segment(2) === 'events' ? 'style="color:#ff6c60"': ''; ?> href="<?php echo base_url('admin/events') ?>">Events</a></li>
            <li><a <?php echo $this->uri->segment(2) === 'about' ? 'style="color:#ff6c60"': ''; ?> href="<?php echo base_url('admin/about') ?>">About</a></li>
          </ul>
        </li> -->
      </ul>
      <!-- sidebar menu end-->
    </div>
  </aside>
  <!--sidebar end-->
