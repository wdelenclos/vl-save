<html lang="fr-FR" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="UTF-8" />
<title>Ecoutez Radio VL</title>
<link rel="icon" type="image/vnd.microsoft.icon" href="http://www.radiovl.fr/wp-content/uploads/2013/09/favicon.png">
<meta name="description" content="Player Radio VL"/>
<link rel="canonical" href="http://www.player.radiovl.fr/" />
<link rel="publisher" href="https://plus.google.com/107908573195095516208"/>
<meta property="og:locale" content="fr_FR" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Ecoutez Radio VL" />
<meta property="og:description" content="Player de Radio VL - Premier media jeune de France" />
<meta property="og:url" content="http://www.player.radiovl.fr/" />
<meta property="og:site_name" content="Radio VL" />
<meta property="og:image" content="http://www.radiovl.fr/wp-content/themes/primetime/images/radiovl.jpg" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="skin/radiovl/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="js/jquery.responsiveTabs.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var stream = {
		title: "RVL",
		mp3: "http://sv3.vestaradio.com:6160/;stream/1"
	},
	ready = false;
	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			ready = true;
			$(this).jPlayer("setMedia", stream).jPlayer("play");
		},
		pause: function() {
			$(this).jPlayer("clearMedia");
		},
		error: function(event) {
			if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
				$(this).jPlayer("setMedia", stream).jPlayer("play");
			}
		},
		swfPath: "js",
		supplied: "mp3",
		preload: "none",
		wmode: "window",
		keyEnabled: true,
		autoPlay: true 
	});
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').responsiveTabs({
            startCollapsed: 'accordion',
            collapsible: 'accordion',
            rotate: false,
            setHash: true,
            animation: 'slide'
        });
    });
</script>
</head>
<body>
 <div class="nowplaying"><span>Radio VL en direct de la F&ecirc;te de la musique</span></div> 
<div id="page">
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio-stream">
	<div class="jp-type-single">
		<div class="jp-gui jp-interface">
			<ul class="jp-controls">
				<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
				<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
				<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
				<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
				<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
			</ul>
		<div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div>
		</div>
		<div class="jp-no-solution">
		<span>Update Required</span>
		To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>

<div id="horizontalTab">
<ul>
<li><a href="#tab-1">LIVE</a></li>
<li><a href="#tab-2">Twitter</a></li>
<li><a href="#tab-3">Facebook</a></li>
<li><a href="#tab-4">Iphone</a></li>
<li><a href="#tab-5">Chat</a></li>
<li><a href="#tab-6">Derni&egrave;res &eacute;missions</a></li>
</ul>
<div id="tab-1" align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/GyBaMqT9auM?rel=0&amp;controls=0&autoplay=1&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
<div id="tab-2" align="center">
<a class="twitter-timeline"  href="https://twitter.com/hashtag/FDLMRadioVL" data-widget-id="612220418158657536">Tweets sur #FDLMRadioVL</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
<div id="tab-3" align="center">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=1388993848034259";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div align="center" class="fb-like-box" data-href="http://www.facebook.com/RadioVL" data-width="580" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="false"></div>
</div>
<div id="tab-4" align="center">
<a href="https://itunes.apple.com/fr/app/radiovl/id698128079" target="_blank"><img src="images/iphone.jpg"></a>
</div>
<div id="tab-5" align="center">
<object width="580" height="350" id="lschat" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="http://cdn.livestream.com/chat/LivestreamChat.swf?&showTimestamp=true&channel=radiovltv"></param><param name="allowScriptAccess" value="always"></param><param name="allowFullScreen" value="true"></param><embed src="http://cdn.livestream.com/chat/LivestreamChat.swf?&showTimestamp=true&channel=radiovltv" name="lschat" width="580" height="350" allowScriptAccess="always" allowFullScreen="true" type="application/x-shockwave-flash" bgcolor="#ffffff"></embed></object>
</div>
<div class="rss" id="tab-6">
<div align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- RVL3 Player Emissions -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-6218890829807622"
     data-ad-slot="9059600725"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
    <?php
    try{
        if(!@$fluxrss=simplexml_load_file('http://www.radiovl.fr/categories/emissions/feed/')){
            throw new Exception('Flux introuvable');
        }
        if(empty($fluxrss->channel->title) || empty($fluxrss->channel->description) || empty($fluxrss->channel->item->title))
            throw new Exception('Flux invalide');
 
        $i = 0;
        $nb_affichage = 10;
        echo '<ul>';
        foreach($fluxrss->channel->item as $item){
            echo '<li>&raquo; <a href="'.(string)$item->link.'">'.(string)$item->title.'</a></li>';
            if(++$i>=$nb_affichage)
                break;
        }
        echo '</ul>';
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
 
?>
</div>
</div>
</div>
</body>
</html>