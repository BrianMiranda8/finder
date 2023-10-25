const CurrentUrl = new URL(window.location.href);
let currentTarget = CurrentUrl.searchParams.get("target");
let allNodes = Array.from(document.querySelectorAll("tr"));
const tipDownArrow = Array.from(document.querySelectorAll("div.arrow"));
const mainTable = document.querySelector("#main-table");

if (currentTarget == null) {
    currentTarget = ".";
}

mainTable.addEventListener("click", async (event) => {
    if (!event.target.classList.contains("arrow")) return;

    tip();

    let tr = event.target.closest("tr");

    let directoryPath = tr.getAttribute("data-location");
    if (!tr.getAttribute("data-set")) {
        await initOpening(tr, directoryPath);
        return;
    }
    displayContent(directoryPath, tr);
});

async function initOpening(tr, directoryPath) {
    await insertDirContent(directoryPath, tr);

    indentChildren(tr.querySelector("div"), directoryPath);
    tr.setAttribute("data-set", true);
}

async function insertDirContent(directoryPath, row) {
    let dirContent = await getContents(directoryPath.replace(".", ""));

    row.insertAdjacentHTML("afterend", dirContent);
}

function displayContent(path, parent) {
    let content = Array.from(document.querySelectorAll("#main-table tr[data-parent]"));

    let img = parent.querySelector("div.arrow");

    content.forEach((tr) => {
        let parent = tr.getAttribute("data-parent");
        if (!parent.includes(path)) return;

        if (img.classList.contains("closed-folder")) tr.classList.add("close-row");
        else tr.classList.remove("close-row");
    });
}

function tip() {
    let folder = event.target.parentElement.querySelector("a.folder-icon");

    if (event.target.classList.contains("closed-folder")) {
        event.target.classList.remove("closed-folder");
        event.target.classList.add("open-folder");
        folder.classList.add("open");
    } else if (event.target.classList.contains("open-folder")) {
        event.target.classList.remove("open-folder");
        event.target.classList.add("closed-folder");
        folder.classList.remove("open");
    }
}

function indentChildren(parent, directoryPath) {
    let content = Array.from(document.querySelectorAll(`[data-parent="${directoryPath}"]`));

    content.forEach((tr) => {
        let container = tr.querySelector("div.stuff-items");

        let dirMargin = parent.style.marginLeft == "" ? 0 : parseInt(parent.style.marginLeft.replace("px", ""));

        container.style.marginLeft = `${dirMargin + 30}px`;
    });
}
