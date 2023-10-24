<html lang="en">

<head>
    <style>

    </style>
    <link rel="stylesheet" type="text/css" href="/local.css">
    <link rel="stylesheet" href="../policy-code/css/draganddrop.css">
    <link rel="stylesheet" href="../policy-code/css/filedraganddrop.css">
    <link rel="stylesheet" href="../policy-code/css/modal-css.css">
    <link rel="stylesheet" href="../policy-code/css/basic.css">


    <?php
    //css is in the header
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/basic-header.html');
    include('./prefs.php');

    echo '<title>' . $userName . ' Stuff </title>';
    //let's start the page here
    echo '</head>';

    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/includes/file-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/includes/folder-modal.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/includes/upload-file-modal.php');

    echo '<body class="navpad">';
    echo '<div class="container">';

    //error_reporting(-1);
    //ini_set('display_errors', 'On');
    
    //View and search functions 
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/functions/folder_view.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/functions/file_view.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/functions/search_view.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/functions/title_view.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/policy-code/FileHandler.php');
    //executable path
    $target = (isset($_GET['target'])) ? $_GET['target'] : '/stuff';

    // title_view($view_type);
    $fileHandler = new FileHandler($target);
    if ($fileHandler->ext == '') {

        echo "<table id='main-table'>";
        $fileHandler->buildRows();
        echo "</table>";
    } else {
        $fileHandler->display();
    }


    ?>
    <!-- <input type="file" name="" id=""> -->

    <div class="footer">
        <img src="/policy-code/images/goToTop.png" onclick="topFunction()" id="topBtn" title="Go to top">
    </div>
    </div>
    <!--end container-->
    <script type="text/javascript" src="/policy-code/functions/top_button.js">
    </script>

    </body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php'); ?>
    <script src="/policy-code/functions/fetch.js"></script>
    <script src="/policy-code/functions/draganddrop.js"></script>

    <script src="/policy-code/functions/tip-down.js"></script>


</html>