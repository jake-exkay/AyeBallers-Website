<?php
/**
 * Cops and Crims Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/copsandcrims.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'copsandcrims_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Cops and Crims</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Cops and Crims Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Cops and Crims (Defusal)
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Wins)</th>
                                                <th>Name</th>
                                                <th>Wins</th>
                                                <th>Kills</th>
                                                <th>Headshots</th>
                                                <th>Shots Fired</th>
                                                <th>Deaths</th>
                                                <th>Bombs Planted</th>
                                                <th>Bombs Defused</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallCvcLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $kills = $player->copsandcrims->defusal->kills;
                                                $wins = $player->copsandcrims->defusal->gameWins;
                                                $shots_fired = $player->copsandcrims->defusal->shotsFired;
                                                $headshots = $player->copsandcrims->defusal->headshots;
                                                $deaths = $player->copsandcrims->defusal->deaths;
                                                $bombs_defused = $player->copsandcrims->defusal->bombsDefused;
                                                $bombs_planted = $player->copsandcrims->defusal->bombsPlanted;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($headshots) . '</td>';
                                                    echo '<td>' . number_format($shots_fired) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    echo '<td>' . number_format($bombs_planted) . '</td>';
                                                    echo '<td>' . number_format($bombs_defused) . '</td>';
                                                    
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
