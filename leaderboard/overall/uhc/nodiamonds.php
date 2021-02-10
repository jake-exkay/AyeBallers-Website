<?php
/**
 * UHC Leaderboard - No Diamonds
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/uhc.php
 */

require "../../../includes/links.php";
include "../../../includes/connect.php";
include "../../../functions/functions.php";
include "../../../functions/player_functions.php";
include "../../../functions/display_functions.php";
include "../../../functions/database/query_functions.php";
include "../../../admin/functions/login_functions.php";

updatePageViews($connection, 'uhc_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>UHC Leaderboard - No Diamonds</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">UHC No Diamonds Leaderboard</h1>
                        <div class="row">
                            <form style="padding-left: 10px" action="../uhc.php">
                                <button class="btn btn-primary">Solo</button><br>
                            </form>
                            <form style="padding-left: 10px" action="teams.php">
                                <button class="btn btn-primary">Teams</button><br>
                            </form>
                            <form style="padding-left: 10px" action="redvsblue.php">
                                <button class="btn btn-primary">Red vs Blue</button><br>
                            </form>
                            <form style="padding-left: 10px">
                                <button class="btn btn-secondary" disabled>No Diamonds</button><br>
                            </form>
                            <form style="padding-left: 10px" action="vanilladoubles.php">
                                <button class="btn btn-primary">Vanilla Doubles</button><br>
                            </form>
                            <form style="padding-left: 10px" action="brawl.php">
                                <button class="btn btn-primary">Brawl</button><br>
                            </form>
                            <form style="padding-left: 10px" action="solobrawl.php">
                                <button class="btn btn-primary">Solo Brawl</button><br>
                            </form>
                            <form style="padding-left: 10px" action="duobrawl.php">
                                <button class="btn btn-primary">Duo Brawl</button><br>
                            </form>
                        </div>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                UHC Leaderboard - No Diamonds
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
                                                <th>Deaths</th>
                                                <th>Heads Eaten</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallUhcLeaderboard($mongo_mng, "NoDiamonds");
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $kills = $player->uhc->nodiamonds->kills;
                                                $wins = $player->uhc->nodiamonds->wins;
                                                $deaths = $player->uhc->nodiamonds->deaths;
                                                $heads_eaten = $player->uhc->nodiamonds->headsEaten;

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (userInGuild($connection, $name)) {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';
                                                    echo '<td>' . number_format($heads_eaten) . '</td>';

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
