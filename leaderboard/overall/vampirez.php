<?php
/**
 * VampireZ Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/vampirez.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'vz_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - VampireZ</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">VampireZ Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - VampireZ
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Human Wins)</th>
                                                <th>Name</th>
                                                <th>Human Wins</th>
                                                <th>Vampire Wins</th>
                                                <th>Coins</th>
                                                <th>Vampire Kills</th>
                                                <th>Human Kills</th>
                                                <th>Gold Bought</th>
                                                <th>Zombie Kills</th>
                                                <th>Most Vampire Kills</th>
                                                <th>Human Deaths</th>
                                                <th>Vampire Deaths</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallVampirezLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $coins = $player->vampirez->coins;
                                                $human_wins = $player->vampirez->asHuman->humanWins;
                                                $vampire_wins = $player->vampirez->asVampire->vampireWins;
                                                $vampire_kills = $player->vampirez->asHuman->vampireKills;
                                                $human_kills = $player->vampirez->asVampire->humanKills;
                                                $gold_bought = $player->vampirez->asHuman->goldBought;
                                                $zombie_kills = $player->vampirez->asHuman->zombieKills;
                                                $most_vampire_kills = $player->vampirez->asHuman->mostVampireKills;
                                                $human_deaths = $player->vampirez->asHuman->humanDeaths;
                                                $vampire_deaths = $player->vampirez->asVampire->vampireDeaths;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($human_wins) . '</td>';
                                                    echo '<td>' . number_format($vampire_wins) . '</td>';
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($vampire_kills) . '</td>';
                                                    echo '<td>' . number_format($human_kills) . '</td>';
                                                    echo '<td>' . number_format($gold_bought) . '</td>';
                                                    echo '<td>' . number_format($zombie_kills) . '</td>';
                                                    echo '<td>' . number_format($most_vampire_kills) . '</td>';
                                                    echo '<td>' . number_format($human_deaths) . '</td>';
                                                    echo '<td>' . number_format($vampire_deaths) . '</td>';

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
