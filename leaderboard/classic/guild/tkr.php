<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - Turbo Kart Racers</title>

        <?php

            include "../../../includes/constants.php";

            $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
               
            if($connection->connect_error) {
                echo 'Error connecting to the database';
            }

            $query = "SELECT * FROM tkr ORDER BY gold_trophy DESC";
            $result = $connection->query($query);

            $stats_query = "UPDATE page_views SET views = views + 1 WHERE page='tkr_guild_leaderboard'";
                            
            if($stats_statement = mysqli_prepare($connection, $stats_query)) {
                mysqli_stmt_execute($stats_statement);
            }

            $last_updated_query = "SELECT * FROM tkr";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            } else {
                $last_updated = '2019-10-10';
            }

            $start_date = new DateTime($last_updated);
            $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

            $mins = $since_start->i;

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

                        <ol class="breadcrumb mb-4">

                        	<form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Overall Leaderboard</button>
	                        </form>

	                        <form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Monthly Leaderboard</button>
	                        </form>

	                        <form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Weekly Leaderboard</button>
	                        </form>

	                        <form action="tkr_leaderboard_guild.php">
	                            <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
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
                                        } elseif ($mins == 1) {
                                            echo "<i>Last Updated: " . $mins . " minute ago</i>";
                                        } else {
                                            echo "<i>Last Updated: " . $mins . " minutes ago</i>";
                                        }
                                    ?>
                                </form>
                            <?php } ?>
                        </div>

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

                                            $result = $connection->query($query);

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
