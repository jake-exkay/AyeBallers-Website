<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Guild Leaderboard - Turbo Kart Racers</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/display_functions.php";
            include "../../../functions/database/query_functions.php";

            updatePageViews($connection, 'tkr_guild_leaderboard', $DEV_IP);

            $result = getTkrLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'tkr');
            $mins = timeSinceUpdate($last_updated);

            $total_gold_trophy = 0;
            $total_silver_trophy = 0;
            $total_bronze_trophy = 0;
            $total_coins = 0;
            $total_box_pickups = 0;
            $total_laps_completed = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $gold_trophy = $row['gold_trophy'];
                    $silver_trophy = $row['silver_trophy'];
                    $bronze_trophy = $row['bronze_trophy'];
                    $laps_completed = $row['laps_completed'];
                    $box_pickups = $row['box_pickups'];
                    $coins = $row['coins'];

                    $total_gold_trophy = $total_gold_trophy + $gold_trophy;
                    $total_silver_trophy = $total_silver_trophy + $silver_trophy;
                    $total_bronze_trophy = $total_bronze_trophy + $bronze_trophy;
                    $total_laps_completed = $total_laps_completed + $laps_completed;
                    $total_box_pickups = $total_box_pickups + $box_pickups;
                    $total_coins = $coins + $coins;

                    $format_total_gold_trophy = number_format($total_gold_trophy);
                    $format_total_silver_trophy = number_format($total_silver_trophy);
                    $format_total_bronze_trophy = number_format($total_bronze_trophy);
                    $format_total_coins = number_format($total_coins);
                    $format_total_laps_completed = number_format($total_laps_completed);
                    $format_total_box_pickups = number_format($total_box_pickups);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Turbo Kart Racers Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - Turbo Kart Racers</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Gold Trophies)</th>
                                                <th>Name</th>
                                                <th>Gold Trophies</th>
                                                <th>Silver Trophies</th>
                                                <th>Bronze Trophies</th>
                                                <th>Coins</th>
                                                <th>Laps Completed</th>
                                                <th>Box Pickups</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_gold_trophy; ?></td>
                                                <td><?php echo $format_total_silver_trophy; ?></td>
                                                <td><?php echo $format_total_bronze_trophy; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_laps_completed; ?></td>
                                                <td><?php echo $format_total_box_pickups; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getTkrLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $gold_trophy = $row['gold_trophy'];
                                                    $silver_trophy = $row['silver_trophy'];
                                                    $bronze_trophy = $row['bronze_trophy'];
                                                    $coins = $row['coins'];
                                                    $laps_completed = $row['laps_completed'];
                                                    $box_pickups = $row['box_pickups'];

                                                    $gold_trophy_format = number_format($gold_trophy);
                                                    $silver_trophy_format = number_format($silver_trophy);
                                                    $bronze_trophy_format = number_format($bronze_trophy);
                                                    $coins_format = number_format($coins);
                                                    $laps_completed_format = number_format($laps_completed);
                                                    $box_pickups_format = number_format($box_pickups);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $gold_trophy_format . '</td>';
                                                        echo '<td>' . $silver_trophy_format . '</td>';
                                                        echo '<td>' . $bronze_trophy_format . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
                                                        echo '<td>' . $laps_completed_format . '</td>';
                                                        echo '<td>' . $box_pickups_format . '</td>';
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
