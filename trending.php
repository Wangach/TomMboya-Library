<?php
// Connect to the database (replace with your database connection code)
$conn = mysqli_connect('localhost', 'root', '', 'tommboyalibrary');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the serial number from the query parameter
$serialnumber = $_POST['serialnumber'];

// Query the database to get the PDF location and book name for the book
$sql = "SELECT booklocation, name FROM `trendingbooks` WHERE serialnumber = '$serialnumber'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// Retrieve the PDF location and book name
$pdfLocation = $row['booklocation'];
$bookName = $row['name'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--Font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <!--Unicons link-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!---aos link stylesheet-->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!--Awesome font kit-->
    <script src="https://kit.fontawesome.com/caea6e076b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Read - <?php echo $bookName; ?></title>
</head>

<body>
    <div class="top-bar">
        <button class="btn" id="prev-page">
            <i class="fas fa-arrow-circle-left"></i> Prev Page
        </button>
        <button class="btn" id="next-page">
            Next Page <i class="fas fa-arrow-circle-right"></i>
        </button>
        <span class="page-info">
            Page <span id="page-num"></span> of <span id="page-count"></span>
        </span>
        <div class="fullscreen-button">
            <button id="fullscreen-toggle">
                <i class="fas fa-expand"></i> Full Screen
            </button>
        </div>

    </div>

    <canvas id="pdf-render"></canvas>

    <script src="pdf.js-master/build/pdf.js"></script>
    <script>
        // Set the worker source for PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'pdf.js-master/build/pdf.worker.js';
        const pdfLocation = '<?php echo $pdfLocation; ?>'; // Retrieve PDF location from PHP
        const url = pdfLocation;

        let pdfDoc = null,
            pageNum = 1,
            pageIsRendering = false,
            pageNumIsPending = null;

        const scale = 1,
            canvas = document.querySelector('#pdf-render'),
            ctx = canvas.getContext('2d');

        // Render the page
        const renderPage = num => {
            pageIsRendering = true;

            // Get page
            pdfDoc.getPage(num).then(page => {
                // Set scale
                const viewport = page.getViewport({
                    scale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderCtx = {
                    canvasContext: ctx,
                    viewport
                };

                page.render(renderCtx).promise.then(() => {
                    pageIsRendering = false;

                    if (pageNumIsPending !== null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });

                // Output current page
                document.querySelector('#page-num').textContent = num;
            });
        };

        // Check for pages rendering
        const queueRenderPage = num => {
            if (pageIsRendering) {
                pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        };

        // Show Prev Page
        const showPrevPage = () => {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        };

        // Show Next Page
        const showNextPage = () => {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        };

        // Get Document
        pdfjsLib
            .getDocument(url)
            .promise.then(pdfDoc_ => {
                pdfDoc = pdfDoc_;

                document.querySelector('#page-count').textContent = pdfDoc.numPages;

                renderPage(pageNum);
            })
            .catch(err => {
                // Display error
                const div = document.createElement('div');
                div.className = 'error';
                div.appendChild(document.createTextNode(err.message));
                document.querySelector('body').insertBefore(div, canvas);
                // Remove top bar
                document.querySelector('.top-bar').style.display = 'none';
            });

        // Button Events
        document.querySelector('#prev-page').addEventListener('click', showPrevPage);
        document.querySelector('#next-page').addEventListener('click', showNextPage);
    </script>
    <script>
        // JavaScript for toggling full-screen mode
        const fullscreenButton = document.getElementById('fullscreen-toggle');

        fullscreenButton.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                // Enter full-screen mode
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                }
            } else {
                // Exit full-screen mode
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        });
    </script>
</body>

</html>