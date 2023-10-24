const fileButton = document.getElementById('file-button');
const folderButton = document.getElementById('folder-button');
const folderModal = document.getElementById('folder-modal');
const uploadModal = document.getElementById('upload-modal');
const fileModal = document.getElementById('file-modal');
const draggableRows = document.querySelectorAll('tr')
const uploadButton = document.getElementById("upload-files-button");
const itemForm = document.getElementById("newItemForm");
const folderForm = document.getElementById("newFolderForm");
const table = document.querySelector('#main-table');


table.addEventListener('dragstart', (event) => {
    // getting info about the current file/folder we want to move
    let tr = event.target.closest('tr');
    let parent = tr.getAttribute('data-parent');
    let location = tr.getAttribute('data-src');
    let name = location.split('/')[location.split('/').length - 1];
    let type = tr.getAttribute('data-type');
    tr.id = 'selected-row';

    // const fileUrl = new URL(path);

    // let fileName = tr.querySelector('div div:nth-child(3) a').innerText;
    // let currentDirectory = fileUrl.searchParams.get('target');
    // let type = fileUrl.searchParams.get('view');

    // /stuff/dogman
    event.dataTransfer.setData('parent', parent);
    // black-block.png
    event.dataTransfer.setData('fileName', name);
    // file
    event.dataTransfer.setData('location', location);
    event.dataTransfer.setData('type', type)



})

table.addEventListener('dragenter', event => {
    event.preventDefault();
})
table.addEventListener('dragover', event => {
    event.preventDefault();
    event.target.style.backgroundColor = "lightgray";
})
table.addEventListener('dragleave', event => {
    event.preventDefault();
    event.target.style.backgroundColor = "";
})
table.addEventListener('drop', async (event) => {
    event.target.style.backgroundColor = "";
    let tr = event.target.closest('tr');
    // data about file that is being moved
    const currentLocation = event.dataTransfer.getData('location');
    const fileName = event.dataTransfer.getData('fileName');
    const parentDir = event.dataTransfer.getData('parent')
    const type = event.dataTransfer.getData('type')
    // info about target area
    const targetType = tr.getAttribute('data-type');
    const targetLocation = tr.getAttribute('data-src');
    const targetParent = tr.getAttribute('data-parent');
    let postObj = {
        targetType,
        targetLocation,
        currentLocation,
        fileName,
        parentDir,
        type,
        targetParent
    }



    let request = await fetch(`../process-movement.php`, {
        method: 'POST',
        headers: {
            "Content-Type": 'text/xml'
        },
        body: JSON.stringify(postObj)
    })

    let response = await request.json();

    if (response.ok) {
        let { success, newLocation } = response
            let insertRow = document.querySelector(`tr[data-location="${response.newLocation}"]`)
            let margin = (insertRow.style.marginLeft == '') ? 0 : parseInt(insertRow.style.marginLeft.replace('px'));
            insertRow.insertAdjacentHTML('afterend', response.row);
            let selectedRow = document.getElementById('selected-row')
            selectedRow.remove();
            // let cloneSelectedRow = selectedRow.cloneNode(true);
            // console.log(cloneSelectedRow);
            // sele.removeAttribute('id');
            // cloneSelectedRow.querySelector('div.stuff-items').style.marginLeft = `${margin + 30}px`;
            // row.insertBefore(cloneSelectedRow, row.nextSibling);
            // selectedRow.remove();
    }



})

// Events 
uploadButton.addEventListener('click', () => {

    uploadModal.classList.remove('hidden');
})

fileButton.addEventListener('click', () => {

    fileModal.classList.remove('hidden');
    itemForm['file-name'].focus();
})

folderButton.addEventListener('click', () => {

    folderModal.classList.remove('hidden');
    folderForm['folder-name'].focus();
})




let cancelButtons = document.getElementsByName('cancel-button');
cancelButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        let modals = document.querySelectorAll('div.bg-modal')
        let modalStyles = Array.from(modals).map((x) => {
            return {
                style: x.classList.add('hidden'),
                button: x
            }
        });
        modalStyles.map(x => {
            if (x['style']) {
                x['button'].classList.remove('show')
            }
        })
    })
})

