<?php 
if(empty($_SESSION['userName']))
  redirect(site_url('admin/login'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Adobe Education - Backend</title>
	<link type="text/css" rel="stylesheet" href="<?php print base_url('css/default.css');?>"/>
	<link type="text/css" rel="stylesheet" href="<?php print base_url('css/jquery-ui-1.8.21.custom.css');?>"/>
	<link rel="shortcut icon" type="image/x-icon" href="<?php print base_url('favicon.ico');?>" />
	<script type="text/javascript" src="<?php print base_url('js/jquery-1.7.min.js');?>"></script>
	<script type="text/javascript" src="<?php print base_url('js/jquery-ui.min.js');?>"></script>
</head>
<body>
<script type="text/javascript">

<?php print 'var userName = "' . $_SESSION['userName'] . '";'; ?>

</script>
<div id="wrapper">
	<div id="navigation">
		<?php include_once 'navigation.php';?>
	</div>
	<div id="pagecontent">
