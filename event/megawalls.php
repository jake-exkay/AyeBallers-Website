<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/custom_styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="../js/countdown.js"></script>

        <title>Mega Walls Tournament - Leaderboard</title>

        <?php

            include "../includes/connect.php";
            include "../functions/functions.php";
            include "event_functions.php";

            updatePageViews($connection, 'mw_event', $DEV_IP);

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
                            <br>
                            <b><h1 class="ayeballers_font">MEGAWALLS TOURNAMENT</h1></b>
                            <center>
                                <h3 class="ayeballers_font">(Tournament ends: 33/33/33)</h3>
                            </center>
                                    
                            <br><br>
                            

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
                                        <?php if (eventStatus($connection) == 1) { ?>
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
                                                    <form action="event_update.php">
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
                                            <?php 
                                                } elseif (eventStatus($connection) == 2) { 
                                                    echo "<i>Event is finished, showing final results.</i>";
                                                } elseif (eventStatus($connection) == 0) {
                                                    echo "<i>Event has not started.</i>";
                                                } else {
                                                    echo "<i>Event has not started.</i>";
                                                }


                                            ?>
                                    </div>
                                    <br>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Tournament Position</th>
                                                <th>Name</th>
                                                <th>Event Wins</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            $i = 1;

                                            $query = "SELECT * FROM event ORDER BY (current_wins - starting_wins) DESC";
                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $current_wins = $row['current_wins'];
                                                    $starting_wins = $row['starting_wins'];

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . ($current_wins - $starting_wins) . '</td>';
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
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    </body>
</html>
