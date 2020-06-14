<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - Paintball</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";

            updatePageViews($connection, 'paintball_guild_leaderboard');

            $query = "SELECT * FROM paintball ORDER BY kills DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM paintball";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            }

            $mins = timeSinceUpdate($last_updated);

            $total_kills = 0;
            $total_wins = 0;
            $total_deaths = 0;
            $total_shots = 0;
            $total_coins = 0;
            $total_killstreaks = 0;
            $total_godfather = 0;
            $total_endurance = 0;
            $total_fortune = 0;
            $guild_kd = 0;
            $guild_sk = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $kills = $row['kills'];
                    $wins = $row['wins'];
                    $coins = $row['coins'];
                    $deaths = $row['deaths'];
                    $shots_fired = $row['shots_fired'];
                    $killstreaks = $row['killstreaks'];
                    $godfather = $row['godfather'];
                    $endurance = $row['endurance'];
                    $fortune = $row['fortune'];

                    $total_kills = $total_kills + $kills;
                    $total_wins = $total_wins + $wins;
                    $total_deaths = $total_deaths + $deaths;
                    $total_shots = $total_shots + $shots_fired;
                    $total_coins = $total_coins + $coins;
                    $total_killstreaks = $total_killstreaks + $killstreaks;
                    $total_godfather = $total_godfather + $godfather;
                    $total_endurance = $total_endurance + $endurance;
                    $total_fortune = $total_fortune + $fortune;

                    $format_total_kills = number_format($total_kills);
                    $format_total_wins = number_format($total_wins);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_coins = number_format($total_coins);
                    $format_total_killstreaks = number_format($total_killstreaks);
                    $format_total_shots = number_format($total_shots);
                    $format_total_godfather = number_format($total_godfather);
                    $format_total_endurance = number_format($total_endurance);
                    $format_total_fortune = number_format($total_fortune);

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
                        <h1 class="mt-4">Paintball Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                        	<form style="margin-right: 10px;" action="../overall/paintball.php">
	                            <button type="submit" class="btn btn-primary">Overall Leaderboard</button>
	                        </form>

	                        <form action="paintball.php">
	                            <button type="submit" class="btn btn-success">AyeBallers Leaderboard</button>
	                        </form>

	                    </ol>

                        <div>
                            <?php if ($mins < 10) { ?>
                                <button type="submit" class="btn btn-danger">Update</button>
                                <?php
                                    if ($mins == 0) {
                                        echo "<i>Last Updated: A moment ago</i>";
                                    } elseif ($mins == 1) {
                                        echo "<i>Last Updated: " . $mins . " minute ago</i>";
                                    } else {
                                        echo "<i>Last Updated: " . $mins . " minutes ago</i>";
                                    }
                                ?>
                                <h6><i>(Leaderboard data can be updated every 10 minutes)</i></h6>
                            <?php } else { ?>
                                <form action="../../master_update.php">
                                    <button type="submit" class="btn btn-success">Update</button>
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
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Guild Leaderboard - Paintball
                            </div>
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
                                                <th>Godfather</th>
                                                <th>Endurance</th>
                                                <th>Fortune</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                                <th>Selected Hat</th>
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
                                                <td><?php echo $format_total_godfather; ?></td>
                                                <td><?php echo $format_total_endurance; ?></td>
                                                <td><?php echo $format_total_fortune; ?></td>
                                                <td><?php echo $guild_kd; ?> (Average)</td>
                                                <td><?php echo $guild_sk; ?> (Average)</td>
                                                <td>N/A</td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $kills = $row['kills'];
                                                    $wins = $row['wins'];
                                                    $coins = $row['coins'];
                                                    $deaths = $row['deaths'];
                                                    $shots_fired = $row['shots_fired'];
                                                    $godfather = $row['godfather'];
                                                    $endurance = $row['endurance'];
                                                    $fortune = $row['fortune'];
                                                    $killstreaks = $row['killstreaks'];
                                                    $hat = $row['hat'];

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
                                                        echo '<td>' . $godfather . '</td>';
                                                        echo '<td>' . $endurance . '</td>';
                                                        echo '<td>' . $fortune . '</td>';
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
                                                        if ($hat == "NoxyD" || $hat == "Rezzus") {
                                                            echo '<td class="table-danger">' . $hat . '</td>';
                                                        } else if ($hat == "No Hat") {
                                                            echo '<td class="table-secondary">' . $hat . '</td>';
                                                        } else {
                                                            echo '<td class="table-success">' . $hat . '</td>';
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
