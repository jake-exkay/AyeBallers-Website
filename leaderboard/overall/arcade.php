<?php
/**
 * Arcade Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/arcade.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'arcade_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - Arcade</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Arcade Leaderboard</h1>
                        <div class="row">
                            <form style="padding-left: 10px">
                                <button class="btn btn-secondary" disabled>Overall</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/bountyhunters.php">
                                <button class="btn btn-primary">Bounty Hunters</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/throwout.php">
                                <button class="btn btn-primary">Throw Out</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/blockingdead.php">
                                <button class="btn btn-primary">Blocking Dead</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/dragonwars.php">
                                <button class="btn btn-primary">Dragon Wars</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/farmhunt.php">
                                <button class="btn btn-primary">Farm Hunt</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/enderspleef.php">
                                <button class="btn btn-primary">Ender Spleef</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/partygames.php">
                                <button class="btn btn-primary">Party Games</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/galaxywars.php">
                                <button class="btn btn-primary">Galaxy Wars</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/holeinthewall.php">
                                <button class="btn btn-primary">Hole In The Wall</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/hypixelsays.php">
                                <button class="btn btn-primary">Hypixel Says</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/miniwalls.php">
                                <button class="btn btn-primary">Mini Walls</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/football.php">
                                <button class="btn btn-primary">Football</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/zombies.php">
                                <button class="btn btn-primary">Zombies</button><br>
                            </form>
                            <form style="padding-left: 10px" action="arcade/hideandseek.php">
                                <button class="btn btn-primary">Hide And Seek</button><br>
                            </form>
                        </div>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Arcade (General)
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Coins)</th>
                                                <th>Name</th>
                                                <th>Coins</th>
                                                <th>Wins</th>
                                                <th>Creeper Attack Record</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallArcadeLeaderboard($mongo_mng, "Overall");
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $coins = $player->arcade->coins;
                                                $record = $player->arcade->creeperAttack->maxWave;
                                                $ender_wins = $player->arcade->enderSpleef->wins;
                                                $p1_wins = $player->arcade->partyGamesOne->wins;
                                                $p2_wins = $player->arcade->partyGamesTwo->wins;
                                                $p3_wins = $player->arcade->partyGamesThree->wins;
                                                $hitw_wins = $player->arcade->holeInTheWall->wins;
                                                $dw_wins = $player->arcade->dragonWars->wins;
                                                $simon_wins = $player->arcade->hypixelSays->wins;
                                                $mw_wins = $player->arcade->miniWalls->wins;
                                                $bh_wins = $player->arcade->bountyHunters->wins;
                                                $throwout_wins = $player->arcade->throwOut->wins;
                                                $bd_wins = $player->arcade->blockingDead->wins;
                                                $gw_wins = $player->arcade->galaxyWars->wins;
                                                $football_wins = $player->arcade->football->wins;
                                                $seeker_wins = $player->arcade->hideAndSeek->seekerWins;
                                                $hider_wins = $player->arcade->hideAndSeek->hiderWins;
                                                $wins = $ender_wins + $p1_wins + $p2_wins + $p3_wins + $hitw_wins + $dw_wins + $simon_wins + $mw_wins + $bh_wins + $throwout_wins + $bd_wins + $gw_wins + $football_wins + $seeker_wins + $hider_wins;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                                
                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($coins) . '</td>';
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($record) . '</td>';
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
