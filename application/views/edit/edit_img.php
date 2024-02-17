<?php echo $error;?>

<?php echo form_open_multipart('auth/edit_img_profile');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />