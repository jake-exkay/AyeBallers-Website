<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Guild - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";

            updatePageViews($connection, 'guild_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <center>
                        <h2 class="ayeballers_font">Guild Members</h2>
                    </center>

                </main>

            <?php include "includes/footer.php"; ?>

        </div>

    </body>
</html>
