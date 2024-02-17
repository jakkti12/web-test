<style>
table {
	font-family: arial, sans-serif;
	border-collapse: collapse;
	width: 100%;
}

td, th {
	border: 1px solid #dddddd;
	text-align: left;
	padding: 8px;
}

tr:nth-child(even) {
	background-color: #dddddd;
}
</style>
<div class="container">
	<h2>user</h2>
	<a href="auth/register">add_user</a>

	<table>
		<tr>
			<th>firstname</th>
			<th>lastname</th>
			<th>email</th>
			<?php if($user_level == 'admin'){?>
			<th>bypass</th>
			<th>edit</th>
			<th>delete</th>
			<?php }?>
		</tr>
		<?php foreach ($all_user->result() as $row) { ?>
			<?php if($row->status == 1){?>
            	<tr>
			<td><?php echo $row->firstname; ?></td>
			<td><?php echo $row->lastname; ?></td>
			<td><?php echo $row->email; ?></td>
			<?php if($user_level == 'admin'){?>
			<td><input type="submit" name="edit" value="Bypass"
				onClick="javascript:window.location='bypass?id=<?php echo $row->id; ?>';"></td>
			<td><input type="submit" name="edit" value="Edit"
				onClick="javascript:window.location='edit_user?id=<?php echo $row->id; ?>';"></td>
			<td><input type="submit" name="delete" value="Delete"
				onClick="javascript:window.location='delete_user_1?id=<?php echo $row->id; ?>';"></td>
				<?php }?>
		</tr>
			<?php }?>
		<?php }?>
	</table>
</div>