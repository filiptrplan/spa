<?php


function owo_gib_router()
{
    static $routes = array(
        ''       => 'IndexHtmlPage',
        '/test'  => 'TestHTMLPage',
    );
    $path = $_SERVER['PATH_INFO'];
    $pageGen = $routes[$path];
    if ($pageGen ) {
        echo $pageGen();
    } else {
        echo '404 no page';
    }
}

owo_gib_router();

?>

<?php function TestHTMLPage() {
    ob_start(); ?>
    <html lang="en">
    <body><h1>Test php page</h1>
    </html>
    <?php
    return ob_get_clean();
} ?>

<?php function IndexHtmlPage() {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Degeneracy</title>
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
              integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
              crossorigin="anonymous" />
    </head>

    <body>
    <based-page data-url="/" data-title="Home | Degeneracy">
        <h1>index.html</h1>
        <button onclick="uwuRouter.SPA_navigate('/test1.html')">Goto TEST1</button>
        <button onclick="uwuRouter.SPA_navigate('/test2.html')">Goto TEST2</button>
        <button onclick="uwuRouter.SPA_navigate('/404')">crash and burn</button>
        <div id="main_title">
            <h1>Welcome you fucking autistic weeb.</h1>
            <button id="normal-button" onclick="onNormalButtonClick()">
                I am normal
            </button>
        </div>
        <footer>
            <a href="https://discord.gg/emdypGmzgn" class="kek">Join discord</a>
            <a href="https://discord.gg/emdypGmzgn">Join discord</a>
        </footer>
        <button id="down-arrow-landing"><span class="fas fa-arrow-down"></span></button>
    </based-page>
    <based-page data-url="/test1.html" data-title="Test 1| Degeneracy">
        <h1>test1.html</h1>
        <button onclick="uwuRouter.SPA_navigate('/')">Goto INDEX</button>
        <button onclick="uwuRouter.SPA_navigate('/test2.html')">Goto TEST2</button>
        <button onclick="uwuRouter.SPA_navigate('/404')">crash and burn</button>
    </based-page>
    <based-page data-url="/test2.html" data-title="Test 2 | Degeneracy">
        <h1>test2.html</h1>
        <form action="http://waifu-storage.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
            Key to upload:
            <input type="input"  name="key" value="filename" /><br />
            <input type="hidden" name="acl" value="public-read" />
            Content-Type:
            <input type="input"  name="Content-Type" value="image/jpeg" /><br />
            File:
            <input type="file"   name="file" /> <br/>
            <input type="submit" name="submit" value="Upload to Amazon S3" />
        </form>
        <button onclick="uwuRouter.SPA_navigate('/test1.html')">Goto TEST1</button>
        <button onclick="uwuRouter.SPA_navigate('/')">Goto INDEX</button>
        <button onclick="uwuRouter.SPA_navigate('/404')">crash and burn</button>
    </based-page>
    <based-page data-url="!FALLBACK"></based-page>
    <div id="main"></div>
    </body>
    <script>
        var Api
        (function () {
            Api = function () { }
            Api.prototype.get = function (path, callback) { return this.request('GET', path, null, callback); };
            Api.prototype.delete = function (path, callback) { return this.request('DELETE', path, null, callback); };
            Api.prototype.post = function (path, request, callback) { return this.request('POST', path, request, callback); };
            Api.prototype.put = function (path, request, callback) { return this.request('PUT', path, request, callback); };

            Api.prototype.request = function (method, url, request = null, callback) {
                if (!method || !url) return
                var xhr = new XMLHttpRequest();
                xhr.open(method, url)
                xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState !== 4) return

                    var respCode = xhr.status;
                    var respBody = xhr.responseText;

                    if (xhr.getResponseHeader('Content-Type') && xhr.getResponseHeader('Content-Type').indexOf('application/json') === 0) {
                        try {
                            respBody = JSON.parse(respBody);
                        } catch (e) { console.error(e) }
                    }
                    return callback(respBody, respCode, xhr.getAllResponseHeaders())
                }

                xhr.send()
            }
        })()
    </script>
    <script>
        var api = new Api()
        var hostUrl = window.location.origin

        class BasedPage extends HTMLElement {
            constructor() {
                super();
            }
        }

        var pages = {};

        class UwuRouter {
            constructor() {
                this.SPA_switch_to_shitty_history_mode();
                this.SPA_init_the_fucking_page();
                this.SPA_do_update_content_refresh_lol();
                window.addEventListener('popstate', this.SPA_do_update_content_refresh_lol);
            }

            SPA_init_the_fucking_page() {
                let elements = Array.from(document.querySelector('body').querySelectorAll('based-page'));
                elements.forEach(x => {
                    pages[x.dataset['url']] = {html:x.innerHTML,title:x.dataset['title']||'page'};
                    x.parentElement.removeChild(x); //b1g code 😎
                });

                if (pages['!FALLBACK'].html && pages['!FALLBACK'].title) return; // fallback/error page was defined in html
                pages['!FALLBACK'] = {html:`error`,title:'OH NO'};
            }
            SPA_switch_to_shitty_history_mode() {
                if (window.location.href.includes("#")) return;
                window.location.href = window.location.href + '#/';
            }
            SPA_do_update_content_refresh_lol() {
                if (!window.location.href.includes(hostUrl)) return;
                const path = window.location.href.split('#').filter((v, i, a) => i != 0).join('');
                document.querySelector('#main').innerHTML = pages[path]?.html || pages['!FALLBACK']?.html
                document.title = pages[path]?.title || pages['!FALLBACK'].title;
            }
            SPA_navigate(path) {
                window.location.href = `${window.location.href.split('#')[0]}#${path}`;
                this.SPA_do_update_content_refresh_lol();
            }
        }

        customElements.define('based-page', BasedPage);

        uwuRouter = new UwuRouter();



    </script>
    <script>
        function onNormalButtonClick() {
            alert("No you're fucking not.");
            window.location = "https://hanime.tv";
        }
        function redirectIfNeeded() {
            if (window.location.href.includes("#")) return;
            window.location.href = window.location.href + "#/";
        }
        function doRenderingPageContentStuff() {
            const path = window.location.href
                .split("#")
                .filter((v, i, a) => i != 0)
                .join("");

            console.log(`im @ ${path}`);
        }
        function spaRedirect(path) {
            window.location.href = `${window.location.href.split("#")[0]
            }#${path}`;
            doRenderingPageContentStuff();
        }

        redirectIfNeeded();
        doRenderingPageContentStuff();
        api.get('https://jsonplaceholder.typicode.com/todos/1', (response) => console.log(response))
    </script>

    <style>
        html,
        body {
            font-family: "Noto Sans", sans-serif;
            background-color: #303030;
            color: #f5f5f5;
            font-size: 1.25em;
        }

        button {
            font-family: "Noto Sans", sans-serif;
            background-color: transparent;
            border: 2px solid white;
            color: #f5f5f5;
            padding: 20px;
            font-size: 30px;
            border-radius: 20px;
            transition: all 0.2s;
        }

        button:hover {
            background-color: white;
            color: #303030;
        }

        button:focus {
            outline: none;
        }

        a {
            color: white;
            transition: all 0.2s;
        }

        a:hover {
            color: rgb(1, 85, 85);
        }

        #down-arrow-landing {
            margin-top: 100px;
            width: 100px;
            height: 100px;
            border-radius: 60px;
        }

        #main {
            height: 900px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #main_title {
            text-align: center;
            width: 100%;
            font-size: 3rem;
        }
        #container {
            display: none;
            background-image: linear-gradient(to right, #606060, #000000);
            background-size:cover;
            color: #303030;
            position: absolute;
            width: 150%;
            border-radius: 2px;
            left: 50%;
            padding: 16px 8px 8px;
            box-sizing: border-box;
        }
    </style>

    </html>
    <?php
    return ob_get_clean();
} ?>

<?php function favicon() {
    ob_start(); ?>

    <?php
    return ob_get_clean();
} ?>
