<?php

include_once  dirname(SELF).'/facebook/facebook.php';

$app_id = '486927037999444';
$app_secret = '25907c941f989bb7ec887911f9687037';
$app_fb_name = 'AdobeEduDACH';

// configured in facebook: redirect this page from canvas to facebook page
if( !empty($_GET['redirect'])) {
	echo '<script type="text/javascript"> window.top.location.href="http://www.facebook.com/'.$app_fb_name.'?sk=app_'.$app_id.'";</script>';
	exit;
}

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

<div id="wrapperDiscount">

    <p id="headlineOne">80% Rabatt auf die Adobe Produkte</p>
		
		<p id="discountInfoOne">Die Adobe Software gibt dir das Werkzeug, um deine ganz persönlichen
			Ideen zu verwirklichen. Und das zu einem genialen Preis.</p>

		<p id="discountInfoTwo">Wenn du Schüler, Student oder Lehrkraft bist, bekommst du eine
			Vielzahl bekannter Adobe Produkte in der Student &amp; Teacher Edition
			bis zu 80% günstiger.</p>
			
    <p id="originalPrice"></p>
    <p id="discountPrice"></p>
    <p id="originalLabel">Original-Preis</p>
    <p id="discountLabel"><b>Spar-Preis</b></p>

		<p id="discountInfoThree">
			<b>Achtung:</b><br /> Auf der Pinnwand kündigen wir manchmal
			Extra-Vergünstigungen an, die der Rechner leider nicht
			berücksichtigen kann. Die dargestellten Preise sind die des Adobe EDU
			Stores Deutschland, alle Preise ohne Gewähr - diese können sich
			tagesaktuell ändern und sind im Adobe EDU Store zu finden.
		</p>

		<p id="headlineTwo">Du willst dir den 80% Rabatt sichern? So geht’s:</p>
		
		<div id="shopLink"></div>
		
		<div class="discountDropdown">
		<input type="text" name="test" value="Wähle ein Produkt" class="field" readonly="readonly" onclick="showList();"/>
		<ul class="list">
		<?php 

    if(!empty($angebote)){
      $index = 0;
      foreach($angebote as $angebot){        
        if($angebot != '')
          echo '<li onclick="selectMe(' . $index . ');">' . $angebot->angebote_name . '</li>';
        
        $index++;
      }
    }  
      
    ?>		
		</ul>
		</div>
		
		<div id="infoHowto">
			<p>
				<b>Besuche den Adobe Shop…</b><br /> für <a href="http://store2.adobe.com/cfusion/store/html/index.cfm?store=OLS-EDU-DE&event=displayEduConditions&nr=0&sdid=JYLAB" target="_blank"><b>Deutschland</b></a> oder für
				<a href="https://store2.adobe.com/cfusion/store/html/index.cfm?store=OLS-EDU-EU&event=displayEduConditions&sdid=JYLAC" target="_blank"><b>Österreich und die Schweiz</b></a>.
			</p>

			<p>
				<b>Wähle das Produkt, das du kaufen möchtest…</b><br /> und lege ein
				Adobe Konto an, um die Bestellung durchzuführen.
			</p>

			<p>
				<b>Lade einen <a href="http://store.adobe.com/store/de_edu/academic_id.html?sdid=JYLAD&#idforms" target="_blank">Nachweis</a> hoch…</b><br /> der belegt, dass du Schüler,
				Student oder Lehrkraft bist und schließe die Bestellung damit ab.
			</p>

			<p>
				<b>Installiere die Testversion des Produkts…</b><br /> oder warte
				auf dein Installationsmedium. Aktiviere es mit der Seriennummer, die
				wir dir zuschicken.
			</p>
		</div>

		<span class="footerLinksNetiquette">
    <a target="_blank" href="http://www.adobe.com/de/aboutadobe/impressum.html">Impressum</a>
  </span>
  
</div>

<div class="footer">
  <div class="like">
  	<div class="fb-like" data-href="https://fbapphost.webguerillas.de/files/adobe_aktionen_framework/index.php/fbapp/discount/like" data-send="true" data-width="500" data-show-faces="false"></div>
  </div>  
</div>

<div id="overlay" style="display:none;">
  <div id="closeOverlay"></div>
  <p>80% Rabatt auf die adobe produkte</p>
  <a onclick="closeMe();" href="http://store2.adobe.com/cfusion/store/html/index.cfm?store=OLS-EDU-DE&event=displayEduConditions&nr=0&sdid=JYLAB" target="_blank" id="shopGermany">&gt; <b>Zum deutschen Shop</b></a>
  <a onclick="closeMe();" href="https://store2.adobe.com/cfusion/store/html/index.cfm?store=OLS-EDU-EU&event=displayEduConditions&sdid=JYLAC" target="_blank" id="shopOther">&gt; <b>Zum Shop für Österreich und die Schweiz</b></a>
</div>

<div id="fb-root"></div>
<script src="https://connect.facebook.net/de_DE/all.js"></script>
<script type="text/javascript">

var data = new Array();

<?php 

if(!empty($angebote)){
  
  echo 'var index = 0;';
  foreach($angebote as $angebot){
    echo 'data[index] = new Array;';
    echo 'data[index][0] = ' . $angebot->angebote_price . ';';
    echo 'data[index][1] = "' . $angebot->angebote_name . '";';
    echo 'data[index][2] = ' . $angebot->angebote_offer . ';';
    echo 'data[index][3] = ' . $angebot->angebote_id . ';';
    echo 'index++;';
  }
}  
  
?>

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

$('#shopLink').click(
  function(){
  	$('#overlay').css('display','block');
  }
);

$('#closeOverlay').click(
  function(){
	  	$('#overlay').css('display','none');
	  }
);

function closeMe(){
	  $('#overlay').css('display','none');
}


var toggleList = true;
function showList(){
	if(toggleList == true){
  	$('.list').css('display','block');
  	toggleList = false;
	}else{
  	$('.list').css('display','none');
  	toggleList = true;
	}
}

 
function selectMe(test){
	var value = data[test];

	$('.field').val( value[1] );
  $('#originalPrice').text(value[0] + ' €');
  $('#discountPrice').text(value[2] + ' €');
	$('.list').css( 'display' , 'none' );

	toggleList = true;
}

</script>
</body>

</html>