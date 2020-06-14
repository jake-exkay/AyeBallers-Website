<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - VampireZ</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";

            updatePageViews($connection, 'vz_guild_leaderboard');

            $query = "SELECT * FROM vampirez ORDER BY human_wins DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM vampirez";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            } else {
                $last_updated = '2019-10-10';
            }

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

                                            $result = $connection->query($query);

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
