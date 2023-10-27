<div class="bg-modal hidden" id="file-modal">
    <div class="modal-content">
        <form id="newItemForm" action="./.policy-code/api/file-process.php" method="POST">

            <div style=" display: flex;align-items: center;width: 90%;justify-content: center;margin: auto;gap: 15px;">

                <span class="bigtext">
                    New Text file In

                </span>
                <select id="insert-into-dir" style="flex-basis: fit-content;border-radius: 5px;text-align: center;color: blue;font-size: 1.5em;padding:0;">
                    <?php
                    echo <<<"EOL"
                            <option data-path="{$resourceManager->get_resource_info()['location']}" selected value="{$resourceManager->get_resource_info()['name']}">{$resourceManager->get_resource_info()['name']}</option>
                        EOL;
                    $content = $handler->get_folder_content();
                    foreach ($content as $dir) {
                        if ($dir["type"] != 'directory')
                            continue;
                        echo <<<"EOL"
                                <option data-path="{$dir['fullPath']}" value="{$dir['name']}">
                                    {$dir['name']}
                                </option>

                                EOL;
                    }
                    ?>
                </select>
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

<script type="module">
    let form = document.querySelector('#newItemForm')
    let mainTable = document.querySelector("#main-table tbody");
    let fileModal = document.querySelector('#file-modal');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        let insertIntoDir = document.querySelector("#insert-into-dir");
        let formData = new FormData(form);
        let selectedOption = insertIntoDir.options[insertIntoDir.options.selectedIndex];

        formData.append('dir', selectedOption.getAttribute('data-path'));
        let request = await fetch('./.policy-code/api/file-process.php', {
            method: "POST",
            body: formData
        });
        let response = await request.json();

        if (!response.ok) throw new Error('error file now created');

        mainTable.insertAdjacentHTML('afterend', response.row)

        fileModal.classList.add('hidden');
    })
</script>