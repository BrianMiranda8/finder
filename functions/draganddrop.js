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
    let path = tr.querySelector('div div:nth-child(3) a').href;
    tr.id = 'selected-row';

    const fileUrl = new URL(path);

    let fileName = tr.querySelector('div div:nth-child(3) a').innerText;
    let currentDirectory = fileUrl.searchParams.get('target');
    let type = fileUrl.searchParams.get('view');

    // /stuff/dogman
    event.dataTransfer.setData('parent', currentDirectory);
    // black-block.png
    event.dataTransfer.setData('fileName', fileName);
    // file
    event.dataTransfer.setData('type', type);



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
    const oldLocation = event.dataTransfer.getData('parent');
    const fileName = event.dataTransfer.getData('fileName');
    const encodedUrl = encodeURIComponent(tr.querySelector('a').href)
    const toURL = new URL(encodedUrl);

    const newDirectory = toURL.searchParams.get('target');

    const targetType = toURL.searchParams.get('view')

    let postObj = {
        parent: oldLocation,
        fileName: fileName,
        newDir: newDirectory
    }
    switch (targetType) {
        case "folder":

            let request = await fetch(`../process-movement.php`, {
                method: 'POST',
                headers: {
                    "Content-Type": 'text/xml'
                },
                body: JSON.stringify(postObj)
            })

            let response = await request.json();

            if (response) {
                let { success, newLocation } = response
                console.log(success, newLocation);
                if (success) {

                    let row = event.target.closest('tr');
                    let margin = (row.style.marginLeft == '') ? 0 : parseInt(row.style.marginLeft.replace('px'));
                    // let row = dir.parentElement.parentElement;
                    let selectedRow = document.getElementById('selected-row')
                    console.log(dir);
                    let cloneSelectedRow = selectedRow.cloneNode(true);
                    console.log(cloneSelectedRow);
                    cloneSelectedRow.removeAttribute('id');
                    cloneSelectedRow.querySelector('div.stuff-items').style.marginLeft = `${margin + 30}px`;
                    row.insertBefore(cloneSelectedRow, row.nextSibling);
                    selectedRow.remove();
                } else {
                    console.log(response);
                }
            }
            break;

        default:
            // alert(`You are trying to move a ${fromFolder} into a ${dropFileFolderType}`)
            break;
    }



})

// Events 
uploadButton.addEventListener('click', () => {
    let content = uploadModal.querySelector('div.file-modal');


    uploadModal.classList.remove('hidden');
})

fileButton.addEventListener('click', () => {
    let content = fileModal.querySelector('div.file-modal');

    fileModal.classList.remove('hidden');
    itemForm['file-name'].focus();
})

folderButton.addEventListener('click', () => {
    let content = folderModal.querySelector('div.file-modal');


    folderModal.classList.remove('hidden');
    folderForm['folder-name'].focus();
})

function getElementTag(event) {
    let target = event.target
    let targetName = target.tagName;

    let returnLink;
    switch (targetName) {
        case "TR":
            returnLink = target.querySelector('td div div:nth-child(3) a').href
            break;
        case "A":
            returnLink = target.href;
            break
        case "IMG":
            returnLink = target.parentElement.parentElement.parentElement.querySelector('div:nth-child(3) a').href;
            break
        case "TD":
            returnLink = event.target.querySelector('div div:nth-child(3) a').href;
            break;
        case "DIV":
            returnLink = target.querySelector('div:nth-child(3) a').href
            break;
    }
    return returnLink
}

function getElementName(event) {
    let target = event.target
    let targetName = target.tagName;

    let returnLink;
    switch (targetName) {
        case "TR":
            returnLink = target.querySelector('td div div:nth-child(3) a').innerText
            break;
        case "A":
            returnLink = target.innerText;
            break
        case "IMG":
            returnLink = target.parentElement.parentElement.parentElement.querySelector('div:nth-child(3) a').innerText;
            break
        case "TD":
            returnLink = event.target.querySelector('div div:nth-child(3) a').href;
            break;
    }

    return returnLink
}

Array.from(draggableRows).forEach(row => {


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

function getRootTr(event) {
    let target = event.target
    let targetName = event.target.tagName;

    let returnLink;
    switch (targetName) {
        case "TR":
            returnLink = target.querySelector('div.stuf-items')
            break;
        case "A":
            returnLink = target.parentElement.parentElement
            break
        case "IMG":
            returnLink = target.parentElement.parentElement
            break
        case "TD":
            returnLink = target.children[0];
            break;
        case "DIV":
            returnLink = target
            break;
    }

    return returnLink
}
