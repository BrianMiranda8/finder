<?php

function title_view($target)
{
    global $userName;
    //echo $userName;

    //build title
    if (strpos($target, '/') != false) {
        $title = substr($target, strrpos($target, '/') + 1) . "\n";
    } else {
        $title = $target;
    }
    if ($title == '.') {
        $title = "Home Page";
    }

    //build page header
    echo '<div class="title">
<div class="two-thirds column" style="display:flex;align-items:center;justify-content: space-around;"><img onclick="history.back()" src="/policy-code/images/back-icon-35.png" class="scale-with-grid" title="Go Back"><a href="index.php"><img src="/policy-code/images/home-folder-icon-35.png" class="scale-with-grid" style="border: none;" title="Home"></a><span class="titleText">' . $userName;
    echo ' ' . $title . '</span> 
    
    <div class="adding-files">
		<div class="file-button" id="file-button" title="New Text File inside"><img src="/policy-code/images/new-file-icon-white.png"></div>
		<div class="file-button" id="folder-button" title="New Folder inside "><img src="/policy-code/images/new-folder-icon.png"></div>
		<div class="file-button" id="upload-files-button" title="Upload Files into"><img src="/policy-code/images/upload-file-icon.png"></div>
	</div>';

    // if ($title !== 'Home Page') {
    echo '</div><div class="one-third column">';
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/includes/search.html');
    // }
    echo '</div></div>';
}
