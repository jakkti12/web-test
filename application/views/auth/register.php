<?php
$arr = $this->session->flashdata();
if (! empty($arr['fail_message'])) {
    $html = '<div class="alert alert-dismissible fail-change_password" role="alert">';
    $html .= '<i class="fa-solid fa-triangle-exclamation icon-fail-change_password"></i>';
    $html .= '<a class="font-success-change_password">';
    $html .= $arr['fail_message'];
    $html .= '</a>';
    $html .= '</div>';
    echo $html;
}
?>
<form action="" method="post">
	<input type="text" name="firstname" placeholder="firstname"><br> <input
		type="text" name="lastname" placeholder="lastname"><br> <input
		type="email" name="email" placeholder="email"><br> <input
		type="password" name="password" placeholder="password"><br> <input
		type="password" name="conf_password" placeholder="confirm_password"><br>
	<input type="submit" value="register">
</form>