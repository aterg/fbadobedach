<?php
include_once 'header.php';
?>
<h2>Aktionsgruppe bearbeiten</h2>
<p><input type="text" id="aktionen_name" value="<?php print $container->aktionen_container_name?>"/>&nbsp;<input type="button" value="speichern" onclick="aktionenSave();"/></p>
<p id="messagebox" style="display: none;">Der Inhalt wurde gespeichert</p>
<a class="addbutton" href="<?php print site_url('admin/aktionen/createelement/'.$container->aktionen_container_id);?>">Aktion hinzufügen</a>
<div id="aktionen_sort">
<?php foreach($container->elements as $element) : ?>
	<div class="aktionen_container" data="<?php print $element->aktionen_elements_id;?>">
		<div class="actionbar">
			<span class="buttons">
				<a href="<?php print site_url('admin/aktionen/editelement/'.$element->aktionen_elements_id);?>">
					<img border="0" src="<?php print base_url('images/edit.png');?>"/>
				</a>
				<a onclick="return confirmDelete();" href="<?php print site_url('admin/aktionen/deleteelement/'.$element->aktionen_elements_id);?>">
					<img border="0" src="<?php print base_url('images/trash.gif');?>"/>
				</a>
			</span>
			<span class="checkbox">Aktiv: <input type="checkbox"<?php print $element->aktionen_elements_active == 1? 'checked="checked"':null;?> value="<?php print $element->aktionen_elements_id;?>" onclick="toggleActive(this);"/>&nbsp;</span>
			<div class="clearfix"></div>
		</div>
		<img src="<?php print base_url('files/'.$element->aktionen_elements_image);?>" width="749" height="184"/>
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
						  "<?php print site_url("admin/aktionen/sortElements")?>",
						  {order:data, userName:userName},
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
	
	function fadeoutMessage() {
		$('#messagebox').fadeOut();
	}

	function aktionenSave() {
		var value = $('#aktionen_name').val();
		if( value != "" ) {

			postdata = {
				container_fid:<?php print $container->aktionen_container_id;?>,
				container_name:value
			};
			
			$.post(
				'<?php print site_url('admin/aktionen/saveaktion');?>',
				{data:postdata, userName:userName},
				function(response) {
					$('#messagebox').fadeIn(350, function(){
						setTimeout('fadeoutMessage()', 3000);
					});
				},
				'json'
			);
		}
	}

	function toggleActive(checkBox){
		var checked = $(checkBox).attr('checked') ? 1 : 0;
		
		$.post(
				"<?php print site_url("admin/aktionen/toggleelement")?>", 
				{'checked':checked, elementid:$(checkBox).val(), userName:userName}, 
				'json'
		);
	}

	function confirmDelete(){
		var action = confirm('Aktion wirklich löschen?');
		return action;
	}
</script>
<?php include_once 'footer.php';?>