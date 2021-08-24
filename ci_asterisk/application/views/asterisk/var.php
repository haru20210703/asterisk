<div class="container">
	<table class="table">
		<tr class="text-center">
		<th style="width:5%">ID
		</th>
		<th style="width:20%">日時
		</th>
		<th style="width:65%">内容
		</th>
		<th style="width:10%">対応者
		</th>
		</tr>
		<?php foreach($sys_data as $value): ?>
		<tr>
		<?php foreach($value as $row): ?>
		<td><?php echo $row; ?>
		</td>
		<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
			
