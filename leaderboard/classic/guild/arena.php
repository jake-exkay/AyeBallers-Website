<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - Arena Brawl</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";

            updatePageViews($connection, 'arena_guild_leaderboard', $DEV_IP);

            $query = "SELECT * FROM arena ORDER BY rating DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM arena";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            } else {
                $last_updated = '2019-10-10';
            }

            $mins = timeSinceUpdate($last_updated);

            $total_rating = 0;
            $total_4v4_wins = 0;
            $total_4v4_kills = 0;
            $total_coins = 0;
            $total_2v2_wins = 0;
            $total_2v2_kills = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $rating = $row['rating'];
                    $wins_4v4 = $row['wins_4v4'];
                    $wins_2v2 = $row['wins_2v2'];
                    $kills_2v2 = $row['kills_2v2'];
                    $kills_4v4 = $row['kills_4v4'];
                    $coins = $row['coins'];

                    $total_rating = $total_rating + $rating;
                    $total_4v4_kills = $total_4v4_kills + $kills_4v4;
                    $total_4v4_wins = $total_4v4_wins + $wins_4v4;
                    $total_2v2_kills = $total_2v2_kills + $kills_2v2;
                    $total_2v2_wins = $total_2v2_wins + $wins_2v2;
                    $total_coins = $coins + $coins;

                    $format_total_rating = number_format($total_rating);
                    $format_total_4v4_kills = number_format($total_4v4_kills);
                    $format_total_4v4_wins = number_format($total_4v4_wins);
                    $format_total_2v2_kills = number_format($total_2v2_kills);
                    $format_total_2v2_wins = number_format($total_2v2_wins);
                    $format_total_coins = number_format($total_coins);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        
        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Arena Brawl Leaderboard</h1>

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
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - Arena Brawl</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Rating)</th>
                                                <th>Name</th>
                                                <th>Rating</th>
                                                <th>2v2 Kills<th>
                                                <th>2v2 Wins</th>
                                                <th>4v4 Kills</th>
                                                <th>4v4 Wins</th>
                                                <th>Coins</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_rating; ?></td>
                                                <td><?php echo $format_total_2v2_kills; ?></td>
                                                <td><?php echo $format_total_2v2_wins; ?></td>
                                                <td><?php echo $format_total_4v4_kills; ?></td>
                                                <td><?php echo $format_total_4v4_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rating = $row['rating'];
                                                    $wins_4v4 = $row['wins_4v4'];
                                                    $wins_2v2 = $row['wins_2v2'];
                                                    $coins = $row['coins'];
                                                    $kills_4v4 = $row['kills_4v4'];
                                                    $wins_4v4 = $row['wins_4v4'];

                                                    $rating_format = number_format($rating);
                                                    $wins_4v4_format = number_format($wins_4v4);
                                                    $wins_2v2_format = number_format($wins_2v2);
                                                    $coins_format = number_format($coins);
                                                    $kills_4v4_format = number_format($kills_4v4);
                                                    $kills_2v2_format = number_format($kills_2v2);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $rating_format . '</td>';
                                                        echo '<td>' . $kills_2v2_format . '</td>';
                                                        echo '<td>' . $wins_2v2_format . '</td>';
                                                        echo '<td>' . $kills_4v4_format . '</td>';
                                                        echo '<td>' . $wins_4v4_format . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
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
