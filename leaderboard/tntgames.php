<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../includes/links.php"; ?>

        <title>Guild Leaderboard - TNT Games</title>

        <?php

            include "../includes/connect.php";
            include "../functions/functions.php";
            include "../functions/display_functions.php";
            include "../functions/database/query_functions.php";

            updatePageViews($connection, 'tntgames_guild_leaderboard', $DEV_IP);

            $result = getTntLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'tntgames');
            $mins = timeSinceUpdate($last_updated);

            $total_wins = $total_coins = $total_wizards_kills = $total_bowspleef_wins = $total_wizards_wins = $total_tntrun_wins = $total_pvprun_kills = $total_tnttag_wins = $total_pvprun_wins = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $wizards_kills = $row['wizards_kills'];
                    $wins_bowspleef = $row['wins_bowspeef'];
                    $coins = $row['coins'];
                    $wins_wizards = $row['wins_wizards'];
                    $wins_tntrun = $row['wins_tntrun'];
                    $wins = $row['total_wins'];
                    $wins_pvprun = $row['wins_pvprun'];
                    $kills_pvprun = $row['kills_pvprun'];
                    $wins_tnttag = $row['wins_tnttag'];

                    $total_wins = $total_wins + $wins;
                    $total_coins = $total_coins + $coins;
                    $total_wizards_kills = $total_wizards_kills + $wizards_kills;
                    $total_bowspleef_wins = $total_bowspleef_wins + $wins_bowspleef;
                    $total_wizards_wins = $total_wizards_wins + $wins_wizards;
                    $total_tntrun_wins = $total_tntrun_wins + $wins_tntrun;
                    $total_pvprun_kills = $total_pvprun_kills + $kills_pvprun;
                    $total_tnttag_wins = $total_tnttag_wins + $wins_tnttag;
                    $total_pvprun_wins = $total_pvprun_wins + $wins_pvprun;

                    $format_total_wins = number_format($total_wins);
                    $format_total_coins = number_format($total_coins);
                    $format_total_wizards_kills = number_format($total_wizards_kills);
                    $format_total_bowspleef_wins = number_format($total_bowspleef_wins);
                    $format_total_wizards_wins = number_format($total_wizards_wins);
                    $format_total_tntrun_wins = number_format($total_tntrun_wins);
                    $format_total_pvprun_kills = number_format($total_pvprun_kills);
                    $format_total_tnttag_wins = number_format($total_tnttag_wins);
                    $format_total_pvprun_wins = number_format($total_pvprun_wins);

                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">TNT Games Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - TNT Games</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Total Wins)</th>
                                                <th>Name</th>
                                                <th>Total Wins</th>
                                                <th>Coins</th>
                                                <th>TNT Run Wins</th>
                                                <th>PVP Run Wins</th>
                                                <th>Bow Spleef Wins</th>
                                                <th>TNT Tag Wins</th>
                                                <th>Wizards Wins</th>
                                                <th>Wizards Kills</th>
                                                <th>PVP Run Kills</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_tntrun_wins; ?></td>
                                                <td><?php echo $format_total_pvprun_wins; ?></td>
                                                <td><?php echo $format_total_bowspleef_wins; ?></td>
                                                <td><?php echo $format_total_tnttag_wins; ?></td>
                                                <td><?php echo $format_total_wizards_wins; ?></td>
                                                <td><?php echo $format_total_wizards_kills; ?></td>
                                                <td><?php echo $format_total_pvprun_kills; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getTntLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $wizards_kills = $row['wizards_kills'];
                                                    $wins_bowspleef = $row['wins_bowspeef'];
                                                    $coins = $row['coins'];
                                                    $wins_wizards = $row['wins_wizards'];
                                                    $wins_tntrun = $row['wins_tntrun'];
                                                    $wins = $row['total_wins'];
                                                    $wins_pvprun = $row['wins_pvprun'];
                                                    $kills_pvprun = $row['kills_pvprun'];
                                                    $wins_tnttag = $row['wins_tnttag'];
                                                    $name = $row['name'];

                                                    $format_wins = number_format($wins);
                                                    $format_coins = number_format($coins);
                                                    $format_wizards_kills = number_format($wizards_kills);
                                                    $format_bowspleef_wins = number_format($wins_bowspleef);
                                                    $format_wizards_wins = number_format($wins_wizards);
                                                    $format_tntrun_wins = number_format($wins_tntrun);
                                                    $format_pvprun_kills = number_format($kills_pvprun);
                                                    $format_tnttag_wins = number_format($wins_tnttag);
                                                    $format_pvprun_wins = number_format($wins_pvprun);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $format_wins . '</td>';
                                                        echo '<td>' . $format_coins . '</td>';
                                                        echo '<td>' . $format_tntrun_wins . '</td>';
                                                        echo '<td>' . $format_pvprun_wins . '</td>';
                                                        echo '<td>' . $format_bowspleef_wins . '</td>';
                                                        echo '<td>' . $format_tnttag_wins . '</td>';
                                                        echo '<td>' . $format_wizards_wins . '</td>';
                                                        echo '<td>' . $format_wizards_kills . '</td>';
                                                        echo '<td>' . $format_pvprun_kills . '</td>';
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
