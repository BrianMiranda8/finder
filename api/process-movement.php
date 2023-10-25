<?php

include('../FileHandler.php');


$data = json_decode(file_get_contents("php://input"), true);
extract($data);
$response = array('error' => '', 'newLocation' => '', 'ok' => false, 'row' => '');

if ($targetType == 'file')
    $newLocation = $targetParent;
else
    $newLocation = $targetLocation;

$dest = $newLocation . '/' . $fileName;

try {


    if (!rename($_SERVER['DOCUMENT_ROOT'] . $currentLocation, $_SERVER['DOCUMENT_ROOT'] . $dest)) {
        throw new Exception(error_get_last()['message']);
    }

    $fileHandler = new FileHandler($dest);
    $response['ok'] = true;
    $response['newLocation'] = $newLocation;
    $response['row'] = $fileHandler->htmlRow($type, $dest, $fileName, $fileHandler->ext);
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {

    echo json_encode($response);
}
