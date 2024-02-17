<div class="background">
	<div class="container">
		<div class="row">
			<div class="col-sm-5 pt-4">
				<div class="container">
					<?php if($this->session->userdata('email')){?>
					<div class="card card-user pt-4">
						<div class="mb-4 px-3">
							<img class="user_img mt-1 m-1" src="<?php echo $user_info['user_picture']?>" width="50px"> 
							<a class="color-white px-3"><?php echo $user_info['email']?></a>
						</div>
					</div>
					<div class="card">
						<div>
							หน้าหลัก
						</div>
					</div>
					<?php }?>
				</div>
			</div>
			<div class="col-sm-7 pt-4">
				<div class="container">
					<a class="color-white btn btn-primary add_post" href="<?php echo base_url('auth/add_post')?>">Add</a><br><br>
					<?php foreach ($post->result() as $row) {?>
    					<div class="card card-post mt-5 mb-5">
    						<div class="container mt-3">
    						<?php foreach ($all_user->result() as $id) { ?>
    								<?php if($row->user_id == $id->id){?>
        								<div class="row">
        									<div class="col-sm-1 mt-2">
        										<img class="user_img" src="<?php echo $id->user_picture; ?>" width="50px"> 
        									</div>
        									<div class="col-md-10 px-4">
        										<a class="color-white"><?php echo $id->firstname;?></a><br>
        										<a class="color-white font-10px"><?php echo $this->date_time->date_thai($row->created_at); ?></a>
        									</div>
        									<?php if($row->user_id == $this->session->userdata('id')){?>
        									<div class="col-sm-1 mt-2">
                                            	<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                                              		<i class="fa-solid fa-ellipsis" style="color: #ffffff; font-size:20px;"></i>
                                    		  	</a>
                                              	<ul class="dropdown-menu">
                                                	<li>
                                                		<input class="dropdown-item" type="submit" name="edit" value="Edit_post"
														onClick="javascript:window.location='edit_post?id=<?php echo $row->post_id; ?>';">
													</li>
													
                                                	<li>
                                                		<input class="dropdown-item" type="submit" name="edit" value="Delete_post"
														onClick="javascript:window.location='delete_post?id=<?php echo $row->post_id; ?>';">
                                                	</li>
                                              </ul>
        									</div>
        									<?php }?>
        								</div>
    								<?php }?>
    							<?php }?>
    						</div><br>
    						<div class="mb-3">
    							<a class="color-white px-3"><?php echo $row->comment;?></a>
    							<hr class="color-white">
    							<img class="img_post" src="<?php echo $row->img;?>">
    						</div>
    					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
</div>