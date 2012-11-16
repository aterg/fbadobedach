<?php

include_once  dirname(SELF).'/facebook/facebook.php';

$app_id = '277223742390945';
$app_secret = '8beb2aec667646f77409c6249ca5ead0';
$app_fb_name = 'AdobeEduDACH';
$app_url = 'http://www.facebook.com/'.$app_fb_name.'?sk=app_'.$app_id;

// configured in facebook: redirect this page from canvas to facebook page
if( !empty($_GET['redirect'])) {
	echo '<script type="text/javascript"> window.top.location.href="'.$app_url.'";</script>';
	exit;
}

$facebook = new Facebook(array(
	'appId' => $app_id,
	'secret' => $app_secret,
	'cookie' => true,
	'oauth' => true
));

$signed_request = $facebook->getSignedRequest();

$isFan = !empty($signed_request['page']['liked'])&&$signed_request['page']['liked']==true ? true : false;

//$isFan=true;




/*
error_reporting(E_ALL);
ini_set("display_errors", "On");
ini_set("display_startup_errors", "On");
*/


$agent = $_SERVER['HTTP_USER_AGENT']; 
$browserArray = array(
    //'Windows Mobile' => 'IEMobile',
    //'Android Mobile' => 'Android',
    //'iPhone Mobile' => 'iPhone',
    //'Firefox' => 'Firefox',
    'Google Chrome' => 'Chrome',
    //'Internet Explorer' => 'MSIE',
    'Opera' => 'Opera',
    'Safari' => 'Safari'
);
//if($browser == "Google Chrome"){ echo "-webkit-border-radius: 10px;" } /*etc*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" style="overflow: hidden;">
<head>
  <title>Adobe EDU Gamescom Info</title>
  <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href='<?php print base_url("css/fbapp.css") ?>' />
  
  <!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href='<?php print base_url("css/fbapp-ie7.css") ?>' />
  <![endif]-->
	
  <style type="text/css">
  
	 #wrapperGamescom {
	 	<?php 
	 	if($isFan==false){
	 		print '
	 				background-image:url("https://fbapphost.webguerillas.de/files/adobe_aktionen_framework/images/gamescom_nofan.jpg");
	 		 		height:388px;
	 		 	';
	 	}
	 	?>
	}
	
	#gamescomElementsUpper{
		position: absolute;
		top: 323px;
		left: 70px;
		width: 685px;
	}
	
	#gamescomVideo{
		margin:12px 0 18px 0;
	}
	
	#gamescomElementsLower{
		left: 70px;
	    position: absolute;
	    bottom: 92px;
	    width: 690px;
	     height: 75px;
	}
	
	#gamescomElementsLower p{
		position: absolute;
		top: 0;
		left: 0;
	}
	
	#gamescomElementsLower .button{
		position: absolute;
		bottom: 0;
		left: 0;
	}
	
	  h1,h2,h3,h4,.hide{
	  	text-indent:-1999px;
	  	height:0;
	  }
	  h5{
	  	font-size:12px;
	  	margin:5px 0;
	  }
	  p{
	  	margin:0;
	  	padding:0;
	  }

	  ul{
	  	padding:0;
	  	margin:0 0 0 13px;
	  	list-style-position:outside;
	  }
	  li{
	  	padding:0;
	  	margin:0;
	  }
	  strong{
	  	font-weight:800;
	  }
	  .spacer1{
	  	display:block;
	  	height:3px;
	  	width:100%;
	  }
	  .spacer2{
	  	display:block;
	  	height:6px;
	  	width:100%;
	  }
	  .button{
	  	width:200px;
	  	height:30px;
	  	text-transform:uppercase;
	  	color:#ffffff;
	  	font-weight:800;
	  	background: none;
    	border: none;
    	margin-top:12px;
	  }
		
	.like {
    	left: 0;
	}

	.footerLinksNetiquette a {
		left: 370px;
	    color: #ffffff;
	    font-size: 12px;
	}
	
	<?php 

	//foreach ($browserArray as $k => $v) {
	    if (preg_match("/Safari/", $agent)) {
	         print '
			#gamescomVideo{
				margin:12px 0 25px 0;
			}
	         ';
	    }  
	    if (preg_match("/Chrome/", $agent)) {
	         print '
			#gamescomVideo{
				margin:12px 0 20px 0;
			}
	         ';
	    }    
	//} 
	//$browser = $k;
	?>
  </style>
  
  <!--[if IE 7]>
  <style type="text/css">
  	#gamescomElementsUpper{
		top: 308px;
	}
	#gamescomVideo{
		margin:12px 0 7px 0;
	}
	#gamescomElementsLower{
		bottom: 92px;
	}
	ul{
  		margin-left:16px;
	}
	  
	.button{
    	margin-top:16px;
	}
  </style>
  <![endif]-->
</head>
<body>

<div id="wrapperGamescom">

	<?php if($isFan==false): ?>
	
	<h1>Adobe</h1>
	<h2>Adobe EDU auf der gamescom</h2>
	<h3>Klicke "Gefällt mir"</h3>
	
	<p class="hide">
		& entdecke, was dich auf dem weltweit größten Messe- und Event-Highlight für interaktive Spiele und Unterhaltung erwartet! 
		gamescom
	</p>
	
	<?php else: ?>
	
	<div id="gamescomElementsUpper">
		<h1>Adobe</h1>
		<h2>Adobe EDU auf der gamescom</h2>
		<h3>Wally Wallet goes gamescom</h3>
		
		<h4>Besuche uns auf der gamescom</h4>
		
		<h2>Deine Kreativität erreicht den nächsten Level!</h2>
		
		<p>
			Kreativität trifft Entertainment. Neben vielen bekannten Spieleherstellern und neuen Entertainment- und Gamingtrends 
			<br />
			kannst du dieses Jahr auf der gamescom auch mit Adobe Education spielerisch kreativ werden. Komm einfach zum 
			<br />
			Messestand und tauche ein in die Welt deiner Fantasie!
		</p>
		
		<h5>Das erwartet dich:</h5>
		<ul>
			<li>
				Gewinne in unserem Wally Wallet Spiel vor Ort tolle Preise, wie z.B. ein iPad 3 oder ein Samsung Galaxy Tab
			</li>
			<li>
				Steuere das Spiel auf einem 60 Zoll Screen allein mit deinen Füßen
			</li>
			<li>
				Sichere dir einen attraktiven Rabatt auf Adobe Produkte
			</li>
			<li>
				Alle Mitspieler können sich EXKLUSIV vor Ort einen attraktiven Zusatz-Rabatt von 20% auf einige Adobe EDU Produkte sichern
			</li>
		</ul>
			
		<iframe id="gamescomVideo" width="669" height="408" src="https://www.youtube.com/embed/VQT0NqvdTro" wmode="transparent" frameborder="0" allowfullscreen></iframe>
		
		<h2>Dein Weg zum Stand</h2>
		
		<p>
			Du findest uns täglich vom 15. - 19. August in Halle 9 der Entertainment Area! Komm einfach innerhalb der 
			<br/>
			Öffnungszeiten zum Stand <strong>A 040.</strong>
			<span class="spacer2"></span>
			<strong>Worauf wartest du noch?</strong> Komm vorbei, spiel und werde kreativ! Lade doch auch deine Freunde ein und besucht uns 
			<br />
			gemeinsam! Wir freuen uns auf dich!
		</p>
		
		<input class="button" type="button" value="Freunde einladen" onclick="inviteFriends();"/>
					
	</div>
	
	<div id="gamescomElementsLower">
		<h3>Löse das Geheimnis der 80%</h3>
		<h2>Wally Wallet wartet bereits auf dich</h2>
		<p>		
			Du schaffst es nicht zur gamescom oder willst für deinen großen Auftritt am 
			<br />
			Stand trainieren? Dann spiele jetzt die Online-Version von Wally Wallet.
		</p>
		<input class="button" type="button" value="Zum Spiel" onclick="window.top.location='https://www.facebook.com/AdobeEduDACH/app_471961336161265';"/>
	</div>
	<?php endif; ?>
	
	<span class="footerLinksNetiquette">
    	<a target="_blank" href="http://www.adobe.com/de/aboutadobe/impressum.html">Impressum</a>
  	</span>
</div>

<div class="footer">
  <div class="like">
  	<div class="fb-like" data-href="https://fbapphost.webguerillas.de/files/adobe_aktionen_framework/index.php/fbapp/gamescom/like" data-send="true" data-width="500" data-show-faces="false"></div>
  </div>  
</div>

<div id="fb-root"></div>
<script type="text/javascript" src="https://connect.facebook.net/de_DE/all.js"></script>
<script type="text/javascript">

var needs_permissions = false;

function inviteFriends(){
    FB.login(function(response){
        if( response.authResponse != "undefined" && response.authResponse != null) {
        	FB.ui({
				url:		'<?php print $app_url;?>',
                method: 	'apprequests',
                name:		'Adobe auf der gamescom',
                caption:    '&nbsp;',
                message: 	'Besuche mit mir Adobe auf der gamescom in Köln, beweise vom 15. - 19. August dein Können bei Wally Wallet & gewinne tolle Preise!'
                }, 
                function(res) {
                	// do nothing here
                }
             );
        	// if with name:
//            FB.api('/me', function(response){
//					FB.ui({
//						url:	 $app_url;?>',
//                        method: 'apprequests',
//                        message: response.name + ' hat gerade bei „5 Freunde für Monte“ mitgemacht. Mit etwas Glück gewinnt '+response.name+' Pizza-Gutscheine für einen DVD-Abend mit Freunden oder andere coole Preise. Mach auch mit! Vielleicht schauen wir ja schon bald gemeinsam DVD.'
//                        }, 
//                        function(res) {
//                        	// do nothing here
//                        }
//                     );
//                }
//            });
  		  }
    //exception must not be handled by default
//    else{
//        alert('your request couldn't be proceeded');
//    }
    });
}

$(document).ready(function() {
	FB.init({
		appId : '<?php print $app_id;?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml : true, // parse XFBML
		oauth: true // use OAuth2
	});

	FB.Canvas.setAutoGrow();

	FB.getLoginStatus(function(response){
    	if (response.status != 'connected') {
    		needs_permissions = true;
    	}
    });

	//fix z-index of iframe
	$('iframe').each(function(){
		var url = $(this).attr("src");
		$(this).attr("src",url+"?wmode=transparent");
	});
	
});

</script>
</body>

</html>