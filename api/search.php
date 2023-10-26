<?php
include('../FileHandler.php');
$responseType = $_SERVER['CONTENT_TYPE'];
$directoryPath = $_GET['dir'];
$fileHanlder = new FileHandler($directoryPath);
$response = array('ok' => false, 'error' => '', 'body' => []);
$substringToSearch = $_GET['query'];


try {
    if ($responseType == 'Application/json') {
        $matchingItems = $fileHanlder->searchFilesWithSubstring($fileHanlder->fullPath, $substringToSearch);
        $response['ok'] = true;
        $response['body'] = $matchingItems;
        // Replace 'your_directory_path' with the directory you want to search in.

    } elseif ($responseType == 'text/html') {

        $table = $fileHanlder->buildSearchRows($fileHanlder->fullPath, $substringToSearch);
        $response['ok'] = true;
        $response['body'] = $table;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
