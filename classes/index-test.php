<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('./ResourceHandler.php');
include('./FileManager.php');
include('./FolderManager.php');
include('./ResourceToHtml.php');

// $resourceHTMLManager = new ResourceHtml();
// $FolderManager = new FolderManager('/stuff', ResourceHtml::class);

$show = ResourceHandler::searchFilesWithSubstring('/stuff', 'a');
echo "<table>";
foreach ($show as $i) {

    if ($i['ext'] == '') {
        echo ResourceHtml::{$i['type']}($i['parent'], $i['path'], $i['basename']);
    } else {
        echo ResourceHtml::{$i['ext']}($i['parent'], $i['path'], $i['basename']);
    }
}

echo "</table>";
