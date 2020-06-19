<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Guild Leaderboard - QuakeCraft</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/display_functions.php";
            include "../../../functions/database/query_functions.php";

            updatePageViews($connection, 'quakecraft_guild_leaderboard', $DEV_IP);

            $result = getQuakeLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'quakecraft');
            $mins = timeSinceUpdate($last_updated);

            $total_kills = 0;
            $total_wins = 0;
            $total_deaths = 0;
            $total_shots = 0;
            $total_coins = 0;
            $total_killstreaks = 0;
            $total_headshots = 0;
            $guild_kd = 0;
            $guild_sk = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $kills = $row['kills'];
                    $wins = $row['wins'];
                    $coins = $row['coins'];
                    $deaths = $row['deaths'];
                    $shots_fired = $row['shots_fired'];
                    $headshots = $row['headshots'];
                    $killstreaks = $row['killstreaks'];

                    $total_kills = $total_kills + $kills;
                    $total_wins = $total_wins + $wins;
                    $total_deaths = $total_deaths + $deaths;
                    $total_shots = $total_shots + $shots_fired;
                    $total_coins = $total_coins + $coins;
                    $total_killstreaks = $total_killstreaks + $killstreaks;
                    $total_headshots = $total_headshots + $headshots;

                    $format_total_kills = number_format($total_kills);
                    $format_total_wins = number_format($total_wins);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_coins = number_format($total_coins);
                    $format_total_killstreaks = number_format($total_killstreaks);
                    $format_total_shots = number_format($total_shots);
                    $format_total_headshots = number_format($total_headshots);

                    $guild_kd = $total_kills / $total_deaths;
                    $guild_sk = $total_shots / $total_kills;
                    $guild_kd = round($guild_kd, 2);
                    $guild_sk = round($guild_sk, 2);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">QuakeCraft Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - QuakeCraft</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Kills)</th>
                                                <th>Name</th>
                                                <th>Kills</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>Shots Fired</th>
                                                <th>Deaths</th>
                                                <th>Headshots</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_kills; ?></td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_shots; ?></td>
                                                <td><?php echo $format_total_deaths; ?></td>
                                                <td><?php echo $format_total_headshots; ?></td>
                                                <td><?php echo $guild_kd; ?> (Average)</td>
                                                <td><?php echo $guild_sk; ?> (Average)</td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getQuakeLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $kills = $row['kills'];
                                                    $wins = $row['wins'];
                                                    $coins = $row['coins'];
                                                    $deaths = $row['deaths'];
                                                    $shots_fired = $row['shots_fired'];
                                                    $headshots = $row['headshots'];
                                                    $killstreaks = $row['killstreaks'];

                                                    if ($kills == 0) {
                                                        $kd = 0;
                                                        $sk = 0;
                                                    } else {
                                                        $kd = $kills / $deaths;
                                                        $sk = $shots_fired / $kills;

                                                        $kd = round($kd, 2);
                                                        $sk = round($sk, 2);
                                                    }

                                                    $kills_format = number_format($kills);
                                                    $wins_format = number_format($wins);
                                                    $deaths_format = number_format($deaths);
                                                    $shots_fired_format = number_format($shots_fired);
                                                    $coins_format = number_format($coins);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $kills_format . '</td>';
                                                        echo '<td>' . $wins_format . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
                                                        echo '<td>' . $shots_fired_format . '</td>';
                                                        echo '<td>' . $deaths_format . '</td>';
                                                        echo '<td>' . $headshots . '</td>';
                                                        if ($kd > 2) {
                                                            echo '<td class="table-success">' . $kd . '</td>';
                                                        } else if ($kd > 1 && $kd < 2) {
                                                            echo '<td class="table-warning">' . $kd . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $kd . '</td>';
                                                        }
                                                        if ($sk > 45) {
                                                            echo '<td class="table-danger">' . $sk . '</td>';
                                                        } else if ($sk > 30 && $sk < 45) {
                                                            echo '<td class="table-warning">' . $sk . '</td>';
                                                        } else {
                                                            echo '<td class="table-success">' . $sk . '</td>';
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
                <?php include "../../../includes/footer.php"; ?>
            </div>
        </div>
    </body>
</html>
