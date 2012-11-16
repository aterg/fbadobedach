<?php
include_once 'header.php';
?>
<h2>Übersicht: Aktionsgruppen</h2>

<a class="addbutton" href="<?php print site_url('admin/aktionen/addaktion')?>">Aktionsgruppe hinzufügen</a>

<div id="aktionen_sort">
<?php foreach($containers as $container) : ?>
	<div class="aktionen_container" data="<?php print $container->aktionen_container_id;?>">
		<div class="actionbar">
			<span><?php print $container->aktionen_container_name;?></span>
			<span class="buttons">
				<a href="<?php print site_url('admin/aktionen/editaktion/'.$container->aktionen_container_id);?>">
					<img border="0" src="<?php print base_url('images/edit.png');?>"/>
				</a>
				<a onclick="return confirmDelete();" href="<?php print site_url('admin/aktionen/deleteaktion/'.$container->aktionen_container_id);?>">
					<img border="0" src="<?php print base_url('images/trash.gif');?>"/>
				</a>
			</span>
			<span class="checkbox">Aktiv: <input type="checkbox"<?php print $container->aktionen_container_activ == 1? 'checked="checked"':null;?> value="<?php print $container->aktionen_container_id;?>" onclick="toggleActive(this);"/>&nbsp;</span>
			<div class="clearfix"></div>
		</div>
		<?php if(!empty($container->elements[0])):?>
		<img src="<?php print base_url('files/'.$container->elements[0]->aktionen_elements_image);?>" width="750" height="185"/>
		<?php endif;?>
	</div>
<?php endforeach;?>
</div>
<script>
	$(function() {
		$( "#aktionen_sort" ).sortable({
			placeholder: "aktionen_container placeholder",
			cursor: "move",
			tolerance: 'pointer',
			containment: 'parent',
			update: 
				function(event, ui) {
				  var data = readContainers();
				  $.post(
						  "<?php print site_url("admin/aktionen/sortAktionen")?>",
						  {order:data},
						  'json'
					);
			  }
		});
		
		$( "#sortable" ).disableSelection();

		$('.aktionen_container').hover(
			function() {
				$(this).addClass('hover');
			},
			function() {
				$(this).removeClass('hover');
			}
		);

	});

function readContainers(){
	var data = new Array();
	var containers = $('.aktionen_container')

	$(containers).each(
			  function(index, element){
				  var ar = new Object();
				  ar.container_id = $(element).attr('data');
				  data.push(ar);
				}
	);
	return data;
}
	
function toggleActive(checkBox){
	var checked = $(checkBox).attr('checked') ? 1 : 0;
	
	$.post(
			"<?php print site_url("admin/aktionen/toggleaktion")?>", 
			{'checked':checked, containerid:$(checkBox).val() , userName:userName}, 
			'json'
	);
}

function confirmDelete(){
	var action = confirm('Aktionsgruppe wirklich löschen?');
	return action;
}
	
	
</script>
<?php 
include_once 'footer.php'
;?>