<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../includes/links.php"; ?>

        <title>AyeBallers Leaderboard - The Walls</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/functions.php";
            include "../../functions/player_functions.php";
            include "../../functions/display_functions.php";
            include "../../functions/database/query_functions.php";

            updatePageViews($connection, 'walls_guild_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">The Walls Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="../overall/walls.php">
                                <button type="submit" class="btn btn-primary">Overall Leaderboard</button>
                            </form>

                            <form action="walls.php">
                                <button type="submit" class="btn btn-primary active">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                AyeBallers Leaderboard - The Walls
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
                                                <th>Coins</th>
                                                <th>Assists</th>
                                                <th>Deaths</th>
                                                <th>Losses</th>
                                                <th>K/D</th>
                                                <th>W/L</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getWallsGuildLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $kills = $row['kills_walls'];
                                                    $wins = $row['wins_walls'];
                                                    $coins = $row['coins_walls'];
                                                    $deaths = $row['deaths_walls'];
                                                    $assists = $row['assists_walls'];
                                                    $losses = $row['losses_walls'];

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    if ($deaths == 0 || $losses == 0) {
                                                        $kd = 0;
                                                        $wl = 0;
                                                    } else {
                                                        $kd = $kills / $deaths;
                                                        $wl = $wins / $losses;

                                                        $kd = round($kd, 2);
                                                        $wl = round($wl, 2);
                                                    }

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        echo '<td>' . number_format($wins) . '</td>';
                                                        echo '<td>' . number_format($kills) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($assists) . '</td>';
                                                        echo '<td>' . number_format($deaths) . '</td>';
                                                        echo '<td>' . number_format($losses) . '</td>';

                                                        if ($kd > 5) {
                                                            echo '<td class="table-success">' . $kd . '</td>';
                                                        } else if ($kd > 2 && $kd < 5) {
                                                            echo '<td class="table-warning">' . $kd . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $kd . '</td>';
                                                        }

                                                        if ($wl > 2) {
                                                            echo '<td class="table-success">' . $wl . '</td>';
                                                        } else if ($wl > 1 && $wl < 2) {
                                                            echo '<td class="table-warning">' . $wl . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $wl . '</td>';
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