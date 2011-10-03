<?php
	require('lister.php');
	
	// first, scan current folder
	$dir = 'photos';
	$list = lister($dir);
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>EasyGallery</title>
	<link type="text/css" href="style.css" rel="stylesheet" />
	<script type="text/javascript" src="lib/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="galleria/galleria-1.2.5.min.js"></script>
	<script type="text/javascript" src="galleria/themes/classic/galleria.classic.min.js"></script>
	<script type="text/javascript" src="galleria/plugins/history/galleria.history.min.js"></script>
</head>
<body>
	<div class="main">
		<div class="header"><h2>EasyGallery</h2></div>
		<div class="gallery" id="gallery">
			<!-- link to images - will be displayed if Javascript is disabled -->
			<?php
				// show link to images
				foreach ($list['picture'] as $pic)
				{
					echo '<a href="'.$dir.'/'.$pic.'">'.$pic.'</a><br />';
				}
			?>
		</div>
		<div class="gallery_list">
			<h3>Galeries</h3>
			<?php
				// show link to images
				foreach ($list['folder'] as $fol)
				{
					$html = '<a href="?gal='.$fol.'" title="'.$fol.'">';
					$html .= '<div class="thumb" style="background-image: url('.$dir.'/'.$fol.'/'.get_thumbnail($dir.'/'.$fol).');"';
					$html .= '><div class="text">'.$fol.'</div></div></a>';
					
					echo $html;
				}
			?>
			<br clear="all" /><!-- the famous infamous trick -->
		</div>
	<div class="footer"></div>
	</div> <!-- end main -->
	<!-- finally, we load galleria -->
	<script>
		$('#gallery').galleria({
		    //data_source: data,
		    height: 700,
		    width: 960,
		    debug: false,
		    // we use a custom source, because img will all load o nstartup it's crappy, and json maybe not work if javascript is disabled
		    dataSelector: "a",
		    dataConfig: function(a) {
		        return {
		            image: $(a).attr('href') // tell Galleria that the href is the main image,
					// we have no title and so on at the moment
		        };
		    }
		});
	</script>
</body>
</html>