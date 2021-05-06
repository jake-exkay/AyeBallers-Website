<?php
/**
 * Arena Brawl Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/arena.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'arena_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Arena Brawl</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Arena Brawl Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Arena Brawl
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Rating)</th>
                                                <th>Name</th>
                                                <th>Rating</th>
                                                <th>Coins</th>
                                                <th>Coins Spent</th>
                                                <th>Keys Used</th>
                                                <th>Damage (All Modes)</th>
                                                <th>Kills (All Modes)</th>
                                                <th>Wins (All Modes)</th>
                                                <th>Losses (All Modes)</th>
                                                <th>Healing (All Modes)</th>
                                                <th>Games Played (All Modes)</th>
                                                <th>Deaths (All Modes)</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallArenaLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $rating = $player->arena->rating;
                                                $coins = $player->arena->coins;
                                                $coins_spent = $player->arena->coinsSpent;
                                                $keys = $player->arena->keys;
                                                $damage_1 = $player->arena->ones->damage;
                                                $damage_2 = $player->arena->twos->damage;
                                                $damage_4 = $player->arena->fours->damage;
                                                $healing_1 = $player->arena->ones->healed;
                                                $healing_2 = $player->arena->twos->healed;
                                                $healing_4 = $player->arena->fours->healed;
                                                $wins_1 = $player->arena->ones->wins;
                                                $wins_2 = $player->arena->twos->wins;
                                                $wins_4 = $player->arena->fours->wins;
                                                $kills_1 = $player->arena->ones->damage;
                                                $kills_2 = $player->arena->twos->kills;
                                                $kills_4 = $player->arena->fours->kills;
                                                $losses_1 = $player->arena->ones->losses;
                                                $losses_2 = $player->arena->twos->losses;
                                                $losses_4 = $player->arena->fours->losses;
                                                $games_1 = $player->arena->ones->games;
                                                $games_2 = $player->arena->twos->games;
                                                $games_4 = $player->arena->fours->games;
                                                $deaths_1 = $player->arena->ones->deaths;
                                                $deaths_2 = $player->arena->twos->deaths;
                                                $deaths_4 = $player->arena->fours->deaths;
                                                $damage = $damage_1 + $damage_2 + $damage_4;
                                                $healing = $healing_1 + $healing_2 + $healing_4;
                                                $wins = $wins_1 + $wins_2 + $wins_4;
                                                $kills = $kills_1 + $kills_2 + $kills_4;
                                                $losses = $losses_1 + $losses_2 + $losses_4;
                                                $games = $games_1 + $games_2 + $games_4;
                                                $deaths = $deaths_1 + $deaths_2 + $deaths_4;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($rating) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($coins_spent) . '</td>';
                                                    echo '<td>' . number_format($keys) . '</td>';
                                                    echo '<td>' . number_format($damage) . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($losses) . '</td>';
                                                    echo '<td>' . number_format($healing) . '</td>';
                                                    echo '<td>' . number_format($games) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    
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
