const fileButton = document.getElementById('file-button');
const folderButton = document.getElementById('folder-button');
const folderModal = document.getElementById('folder-modal');
const uploadModal = document.getElementById('upload-modal');
const fileModal = document.getElementById('file-modal');
const draggableRows = document.querySelectorAll('tr')
const uploadButton = document.getElementById("upload-files-button");
const itemForm = document.getElementById("newItemForm");
const folderForm = document.getElementById("newFolderForm");
console.log(itemForm);
// Events 
uploadButton.addEventListener('click', () => {
    let content = uploadModal.querySelector('div.file-modal');

    //content.classList.add('open')
    //uploadModal.classList.add('show');
    uploadModal.classList.remove('hidden');
})

fileButton.addEventListener('click', () => {
    let content = fileModal.querySelector('div.file-modal');
    //fileModal.classList.add('show');
   //content.classList.add('open');
  fileModal.classList.remove('hidden');
  itemForm['file-name'].focus();
})

folderButton.addEventListener('click', () => {
    let content = folderModal.querySelector('div.file-modal');

    //content.classList.add('open')
   // folderModal.classList.add('show');
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

    row.addEventListener('dragstart', (event) => {
        // getting info about the current file/folder we want to move

        const tagHref = getElementTag(event);
        const fileUrl = new URL(tagHref);
        let elementName = getElementName(event);
        let currentDirectory = fileUrl.searchParams.get('target');
        getRootTr(event).parentElement.parentElement.id = 'selected-row';
        let elementType = fileUrl.searchParams.get('view');
        event.dataTransfer.setData('currentDir', currentDirectory);
        event.dataTransfer.setData('fileType', elementType);
        event.dataTransfer.setData('fileName', elementName);
        event.dataTransfer.setData('fromURl', tagHref)


    })
    row.addEventListener('dragenter', event => {
        event.preventDefault();
    })
    row.addEventListener('dragover', event => {
        event.preventDefault();
        event.target.style.backgroundColor = "lightgray";
    })
    row.addEventListener('dragleave', event => {
        event.preventDefault();
        event.target.style.backgroundColor = "";
    })
    row.addEventListener('drop', (event) => {
		        event.target.style.backgroundColor = "";

        const directoryThatFromFilesLivesIn = event.dataTransfer.getData('currentDir');
        const fromName = event.dataTransfer.getData('fileName');

        const toURL = getElementTag(event);
        const toDirectoryPath = new URL(toURL).searchParams.get('target');

        const toType = new URL(getElementTag(event)).searchParams.get('view')

        switch (toType) {
            case "folder":
                postObj = {
                    currentDirectory: directoryThatFromFilesLivesIn,
                    fromName: fromName,
                    toDirectory: toDirectoryPath
                }
                fetch(`../process-movement.php`, {
                    method: 'POST',
                    headers: {
                        "Content-Type": 'text/xml'
                    },
                    body: JSON.stringify(postObj)
                }).then(data => {
                    return data.json();
                }).then(response => {
                    let { success, newLocation } = response
                    console.log(success, newLocation);
                    if (success) {

                        let dir = getRootTr(event);
                        let margin = (dir.style.marginLeft == '') ? 0 : parseInt(dir.style.marginLeft.replace('px'));
                        let row = dir.parentElement.parentElement;
                        let selectedRow = document.getElementById('selected-row')
                        console.log(dir);
                        let cloneSelectedRow = selectedRow.cloneNode(true);
                        console.log(cloneSelectedRow);
                        cloneSelectedRow.removeAttribute('id');
                        cloneSelectedRow.querySelector('div.stuff-items').style.marginLeft = `${margin + 30}px`;
                        row.parentNode.insertBefore(cloneSelectedRow, row.nextSibling);
                        selectedRow.remove();
                    } else {
                        console.log(response);
                    }
                })
                break;

            default:
                // alert(`You are trying to move a ${fromFolder} into a ${dropFileFolderType}`)
                break;
        }



    })
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
