<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../includes/links.php"; ?>

        <title>Overall Leaderboard - QuakeCraft</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/functions.php";
            include "../../functions/player_functions.php";
            include "../../functions/display_functions.php";
            include "../../functions/database/query_functions.php";
            include "../../admin/functions/login_functions.php";

            updatePageViews($connection, 'quake_overall_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">QuakeCraft Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="quakecraft.php">
                                <button type="submit" class="btn btn-primary active">Overall Leaderboard</button>
                            </form>

                            <form action="../guild/quakecraft.php">
                                <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - QuakeCraft
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">     
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Kills)</th>
                                                <th>Name</th>
                                                <th>Kills</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>Deaths</th>
                                                <th>Shots Fired</th>
                                                <th>Killstreaks</th>
                                                <th>Headshots</th>
                                                <th>Distance Travelled</th>
                                                <th>Highest Killstreak</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getOverallQuakeLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $coins = $row['coins_quake'];
                                                    $kills = $row['kills_quake'];
                                                    $deaths_quake = $row['deaths_quake'];
                                                    $wins_quake = $row['wins_quake'];
                                                    $killstreaks_quake = $row['killstreaks_quake'];
                                                    $kills_teams_quake = $row['kills_teams_quake'];
                                                    $deaths_teams_quake = $row['deaths_teams_quake'];
                                                    $wins_teams_quake = $row['wins_teams_quake'];
                                                    $killstreaks_teams_quake = $row['killstreaks_teams_quake'];
                                                    $highest_killstreak_quake = $row['highest_killstreak_quake'];
                                                    $shots_fired_teams_quake = $row['shots_fired_teams_quake'];
                                                    $headshots_teams_quake = $row['headshots_teams_quake'];
                                                    $headshots_quake = $row['headshots_quake'];
                                                    $shots_fired_quake = $row['shots_fired_quake'];
                                                    $distance_travelled_quake = $row['distance_travelled_quake'];
                                                    $distance_travelled_teams_quake = $row['distance_travelled_teams_quake'];

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    if ($kills == 0 && $kills_teams_quake == 0) {
                                                        $kd = 0;
                                                        $sk = 0;
                                                    } else {
                                                        $kd = ($kills + $kills_teams_quake) / ($deaths_quake + $deaths_teams_quake);
                                                        $sk = ($shots_fired_quake + $shots_fired_teams_quake) / ($kills + $kills_teams_quake);

                                                        $kd = round($kd, 2);
                                                        $sk = round($sk, 2);
                                                    }

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        echo '<td>' . number_format($kills + $kills_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($wins_quake + $wins_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($deaths_quake + $deaths_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($shots_fired_quake + $shots_fired_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($killstreaks_quake + $killstreaks_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($headshots_quake + $headshots_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($distance_travelled_quake + $distance_travelled_teams_quake) . '</td>';
                                                        echo '<td>' . number_format($highest_killstreak_quake) . '</td>';

                                                        if ($kd > 5) {
                                                            echo '<td class="table-success">' . $kd . '</td>';
                                                        } else if ($kd > 2 && $kd < 5) {
                                                            echo '<td class="table-warning">' . $kd . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $kd . '</td>';
                                                        }

                                                        if ($sk < 1) {
                                                            echo '<td class="table-success">' . $sk . '</td>';
                                                        } else if ($sk > 1 && $sk < 1.5) {
                                                            echo '<td class="table-warning">' . $sk . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $sk . '</td>';
                                                        }
                                                        
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
