<div class="bg-modal hidden" id="folder-modal">
    <div class="modal-content">
        <form id="newFolderForm" action="./.policy-code/api/folder-process.php" method="POST">

            <div style="display: flex; align-items: center; width: 90%; justify-content: center;margin: auto;"><span
                    id="new-folder-title" class="bigtext">New Folder
                    <?php echo $_User; ?>
                </span><img src="./.policy-code/images/folder-blue-closed.png" style="margin-left: 20px; width: 45px;">
            </div>
            <p>
                <label for="folder-name">Folder Name</label>
                <input type="text" required name="folder-name" class="modal-input" autocomplete="off" />
            <div class="upload-button-container">

                <button name="cancel-button" class="button">Cancel</button>
                <button class="button">Add</button>
            </div>

        </form>
    </div>
</div>
<script type="module">

</script>