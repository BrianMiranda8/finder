function api() {
    return new URL(window.location);
}

async function getContents(path, type = '') {
    let url = api();
    let pathName = url.pathname;
    url.pathname = '/policy-code/path-info.php'
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