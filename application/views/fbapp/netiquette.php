<?php

include_once  dirname(SELF).'/facebook/facebook.php';

// configured in facebook: redirect this page from canvas to facebook page
if( !empty($_GET['redirect'])) {
	echo '<script type="text/javascript"> window.top.location.href="http://www.facebook.com/'.$app_fb_name.'?sk=app_'.$app_id.'";</script>';
	exit;
}

$app_id = '179254178871420';
$app_secret = 'ccf628f836f0fc2ec2e49c5668944f00';
$app_fb_name = 'AdobeEduDACH';

$facebook = new Facebook(array(
	'appId' => $app_id,
	'secret' => $app_secret,
	'cookie' => true,
	'oauth' => true
));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" style="overflow: hidden;">
<head>
  <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href='<?php print base_url("css/fbapp.css") ?>' />
</head>
<body>

<div id="wrapper">
  
  <p id="headlineNetiquette">Netiquette</p>

  <div id="nettiquetteText">
		<p>Liebe Kreative, wir freuen uns sehr, wenn ihr euch auf dieser Seite
			über Ideen und Visionen, neue Adobe Tools und weitere spannende
			Themen austauscht. Bitte achtet aber unbedingt auf den guten Ton:</p>
		<p><b>1. Geht fair miteinander um</b><br /> Für Beschimpfungen und Beleidigungen
			ist hier kein Platz. Konstruktive Kritik, wie Feedback zu neuer Adobe
			Software, wird gerne angenommen.</p>
		<p><b>2. Bleibt beim Thema </b><br />Bitte achtet darauf, dass sich eure Beiträge
			auf die entsprechenden Themen beziehen. Private Dinge, die nicht für
			die Öffentlichkeit bestimmt sind, solltet ihr außen vor lassen.</p>
		<p><b>3. Macht keine Schleichwerbung </b><br />Links, Werbung und themenfremde
			Inhalte werden von uns gelöscht.</p>
		<p>Vielen Dank für euer Verständnis! Wir freuen uns schon jetzt auf
			alle tollen Beiträge, die diese Fanpage bereichern werden. In diesem
			Sinne: Create now – everywhere.</p>
    <br />
		<p id="small" style="line-height: 12px;"><b>Disclaimer</b></p>
		<p id="small" style="line-height: 12px; width:680px;">Wir übernehmen keine Verantwortung und Haftung für die von Nutzern
			eingestellten Kommentare und Links. Die Beiträge der Nutzer wie
			Fotos, Videos oder Kommentare entsprechen nicht zwangsläufig der
			offiziellen Stellungnahme der Adobe Systems GmbH und werden vom uns nicht auf
			Vollständigkeit und Korrektheit überprüft.
		</p>
  </div>
  <span class="footerLinksNetiquette">
    <a target="_blank" href="http://www.adobe.com/de/aboutadobe/impressum.html">Impressum</a>
  </span>
  
</div>

<div id="fb-root"></div>
<script src="https://connect.facebook.net/de_DE/all.js"></script>
<script type="text/javascript">

var url = 'http://www.facebook.com/<?php print $app_fb_name;?>?sk=app_<?php print $app_id;?>';

$(document).ready(function() {
	FB.init({
		appId : '<?php print $app_id;?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml : true, // parse XFBML
		oauth: true // use OAuth2
	});

	window.fbAsyncInit = function() {
		FB.Canvas.setAutoGrow();
	};
      
	FB.Canvas.setAutoGrow();

	setTimeout("FB.Canvas.setAutoGrow()", 1000);
});

</script>
</body>

</html>