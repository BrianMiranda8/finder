const CurrentUrl = new URL(window.location.href);
let currentTarget = CurrentUrl.searchParams.get('target');
let allNodes = Array.from(document.querySelectorAll('tr'));
let allDirs = Array.from(document.querySelectorAll('[data-type = "dir"]'));
const tipDownArrow = Array.from(document.querySelectorAll('div.arrow'));


if (currentTarget == null) {
    currentTarget = "."
}

allNodes.forEach(node => {
    let target = node.getAttribute('data-src');

    if (currentTarget != target) {
        node.classList.add('close-row')

    }
})

//loop through all directories and indent content
allDirs.forEach(dir => {
    let dirMargin = 0;
    let dirName = dir.parentElement.parentElement.getAttribute('data-location');
    if (dir.style.marginLeft != "") {
        dirMargin = parseInt(dir.style.marginLeft.replace("px", ""));
    }
    let dirContent = document.querySelectorAll(`[data-src = "${dirName}"] div.stuff-items`);

    dirContent.forEach(item => {
        item.style.marginLeft = `${dirMargin + 30}px`;
    })
})

tipDownArrow.forEach(arrow => {
    arrow.addEventListener('click', (e) => {
        e.preventDefault();
        tip(); //just chanes the arrow
        const imgUrl = new URL(e.target.parentElement.children[1].children[0].href);
        let imgTarget = imgUrl.searchParams.get('target');
        let targetFile = Array.from(document.querySelectorAll(`tr[data-src="${imgTarget}"]`));


        let openRows = Array.from(document.getElementsByClassName('open-row'))
            .filter((row) => {
                let rowSrc = row.getAttribute('data-src');
                if (rowSrc.includes(`${imgTarget}`)) {

                    return row
                }
                return false
            });

        targetFile.forEach(file => {

            if (file.classList.contains('close-row')) {
                file.classList.add('open-row')
                file.classList.remove('close-row')

            } else {
                file.classList.add('close-row');
                file.classList.remove('open-row');

            }
        })

        openRows.forEach(row => {
            let arrow;
            if (row.querySelector('div.stuff-items[data-type="dir"] div.arrow')) {
                arrow = row.querySelector('div.stuff-items[data-type="dir"] div.arrow');
                let folder = row.querySelector('div>a.folder-icon')
                folder.classList.remove('open')
                arrow.classList.remove('open-folder');
                arrow.classList.add('closed-folder');
            }
            row.classList.remove('open-row');
            row.classList.add('close-row')


        })

    })
})
function tip() {
    let folder = event.target.parentElement.querySelector('div>a.folder-icon')

    if (event.target.classList.contains('closed-folder')) {
        event.target.classList.remove('closed-folder');
        event.target.classList.add('open-folder');
        folder.classList.add('open')
    }
    else if (event.target.classList.contains('open-folder')) {
        event.target.classList.remove('open-folder');
        event.target.classList.add('closed-folder');
        folder.classList.remove('open')
    }
}
