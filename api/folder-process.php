<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$fileDirectory = dirname($_SERVER['SCRIPT_NAME']);
$folderName = $_POST['folder-name'];
$root = $_SERVER['DOCUMENT_ROOT'];

$root = dirname($_POST['root']);
$currentDirectory = $_POST['directory'];
chdir('stuff/' . "$currentDirectory");
echo getcwd();
mkdir($folderName, 0755, true);
header("location:" . $_SERVER['HTTP_REFERER']);
