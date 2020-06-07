<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Event Leaderboard</title>

        <?php

            include "../includes/connect.php";
            include "../functions/functions.php";

            $tournament_started = false;

            updatePageViews($connection, 'event_leaderboard');

            $query = "SELECT * FROM event ORDER BY total_points DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM event";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            }

            $start_date = new DateTime($last_updated);
            $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

            $mins = $since_start->i;
        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <center>
                            <b><h1 class="mt-4">Paintball Tournament #2</h1></b>
                            <?php
                                if ($tournament_started == false) {
                                    echo "<h3>Time Until Tournament: 00:00:00</h2>";
                                } else {
                                    echo "<h3>Tournament Time Remaining: 00:00:00</h2>";
                                }
                            ?>
                            <p>Tournament hosted by Emilyie. Website created by ExKay.</p>

                            <br><br>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <p>View Event Thread</p>
                                </div>
                                <div class="col-md-4">
                                    <p>Report NoxyD/Rezzus User</p>
                                </div>
                                <div class="col-md-4">
                                    <p>View Previous Tournament</p>
                                </div>
                            </div>

                        </center>
                        
                        <br>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Event Leaderboard
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div>
                                        <?php
                                            if ($mins == 0) {
                                                echo "<i>Last Updated: A moment ago</i>";
                                            } elseif ($mins == 1) {
                                                echo "<i>Last Updated: " . $mins . " minute ago</i>";
                                            } else {
                                                echo "<i>Last Updated: " . $mins . " minutes ago</i>";
                                            }
                                        ?>
                                        <h6><i>(Event leaderboard is automatically updated every 10 minutes)</i></h6>
                                    </div>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Tournament Position</th>
                                                <th>Name</th>
                                                <th>Total Points</th>
                                                <th>Event Kills</th>
                                                <th>Event Wins</th>
                                                <th>Event Forcefield Time</th>
                                                <th>Event Deaths</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            $i = 1;

                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $total_points = $row['total_points'];
                                                    $kills = $row['event_kills'];
                                                    $wins = $row['event_wins'];
                                                    $deaths = $row['event_deaths'];
                                                    $forcefield = $row['event_ff'];

                                                    $points_format = number_format($total_points);
                                                    $kills_format = number_format($kills);
                                                    $wins_format = number_format($wins);
                                                    $deaths_format = number_format($deaths);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $points_format . '</td>';
                                                        echo '<td>' . $kills_format . '</td>';
                                                        echo '<td>' . $wins_format . '</td>';
                                                        echo '<td>' . $forcefield . '</td>';
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