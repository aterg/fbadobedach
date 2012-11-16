<?php
include_once 'header.php';

$angebote_id = !empty($angebot) ? $angebot->angebote_id : null;
$angebote_name  = !empty($angebot) ? $angebot->angebote_name : null;
$angebote_price = !empty($angebot) ? $angebot->angebote_price : null;
$angebote_offer = !empty($angebot) ? $angebot->angebote_offer : null;
$angebote_start = !empty($angebot) ? $angebot->angebote_start : null;
$angebote_end = !empty($angebot) ? $angebot->angebote_end : null;

$price_euro = sprintf('%02d', 0);
$price_cent  = sprintf('%02d', 0);
if(!empty($angebote_price) ) {
	$tmp_price_euro = explode('.', $angebote_price);
	$price_euro = $tmp_price_euro[0];
	$price_cent = $tmp_price_euro[1];
}

$offer_euro = sprintf('%02d', 0);
$offer_cent  = sprintf('%02d', 0);
if(!empty($angebote_offer) ) {
	$tmp_offer_euro = explode('.', $angebote_offer);
	$offer_euro = $tmp_offer_euro[0];
	$offer_cent = $tmp_offer_euro[1];
}

?>
<h2>Angebot bearbeiten</h2>
<form action="<?php print site_url('admin/angebote/saveangebot');?>" method="post">
	<input type="hidden" name="angebote_id" value="<?php print $angebote_id;?>"/>
	<input type="hidden" name="userName" value="<?php print $_SESSION['userName']?>"/>
	<table border="0" width="400">
		<tr>
			<td>Angebot-Name</td>
			<td colspan="2">
				<input type="text" name="angebote_name" maxlength="255" value="<?php print $angebote_name;?>" style="width: 100%;"/>
			</td>
		</tr>
		<tr>
			<td>Original-Preis</td>
			<td>
				<input type="text" name="angebote_price_euro" maxlength="4" value="<?php print $price_euro;?>" size="4"/>&euro;
			</td>
			<td>
				<input type="text" name="angebote_price_cent" maxlength="2" value="<?php print $price_cent;?>" size="2"/>Cent
			</td>
		</tr>
		<tr>
			<td>Angebots-Preis</td>
			<td>
				<input type="text" name="angebote_offer_euro" maxlength="4" value="<?php print $offer_euro;?>" size="4"/>&euro;
			</td>
			<td>
				<input type="text" name="angebote_offer_cent" maxlength="2" value="<?php print $offer_cent;?>" size="2"/>Cent
			</td>
		</tr>
		<tr>
			<td>Gültig von:</td>
			<td colspan="2"><input value="<?php print $angebote_start;?>" id="datepicker1" type="text" name="angebote_start"/></td>
		</tr>
		<tr>
			<td>Gültig bis:</td>
			<td colspan="2"><input value="<?php print $angebote_end;?>" id="datepicker2" type="text" name="angebote_end"/></td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="submit" value="speichern"/>&nbsp;<input type="button" value="abbrechen" onclick="javascript:history.back();"/>
			</td>
		</tr>
	</table>
	<script type="text/javascript">
		$(function(){
			// prevent user input here
			$( "#datepicker1" ).keydown(function(){return false;});
			$( "#datepicker2" ).keydown(function(){return false;});
			
			<?php if(!empty($angebot)):?>
			$( "#datepicker1" ).datepicker({defaultDate:'<?php print $angebote_start;?>', dateFormat:'yy-mm-dd'});
			$( "#datepicker2" ).datepicker({defaultDate:'<?php print $angebote_end;?>', dateFormat:'yy-mm-dd'});
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
include_once 'footer.php';
?>