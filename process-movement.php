<?php
// rename("/test1.txt", "/rogman.txt");
include('./policy-code/FileHandler.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$data = json_decode(file_get_contents("php://input"), true);
extract($data);
$response = array('error' => '', 'newLocation' => '', 'ok' => false, 'row' => '');
try {
    $newLocation = $targetLocation . '/' . $fileName;
    if (!rename($_SERVER['DOCUMENT_ROOT'] . $currentLocation, $_SERVER['DOCUMENT_ROOT'] . $newLocation)) {
        throw new Exception(error_get_last()['message']);
    }

    $fileHandler = new FileHandler($newLocation);

    $response['ok'] = true;
    $response['newLocation'] = $newLocation;
    $response['row'] = $fileHandler->htmlRow($type, $newLocation, $fileName, $fileHandler->ext);
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {

    echo json_encode($response);
}