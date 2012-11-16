<?php
include_once 'header.php';

function getActive($state) {
	return $state == 1 ? 'checked="checked"' : null;
}

?>
<h2>Angebote</h2>
<p>
	<a class="addbutton" href="<?php print site_url('admin/angebote/editangebot');?>">Angebot hinzufügen</a>
</p>
<?php if(!empty($angebote)):?>
<table class="datatable" cellspacing="0" cellpadding="3">
	<tr>
		<th align="left">Name</th>
		<th align="right" width="100">Original-Preis</th>
		<th align="right" width="100">Angebots-Preis</th>
		<th align="center" width="50">Aktiv</th>
		<th width="25">&nbsp;</th>
		<th width="25">&nbsp;</th>
	</tr>
	<?php foreach($angebote as $angebot):?>
		<tr>
			<td><?php print $angebot->angebote_name;?></td>
			<td align="right"><?php print $angebot->angebote_price;?>&euro;</td>
			<td align="right"><?php print $angebot->angebote_offer;?>&euro;</td>
			<td align="center"><input value="<?php print $angebot->angebote_id;?>" type="checkbox" onclick="toggleActive(this)" <?php print getActive($angebot->angebote_active);?>/></td>
			<td align="center"><a href="<?php print site_url('admin/angebote/editangebot/'.$angebot->angebote_id);?>"><img src="<?php print base_url('images/edit.png');?>"/></a></td>
			<td align="center"><a onclick="return confirmDelete();" href="<?php print site_url('admin/angebote/deleteangebot/'.$angebot->angebote_id);?>"><img src="<?php print base_url('images/trash.gif');?>"/></a></td>
		</tr>
	<?php endforeach;?>
</table>
<script type="text/javascript">
function toggleActive(checkBox){
	var checked = $(checkBox).attr('checked') == 'checked' ?1:0;
	
	$.post(
			"<?php print site_url("admin/angebote/toogleangebot")?>", 
			{checked:checked, angebote_id:$(checkBox).val(), userName:userName}, 
			'json'
	);
}
function confirmDelete(){
	var action = confirm('Dieses Angebot wirklich löschen?');
	return action;
}
</script>
<?php else:?>
<p><em>Es sind noch keine Angebote eingestellt.</em></p>
<?php endif;?>
<?php 
include_once 'footer.php';
?>