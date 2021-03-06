<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../../css/styles.css" rel="stylesheet" />
        <link href="../../css/custom_styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="../../js/countdown.js"></script>

        <title>Paintball Tournament #2 - Leaderboard</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/backend_functions.php";
            include "event_functions.php";

            updatePageViews($connection, 'pb2_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <center>
                            <br>
                            <b><h1 class="ayeballers_font">PAINTBALL TOURNAMENT #2</h1></b>
                            <center>
                                <h3 class="ayeballers_font">(Tournament has ended)</h3>
                            </center>
                                    
                            <br><br>
                            
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <form action="https://hypixel.net/threads/paintball-tournament-v2-win-real-money.3045096/">
                                        <button type="submit" class="btn btn-primary">Event Thread</button>
                                    </form>
                                </div>
                                <div class="col-md-6 text-center">
                                    <form action="https://hypixel.net/threads/paintball-tournament-official-community-tournament-win-real-money.2831526/">
                                        <button type="submit" class="btn btn-primary">Previous Tournament</button>
                                    </form>
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
                                        <i>Event has finished, showing final results.</i>
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

                                            $query = "SELECT * FROM pb2_event ORDER BY total_points DESC";
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
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (1st)" height="25" width="auto" src="../../assets/img/gold.png"/></td>';
                                                        } else if ($name == 'pcint') {
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (2nd)" height="25" width="auto" src="../../assets/img/silver.png"/></td>';
                                                        } else if ($name == 'gibbgibb') {
                                                            echo '<td>' . $name . ' <img title="Previous Tournament Winner (3rd)" height="25" width="auto" src="../../assets/img/bronze.png"/></td>';
                                                        } else if ($name == 'ExKay') {
                                                        echo '<td>' . $name . ' <img title="AyeBallers Member" height="15" width="auto" src="../../assets/img/favicon.png"/><img title="Event Staff" height="15" width="auto" src="../../assets/img/star.png"/></td>';
                                                        } else if ($name == 'Emilyie') {
                                                        echo '<td>' . $name . ' <img title="AyeBallers Member" height="15" width="auto" src="../../assets/img/favicon.png"/><img title="Event Staff" height="15" width="auto" src="../../assets/img/star.png"/></td>';
                                                        } else if ($name == 'PotAccuracy') {
                                                        echo '<td>' . $name . ' <img title="AyeBallers Member" height="15" width="auto" src="../../assets/img/favicon.png"/><img title="Event Staff" height="15" width="auto" src="../../assets/img/star.png"/></td>';
                                                        } else if (false) {
                                                            echo '<td>' . $name . ' <img title="AyeBallers Member" height="15" width="auto" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td>' . $name . '</td>';
                                                        }
                                                        echo '<td>' . $total_points . '</td>';
                                                        echo '<td>' . $event_kills . '<p style="color:Green;">(+' . $event_kills . ')</p></td>';
                                                        echo '<td>' . $event_wins . '<p style="color:Green;">(+' . ($event_wins * 15) . ')</p></td>';
                                                        echo '<td>' . $event_forcefield . ' (' . round($event_forcefield / 60) . ' mins) <p style="color:Green;">(+' . (round($event_forcefield * 5 / 60)) . ')</p></td>';
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
        <script src="../../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    </body>
</html>
