<style>
    .drop__zone {
        width: 350px;
        height: 350px;
        border: dotted 2px purple;
    }
</style>

<div class="file-modal-container" id="upload-modal">
    <form action='../file-upload-process.php' method="POST" enctype="multipart/form-data">
        <div class="file-modal">

            <h1>Select File(s) To Upload</h1>
            <input type="hidden" id="input1" name="directory" value="<?php echo $_GET['target']; ?>">
            <input type='file' id='file-upload' name='upload-file[]' multiple>

            <div class="upload-button-container">
                <button id="upload-close" name="cancel-button">Close</button>
                <button>Upload</button>
            </div>
        </div>
    </form>
</div>
