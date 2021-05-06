<?php
/**
 * Walls Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/walls.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'walls_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - The Walls</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">The Walls Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - The Walls
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
                                                <th>Coins</th>
                                                <th>Assists</th>
                                                <th>Deaths</th>
                                                <th>Losses</th>
                                                <th>K/D</th>
                                                <th>W/L</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallWallsLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $kills = $player->walls->kills;
                                                $wins = $player->walls->wins;
                                                $coins = $player->walls->coins;
                                                $deaths = $player->walls->deaths;
                                                $assists = $player->walls->assists;
                                                $losses = $player->walls->losses;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                if ($deaths == 0 || $losses == 0) {
                                                    $kd = 0;
                                                    $wl = 0;
                                                } else {
                                                    $kd = $kills / $deaths;
                                                    $wl = $wins / $losses;

                                                    $kd = round($kd, 2);
                                                    $wl = round($wl, 2);
                                                }

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($assists) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    echo '<td>' . number_format($losses) . '</td>';

                                                    if ($kd > 5) {
                                                        echo '<td class="table-success">' . $kd . '</td>';
                                                    } else if ($kd > 2 && $kd < 5) {
                                                        echo '<td class="table-warning">' . $kd . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $kd . '</td>';
                                                    }

                                                    if ($wl > 2) {
                                                        echo '<td class="table-success">' . $wl . '</td>';
                                                    } else if ($wl > 1 && $wl < 2) {
                                                        echo '<td class="table-warning">' . $wl . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $wl . '</td>';
                                                    }
                                                    
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
