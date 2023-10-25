   <?php
    //build title
    $target = $_GET['target'];
    if (strpos($target, '/') != false) {
        $title = substr($target, strrpos($target, '/') + 1) . "\n";
        $title = "in " . $title;
    } else {
        $title = $target;
    }
    if ($title == '') {
        $title = "in Home Folder";
    }

    ?>

   <div class="bg-modal hidden" id="file-modal">
       <div class="modal-content">
           <form id="newItemForm" action="../file-process.php" method="POST">
               <input type="hidden" name="root" value="<?php echo $_SERVER['PHP_SELF']; ?>">
               <input type="hidden" name="directory" value="<?php echo $_GET['target'] ?>">
               <div style="display: flex; align-items: center; width: 90%; justify-content: center;margin: auto;"><span class="bigtext">New Text file <?php echo $title; ?></span>
                   <img src="./.policy-code/images/file.png" style="margin: 20px 0px 20px 20px; width: 45px;">
               </div>
               <label for="file-name">Name</label>
               <input type="text" required name="file-name" autocomplete="off" class="modal-input">
               <hr>
               <label for="content">Text</label><br />
               <textarea required name="content" rows="6" id="content"></textarea>
               <div class="upload-button-container">

                   <button name="cancel-button" class="button">Cancel</button>
                   <button class="button">Save</button>
               </div>

           </form>
       </div>
   </div>