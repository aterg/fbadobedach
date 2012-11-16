<?php
include_once 'header.php';
$element_url = !empty($element) ? $element->aktionen_elements_url : null;
$element_image = !empty($element) ? base_url('files/'.$element->aktionen_elements_image) : null;
$title = empty($element) ? "hinzufügen" : "bearbeiten";
$container = empty($container) ? $element->aktionen_elements_containers_fid : $container;
$aktionen_start = !empty($element) ? $element->aktionen_elements_start : null;
$aktionen_end = !empty($element) ? $element->aktionen_elements_end : null;
?>
<h2>Element <?php print $title;?></h2>
<form action="<?php print site_url('admin/aktionen/saveelement');?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="container_fid" value="<?php print $container;?>"/>
	<input type="hidden" name="element_id" value="<?php print empty($element) ? null : $element->aktionen_elements_id;?>"/>
	<table>
		<tr>
			<td valign="top">Bild</td>
			<td>
				<?php if( !empty($element_image) ) : ?>
				<img src="<?php print $element_image?>"/><br/>
				<?php endif;?>
				<input type="file" name="element_image"/>
			</td>
		</tr>
		<tr>
			<td>Button-URL</td>
			<td><input type="text" name="element_url" value="<?php print !empty($element_url) ? $element_url : null;?>"/></td>
		</tr>
		<tr>
			<td>Gültig von:</td>
			<td><input value='<?php $date_start = explode(' ' , $aktionen_start); echo $date_start[0];?>' id="datepicker1" type="text" name="aktionen_start"/></td>
		</tr>
		<tr>
			<td>Gültig bis:</td>
			<td><input value='<?php $date_end = explode(' ', $aktionen_end); echo $date_end[0];?>' id="datepicker2" type="text" name="aktionen_end"/></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="speichern"/>&nbsp;<input type="button" onclick="history.back();" value="abbrechen"/>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		$(function(){
			// prevent user input here
			$( "#datepicker1" ).keydown(function(){return false;});
			$( "#datepicker2" ).keydown(function(){return false;});
			
			<?php if(!empty($element)):?>
			$( "#datepicker1" ).datepicker({defaultDate:'<?php $date_start = explode(' ' , $aktionen_start); echo $date_start[0];?>', dateFormat:'yy-mm-dd'});
			$( "#datepicker2" ).datepicker({defaultDate:'<?php $date_end = explode(' ', $aktionen_end); echo $date_end[0];?>', dateFormat:'yy-mm-dd'});
			<?php else:?>
			$( "#datepicker1" ).datepicker();
			$( "#datepicker2" ).datepicker();
			$( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd");
			$( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd");
			<?php endif;?>
		});
	</script>
</form>
<?php 
include_once('footer.php');
?>