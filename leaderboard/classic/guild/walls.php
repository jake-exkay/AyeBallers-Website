<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Guild Leaderboard - The Walls</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/display_functions.php";
            include "../../../functions/database/query_functions.php";

            updatePageViews($connection, 'walls_guild_leaderboard', $DEV_IP);

            $result = getWallsLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'walls');
            $mins = timeSinceUpdate($last_updated);

            $total_wins = 0;
            $total_kills = 0;
            $total_deaths = 0;
            $total_coins = 0;
            $total_assists = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $wins = $row['wins'];
                    $kills = $row['kills'];
                    $deaths = $row['deaths'];
                    $assists = $row['assists'];
                    $coins = $row['coins'];

                    $total_wins = $total_wins + $wins;
                    $total_kills = $total_kills + $kills;
                    $total_deaths = $total_deaths + $deaths;
                    $total_assists = $total_assists + $assists;
                    $total_coins = $coins + $coins;

                    $format_total_wins = number_format($total_wins);
                    $format_total_kills = number_format($total_kills);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_coins = number_format($total_coins);
                    $format_total_assists = number_format($total_assists);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "/var/www/html/includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">The Walls Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - The Walls</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Wins)</th>
                                                <th>Name</th>
                                                <th>Wins</th>
                                                <th>Kills</th>
                                                <th>Assists</th>
                                                <th>Coins</th>
                                                <th>Deaths</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_kills; ?></td>
                                                <td><?php echo $format_total_assists; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_deaths; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getWallsLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $wins = $row['wins'];
                                                    $kills = $row['kills'];
                                                    $deaths = $row['deaths'];
                                                    $coins = $row['coins'];
                                                    $assists = $row['assists'];

                                                    $wins_format = number_format($wins);
                                                    $kills_format = number_format($kills);
                                                    $deaths_format = number_format($deaths);
                                                    $coins_format = number_format($coins);
                                                    $assists_format = number_format($assists);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td><a href="../../../stats.php?player=' . $name . '">' . $name . '</a></td>';
                                                        echo '<td>' . $wins_format . '</td>';
                                                        echo '<td>' . $kills_format . '</td>';
                                                        echo '<td>' . $assists . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
                                                        echo '<td>' . $deaths_format . '</td>';
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
