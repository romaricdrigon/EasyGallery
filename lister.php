<?php
/*
 * Thsi very little piece of script will list
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
	echo $dir;
	
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
function get_thumbnail($dir)
{
	global $extensions; // access defined file extensions list
	
	if (is_dir($dir) !== TRUE)
	{
		echo 'Unable to open folder';
	}
	
	// we look for a thumbnail.jpg file
	if (is_file($dir.'/thumbnail.jpg') === TRUE)
	{
		return 'thumbnail.jpg';
	}
	else
	{
		// get first file, by asc. alphabetic order
		$files = scandir($dir);
		
		if ($files === FALSE)
		{
			echo "Unable to open directory";
		}
		
		foreach ($files as $file)
		{
			if (is_file($dir.'/'.$file) === TRUE && in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) // file
			{
				return $file; // return the first picture found
			}
		}
	}
}

// return the folder from GET param
function get_folder()
{
	$folder = $_GET['gallery']; // $_GET is automatically url-decoded - and a slash added
	
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
			$step = stripslashes($step); // strip slashes that were automatically added when using $_GET
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