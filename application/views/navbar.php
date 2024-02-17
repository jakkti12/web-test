<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url('')?>"><img src="/assets/img/logo.png" width="50px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <?php if(!$this->session->userdata('email')){?>
      <ul class="navbar-nav navbar-home-1">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('auth/login')?>">login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('auth/login')?>">register</a>
        </li>
      </ul>
      <?php }else{?>
      <ul class="navbar-nav">
      	<li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('')?>">หน้าหลัก</a>
        </li>
        
        <li class="nav-item dropdown navbar-home-2">
          <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
          	<img class="user_img" src="<?php echo $user_info['user_picture']?>"> 
		  </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo base_url('auth/edit_profile')?>">edit_profile</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url('auth/edit_img_profile')?>">edit_img_profile</a></li>
            <?php if($user_level == 'admin'){?>
            <li><a class="dropdown-item" href="<?php echo base_url('auth/admin')?>">bypass</a></li>
            <?php }?>
            <li><a class="dropdown-item" href="<?php echo base_url('auth/logout')?>">logout</a></li>
          </ul>
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</nav>