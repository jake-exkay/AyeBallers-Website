<?php
/**
 * Player page - Allows for searching for specific guilds.
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

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Guild Search - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

        <div id="layoutSidenav_content">

            <main style="padding-right: 475px; padding-left: 475px; padding-top: 150px">

                <div class="card">
                    <div class="card-body">

                        <form class="form-signin" name="guildForm" action="guild.php" method="GET" enctype="multipart/form-data">

                            <div class="form-label-group">
                                <center>
                                    <img alt="AyeBallers Logo" src="assets/img/ayeballers.png" height="150" width="auto" />
                                </center>

                                <br>

                                <center>
                                    <h3 class="ayeballers_font">Hypixel Guild Search</h3>
                                </center>

                                <br>

                                <input type="text" class="form-control" name="guild" placeholder="Guild Name" required>
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
