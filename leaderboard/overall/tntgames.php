<?php
/**
 * TNT Games Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/tntgames.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/functions.php";
include "../../functions/player_functions.php";
include "../../functions/display_functions.php";
include "../../functions/database/query_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'tnt_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - TNT Games</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">TNT Games Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - TNT Games
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Wins)</th>
                                                <th>Name</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>TNT Run Wins</th>
                                                <th>Bow Spleef Wins</th>
                                                <th>TNT Tag Wins</th>
                                                <th>PVP Run Wins</th>
                                                <th>TNT Wizards Wins</th>
                                                <th>Winstreak</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallTntLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $wins = $player->tntgames->wins;
                                                $coins = $player->tntgames->coins;
                                                $tntrun_wins = $player->tntgames->tntrun->wins;
                                                $bowspleef_wins = $player->tntgames->bowspleef->wins;
                                                $tntag_wins = $player->tntgames->tntag->wins;
                                                $pvprun_wins = $player->tntgames->pvprun->wins;
                                                $wizards_wins = $player->tntgames->wizards->wins;
                                                $winstreak = $player->tntgames->winstreak;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (userInGuild($connection, $name)) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($tntrun_wins) . '</td>';
                                                    echo '<td>' . number_format($bowspleef_wins) . '</td>';
                                                    echo '<td>' . number_format($tntag_wins) . '</td>';
                                                    echo '<td>' . number_format($pvprun_wins) . '</td>';
                                                    echo '<td>' . number_format($wizards_wins) . '</td>';
                                                    echo '<td>' . number_format($winstreak) . '</td>';

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
