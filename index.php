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
require "includes/connect.php";
require "functions/functions.php";
include "admin/functions/login_functions.php";

updatePageViews($connection, 'home_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Home - AyeBallers</title>
    </head>

    <body>

        <img alt="Website Header" src="assets/img/web-header.png" height=auto width=100% />

        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #0B2027;">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-inner" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php" style="color:white;">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="player.php" style="color:white;">Player Statistics</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="guildsearch.php" style="color:white;">Guild Statistics</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" style="color:white;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Leaderboards
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="leaderboard/overall/paintball.php">Paintball</a>
                  <a class="dropdown-item" href="leaderboard/overall/quakecraft.php">Quakecraft</a>
                  <a class="dropdown-item" href="leaderboard/overall/tkr.php">Turbo Kart Racers</a>
                  <a class="dropdown-item" href="leaderboard/overall/vampirez.php">VampireZ</a>
                  <a class="dropdown-item" href="leaderboard/overall/arena.php">Arena Brawl</a>
                  <a class="dropdown-item" href="leaderboard/overall/walls.php">The Walls</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="leaderboard/overall/arcade.php">Arcade</a>
                  <a class="dropdown-item" href="leaderboard/overall/copsandcrims.php">Cops and Crims</a>
                  <a class="dropdown-item" href="leaderboard/overall/tntgames.php">TNT Games</a>
                  <a class="dropdown-item" href="leaderboard/overall/uhc.php">UHC</a>
                  <a class="dropdown-item" href="leaderboard/overall/warlords.php">Warlords</a>
                  <a class="dropdown-item" href="leaderboard/overall/skywars.php">Skywars</a>
                  <a class="dropdown-item" href="leaderboard/overall/bedwars.php">Bedwars</a>
                </div>
              </li>
                <li class="nav-item">
                <a class="nav-link" style="color:white;" href="event/leaderboard.php">Event</a>
              </li>
            </ul>
            
          </div>
        </nav>

        <div id="layoutSidenav_content">

            <main style="padding-right: 5%; padding-left: 5%; padding-top: 50px">

                <div class="row">
                    <div class="col-md-9">
                    	<div style="background-color:#FFF;; opacity: 0.8; filter:(opacity=50);" class="card">
                			<div class="card-body">

                                    <center>
                                        <h3 class="ayeballers_font">New home design WIP, please use the navigation bar to access the main site.</h3>
                        			</center>

                                    <br>
        		            </div>
        		        </div>
                    </div>

                    <div class="col-md-3">

                        <div style="background-color:#FFF;; opacity: 0.8; filter:(opacity=50);" class="card">
                            <div class="card-body">

                                    <center>
                                        <h3 class="ayeballers_font">New home design WIP, please use the navigation bar to access the main site.</h3>
                                    </center>

                                    <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </div>

        	</main>

            <br>
            
            <?php require "includes/footer.php"; ?>

        </div>

    </body>
</html>
