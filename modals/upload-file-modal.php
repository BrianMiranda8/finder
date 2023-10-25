   <?php
   //build title
   $target = $_GET['target'] ;
    if (strpos($target, '/') != false) {
        $title = substr($target, strrpos($target, '/') + 1) . "\n";
        $title = "to ".$title;
    } else {
        $title = $target;
    }
    if ($title == '') {
        $title = "to Home Folder";
    }

?>

<style>
    .drop__zone {
        width: 350px;
        height: 350px;
        border: dotted 2px purple;
    }
</style>

<div class="bg-modal hidden" id="upload-modal">
        <div class="modal-content">
    <form action='../file-upload-process.php' method="POST" enctype="multipart/form-data">


            <h1>Upload file(s) <?php echo $title;?> </h1>
            <input type="hidden" id="input1" name="directory" value="<?php echo $_GET['target']; ?>">
            <input type='file' id='file-upload' name='upload-file[]' multiple>
<p>
            <div class="upload-button-container">
                <button id="upload-close" name="cancel-button" class="button">Close</button>
                <button class="button">Upload &uArr;</button>
            </div>

    </form>
        </div>
</div>
