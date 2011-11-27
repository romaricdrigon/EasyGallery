<?php
	/*
	 * EasyGallery
	 * http://github.com/romaricdrigon/
	 */
	
	/*
	 * This very little piece of script will list
	 * files (pictures only) & folders in a directory,
	 * sorted by ascending alphebitic order
	 * No recursion, no fancy and cpu-consuming stuff
	 * @param :
	 *  - dir name {string}, with no slashes
	 */

 	// we can't define an array as const - so we'll accede this var via super-global
 	// and, oh, yes it's dirty, but so damn fast to code
	$extensions = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'gif'); // allowed files extensions

//  list images in a given directory
function lister($dir)
{
	$files = scandir($dir);
	
	if ($files === FALSE)
	{
		echo 'Unable to open folder';
	}
	
	$content = array();
	global $extensions; // access defined file extensions list
	
	// array_diff to remove . and ..
	foreach (array_diff($files, array('.','..')) as $file)
	{
		// careful, you have to call is_dir or is_file on the full path!
		$f = $dir.'/'.$file;

		if (is_dir($f) === TRUE) // directory
		{
			$content['folder'][] = $file;
		}
		else if (is_file($f) === TRUE && in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) // file
		{
			// we consider this script will not be used by idiots, so we don't re-check mime type
			$content['picture'][] = $file;
		}
		// we elude symlinks
	}
	
	return $content;
}

// return thumbnail representing a directory
// V2 : recursivity FTW
// param : dir : folder that must represented by a thumbnail
function get_thumbnail($dir)
{
	global $extensions; // access defined file extensions list
	
	$list = lister($dir);
	
	if (isset($list['picture']['thumbnail.jpg']) === TRUE)
	{
		return 'thumbnail.jpg';
	}
	// get first picture file in the folder
	else if ((isset($list['picture']) === TRUE) && (sizeof($list['picture']) > 0))
	{
		return $list['picture'][0];
	}
	// search in sub folders
	else if ((isset($list['folder']) === TRUE) && (sizeof($list['folder']) > 0))
	{
		foreach ($list['folder'] as $a_folder)
		{
			// recursivity, yeah!
			$a_folder_thumb = get_thumbnail($dir.'/'.$a_folder);
			
			if ($a_folder_thumb !== '')
			{
				return $a_folder.'/'.$a_folder_thumb;
			}
		}
	}
	
	return ''; // nothing was found
	
}

// return the folder from GET param
function get_folder()
{
	$folder = $_GET['gallery']; // $_GET is automatically url-decoded - and backslashes added
	$folder = stripslashes($folder); // remove theses backslashes
	
	if (stripos($folder, '..') !== FALSE) // strict test (can return 0 for "position 0")
	{
		//die("Forbidden directory"); // don't fuck with me bro
		return ''; // be nice, just return to root
	}
	
	// remove ending slash
	$folder = no_slash($folder);
	
	return $folder;
}

// display a path link
// @param :
// - root (first directory, Home)
// - then path
function show_path($root, $dir)
{
	echo '<a href="?gallery=/" title="Index">Index</a>';
	
	if ($dir != '')
	{	
		$path = explode('/', $dir);
		
		foreach ($path as $step)
		{
			$link .= $step.'/';
			$step = htmlentities($step, ENT_QUOTES, 'UTF-8'); // html encode to take care of probable shit, watch out we're in UTF-8 for folders
			
			// last step, assemble and apply gallery_link
			$full_path .= ' &gt; <a href="?gallery='.gallery_link($link).'" title="'.$step.'">'.$step.'</a>';
		}		
	}
	
	echo $full_path;
}

// withdrew the ending slash from a name
// (if one found)
// not so useful, more kind of an alias
function no_slash($name)
{
	return rtrim($name, '/');
}

// format a link to a sub gallery
// url encode and remove last right slash
function gallery_link($name)
{
	return urlencode(no_slash($name));
}

/* EOF */