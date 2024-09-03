<!doctype html>
<html lang="en">

<head>
    <title>Typescript Example - Getting Started - Quick Start Example</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style media="only screen">
        :root,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            box-sizing: border-box;
            -webkit-overflow-scrolling: touch;
        }

        html {
            position: absolute;
            top: 0;
            left: 0;
            padding: 0;
            overflow: auto;
            font-family: -apple-system, "system-ui", "Segoe UI", Roboto,
                "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif,
                "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
                "Noto Color Emoji";
        }

        body {
            padding: 16px;
            overflow: auto;
            background-color: transparent;
        }

        /* Hide codesandbox highlighter */
        body>#highlighter {
            display: none;
        }
    </style>
</head>

<body>
    <div id="myGrid" style="width: 100%; height: 100%" class="ag-theme-quartz"></div>
    <script>
        (function() {
            const appLocation = "";

            window.__basePath = appLocation;
        })();
    </script>
    <script>
        var appLocation = "";
        var boilerplatePath = "";
        var systemJsMap = {
            "@ag-grid-community/styles": "https://cdn.jsdelivr.net/npm/@ag-grid-community/styles@31.3.2",
            "ag-grid-charts-enterprise": "https://cdn.jsdelivr.net/npm/ag-grid-charts-enterprise@31.3.2/",
            "ag-grid-community": "https://cdn.jsdelivr.net/npm/ag-grid-community@31.3.2",
            "ag-grid-enterprise": "https://cdn.jsdelivr.net/npm/ag-grid-enterprise@31.3.2/",
        };
        var systemJsPaths = {
            "@ag-grid-community/client-side-row-model": "https://cdn.jsdelivr.net/npm/@ag-grid-community/client-side-row-model@31.3.2/dist/package/main.cjs.js",
            "@ag-grid-community/core": "https://cdn.jsdelivr.net/npm/@ag-grid-community/core@31.3.2/dist/package/main.cjs.js",
            "@ag-grid-community/csv-export": "https://cdn.jsdelivr.net/npm/@ag-grid-community/csv-export@31.3.2/dist/csv-export.cjs.min.js",
            "@ag-grid-community/infinite-row-model": "https://cdn.jsdelivr.net/npm/@ag-grid-community/infinite-row-model@31.3.2/dist/package/main.cjs.js",
            "ag-charts-community": "https://cdn.jsdelivr.net/npm/ag-charts-community/",
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/systemjs@0.19.47/dist/system.js"></script>
    <script src="systemjs.config.js"></script>
    <script>
        System.import("main.ts").catch(function(err) {
            console.error(err);
        });
    </script>
</body>

</html>