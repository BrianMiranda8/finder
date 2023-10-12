<div class="file-modal-container" id="file-modal">
    <form id="newItemForm" action="../file-process.php" method="POST">
        <div class="file-modal">
            <input type="hidden" name="root" value="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="directory" value="<?php echo $_GET['target'] ?>">
            <h1>Add New File</h1>
            <label for="file-name">File Name</label>
            <input type="text" name="file-name" autocomplete="off" class="modal-input">
            <label for="content">Content</label>
            <textarea name="content" id="content">

            </textarea>
            <div class="upload-button-container">

                <button name="cancel-button">Cancel</button>
                <button>Add</button>
            </div>
        </div>
    </form>
    <button onclick="setFocus()">focus</button>
</div>
<script>
	 function setFocus(){
	 document.getElementById("fileName").focus();
	}
</script>
