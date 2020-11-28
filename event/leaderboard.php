<?php
/**
 * Event page - Showing leaderboard and event statistics
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/event/leaderboard.php
 */

require "../includes/links.php";
require "../functions/functions.php";
require "../functions/player_functions.php";
require "event_functions.php";
require "../includes/connect.php";

updatePageViews($connection, 'pb3_leaderboard', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Paintball Tournament - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

    <?php require "../includes/navbar.php"; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <br>

                    <b><h1 class="event_font">PAINTBALL TOURNAMENT</h1></b>
                    <h3 class="ayeballers_font"><b>Starts:</b> 1st October 2020</h3>

                    <hr>
                                
                    <br>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Event Leaderboard
                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Position</th>
                                                    <th>Name</th>
                                                    <th>Total Points</th>
                                                    <th>Kills</th>
                                                    <th>Wins</th>
                                                    <th>Forcefield Time</th>
                                                    <th>Deaths</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php

                                                $i = 1;

                                                $result = getEventLeaderboard($connection);

                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        $name = $row['name'];
                                                        $total_points = $row['total_points'];
                                                        $kills = $row['current_kills'];
                                                        $wins = $row['current_wins'];
                                                        $deaths = $row['current_deaths'];
                                                        $forcefield = $row['current_ff'];
                                                        $kills_start = $row['starting_kills'];
                                                        $wins_start = $row['starting_wins'];
                                                        $deaths_start = $row['starting_deaths'];
                                                        $forcefield_start = $row['starting_ff'];
                                                        $rank = $row['rank'];
                                                        $rank_colour = $row['rank_colour'];

                                                        $event_kills = $kills - $kills_start;
                                                        $event_wins = $wins - $wins_start;
                                                        $event_deaths = $deaths - $deaths_start;
                                                        $event_forcefield = $forcefield - $forcefield_start;

                                                        $formatted_name = getRankFormatting($name, $rank, $rank_colour);

                                                        echo '<tr>';
                                                            echo '<td>' . $i . '</td>';
                                                            if ($name == 'recordheat' || $name == 'Pablojor') {
                                                                echo '<td><a href="../../../stats.php?player=' . $name . '">' . $formatted_name . '</a> <img title="Previous Tournament Winner" height="25" width="auto" src="../assets/img/gold.png"/></td>';
                                                            } else if ($name == 'ExKay' || $name == 'Emirichuwu' || $name == 'PotAccuracy') {
                                                            echo '<td><a href="../../../stats.php?player=' . $name . '">' . $formatted_name . '</a> <img title="AyeBallers Member" height="15" width="auto" src="../assets/img/favicon.png"/><img title="Event Staff" height="15" width="auto" src="../assets/img/star.png"/></td>';
                                                            } else if (userInGuild($connection, $name)) {
                                                                echo '<td><a href="../../../stats.php?player=' . $name . '">' . $formatted_name . '</a> <img title="AyeBallers Member" height="15" width="auto" src="../assets/img/favicon.png"/></td>';
                                                            } else {
                                                                echo '<td><a href="../../../stats.php?player=' . $name . '">' . $formatted_name . '</a></td>';
                                                            }
                                                            echo '<td>' . $total_points . '</td>';
                                                            echo '<td>' . $event_kills . '<p style="color:Green;">(+' . $event_kills . ')</p></td>';
                                                            echo '<td>' . $event_wins . '<p style="color:Green;">(+' . ($event_wins * 15) . ')</p></td>';
                                                            echo '<td>' . $event_forcefield . ' (' . round($event_forcefield / 60) . ' mins) <p style="color:Green;">(+' . (round($event_forcefield * 5 / 60)) . ')</p></td>';
                                                            echo '<td>' . $event_deaths . '<p style="color:Red;">(-' . $event_deaths . ')</p></td>';
                                                        echo '</tr>'; 
                                                        $i = $i + 1;
                                                    }
                                                }


                                            ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-users mr-1"></i>
                                    Participants
                                </div>

                                <div class="card-body">
                                    <?php
                                        $result = getParticipantsData($connection);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $rank = $row["rank"];
                                                $rank_colour = $row["rank_colour"];
                                                $name = $row["name"];
                                                $rank_format = getRankFormatting($name, $rank, $rank_colour);
                                                echo '<img style="height: 25px; width: 25px;" src="https://crafatar.com/avatars/' . $row["UUID"] . '"/> ';
                                                echo '<a href="../../../stats.php?player=' . $name . '">' . $rank_format . "</a><br>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-list mr-1"></i>
                                    FAQ
                                </div>

                                <div class="card-body">
                                    <b>Q:</b> Where can I report users for using NoxyD or Rezzus?
                                    <br>
                                    <b>A:</b> Upload a screenshot on <a href="report.php">this page</a>.
                                    <hr>
                                    <b>Q:</b> How are statistics updated?
                                    <br>
                                    <b>A:</b> Each time a users' profile page is loaded, their statistics on the leaderboard will update.
                                    <hr>
                                    <b>Q:</b> Where can I find out information about the tournament?
                                    <br>
                                    <b>A:</b> Visit the forum thread here.
                                    <hr>
                                    <b>Q:</b> The leaderboard is broken?
                                    <br>
                                    <b>A:</b> Contact ExKay#0184 on Discord.
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php require "../includes/footer.php"; ?>
            <script>
                    $(document).ready(function () {
                    $('#leaderboard').DataTable({
                    });
                    $('.dataTables_length').addClass('bs-select');
                    });
            </script>

        </div>

    </body>
</html>
