<?php
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/FileHandler.php');


$target = (isset($_GET['target'])) ? $_GET['target'] : '/stuff';

?>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../local.css">
    <link rel="stylesheet" href="./.policy-code/css/draganddrop.css">
    <link rel="stylesheet" href="./.policy-code/css/filedraganddrop.css">
    <link rel="stylesheet" href="./.policy-code/css/modal-css.css">
    <link rel="stylesheet" href="./.policy-code/css/basic.css">
    <link rel="stylesheet" href="./.policy-code/css/skeleton.css" type="text/css">
    <title>R+E Stuff</title>
</head>


<body class="navpad">
    <?php

    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/includes/file-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/includes/folder-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/includes/upload-file-modal.php');



    ?>

    <div class="container">
        <?php

        $fileHandler = new FileHandler($target);
        if ($fileHandler->ext == '') {
            $fileHandler->DirectoryTitle();
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


</body>


<script type="text/javascript" src="./.policy-code/javascript/top_button.js"></script>
<script src="./.policy-code/javascript/fetch.js"></script>
<script src="./.policy-code/javascript/draganddrop.js"></script>
<script src="./.policy-code/javascript/tip-down.js"></script>

</html>