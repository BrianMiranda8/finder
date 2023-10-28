<?php
// include('../classes/ResourceHandler.php');
// include('../FileHandler.php');
// $responseType = $_SERVER['CONTENT_TYPE'];
// $directoryPath = $_GET['dir'];
// $fileHanlder = new FileHandler($directoryPath);
// $response = array('ok' => false, 'error' => '', 'body' => []);
// $substringToSearch = $_GET['query'];


// try {
//     if ($responseType == 'Application/json') {
//         $matchingItems = ResourceHandler::searchFilesWithSubstring($fileHanlder->fullPath, $substringToSearch);
//         $response['ok'] = true;
//         $response['body'] = $matchingItems;
//     } elseif ($responseType == 'text/html') {

//         $table = $fileHanlder->buildSearchRows($fileHanlder->fullPath, $substringToSearch);
//         $response['ok'] = true;
//         $response['body'] = $table;
//     }
// } catch (Exception $e) {
//     $response['error'] = $e->getMessage();
// }

// echo json_encode($response);
