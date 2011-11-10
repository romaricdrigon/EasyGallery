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
	$files = scandir($dir);
	
	if ($files === FALSE)
	{
		echo "Unable to open directory";
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
		// we elude symlink
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
		return $dir.'/thumbnail.jpg';
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
	$folder = $_GET['gal'];
	
	$folder = mysql_escape_string($folder); // be prudent
	
	// remove ending slash
	$folder = rtrim($folder, '/');
	
	return $folder;
}

// display a path link
// @param :
// - root (first directory, Home)
// - then path
function show_path($root, $dir)
{
	echo '<a href="?gal=/" title="Index">Index</a>';
	
	if ($dir != '')
	{	
		$path = explode('/', $dir);
		
		foreach ($path as $step)
		{
			$link .= $step.'/';
			
			$full_path .= ' &gt; <a href="?gal='.$link.'" title="'.$step.'">'.$step.'</a>';
		}		
	}
	
	echo $full_path;
}

/* EOF */