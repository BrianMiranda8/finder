<!--This include is used for simplefinder only-->

<div id="search-bar" style="float:right;padding:8px 7px 7px 7px;">
    <datalist id="suggestions"></datalist>
    <form action="index.php">

        <input type="text" name="keyword" style="width:80%;" list="suggestions">
        <input type="hidden" name="view" value="search">
        <input type="hidden" name="search" value="<?php echo $_HomePage; ?>">

        <input class="clearButton" view="search" type="submit" name="submit" value="Submit">
    </form>
</div>

<script type="module">
    const searchBar = document.querySelector('#search-bar')
    const form = searchBar.querySelector('form');
    const search = form.querySelector('input[name="search-box"]')
    const mainTable = document.querySelector('#main-table');
    let delayTimer = null;

    // form.addEventListener('submit', async (event) => {
    //     event.preventDefault();
    //     let api = new URL(window.location.href);
    //     api.pathname = '/stuff/.policy-code/api/search.php';
    //     if (search.value.includes('/')) {
    //         return;
    //     }

    //     let query = {
    //         query: search.value,
    //         base: search.innerText
    //     };
    //     let dir = (!api.searchParams.has('target')) ? '/stuff' : api.searchParams.get('target')
    //     api.searchParams.append('query', search.value);
    //     api.searchParams.append('dir', dir);
    //     let request = await fetch(api, {
    //         headers: {
    //             "Content-Type": "text/html",
    //         },
    //     })

    //     let response = await request.json();
    //     if (!response.ok) return

    //     mainTable.innerHTML = response.body;
    // })

    /*
        search.addEventListener("input", async (event) => {
            let search = event.target.value;

            if (search == '') return;

            if (delayTimer) {
                clearTimeout(delayTimer);
            }

            delayTimer = setTimeout(async () => {
                let request = await fetch("./.policy-code/api/search.php?query=" + search + "&dir=/stuff", {
                    headers: {
                        "Content-Type": "Application/json",
                    },
                });
                const datalist = document.querySelector('datalist#suggestions');

                datalist.innerHTML = '';
                let response = await request.json();

                if (!response.ok) throw new Error(response.error)

                response.body.forEach(sug => {
                    const option = document.createElement('option');
                    option.value = sug.path;
                    option.innerText = sug.basename
                    datalist.appendChild(option);
                });
            }, 650);
        })
        */
</script>