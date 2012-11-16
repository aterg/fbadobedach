<?php

include_once  dirname(SELF).'/facebook/facebook.php';

$app_id = '436071196433027';
$app_secret = '8f435b2570c451d4c70e7487617c1794';
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
  
  <!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href='<?php print base_url("css/fbapp-ie7.css") ?>' />
  <![endif]-->
	
  <style type="text/css">
  .paging {
  	position: absolute;
  	right: 5px;
  	top: 0;
  	height: 25px;
  	line-height: 25px;
  	z-index: 100;
  	color: #fff;
  }
  .paging a {
  	color: #fff;
  	text-decoration: none;
  	padding-left: 2px;padding-right:2px;
  }
  .slidecontainer {
  	width: 750px;
  	height: 185px;
  }
  .slidecontainer ul {
  	position: absolute;
  	left: 0;
  	top: 0;
  	z-index: 10;
  	list-style: none;
  	width: 749px;
  	height: 184px;
  	overflow: hidden;
  	margin: 0;
  	padding: 0;
  }
  .slidecontainer ul li {
  	float: left;
  	margin: 0;
  	padding: 0;
  	width: 750px;
  	height: 185px;
  }
  </style>
</head>
<body>

<div id="wrapperWelcome">

  <p id="welcomeInfo">
    Satte 80% Rabatt auf die Adobe Produkte.<br />
    Kreativwettbewerbe &amp; andere Aktionen mit coolen Preisen.<br />
    Eine austauschfreudige Community  &gt; <a href="http://www.facebook.com/AdobeEduDACH" target="_top"><b>Zur Pinnwand</b></a><br />
    Großartige Karrierechancen &gt; <a href="http://www.adobe.com/careers.html?sdid=JYLAE" target="_blank" ><b>Bewirb dich bei Adobe</b></a>
  </p>

<div id="aktionenElements">
<?php foreach($containers as $container):?>
	<div class="slidecontainer">
		<div class="paging">
		<?php 
		  if(count($container->elements) > 1){
  			for($i = 0; $i < count($container->elements); $i++) {
  				print '<a class="pagingLinks" onclick="changeLinkUnderline('. $i .');" href="javascript:void(0);" rel="'.$container->elements[$i]->aktionen_elements_id.'">'.($i+1).'</a>';
  			}
		  }
		?>
		</div>
		<ul id="ul<?php print $container->aktionen_container_id?>">
		<?php foreach($container->elements as $element):?>
			<li id="li<?php print $element->aktionen_elements_id;?>">
				<img src="<?php print base_url('files/'.$element->aktionen_elements_image);?>" />
				<a href="<?php print $element->aktionen_elements_url; ?>" target="_top" class="ulLinks"></a>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endforeach;?>
</div>
	<span class="footerLinksNetiquette">
    <a target="_blank" href="http://www.adobe.com/de/aboutadobe/impressum.html">Impressum</a>
  </span>  
</div>

<div class="footer">
  <div class="like">
  	<div class="fb-like" data-href="https://fbapphost.webguerillas.de/files/adobe_aktionen_framework/index.php/fbapp/welcome/like" data-send="true" data-width="500" data-show-faces="false"></div>
  </div>  
</div>

<div id="fb-root"></div>
<script src="https://connect.facebook.net/de_DE/all.js"></script>
<script type="text/javascript">

var url = 'http://www.facebook.com/<?php print $app_fb_name;?>?sk=app_<?php print $app_id;?>';
var timer = 0;
var slider = null;
var next = 1;


function changeLinkUnderline( index ){
	//find a Elements
	var aElements = $('.paging').find('a');
	$(aElements[index]).css('text-decoration','underline');

	$(aElements[index]).css('text-decoration','underline');

	if( index == 0 )
	{
		$(aElements[index+1]).css('text-decoration','none');
	}else{
		$(aElements[index-1]).css('text-decoration','none');
	}
}


function slideContainer() {
	var li_elements = $(slider).find('li');
	$(li_elements).hide();
	
	//find a Elements
	var aElements = $('.paging').find('a');

	if( next >= li_elements.length )
	{
		next = 0;
	}

	//get next li element
	var toShow = li_elements[next];	
	if( toShow ) 
	{
		$(toShow).fadeIn('slow');
		$(aElements[next]).css('text-decoration','underline');

		
		if( next == 0 )
		{
			$(aElements[next+1]).css('text-decoration','none');
		}else{
			$(aElements[next-1]).css('text-decoration','none');
		}
		
		next++;
	}
}

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

	var slideContainers = $('.slidecontainer');
	$(slideContainers).each(function(index, container){

		if( index == 0 ) {
			slider = container;
			timer = setInterval('slideContainer()',6000);
		}
		
		var pagings = $(slideContainers).find('a');
		$(pagings).each(function(i, link){
			$(link).click(function(){
				var id = $(this).attr('rel');
				var li = $('li#li'+id);
				$(li).parent().find('li').hide();
				clearInterval(timer);
				$('li#li'+id).fadeIn();
			});
		});
	});

	var aElements = $('.paging').find('a');
	$(aElements[next-1]).css('text-decoration', 'underline');
	
	//setTimeout("FB.Canvas.setAutoGrow()", 1000);
	setTimeout("slideContainer()", 1000);
});

</script>
</body>

</html>