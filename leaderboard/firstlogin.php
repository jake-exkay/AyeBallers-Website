<?php
/**
 * First Login Leaderboard - Overall
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/arena.php
 */

require "../includes/links.php";
include "../includes/connect.php";
include "../functions/functions.php";
include "../functions/player_functions.php";
include "../functions/display_functions.php";
include "../functions/database/query_functions.php";
include "../admin/functions/login_functions.php";

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Overall Leaderboard - First Login</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">First Login Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - First Login
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (First Login)</th>
                                                <th>Name</th>
                                                <th>Login Date (Server Time)</th>
                                                <th>Recent Game</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getOverallFirstLoginLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $player) {
                                                $name = $player->name;
                                                $rank = $player->rank;
                                                $rank_colour = $player->rankColour;
                                                $first_login = $player->firstLogin;
                                                $recent_game = $player->recentGameType;

                                                $login_date = date("d M Y (H:i:s)", (int)substr($first_login, 0, 10));

                                                if ($login_date == "01 Jan 1970 (00:00:00)") {
                                                    continue;
                                                }

                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    if (userInGuild($connection, $name)) {
                                                        echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                    } else {
                                                        echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                    }
                                                    echo '<td>' . $login_date . '</td>';
                                                    echo '<td>' . $recent_game . '</td>';
                                                    
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

                <?php include "../includes/footer.php"; ?>
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
