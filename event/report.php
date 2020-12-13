<?php
/**
 * Report page - Allows reporting for using banned hats.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/event/leaderboard.php
 */

require "../includes/links.php";
require "../functions/functions.php";
require "../functions/player_functions.php";
require "event_functions.php";
require "../includes/connect.php";
include "../admin/functions/login_functions.php";

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Paintball Tournament - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php include "../includes/connect.php"; ?>

        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <center>
                            <b><h1 class="mt-4">Report NoxyD/Rezzus User</h1></b>
                            <p>Due to a high amount of requests, the <b>NoxyD</b> and <b>Rezzus</b> hats are banned for tournament participants. As there is no real way of enforcing these rules, players can report other players if they are seen using these hats. Please upload a screenshot below and it will be reviewed. Players using these hats may be removed from the tournament.</p>
                            <p>Please note: all reports are anonymous, please upload a full minecraft screenshot, cropped images will not be taken into account.</p>

                            <br><br>
                        
                            <p><a href="leaderboard.php">Back To Leaderboard</a></p>

                        </center>
                        
                        <br>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Report Player
                            </div>
                            <div class="card-body">
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    Select image to upload:
                                    <input type="file" name="uploadedFile" id="uploadedFile">
                                    <input type="submit" value="Upload Image" name="submit">
                                </form>
                            </div>
                        </div>

                    </div>
                </main>

                <?php require "../includes/footer.php"; ?>

            </div>
    </body>
</html>
