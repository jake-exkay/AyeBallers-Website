<?php
/**
 * Admin EXP tracker page
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/admin/dashboard
 */

require "../includes/links.php";
require "../includes/constants.php";
require "../functions/functions.php";
require "../functions/player_functions.php";
require "../includes/connect.php";
require "../functions/display_functions.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>EXP Tracker - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild Experience Statistics
                                        </div>
                                        <div class="card-body">
                                            <b>Total GEXP Today: </b><?php echo getDailyGuildExperience($connection); ?><br>
                                            <b>Total GEXP This Week: </b><?php echo getWeeklyGuildExperience($connection); ?><br>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            GEXP Leaderboard (DAILY)
                                        </div>
                                        <div class="card-body">
                                            <table id="admin" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Position</th>
                                                        <th>Name</th>
                                                        <th>Guild Rank</th>
                                                        <th>GEXP (Today)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        $result = getGuildDailyExperience($connection);
                                                        $position = 1;

                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                $uuid = $row["uuid"];
                                                                $g_rank = $row["rank"];
                                                                $exp = $row["exp"];
                                                                $player = getLocalPlayer($mongo_mng, $uuid);
                                                                $rank = $player->rank;
                                                                $rank_colour = $player->rankColour;
                                                                $name = $player->name;
                                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                                echo '<tr>';
                                                                    echo '<td>' . $position . '</td>';
                                                                    echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                                    echo '<td>' . $g_rank . '</td>';
                                                                    echo '<td>' . number_format($exp) . '</td>';
                                                                echo '</tr>'; 

                                                                $position = $position + 1;
                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            GEXP Leaderboard (WEEKLY)
                                        </div>
                                        <div class="card-body">
                                            <table id="admin" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Position</th>
                                                        <th>Name</th>
                                                        <th>Guild Rank</th>
                                                        <th>GEXP (This Week)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        $result = getGuildMembersExperience($connection);
                                                        $position = 1;

                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                $uuid = $row["uuid"];
                                                                $g_rank = $row["rank"];
                                                                $exp = $row["exp"];
                                                                $player = getLocalPlayer($mongo_mng, $uuid);
                                                                $rank = $player->rank;
                                                                $rank_colour = $player->rankColour;
                                                                $name = $player->name;
                                                                $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                                echo '<tr>';
                                                                    echo '<td>' . $position . '</td>';
                                                                    echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                                    echo '<td>' . $g_rank . '</td>';
                                                                    echo '<td>' . number_format($exp) . '</td>';
                                                                echo '</tr>'; 

                                                                $position = $position + 1;
                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </main>

                <?php require "../includes/footer.php"; ?>

            </div>

    </body>

</html>

