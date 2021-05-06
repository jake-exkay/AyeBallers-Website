<?php
/**
 * Paintball Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/paintball.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/functions.php";
include "../../functions/player_functions.php";
include "../../functions/display_functions.php";
include "../../functions/database/query_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'paintball_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Paintball</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Paintball Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Paintball
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Kills)</th>
                                                <th>Name</th>
                                                <th>Kills</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>Shots Fired</th>
                                                <th>Deaths</th>
                                                <th>Forcefield Time</th>
                                                <th>Killstreaks</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                                <th>Hat</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallPaintballLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $kills = $player->paintball->kills;
                                                $wins = $player->paintball->wins;
                                                $coins = $player->paintball->coins;
                                                $deaths = $player->paintball->deaths;
                                                $shots_fired = $player->paintball->shotsFired;
                                                $hat = $player->paintball->hat;
                                                $ff_time = $player->paintball->forcefieldTime;
                                                $killstreaks = $player->paintball->killstreaks;
                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                if ($kills == 0) {
                                                    $kd = 0;
                                                    $sk = 0;
                                                } else {
                                                    $kd = $kills / $deaths;
                                                    $sk = $shots_fired / $kills;

                                                    $kd = round($kd, 2);
                                                    $sk = round($sk, 2);
                                                }

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (userInGuild($connection, $name)) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($shots_fired) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    echo '<td>' . gmdate("H:i:s", $ff_time) . '</td>';
                                                    echo '<td>' . number_format($killstreaks) . '</td>';

                                                    if ($kd > 3) {
                                                        echo '<td class="table-success">' . $kd . '</td>';
                                                    } else if ($kd > 1 && $kd < 3) {
                                                        echo '<td class="table-warning">' . $kd . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $kd . '</td>';
                                                    }

                                                    if ($sk < 30) {
                                                        echo '<td class="table-success">' . $sk . '</td>';
                                                    } else if ($sk > 30 && $sk < 45) {
                                                        echo '<td class="table-warning">' . $sk . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $sk . '</td>';
                                                    }

                                                    echo '<td>' . formatPaintballHat($hat) . '</td>';
                                                    
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
