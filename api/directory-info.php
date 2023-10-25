<?php
include('../FileHandler.php');
$handler = new FileHandler($_GET['path']);

$type = $_GET['type'];

$responseType = $_SERVER['HTTP_ACCEPT'];

if ($responseType == 'application/json') {
    $contents = $handler->retrieveContent();
    if (isset($type))
        $contents = array_filter($contents, function ($cont) use ($type) {
            return $cont['type'] == $type;
        });


    echo json_encode($contents);
}

if ($responseType == 'text/html') {
    // echo "<table>";
    $handler->buildRows();
    // echo "</table>";
}
