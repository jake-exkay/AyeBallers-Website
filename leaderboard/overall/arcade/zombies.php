<?php
/**
 * Arcade Leaderboard - Zombies
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/arcade.php
 */

require "../../../includes/links.php";
include "../../../includes/connect.php";
include "../../../functions/backend_functions.php";
include "../../../functions/player_functions.php";
include "../../../functions/leaderboard_functions.php";
include "../../../admin/functions/login_functions.php";

updatePageViews($connection, 'arcade_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Arcade Leaderboard - Zombies</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Zombies Leaderboard</h1>
                        <div class="row">
                            <form style="padding-left: 10px" action="../arcade.php">
                                <button class="btn btn-primary">Overall</button><br>
                            </form>
                            <form style="padding-left: 10px" action="bountyhunters.php">
                                <button class="btn btn-primary">Bounty Hunters</button><br>
                            </form>
                            <form style="padding-left: 10px" action="throwout.php">
                                <button class="btn btn-primary">Throw Out</button><br>
                            </form>
                            <form style="padding-left: 10px" action="blockingdead.php">
                                <button class="btn btn-primary">Blocking Dead</button><br>
                            </form>
                            <form style="padding-left: 10px" action="dragonwars.php">
                                <button class="btn btn-primary">Dragon Wars</button><br>
                            </form>
                            <form style="padding-left: 10px" action="farmhunt.php">
                                <button class="btn btn-primary">Farm Hunt</button><br>
                            </form>
                            <form style="padding-left: 10px" action="enderspleef.php">
                                <button class="btn btn-primary">Ender Spleef</button><br>
                            </form>
                            <form style="padding-left: 10px" action="partygames.php">
                                <button class="btn btn-primary">Party Games</button><br>
                            </form>
                            <form style="padding-left: 10px" action="galaxywars.php">
                                <button class="btn btn-primary">Galaxy Wars</button><br>
                            </form>
                            <form style="padding-left: 10px" action="holeinthewall.php">
                                <button class="btn btn-primary">Hole In The Wall</button><br>
                            </form>
                            <form style="padding-left: 10px" action="hypixelsays.php">
                                <button class="btn btn-primary">Hypixel Says</button><br>
                            </form>
                            <form style="padding-left: 10px" action="miniwalls.php">
                                <button class="btn btn-primary">Mini Walls</button><br>
                            </form>
                            <form style="padding-left: 10px" action="football.php">
                                <button class="btn btn-primary">Football</button><br>
                            </form>
                            <form style="padding-left: 10px">
                                <button class="btn btn-secondary" disabled>Zombies</button><br>
                            </form>
                            <form style="padding-left: 10px" action="hideandseek.php">
                                <button class="btn btn-primary">Hide And Seek</button><br>
                            </form>
                        </div>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Arcade Leaderboard - Zombies
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Best Round)</th>
                                                <th>Name</th>
                                                <th>Best Round</th>
                                                <th>Fastest 10 Minutes</th>
                                                <th>Fastest 20 Minutes</th>
                                                <th>Players Revived</th>
                                                <th>Doors Opened</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallArcadeLeaderboard($mongo_mng, "Zombies");
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $best_round = $player->arcade->zombies->bestRound;
                                                $fastest10 = $player->arcade->zombies->fastestTen;
                                                $fastest20 = $player->arcade->zombies->fastestTwenty;
                                                $players_revived = $player->arcade->zombies->playersRevived;
                                                $doors_opened = $player->arcade->zombies->doorsOpened;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                                
                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($best_round) . '</td>';
                                                    echo '<td>' . number_format($fastest10) . '</td>';
                                                    echo '<td>' . number_format($fastest20) . '</td>';
                                                    echo '<td>' . number_format($players_revived) . '</td>';
                                                    echo '<td>' . number_format($doors_opened) . '</td>';
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

                <?php include "../../../includes/footer.php"; ?>
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
