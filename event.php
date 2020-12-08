<?php
/**
 * Event page - Page showing current and previous events.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/event.php
 */

require "includes/links.php";
require "includes/connect.php";
require "includes/constants.php";
require "functions/functions.php";
require "functions/display_functions.php";
include "admin/functions/login_functions.php";

updatePageViews($connection, 'event_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Event - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

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

                <?php require "includes/footer.php"; ?>

            </div>

    </body>
</html>
