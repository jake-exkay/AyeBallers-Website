<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Event - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";

            updatePageViews($connection, 'event_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php include "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <center>
                        <br>
                        <b><h1 class="ayeballers_font">Next Event:</h1></b>
                        <center>
                            <h3 class="ayeballers_font">TBA</h3>
                        </center>
                                
                        <br><br>
                        
                        <p>Previous Events</p>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <form action="https://hypixel.net/threads/paintball-tournament-official-community-tournament-win-real-money.2831526/">
                                    <button type="submit" class="btn btn-primary">Paintball Tournament #1</button>
                                </form>
                            </div>
                            <div class="col-md-6 text-center">
                                <form action="event/archive/pb2.php">
                                    <button type="submit" class="btn btn-primary">Paintball Tournament #2</button>
                                </form>
                            </div>
                        </div>

                    </center>

                   
                </main>

                <?php include "includes/footer.php"; ?>

            </div>

    </body>
</html>
