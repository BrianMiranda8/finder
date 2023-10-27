<?php
// include('../FileHandler.php');
include("../classes/FolderManager.php");
include("../classes/ResourceToHtml.php");

$handler = new FolderManager($_GET['path'], ResourceHtml::class);
$type = $_GET['type'];
$responseType = $_SERVER['HTTP_ACCEPT'];

if ($responseType == 'application/json') {
    $contents = $handler->get_folder_content();
    if (isset($type))
        $contents = array_filter($contents, function ($cont) use ($type) {
            return $cont['type'] == $type;
        });


    echo json_encode($contents);
}

if ($responseType == 'text/html') {

    echo  $handler->buildRows();
}
