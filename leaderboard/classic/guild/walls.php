<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - The Walls</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";

            updatePageViews($connection, 'walls_guild_leaderboard', $DEV_IP);

            $query = "SELECT * FROM walls ORDER BY wins DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM walls";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            } else {
                $last_updated = '2019-10-10';
            }

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
        
        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">The Walls Leaderboard</h1>

                        <div>
                            <?php if ($mins < 5) { ?>
                                <button type="submit" title="Last Updated: <?php echo $mins; ?> minutes ago." class="btn btn-danger">Update</button>
                                <?php
                                    if ($mins == 0) {
                                        echo "<i>Last Updated: A moment ago</i>";
                                    } elseif ($mins == 1) {
                                        echo "<i>Last Updated: " . $mins . " minute ago</i>";
                                    } else {
                                        echo "<i>Last Updated: " . $mins . " minutes ago</i>";
                                    }
                                ?>
                                <h6><i>(Leaderboard data can be updated every 5 minutes)</i></h6>
                            <?php } else { ?>
                                <form action="../../master_update.php">
                                    <button type="submit" title="Last Updated: <?php echo $mins; ?> minutes ago." class="btn btn-success">Update</button>
                                    <?php
                                        if ($mins == 0) {
                                            echo "<i>Last Updated: A moment ago</i>";
                                        } elseif ($mins >= 60) {
                                            echo "<i>Last Updated: more than an hour ago</i>";
                                        } elseif ($mins == 1) {
                                            echo "<i>Last Updated: " . $mins . " minute ago</i>";
                                        } else {
                                            echo "<i>Last Updated: " . $mins . " minutes ago</i>";
                                        }
                                    ?>
                                </form>
                            <?php } ?>
                        </div>

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

                                            $result = $connection->query($query);

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
                                                        echo '<td>' . $name . '</td>';
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
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/demo/chart-area-demo.js"></script>
        <script src="../../../assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../../../assets/demo/datatables-demo.js"></script>
    </body>
</html>
