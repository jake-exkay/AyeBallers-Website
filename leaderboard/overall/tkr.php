<?php
/**
 * Turbo Kart Racers Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/tkr.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'tkr_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Turbo Kart Racers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Turbo Kart Racers Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Turbo Kart Racers
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Trophies)</th>
                                                <th>Name</th>
                                                <th>Total Trophies</th>
                                                <th>Gold Trophies</th>
                                                <th>Silver Trophies</th>
                                                <th>Bronze Trophies</th>
                                                <th>Coins</th>
                                                <th>Laps Completed</th>
                                                <th>Coin Pickups</th>
                                                <th>Box Pickups</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallTkrLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $coins = $player->tkr->coins;
                                                $wins = $player->tkr->wins;
                                                $gold_trophy = $player->tkr->goldTrophy;
                                                $silver_trophy = $player->tkr->silverTrophy;
                                                $bronze_trophy = $player->tkr->bronzeTrophy;
                                                $laps_completed = $player->tkr->lapsCompleted;
                                                $box_pickups = $player->tkr->boxPickups;
                                                $coin_pickups = $player->tkr->coinPickups;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($gold_trophy) . '</td>';
                                                    echo '<td>' . number_format($silver_trophy) . '</td>';
                                                    echo '<td>' . number_format($bronze_trophy) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($laps_completed) . '</td>';
                                                    echo '<td>' . number_format($coin_pickups) . '</td>';
                                                    echo '<td>' . number_format($box_pickups) . '</td>';

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
