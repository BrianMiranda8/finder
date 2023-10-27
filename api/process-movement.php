<?php

// include('../FileHandler.php');
include("../classes/FileManager.php");
include("../classes/FolderManager.php");
include("../classes/ResourceHandler.php");
include("../classes/ResourceToHtml.php");

$data = json_decode(file_get_contents("php://input"), true);
extract($data);
$response = array('error' => '', 'newLocation' => '', 'ok' => false, 'row' => '');
$fileName = preg_replace('/%23/', '#', $fileName);
$currentLocation = preg_replace('/%23/', '#', $currentLocation);

if ($targetType == 'file')
    $newLocation = $targetParent;
else
    $newLocation = $targetLocation;

$dest = $newLocation . '/' . $fileName;

try {


    if (!rename($_SERVER['DOCUMENT_ROOT'] . $currentLocation, $_SERVER['DOCUMENT_ROOT'] . $dest)) {
        throw new Exception(error_get_last()['message']);
    }

    $fileHandler = new ResourceHandler($dest);
    $response['ok'] = true;
    $response['newLocation'] = $newLocation;
    $response['row'] = "<table>" . $fileHandler->buildResourceRow() . "</table>";
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {

    echo json_encode($response);
}
