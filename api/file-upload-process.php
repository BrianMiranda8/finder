<?php
// $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/stuff';
$currentDirectory = $_POST['directory'];

function reArrayFiles(&$file_post)
{

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

if ($currentDirectory != "") {
    $currentDirectory = str_replace('.', "", $currentDirectory);
}

$newFileArray = reArrayFiles($_FILES['upload-file']);

foreach ($newFileArray as $file) {
    $uploadfile = $_SERVER['DOCUMENT_ROOT'] . $currentDirectory . "/" . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
        break;
    }
}
header("location:" . $_SERVER['HTTP_REFERER']);
