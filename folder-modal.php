<style>
    /* body {
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;

    } */
</style>



<div class="file-modal-container" id="folder-modal">
    <form id="newFolderForm" action="../folder-process.php" method="POST">
        <input type="hidden" name="root" value="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="directory" value="<?php echo $_GET['target'] ?>">
        <div class="file-modal">
            <h1>Add New Folder</h1>
            <label for="folder-name">Folder Name</label>
            <input type="text" name="folder-name" class="modal-input" autocomplete="off" />
            <div class="upload-button-container">

                <button name="cancel-button">Cancel</button>
                <button>Add</button>
            </div>
        </div>
    </form>
</div>
