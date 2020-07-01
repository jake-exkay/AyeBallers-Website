<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/custom_styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Error - AyeBallers</title>

        <?php

            $previous = "javascript:history.go(-2)";
            if (isset($_SERVER['HTTP_REFERER'])) {
                $previous = $_SERVER['HTTP_REFERER'];
            }

        ?>

    </head>

    <body>
        <center>
            <b>
                <h1 style="padding-top: 400px; font-family: BKANT, sans-serif">Error</h1>
            </b>
            <h3 style="font-family: BKANT, sans-serif">The event has finished, please reset the database before starting another event.</h2>
            <h3>
                <a href="<?= $previous ?>">< Go Back</a>
            </h3>
        </center>
    </body>

</html>