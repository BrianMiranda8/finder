<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/FileHandler.php');
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/classes/FileManager.php');
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/classes/FolderManager.php');
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/classes/ResourceToHtml.php');
include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/classes/ResourceHandler.php');

include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/config.php');


$target = (!isset($_GET['target']) || $_GET['target'] == '') ? $_HomePage : $_GET['target'];
if (strpos($target, 'stuff') === false) {
    $target = '/stuff';
}
$view = (!isset($_GET['view']) || $_GET['view'] != 'search') ? false : $_GET['view'];
$resourceInfo = [];

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
        <?php echo $_User . ' Stuff'; ?>
    </title>
</head>


<body class="navpad">
    <div class="container">

        <?php
        if ($view != false) {

            ResourceHtml::Directorytitle('', "Searched For '$_GET[keyword]'");
            echo "<table id='main-table'>";
            echo ResourceHandler::buildSearchView($_GET['search'], $_GET['keyword']);
            echo "</table>";
        } else {

            $resourceManager = new ResourceHandler($target);
            $handler = $resourceManager->get_handler();
            $resourceInfo = $resourceManager->get_resource_info();
            $resourceManager->showView($_User);
        }
        ?>

        <div class="footer">
            <img src="./.policy-code/images/goToTop.png" onclick="topFunction()" id="topBtn" title="Go to top">
        </div>
    </div>


</body>
<script type="text/javascript" src="./.policy-code/javascript/top_button.js"></script>
<?php
if ($resourceInfo['type'] == 'directory' && isset($resourceInfo['type'])) {

    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/file-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/folder-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/stuff/.policy-code/modals/upload-file-modal.php');
?>
    <script src="./.policy-code/javascript/fetch.js"></script>
    <script src="./.policy-code/javascript/draganddrop.js"></script>
    <script src="./.policy-code/javascript/tip-down.js"></script>
    <script type="module" src="./.policy-code/javascript/index.js"></script>
<?php
}
?>

</html>