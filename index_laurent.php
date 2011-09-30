<!doctype html>
<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
        <script src="galleria-1.2.5.js"></script>
    </head>
    <body>

- <?php
$dirs = glob("images/" . "*/", GLOB_BRACE);
 
foreach($dirs as $dir){
 preg_match('/images\/(.*)\//',$dir, $matches);
$dirname = $matches[1];
echo '<a href="?dir='.$dirname.'" >'.$dirname.'</a> - ';

}



if( isset($_GET['dir'])){
$dir = $_GET['dir'];
$directory = "images/$dir/";




//get all image files with a .jpg extension.
$images = glob($directory . "{*.gif,*.jpg,*.png,*.JPG}", GLOB_BRACE);

?>
        <div id="gallery" style="height:800px; width:1024px">
<?php

//print each file name
foreach($images as $image)
{
echo '<img src="'.$image.'" title="'.$image.'">'."\n";
}

?>
        </div>
        <script>

            Galleria.loadTheme('themes/classic/galleria.classic.min.js');
            $("#gallery").galleria({
                		
            });
        </script>
    <?php

}

?>


</body>
</html>
