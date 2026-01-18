<?php

# get correct id for plugin
$thisfile=basename(__FILE__, ".php");
 
# register plugin
register_plugin(
	$thisfile, //Plugin id
	'PlayGIF', 	//Plugin name
	'1.0', 		//Plugin version
	'Team CE',  //Plugin author
	'https://www.getsimple-ce.ovh/', //author website
	'Play animated GIFs on hover or click.', //Plugin description
	'plugins', //page type - on which admin tab to display
	'PlayGIF_admin'  //main function (administration)
);
 
# add a link in the admin tab 'theme'
add_action('plugins-sidebar','createSideMenu',array($thisfile,'PlayGIF <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#FF4C4C" d="M6.25 8.047c0-1.93 2.093-3.132 3.76-2.16l6.777 3.954c1.653.964 1.653 3.354 0 4.319l-6.777 3.953c-1.667.972-3.76-.23-3.76-2.16zm3.004-.864a1 1 0 0 0-1.504.864v7.906a1 1 0 0 0 1.504.864l6.777-3.953a1 1 0 0 0 0-1.728z"/><path fill="#FF4C4C" d="M7.75 8.047a1 1 0 0 1 1.504-.864l6.777 3.953a1 1 0 0 1 0 1.728l-6.777 3.953a1 1 0 0 1-1.504-.864z" opacity="0.5"/></svg>'));
 
# activate filter 
add_action('theme-footer','PlayGIF_js'); 
 
function PlayGIF_admin() {
    global $SITEURL;
	global $USR;
	echo '
	<link rel="stylesheet" href="'.$SITEURL.'plugins/massiveAdmin/css/w3.css">
	<style>
		.donate {margin:20px 0; padding:15px; border:solid 1px #ddd; background:#fafafa; border-radius:5px; margin:0!important;}
		.donateButton {box-shadow: 0px 1px 0px 0px #fff6af; background:linear-gradient(to bottom, #ffec64 5%, #ffab23 100%); background-color:#ffec64; border-radius:8px; border:1px solid #ffaa22; display:inline-block; cursor:pointer; color:#333333; font-family:Arial; font-size:1.2em; font-weight:normal!important; padding:5px 10px; text-decoration:none!important; text-shadow:0px 1px 0px #ffee66; margin-left:20px;}
		.donateButton:hover {background:linear-gradient(to bottom, #ffab23 5%, #ffec64 100%); background-color:#ffab23;}
		.donateButton:active {position:relative; top:1px;}
		.tpl {padding:5px 8px; background-color:#eee; border:1px solid #ccc; border-radius:3px; }
		@media (min-width: 601px) {.w3-col.m6, .w3-half {width: 47%;}
		
	</style>
	
	<div class="w3-parent ">
		<header class="w3-container w3-border-bottom w3-margin-bottom">
		
			<h3>PlayGIF <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#FF4C4C" d="M6.25 8.047c0-1.93 2.093-3.132 3.76-2.16l6.777 3.954c1.653.964 1.653 3.354 0 4.319l-6.777 3.953c-1.667.972-3.76-.23-3.76-2.16zm3.004-.864a1 1 0 0 0-1.504.864v7.906a1 1 0 0 0 1.504.864l6.777-3.953a1 1 0 0 0 0-1.728z"/><path fill="#FF4C4C" d="M7.75 8.047a1 1 0 0 1 1.504-.864l6.777 3.953a1 1 0 0 1 0 1.728l-6.777 3.953a1 1 0 0 1-1.504-.864z" opacity="0.5"/></svg></h3>
			<p>Play animated GIFs on hover or click.</p>
			
		</header>
		<div class="w3-container w3-border-bottom w3-margin-bottom">
	
			<h4>Usage:</h4>
			<p>Add the following CSS class to your gif.</p>
			
			<div class="w3-row">
				<div class="w3-half">
					<p><b>Click to play class <span style="font-weight:400;font-size:.9em">(add to <u>img</u>)</span>:</b></p>
					<code class="cke">
						gif-click
					</code><br><br>
					
					<p><b>Optional frame classes :</b></p>
					<div class="w3-half">
						<p><img class="frame1black" src="https://picsum.photos/125?grayscale" alt="example"></p>
						<code class="cke">
							frame1red<br>
							frame1blue<br>
							frame1yellow<br>
							frame1green<br>
							frame1black
						</code>
					</div>
					<div class="w3-half">
						<p><img class="frame2black" src="https://picsum.photos/75?grayscale" alt="example"></p>
						<code class="cke">
							frame2red<br>
							frame2blue<br>
							frame2yellow<br>
							frame2green<br>
							frame2black
						</code>
					</div>
				</div>
				
				<div class="w3-half">
					<p><b>Hover to play class <span style="font-weight:400;font-size:.9em">(add to <u>img</u> or <u>parent</u>)</span>:</b></p>
					
					<code class="cke">
						gif-hover
					</code><br><br>
				</div>
			</div> 
			
			<hr>
			
			<h4 class="w3-margin-bottom">Examples:</h4>
			
			 <div class="w3-row w3-row-padding">
				<div class="w3-half w3-center w3-padding-16">
					<p class="tpl">&lt;img class="gif-click frame1blue"  src="pc-morph.gif"></p>
					<p><img class="gif-click frame1blue" src="' . $SITEURL . 'plugins/PlayGIF/images/pc-morph.gif" width="200"></p>
				</div>
				
				<div class="w3-half w3-center w3-padding-16">
					<p class="tpl">&lt;a class="gif-hover" href="tel:+123456789"><br>&lt;img src="phone-icon.gif"> +1 234 567 89<br>&lt;/a></p>
					<p><a class="gif-hover" style="text-decoration:none;" href="tel:+123456789"><img src="' . $SITEURL . 'plugins/PlayGIF/images/phone-icon.gif" width="32"> +1 234 567 89</a></p>
				</div>
			</div> 
			
		</div>
		
		<footer class="w3-padding-top-32 margin-bottom-none">
			<p class="donate">Is this plugin useful to you? Support a developer.
				<a href="https://getsimple-ce.ovh/donate" target="_blank" class="donateButton">
					<b>Buy Us A Coffee </b>
					<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-opacity="0" d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z"><animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.5s" values="0;1"></animate></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="48" stroke-dashoffset="48" d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="48;0"></animate></path><path stroke-dasharray="14" stroke-dashoffset="14" d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="14;0"></animate></path><mask id="lineMdCoffeeHalfEmptyFilledLoop0"><path stroke="#fff" d="M8 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M12 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M16 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4"><animateMotion calcMode="linear" dur="3s" path="M0 0v-8" repeatCount="indefinite"></animateMotion></path></mask><rect width="24" height="0" y="7" fill="currentColor" mask="url(#lineMdCoffeeHalfEmptyFilledLoop0)"><animate fill="freeze" attributeName="y" begin="0.8s" dur="0.6s" values="7;2"></animate><animate fill="freeze" attributeName="height" begin="0.8s" dur="0.6s" values="0;5"></animate></rect></g></svg>
				</a>
			</p>
		</footer>
		
	</div>
	
	<script src="' . $SITEURL . 'plugins/PlayGIF/js/play-gif.js"></script>
	';
}

function PlayGIF_js() {
	global $SITEURL;
	echo '
	<script src="' . $SITEURL . 'plugins/PlayGIF/js/play-gif.js"></script>
	';
}	
?>