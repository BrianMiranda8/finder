<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/FileHandler.php');
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/config.php');

$target = (!isset($_GET['target']) || $_GET['target'] == '') ? $_HomePage : $_GET['target'];

?>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../local.css">
    <link rel="stylesheet" href="./.policy-code/css/draganddrop.css">
    <link rel="stylesheet" href="./.policy-code/css/filedraganddrop.css">
    <link rel="stylesheet" href="./.policy-code/css/modal-css.css">
    <link rel="stylesheet" href="./.policy-code/css/basic.css">
    <link rel="stylesheet" href="./.policy-code/css/skeleton.css" type="text/css">
    <title>
        <?php echo $_User; ?>
    </title>
</head>


<body class="navpad">

    <div class="container">
        <?php

        $fileHandler = new FileHandler($target);
        if ($fileHandler->ext == '') {
            $fileHandler->DirectoryTitle($_User);
            echo "<table id='main-table'>";
            $fileHandler->buildRows();
            echo "</table>";
        } else {
            $fileHandler->display();
        }
        ?>

        <div class="footer">
            <img src="./.policy-code/images/goToTop.png" onclick="topFunction()" id="topBtn" title="Go to top">
        </div>
    </div>

    <?php
    // upload/create folder and create file modals
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/file-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/folder-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/upload-file-modal.php');
    ?>
</body>


<script type="text/javascript" src="./.policy-code/javascript/top_button.js"></script>
<script src="./.policy-code/javascript/fetch.js"></script>
<script src="./.policy-code/javascript/draganddrop.js"></script>
<script src="./.policy-code/javascript/tip-down.js"></script>
<script type="module" src="./.policy-code/javascript/index.js"></script>

</html>