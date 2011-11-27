<?php
	require('lister.php');
	
	$subdir = get_folder(); // get only subdirectory
	$dir = ($subdir=='')?'photos':'photos/'.$subdir; // full path - check if there's subdir to avoid ending /

	// scan folder
	$list = lister($dir);
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>EasyGallery</title>
	<link type="text/css" href="style.css" rel="stylesheet" />
	<!-- jQuery -->
	<script type="text/javascript" src="lib/jquery-1.6.4.min.js"></script>
	<!-- Galleria (jQuery plugin) -->
	<script type="text/javascript" src="galleria/galleria-1.2.5.min.js"></script>
	<script type="text/javascript" src="galleria/themes/classic/galleria.classic.min.js"></script>
	<script type="text/javascript" src="galleria/plugins/history/galleria.history.min.js"></script>
	<!-- custom script -->
	<script type="text/javascript" src="easygallery.js"></script>	
</head>
<body>
	<div class="main" id="main">
		<div class="header"><h2>EasyGallery</h2></div>
		<div class="path"><?php show_path('photos', $subdir); ?></div>
		<div id="fullscreen">Passer en mode plein &eacute;cran</div>
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
		<?php 
			if (sizeof($list['folder']) != 0):
		?>
			<div class="gallery_list">
				<h3>Sous-galeries</h3>
				<?php
					// show link to images
					foreach ($list['folder'] as $fol)
					{
						// test to avoid one more slash	
						$path = ($subdir=='')?$fol:$subdir.'/'.$fol;
						
						$html = '<a href="?gallery='.gallery_link($path).'" title="'.$fol.'">'; // url encode, be prudent
						$html .= '<div class="thumb" style="background-image: url(\''.$dir.'/'.$fol.'/'.get_thumbnail($dir.'/'.$fol).'\');"';
						$html .= '><div class="text">'.$fol.'</div></div></a>';
						
						echo $html;
					}
				?>
				<br clear="all" /><!-- the famous infamous trick -->
			</div>
		<?php 
			endif;
		?>
	<div class="footer">
		<?php 
			// display the comment only if there's a gallery
			if (sizeof($list['picture']) != 0):
		?>
			<span class="white">Appuyer sur la touche "Entr&eacute;e" du clavier pour d&eacute;marrer le diaporama, "Esc" pour le quitter.</span><br />
		<?php 
			endif;
		?>
		EasyGallery, 2011, <a href="http://github.com/romaricdrigon/" target="_blank">http://github.com/romaricdrigon/</a>
	</div>
	</div> <!-- end main -->
	<!-- finally, we load galleria -->
	<script>
		$('#gallery').galleria({
		    //data_source: data,
		    height: 700,
		    width: 960,
		    debug: false,
		    // we use a custom source, because img will all load on startup it's crappy, and json maybe not work if javascript is disabled
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