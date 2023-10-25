<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$returnPage = $_SERVER['HTTP_REFERER'];
$webRoot = $_SERVER['DOCUMENT_ROOT'];
$fileName = $_POST['file-name'];
$content = $_POST['content'];
$content = str_replace("\r\n", '<br>', $content);
$root = dirname($_POST['root']);

$currentDirectory = $_POST['directory'];
$fullPath = $webRoot . "" . $root . "" . $fileName;
if ($currentDirectory != "") {
    $currentDirectory = str_replace('.', "", $currentDirectory);
}



chdir("stuff/$currentDirectory");

$newfile = fopen("$fileName" . ".txt", 'wb');
// fwrite($newfile, "<html>");
fwrite($newfile, "$content");
fclose($newfile);
header("location:" . $_SERVER['HTTP_REFERER']);
