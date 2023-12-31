function api() {
    return new URL(window.location);
}

async function getContents(path, type = '') {
    let url = api();
    let start = url.pathname.substring(0, url.pathname.lastIndexOf('/'))
    console.log(url.pathname.substring(0, 9));
    url.pathname = start + '/.policy-code/api/directory-info.php'
    url.searchParams.append('path', path);

    if (type != '')
        url.searchParams.append('type', type)

    let request = await fetch(url.href, {
        headers: {
            'Accept': "text/html"
        }
    });
    let response = await request.text();

    return response
}