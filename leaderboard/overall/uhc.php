<?php
/**
 * UHC Leaderboard - Solo
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/uhc.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'uhc_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - UHC Champions</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">UHC Champions Leaderboard</h1>
                        <div class="row">
                            <form style="padding-left: 10px">
                                <button class="btn btn-secondary" disabled>Solo</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/teams.php">
                                <button class="btn btn-primary">Teams</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/redvsblue.php">
                                <button class="btn btn-primary">Red vs Blue</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/nodiamonds.php">
                                <button class="btn btn-primary">No Diamonds</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/vanilladoubles.php">
                                <button class="btn btn-primary">Vanilla Doubles</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/brawl.php">
                                <button class="btn btn-primary">Brawl</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/solobrawl.php">
                                <button class="btn btn-primary">Solo Brawl</button><br>
                            </form>
                            <form style="padding-left: 10px" action="uhc/duobrawl.php">
                                <button class="btn btn-primary">Duo Brawl</button><br>
                            </form>
                        </div>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - UHC Champions (Solo)
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Score)</th>
                                                <th>Name</th>
                                                <th>Score</th>
                                                <th>Solo Kills</th>
                                                <th>Solo Wins</th>
                                                <th>Coins</th>
                                                <th>Solo Deaths</th>
                                                <th>Solo Heads Eaten</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallUhcLeaderboard($mongo_mng, "Solo");
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $kills = $player->uhc->solo->kills;
                                                $wins = $player->uhc->solo->wins;
                                                $coins = $player->uhc->coins;
                                                $score = $player->uhc->score;
                                                $deaths = $player->uhc->solo->deaths;
                                                $heads_eaten = $player->uhc->solo->headsEaten;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($score) . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    echo '<td>' . number_format($heads_eaten) . '</td>';

                                                echo '</tr>'; 
                                                $i = $i + 1;
                                                
                                            }

                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>

                <?php include "../../includes/footer.php"; ?>
                <script>
                    $(document).ready(function () {
                    $('#leaderboard').DataTable({
                    });
                    $('.dataTables_length').addClass('bs-select');
                    });
                </script>
                
            </div>
        </div>

    </body>
</html>
