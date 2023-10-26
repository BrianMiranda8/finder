<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$fileDirectory = $_POST['currentDir'];
$folderName = $_POST['folder-name'];
$root = $_SERVER['DOCUMENT_ROOT'];

chdir($root . $fileDirectory);

mkdir($folderName, 0755, true);
header("location:" . $_SERVER['HTTP_REFERER']);
