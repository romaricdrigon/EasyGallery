# EasyGallery

## How it works?

You just copy this app's files on a server with PHP enabled. In a subfolder called ```/photos/```, you can put files & sub-folders.  
Sub-folders are galleries, pictures will be listed and displayed nicely using [Galleria](http://galleria.io/)  
You can have an unlimited number of (imbricated) galleries, so you can keep things organized.

It's best not to use big pictures files (< 0.5 mb), as thumbnails are resized on the fly, it's both useless (they're displayed as 960px wide) and may slow down the application.

If the visitor does not have Javascript enabled (really?), he will just see a list of thumbnail-sized pictures (with a link to the bigger version), and he will be able to navigate through galleries anyway.

## Installation

Put the app files in a web-enabled directory.  
Put pictures & sub-folders in ```/photos/```  

A few restrictions apply on folders name:
 * accents are supported, everything will be served as UTF-8
 * spaces are correctly handled
 * some HTML special chars are forbidden: ```<```, ```>```, ```&``` and ```"```
 * single quotes, ```'``` are allowed
 * two dots ```..``` are forbidden (it means upper directory!)

Empty folders (no file at all and no subfolders) will not be displayed.

## Examples / Demo

You can see it in action [here](http://romaricdrigon.fr/easy-gallery/)  
It's also used at the moment to power [theses galleries](http://photos.24heures.org/)

## Localization

Set ```$lang``` variable, at the top of ```index.php``` to either English, ```en```, or French, ```fr```  
If you want to create your own, translation are very simple PHP files (4 strings to translate!) under ```/lang```

## Thumbnails

You may consider adding thumbs pictures, so the page will load way faster (because Galleria fetches only the small pictures, and not the full ones) and the UX will be smoother.
Make 60px-big picture, add ```_thumb``` suffix in their names (before the extension ; it may be changed, see [config](#options)).

You can disable thumbs check: it will not look for thumbs, which may you save a little time in huge collections, but pages may take a huge time to load then. See [options](#options).

Anyway, the script will degrade nicely, if no thumbnail is found, it'll use the full-size picture. If a thumb exists but not the corresponding file (same name), it'll not display it.

## Keyboard handling

It supports keyboard commands: 
 - ```left``` and ```right arrow``` will change the picture
 - ```Enter``` key toggle full screen mode
 - ```spacebar``` launch/stop the slideshow mode (with a 5 seconds delay, available in normal or fullscreen mode)
 - ```esc``` key leave any of the previous mode

 On mobile devices, you can swipe to change the picture.

## What format are supported?

Only pictures are accepted: ```.jpg```, ```.jpeg```, ```.png``` or ```.gif``` files (upper or lowercase).

## Set a custom thumbnail

It will first search in a subfolder for a file named ```thumbnail.jpg```. If not found, it will use the first picture.
If there are no pictures in the folder, then it's recursive, it will search it's first subfolder for a file...

## Options

On top of ```index.php``` file, you may configure some parameters:
 - ```$use_thumbs```: if FALSE, it won't look for thumbnails (you may save some server time; however not using thumbnails is not a really good idea for your viewers)
 - ```$thumbs_suffix```: you may change the ```_thumb``` suffix used to differentiate thumbs from full-size pictures to something else
 - ```$lang```: cf [localization](#localization)

## License

Feel free to use and abuse, modify and redistributing and so on. I would be happy to hear from users!  
It uses jQuery, Galleria (and some plugins) under MIT license.