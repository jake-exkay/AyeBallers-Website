<?php
/**
 * Quakecraft Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/quakecraft.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/functions.php";
include "../../functions/player_functions.php";
include "../../functions/display_functions.php";
include "../../functions/database/query_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'quake_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Quakecraft</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Quakecraft Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Quakecraft
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
                                                <th>Deaths</th>
                                                <th>Shots Fired</th>
                                                <th>Killstreaks</th>
                                                <th>Headshots</th>
                                                <th>Distance Travelled</th>
                                                <th>Highest Killstreak</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallQuakeLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $coins = $player->quakecraft->coins;
                                                $kills = $player->quakecraft->soloKills;
                                                $deaths_quake = $player->quakecraft->soloDeaths;
                                                $wins_quake = $player->quakecraft->soloWins;
                                                $killstreaks_quake = $player->quakecraft->soloKillstreaks;
                                                $kills_teams_quake = $player->quakecraft->teamKills;
                                                $deaths_teams_quake = $player->quakecraft->teamDeaths;
                                                $wins_teams_quake = $player->quakecraft->teamWins;
                                                $killstreaks_teams_quake = $player->quakecraft->teamKillstreaks;
                                                $highest_killstreak_quake = $player->quakecraft->highestKillstreak;
                                                $shots_fired_teams_quake = $player->quakecraft->teamShotsFired;
                                                $headshots_teams_quake = $player->quakecraft->teamHeadshots;
                                                $headshots_quake = $player->quakecraft->soloHeadshots;
                                                $shots_fired_quake = $player->quakecraft->soloShotsFired;
                                                $distance_travelled_quake = $player->quakecraft->soloDistanceTravelled;
                                                $distance_travelled_teams_quake = $player->quakecraft->teamDistanceTravelled;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                if ($kills == 0 && $kills_teams_quake == 0) {
                                                    $kd = 0;
                                                    $sk = 0;
                                                } else {
                                                    $kd = ($kills + $kills_teams_quake) / ($deaths_quake + $deaths_teams_quake);
                                                    $sk = ($shots_fired_quake + $shots_fired_teams_quake) / ($kills + $kills_teams_quake);

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
                                                    echo '<td>' . number_format($kills + $kills_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($wins_quake + $wins_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($deaths_quake + $deaths_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($shots_fired_quake + $shots_fired_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($killstreaks_quake + $killstreaks_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($headshots_quake + $headshots_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($distance_travelled_quake + $distance_travelled_teams_quake) . '</td>';
                                                    echo '<td>' . number_format($highest_killstreak_quake) . '</td>';

                                                    if ($kd > 5) {
                                                        echo '<td class="table-success">' . $kd . '</td>';
                                                    } else if ($kd > 2 && $kd < 5) {
                                                        echo '<td class="table-warning">' . $kd . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $kd . '</td>';
                                                    }

                                                    if ($sk < 1) {
                                                        echo '<td class="table-success">' . $sk . '</td>';
                                                    } else if ($sk > 1 && $sk < 1.5) {
                                                        echo '<td class="table-warning">' . $sk . '</td>';
                                                    } else {
                                                        echo '<td class="table-danger">' . $sk . '</td>';
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
