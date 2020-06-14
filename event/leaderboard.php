<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../../css/styles.css" rel="stylesheet" />
        <link href="../../../css/custom_styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <script>
            var countDownDate = new Date("May 23, 2021 22:00:00").getTime();
            var x = setInterval(function() {
                var now = new Date().getTime();

                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "";
                }
            }, 1000);
        </script>

        <title>Event Leaderboard</title>

        <?php

            include "../includes/connect.php";
            include "../functions/functions.php";
            include "../css/custom_styles.css";
            include "event_functions.php";

            $tournament_started = false;

            updatePageViews($connection, 'event_leaderboard');

            $query = "SELECT * FROM event ORDER BY total_points DESC";
            $result = $connection->query($query);

            $last_updated_query = "SELECT * FROM event_management";
            $last_updated_result = $connection->query($last_updated_query);

            if ($last_updated_result->num_rows > 0) {
                while($last_updated_row = $last_updated_result->fetch_assoc()) {
                    $last_updated = $last_updated_row['last_updated'];
                }
            }

            $mins = timeSinceUpdate($last_updated);
        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <center>
                            <br><br>
                            <b><h1 style="font-family: BKANT, sans-serif">Paintball Tournament #2</h1></b>

                            <?php
                                if ($tournament_started == false) {
                            ?>

                                <div class="border" style="border-radius: 10px; margin-left: 600px; margin-right: 600px;">
                                    <center><h3>Time Until Tournament: </h3><h3 style="font-family: BKANT, sans-serif" id="countdown"></h3></center>
                            <?php } else { ?>
                                    <center><h3>Time Remaining In Tournament: </h3><h3 style="font-family: BKANT, sans-serif" id="countdown"></h3></center>
                            <?php } ?>
                                </div>
                                    
                            <br><br>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <p>View Event Thread</p>
                                </div>
                                <div class="col-md-4">
                                    <p><a href="report.php">Report NoxyD/Rezzus User</a></p>
                                </div>
                                <div class="col-md-4">
                                    <p><a href="https://hypixel.net/threads/paintball-tournament-official-community-tournament-win-real-money.2831526/" target="_blank">View Previous Tournament</a></p>
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
                                            <form action="event_update.php">
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
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Tournament Position</th>
                                                <th>Name</th>
                                                <th>Total Points</th>
                                                <th>Event Kills</th>
                                                <th>Event Wins</th>
                                                <th>Event Forcefield Time (Seconds)</th>
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
                                                    $kills = $row['current_kills'];
                                                    $wins = $row['current_wins'];
                                                    $deaths = $row['current_deaths'];
                                                    $forcefield = $row['current_ff'];
                                                    $kills_start = $row['starting_kills'];
                                                    $wins_start = $row['starting_wins'];
                                                    $deaths_start = $row['starting_deaths'];
                                                    $forcefield_start = $row['starting_ff'];

                                                    $event_kills = $kills - $kills_start;
                                                    $event_wins = $wins - $wins_start;
                                                    $event_deaths = $deaths - $deaths_start;
                                                    $event_forcefield = $forcefield - $forcefield_start;

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if ($name == 'recordheat') {
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (1st)" height="25" width="auto" src="../assets/img/gold.png"/></td>';
                                                        } else if ($name == 'pcint') {
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (2nd)" height="25" width="auto" src="../assets/img/silver.png"/></td>';
                                                        } else if ($name == 'gibbgibb') {
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (3rd)" height="25" width="auto" src="../assets/img/bronze.png"/></td>';
                                                        } else if ($name == 'ExKay') {
                                                        echo '<td>' . $name . ' <img title="Event Staff" height="15" width="auto" src="../assets/img/star.png"/></td>';
                                                        } else if ($name == 'Emilyie') {
                                                        echo '<td>' . $name . ' <img title="Event Staff" height="15" width="auto" src="../assets/img/star.png"/></td>';
                                                        } else if ($name == 'PotAccuracy') {
                                                        echo '<td>' . $name . ' <img title="Event Staff" height="15" width="auto" src="../assets/img/star.png"/></td>';
                                                        } else {
                                                            echo '<td>' . $name . '</td>';
                                                        }
                                                        echo '<td>' . $total_points . '</td>';
                                                        echo '<td>' . $event_kills . '<p style="color:Green;">(+' . $event_kills . ')</p></td>';
                                                        echo '<td>' . $event_wins . '<p style="color:Green;">(+' . ($event_wins * 15) . ')</p></td>';
                                                        echo '<td>' . $event_forcefield . '<p style="color:Green;">(+' . (round($event_forcefield * 5 / 60)) . ')</p></td>';
                                                        echo '<td>' . $event_deaths . '<p style="color:Red;">(-' . $event_deaths . ')</p></td>';
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
