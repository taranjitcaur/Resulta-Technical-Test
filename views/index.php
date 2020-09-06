<table id="example" class="table table-striped table-bordered">
	<thead>
		<tr>
		<?php foreach($columns as $key => $value) { ?>
			<th><?php echo ucfirst($value); ?></th>
		<?php }  ?>
		</tr>
	</thead>
	<tbody> 
		<tr>
		<?php
		$count = 0;	
		foreach($data as $key => $value) { 
			foreach($value as $key1 => $value1) { 
			$count = $count + 1;
			?>
			<td><?php echo $value1; ?>
			</td>
		<?php } 
			if ($count % 6 == 0) {
				echo '</tr>';				
			}			
		} ?>	
				   
	</tbody>
	<tfoot>
		<tr>
		<?php foreach($columns as $key => $value) { ?>
			<th><?php echo ucfirst($value); ?></th>
		<?php }  ?>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
