<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../includes/links.php"; ?>

        <title>Guild Leaderboard - SkyWars</title>

        <?php

            include "../includes/connect.php";
            include "../functions/functions.php";
            include "../functions/display_functions.php";
            include "../functions/database/query_functions.php";

            updatePageViews($connection, 'skywars_guild_leaderboard', $DEV_IP);

            $result = getSkywarsLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'skywars');
            $mins = timeSinceUpdate($last_updated);

            $total_wins = $total_coins = $total_kills = $total_assists = $total_deaths = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $wins = $row['wins'];
                    $kills = $row['kills'];
                    $coins = $row['coins'];
                    $assists = $row['assists'];
                    $deaths = $row['deaths'];
                
                    $total_wins = $total_wins + $wins;
                    $total_coins = $total_coins + $coins;
                    $total_kills = $total_kills + $kills;
                    $total_assists = $total_assists + $assists;
                    $total_deaths = $total_deaths + $deaths;

                    $format_total_wins = number_format($total_wins);
                    $format_total_coins = number_format($total_coins);
                    $format_total_kills = number_format($total_kills);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_assists = number_format($total_assists);

                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">SkyWars Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - SkyWars</div>
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

                                            $result = getSkywarsLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $wins = $row['wins'];
                                                    $kills = $row['kills'];
                                                    $coins = $row['coins'];
                                                    $assists = $row['assists'];
                                                    $deaths = $row['deaths'];
                                                    $name = $row['name'];

                                                    $format_wins = number_format($wins);
                                                    $format_coins = number_format($coins);
                                                    $format_kills = number_format($kills);
                                                    $format_deaths = number_format($deaths);
                                                    $format_assists = number_format($assists);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $format_wins . '</td>';
                                                        echo '<td>' . $format_kills . '</td>';
                                                        echo '<td>' . $format_assists . '</td>';
                                                        echo '<td>' . $format_coins . '</td>';
                                                        echo '<td>' . $format_deaths . '</td>';
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
                <?php include "../includes/footer.php"; ?>
            </div>
        </div>
        
    </body>
</html>
