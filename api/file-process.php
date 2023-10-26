<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include('../FileHandler.php');
$returnPage = $_SERVER['HTTP_REFERER'];
$webRoot = $_SERVER['DOCUMENT_ROOT'];
$fileName = $_POST['file-name'];
$content = $_POST['content'];
$content = str_replace("\r\n", '<br>', $content);
$root = dirname($_POST['root']);



chdir($webRoot . $_POST['dir']);

$newfile = fopen($fileName . ".txt", 'wb');
// fwrite($newfile, "<html>");
fwrite($newfile, "$content");
$metaData = stream_get_meta_data($newfile);

// Getting the file name from metadata
$fileNameFromMeta = $metaData['uri'];
fclose($newfile);
$file = new FileHandler($_POST['dir'] . '/' . $fileNameFromMeta);
$target = $_POST['dir'] . '/' . $fileNameFromMeta;
$row = $file->htmlRow('file', $target, $fileNameFromMeta, 'txt');
echo json_encode(['ok' => true, 'row' => $row]);
