<?php
    /*
     * EasyGallery
     * http://github.com/romaricdrigon/
     */

    /*
     * This very little piece of script will list
     * files (pictures only) & folders in a directory,
     * sorted by ascending alphabetic order
     * @param :
     *  - dir name {string}, with no slashes
     */

    // allowed files extensions
    $extensions = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF');

//  list images in a given directory
function lister($dir, $use_thumbs, $thumbs_suffix = '')
{
    // test if dir exists before
    if (is_dir($dir)) {
        $files = scandir($dir);
    } else {
        echo 'Dossier introuvable';
        return '';
    }

    if ($files == FALSE) {
        echo 'Unable to open folder';
        return '';
    }

    $content = array();
    global $extensions; // access defined file extensions list

    $files = array_diff($files, array('.','..')); // array_diff to remove . and ..
    sort($files, SORT_STRING); // sort, important for next step ; make sure everything is seen as strings

    foreach ($files as $file) {
        $f = $dir.'/'.$file; // careful, you have to call is_dir or is_file on the full path!

        if (is_dir($f) === TRUE && sizeof(scandir($f)) > 2) { // directory, not empty (2 items by default : . and ..)
            $content['folder'][] = $file;
        } else if (is_file($f) === TRUE && in_array(pathinfo($file, PATHINFO_EXTENSION), $extensions)) { // file
            // we consider there's only pictures files, this is part of the "contract" - so we don't re-check mime type
            if (($use_thumbs === TRUE) && (strpos($file, $thumbs_suffix) != FALSE)) {
                // it's a thumbnail - using str_replace and an associative array allow to match big picture & thumb
                $content['picture'][str_replace($thumbs_suffix, '', $file)]['thumb'] = $file;
            } else {
                $content['picture'][$file]['big'] = $file; // otherwise it's a big one
            }
        }
        // we elude symlinks, to avoid loops
    }

    return $content;
}

// return thumbnail representing a directory
// param : dir : folder that must represented by a thumbnail
function get_thumbnail($dir)
{
    $list = lister($dir, FALSE); // we don't care about thumbs, so save some time

    if (isset($list['picture']['thumbnail.jpg']) === TRUE) {
        return 'thumbnail.jpg';
    } else if ((isset($list['picture']) === TRUE) && (sizeof($list['picture']) > 0)) { // get first picture file in the folder
        $key = key($list['picture']); // get current value
        return $list['picture'][$key]['big'];
    } else if ((isset($list['folder']) === TRUE) && (sizeof($list['folder']) > 0)) { // search in sub folders
        foreach ($list['folder'] as $a_folder) {
            // recursivity FTW
            $a_folder_thumb = get_thumbnail($dir.'/'.$a_folder);

            if ($a_folder_thumb !== '') {
                return $a_folder.'/'.$a_folder_thumb;
            }
        }
    }

    return ''; // nothing was found
}

// return the folder from GET param
function get_folder()
{
    if (! isset($_GET['gallery'])) {
        return ''; // means root
    }

    $folder = $_GET['gallery']; // $_GET is automatically url-decoded - and backslashes added
    $folder = stripslashes($folder); // remove theses backslashes

    if (stripos($folder, '..') !== FALSE) {
        //die("Forbidden directory"); // don't fuck with me bro
        return ''; // be nice, just return to root
    }

    // remove ending slash
    return no_slash($folder);
}

// display a path link
// @param :
// - root (first directory, Home)
// - then path
function show_path($dir)
{
    echo '<a href="?gallery=/" title="Index">Index</a>';
    $link = '';
    $full_path = '';

    if ($dir != '') {
        $path = explode('/', $dir);

        foreach ($path as $step) {
            $link .= $step.'/';

            // last step, assemble and apply gallery_link
            $full_path .= ' / <a href="?gallery='.link_safe(gallery_link($link)).'" title="'.link_safe($step).'">'.html_safe($step).'</a>';
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

// escape " but not '
function link_safe($string)
{
    return htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
}
// html encode everything, including accents
function html_safe($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

/* EOF */
