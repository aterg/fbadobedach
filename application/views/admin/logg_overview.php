<?php
include_once 'header.php';
?>
<h2>Übersicht: Logs</h2>

<table class="datatable" cellspacing="0" cellpadding="3">
  <tr>
    <td align="left">User</td>
    <td align="left">Aktion</td>
    <td align="left">Datum</td>
  </tr>
<?php foreach($loggs as $log) : ?>
  <tr>
    <td><p><?php print $log->user;?></p></td>
		<td><p><?php print $log->action;?></p></td>
		<td><p><?php print $log->time;?></p></td>
  </tr>
<?php endforeach;?>
</table>

<?php include_once 'footer.php';?>
