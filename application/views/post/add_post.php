<?php echo form_open_multipart('auth/add_post');?>
<input type="text" name="comment" placeholder="comment">
<input type="file" name="userfile" size="20" />
<input type="submit" value="upload" />