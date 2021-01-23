<?php
/**
 * Player page - Allows for searching for specific players.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/player.php
 */

require "includes/links.php";
require "functions/functions.php";
include "admin/functions/login_functions.php";

updatePageViews($connection, 'home_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Guild Search - AyeBallers</title>
    </head>

    <body style="background-image: url('assets/img/background-2.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;" class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

        <div id="layoutSidenav_content">

            <main style="padding-right: 25%; padding-left: 25%; padding-top: 100px">

                <div style="background-color:#FFF;; opacity: 0.8; filter:(opacity=50);" class="card">
                    <div class="card-body">

                        <form class="form-signin" name="playerForm" action="stats.php" method="GET" enctype="multipart/form-data">

                            <div class="form-label-group">
                                <center>
                                    <img alt="AyeBallers Logo" src="assets/img/ayeballers.png" height="150" width="auto" />
                                </center>

                                <br>

                                <center>
                                    <h3 class="ayeballers_font">Hypixel Player Search</h3>
                                </center>

                                <br>

                                <input type="text" class="form-control" name="player" placeholder="Player Name" required>
                            </div> 

                            <br>

                            <center>
                                <button type="submit" class="btn btn-lg btn-primary">Search</button>
                            </center>

                        </form>
                    </div>
                </div>

            </main>
            
            <?php require "includes/footer.php"; ?>

        </div>

    </body>
</html>