****** How it works? ******

You just copy this app's files on a server with Php enabled. In a subfolder called /photos/, you can put files & sub-folders.
It'll list all pictures files as a gallery powered by Galleria, and sub-folders with thumbnails.

It's best not to use big pictures files (< 0.5 mb), as thumbnails are resized one the fly, it both useless (they're displayed as 960px wide) and may provoke slowing downs.


****** Setup ******

Put the app in root directory.
Put pictures & sub-folders (to create galleries) in /photos/
Avoid special chars in names of subdirectories & files (spaces are ok, as accents). Double dot ('..') is forbidden, as it means upper directory!


****** Thumbs ******

You may consider adding thumbs pictures, the page will load way faster (because Galleria fetches only the small pictures, and not the full ones) and the UX will be smoother.
Make 60px-big picture, add '_thumb' prefix in their names (before the extension), and make sure $use_thumbs is set to TRUE in index.php at the beginning.

You can disable thumbs check: it'll not look for thumbs, which may you save a little time in huge collections, but it may not be very smart as pages will take a huge time to load then.

Anyway, the script will degrade nicely, if no thumb is found, it'll use the big picture instead ; if a thumb exists but not the corresponding file (same name), it'll not display it.


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