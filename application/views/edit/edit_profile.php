<form action="" method="post">
	<input type="text" name="firstname" value="<?php echo $user_info['firstname']?>" placeholder="firstname"><br> 
	<input type="text" name="lastname" value="<?php echo $user_info['lastname']?>" placeholder="lastname"><br>
	<input type="email" name="email" value="<?php echo $user_info['email']?>" placeholder="email"><br>
	<input type="password" name="old_password" placeholder="Old_password"><br>
	<input type="password" name="new_password" placeholder="new_password"><br> 
	<input type="password" name="conf_password" placeholder="confirm_password"><br> 
	<input type="submit" value="Edit">
</form>