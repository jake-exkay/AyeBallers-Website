<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Guild Leaderboard - VampireZ</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/display_functions.php";
            include "../../../functions/database/query_functions.php";

            updatePageViews($connection, 'vz_guild_leaderboard', $DEV_IP);

            $result = getVampirezLeaderboard($connection);
            $last_updated = getLastUpdated($connection, 'vampirez');
            $mins = timeSinceUpdate($last_updated);

            $total_human_kills = 0;
            $total_vampire_kills = 0;
            $total_zombie_kills = 0;
            $total_coins = 0;
            $total_human_wins = 0;
            $total_vampire_wins = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $human_kills = $row['human_kills'];
                    $vampire_kills = $row['vampire_kills'];
                    $zombie_kills = $row['zombie_kills'];
                    $human_wins = $row['human_wins'];
                    $vampire_wins = $row['vampire_wins'];
                    $coins = $row['coins'];

                    $total_human_kills = $total_human_kills + $human_kills;
                    $total_vampire_kills = $total_vampire_kills + $vampire_kills;
                    $total_zombie_kills = $total_zombie_kills + $zombie_kills;
                    $total_human_wins = $total_human_wins + $human_wins;
                    $total_vampire_wins = $total_vampire_wins + $vampire_wins;
                    $total_coins = $coins + $coins;

                    $format_total_human_kills = number_format($total_human_kills);
                    $format_total_vampire_kills = number_format($total_vampire_kills);
                    $format_total_zombie_kills = number_format($total_zombie_kills);
                    $format_total_coins = number_format($total_coins);
                    $format_total_vampire_wins = number_format($total_vampire_wins);
                    $format_total_human_wins = number_format($total_human_wins);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">VampireZ Leaderboard</h1>

                        <?php displayUpdateButton($mins); ?>

                        <br>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - VampireZ</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Human Wins)</th>
                                                <th>Name</th>
                                                <th>Human Wins</th>
                                                <th>Vampire Kills</th>
                                                <th>Zombie Kills</th>
                                                <th>Coins</th>
                                                <th>Human Kills</th>
                                                <th>Vampire Wins</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_human_wins; ?></td>
                                                <td><?php echo $format_total_vampire_kills; ?></td>
                                                <td><?php echo $format_total_zombie_kills; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_human_kills; ?></td>
                                                <td><?php echo $format_total_vampire_wins; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getVampirezLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $human_wins = $row['human_wins'];
                                                    $vampire_kills = $row['vampire_kills'];
                                                    $vampire_wins = $row['vampire_wins'];
                                                    $coins = $row['coins'];
                                                    $zombie_kills = $row['zombie_kills'];
                                                    $human_kills = $row['human_kills'];

                                                    $human_wins_format = number_format($human_wins);
                                                    $vampire_kills_format = number_format($vampire_kills);
                                                    $vampire_wins_format = number_format($vampire_wins);
                                                    $coins_format = number_format($coins);
                                                    $zombie_kills_format = number_format($zombie_kills);
                                                    $human_kills_format = number_format($human_kills);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $human_wins_format . '</td>';
                                                        echo '<td>' . $vampire_kills_format . '</td>';
                                                        echo '<td>' . $zombie_kills_format . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
                                                        echo '<td>' . $human_kills_format . '</td>';
                                                        echo '<td>' . $vampire_wins_format . '</td>';
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
