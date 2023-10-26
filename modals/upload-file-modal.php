<style>
    .drop__zone {
        width: 350px;
        height: 350px;
        border: dotted 2px purple;
    }
</style>

<div class="bg-modal hidden" id="upload-modal">
    <div class="modal-content">
        <form action='./.policy-code/api/file-upload-process.php' method="POST" enctype="multipart/form-data">


            <h1>Upload file(s)
                <?php echo $_User; ?>
            </h1>
            <input type="hidden" id="input1" name="directory" value="<?php echo $target; ?>">
            <input type='file' id='file-upload' name='upload-file[]' multiple>
            <p>
            <div class="upload-button-container">
                <button id="upload-close" name="cancel-button" class="button">Close</button>
                <button class="button">Upload &uArr;</button>
            </div>

        </form>
    </div>
</div>

<script type="module">


</script>