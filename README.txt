****** How it works? ******

You just copy this app's files on a server with Php enabled. In a subfolder called /photos/, you can put files & sub-folders.
It'll list all pictures files as a gallery powered by Galleria, and sub-folders with thumbnails.

It's best not to use big pictures files (< 0.5 mb), as thumbnails are resized one the fly, it both useless (they're displayed as 960px wide) and may provoke slowing downs.
You may consider adding thumbs pictures (thus modify a little bit lister() function), or splcie the gallery using Galleria API.


****** Setup ******

Put the app in root directory.
Put pictures & sub-folders (to create galleries) in /photos/
Avoid special chars in names of subdirectories & files (spaces are ok, as accents). Double dot ('..') is forbidden, as it means upper directory!


****** Keyboard handling ******

It supports keyboard commands: left/right arrows will change the picture, enter key launch the diaporama (using a 3 sec. delay), esc. key leave it.


****** What format are supported? ******

Only pictures are accepted, .jpg, .jpeg, .png or .gif files.


****** Set a custom thumbnail ******

It'll first search subfolders for a file named thumbnail.jpg. If not found, it'll use the first picture.
If not found ine the folder, it'll go recursive, search it's first subfolder for a file...


****** License ******

Feel free to use and abuse this, modify and redistributing and so on. I would be happy to hear from users!
It uses jQuery, Galleria (and some plugins) under MIT license.