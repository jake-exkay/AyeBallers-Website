<?php
/**
 * TNT Run Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/tntgames.php
 */

require "../../../includes/links.php";
include "../../../includes/connect.php";
include "../../../functions/backend_functions.php";
include "../../../functions/player_functions.php";
include "../../../functions/leaderboard_functions.php";
include "../../../admin/functions/login_functions.php";

updatePageViews($connection, 'tnt_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>TNT Games Leaderboard - TNT Run</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">TNT Run Leaderboard</h1>
                        <div class="row">
                            <form style="padding-left: 10px" action="../tntgames.php">
                                <button class="btn btn-primary">Overall</button><br>
                            </form>
                            <form style="padding-left: 10px">
                                <button class="btn btn-secondary" disabled>TNT Run</button><br>
                            </form>
                            <form style="padding-left: 10px" action="pvprun.php">
                                <button class="btn btn-primary">PVP Run</button><br>
                            </form>
                            <form style="padding-left: 10px" action="tntag.php">
                                <button class="btn btn-primary">TNT Tag</button><br>
                            </form>
                            <form style="padding-left: 10px" action="wizards.php">
                                <button class="btn btn-primary">TNT Wizards</button><br>
                            </form>
                            <form style="padding-left: 10px" action="bowspleef.php">
                                <button class="btn btn-primary">Bow Spleef</button><br>
                            </form>
                        </div>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                TNT Games Leaderboard - TNT Run
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Wins)</th>
                                                <th>Name</th>
                                                <th>Wins</th>
                                                <th>Losses</th>
                                                <th>W/L</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallTntLeaderboard($mongo_mng, "TNTRun");
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $wins = $player->tntgames->tntrun->wins;
                                                $deaths = $player->tntgames->tntrun->deaths;
                            
                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                if ($deaths == 0 || $wins == 0) {
                                                    $wl = 0;
                                                } else {
                                                    $wl = $wins / $deaths;
                                                    $wl = round($wl, 2);
                                                }

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (false) {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    
                                                    echo '<td>' . number_format($wins) . '</td>';
                                                    echo '<td>' . number_format($deaths) . '</td>';

                                                    if ($wl > 3) {
                                                        echo '<td class="table-success">' . $wl . '</td>';
                                                    } else if ($wl > 1 && $wl < 3) {
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
