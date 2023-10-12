<?php
//after a search is performed this is how we will look at the page

function search_view($target){
//build title
echo $title;
	
//capture post data from search field
$search = $_GET['query'];

if ($search != '') {echo '<div class="title">
<div class="two-thirds column" style="display:flex;align-items:center;justify-content: space-around;"><img onclick="history.back()" src="/policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back"><a href="index.php"><img src="/policy-code/images/home-folder-icon-35.png" class="scale-with-grid" style="border: none;"></a><span class="titleText">Results for - '.$search;

echo '</div>
<div class="one-third column">';
include ($_SERVER['DOCUMENT_ROOT'].'/includes/search.html');}
echo '</div>';

if ($search !== ''){
//if $search in NOT empty, then we need to search. Otherwise, just load index as usual

global $file_info; // All the file paths will be pushed here
$file_info = array();

/**
 * @this is the search function
 * @function recursive_scan
 * @description Recursively scans a folder and its child folders
 * @param $path :: Path of the folder/file
 * 
 * */
function recursive_scan($path){
    global $file_info;
    $path = rtrim($path, '/');
    
    if(!is_dir($path)) $file_info[] = $path;
        else {
            $files = scandir($path);
            foreach($files as $file) 
            //filter out first 2 . and .. folders
            if($file != '.' && $file != '..') recursive_scan($path . '/' . $file);
        }
}

//Get the area that we are in by using / as delimiter and making array of all items in string
$match = explode ('/', $target);
//set the search area to first item in match
$area = $match[1];

recursive_scan($area);
	echo '<table>';
foreach ($file_info as $found){
	
	//strpos is case sensative stripos is not
	//build urls with names
$prettyFound = basename($found);

if (stripos(basename($found), $search) > -1){
	//filter results to just the basename
	if (stripos($found, '.html') == true){
		//file is an html file
	echo '<tr><td class="narrow">';
	echo '<a href="index.php?target='.$found.'&view=file">';
	echo '<img src="/policy-code/images/file.png" class="folder" title="View File"></td>';
	echo '<td><a href="index.php?target='.$found.'&view=file">'.$prettyFound.'</a>';
	echo '</td></tr>'."\n\n";
	}
	elseif (stripos($found, '.pdf') == true){
	//file is a pdf
	echo '<tr><td class="narrow">';
	echo '<a href="'.$found.'" target="_blank"><img src="/policy-code/images/pdf-icon.png" class="folder" title="View PDF">';
	echo '</td><td>';
	echo '<a href="'.$found.'" target="_blank">'.$prettyFound.'</a>';
	echo '</td></tr>'."\n\n";

		}
		
	//test for webarchive
	elseif (stripos($found, '.webarchive') == true){
	echo '<tr><td class="narrow">';
	echo '<a href="'.$found.'" download>';
	echo '<img src="/policy-code/images/file.png" class="folder" title="Download Web Archive"></a>';
	echo '</td><td>';
	echo '<a href="'.$found.'" download>';
	echo $prettyFound.' <span class="download">- (Download)</span></a>';
	echo '</td></tr>';
		}
		
	//test for pages, numbers, xls
	elseif (stripos($found, '.pages') == true || stripos($found, '.numbers') == true || stripos($found, '.xls') == true){
	echo '<tr><td class="narrow">';
	echo '<a href="'.$found.'" download>';
	echo '<img src="/policy-code/images/file.png" class="folder" title="Download File"></a>';
	echo '</td><td>';
	echo '<a href="'.$found.'" download>';
	echo $prettyFound.' <span class="download">- (Download)</span></a>';
	echo '</td></tr>';
		}
		
	elseif (stripos($i, '.png') == true || stripos($i, '.jpg') == true){
		//file is an image
	echo '<tr><td class="narrow">';
	echo('<a href="'.$found.'" target="_blank"><img src="/policy-code/images/image-icon.png" class="folder" title="View Image"></td><td><a href="'.$found.'" target="_blank">'.$prettyFound.'</a></td></tr>'."\n\n");

		}
	else {
	echo '<tr><td class="narrow">
	<a href="index.php?target='.$found.'&view=file"><img src="/policy-code/images/file.png" class="folder" title="View File"></td><td><a href="index.php?target='.$found.'&view=file">'.$prettyFound.'</a></td></tr>'."\n\n";

	}
		}
	}
	echo '</table>';
$search = '';

}

if (strpos($target, '/') != false){
$title = substr($target, strrpos($target, '/' )+1)."\n";
}
else {
	$title = $target;
}

	
	}
//end of search view
