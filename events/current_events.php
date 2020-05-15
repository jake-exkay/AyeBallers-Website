<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="../css/custom_styles.css" rel="stylesheet" />
        <title>AyeBallers Event Management</title>

    </head>

    <body>

        <main>
            <center>
                <img class="website_header" src="../assets/img/ayeballers.png"/>
                <h1 style="font-family: BKANT, sans-serif">Events Management Panel</h1>

                <br><br>

                <h3 style="font-family: BKANT, sans-serif">Current Events</h3>

                <br><br>

                <?php

                    include "../CONSTANTS.php";

                    $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
                   
                    if($connection->connect_error) {
                        echo 'Error connecting to the database';
                    }
            
                    $query = "SELECT * FROM events";
                    $result = $connection->query($query);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $event_name = $row["event_title"];
                            $event_type = $row["event_type"];
                            $game_type = $row["game_type"];
                            $start_date = $row["start_date"];
                            $end_date = $row["end_date"];
                            $event_host = $row["event_host"];
                            $event_status = $row["event_status"];

                            echo '<div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">';
                            echo '<div class="card"><div class="card-body">';
                            echo '<h4 style="font-family: BKANT, sans-serif">' . $event_name . '</h4><br>';
                            echo '<p><b>Event Type: </b>' . $event_type . '</p>';
                            echo '<p><b>Event Host: </b>' . $event_host . '</p>';
                            echo '<p><b>Game: </b>' . $game_type . '</p>';
                            echo '<p><b>Start Date: </b>' . $start_date . '</p>';
                            echo '<p><b>End Date: </b>' . $end_date . '</p>';
                            echo '<p><b>Status: </b>' . $event_status . '</p>';
                            echo '<div class="row">';
                            echo '<div class="col-md-6">';
                            echo '<form action="'.$event_name.'.php">';
                            echo '<button type="submit" class="btn btn-primary">Leaderboard</button>';
                            echo '</form>';
                            echo '</div>';
                            echo '<div class="col-md-6">';
                            echo '<form action="edit_event.php">';
                            echo '<button type="submit" class="btn btn-primary">Edit Event</button>';
                            echo '</form>';
                            echo '</div></div></div></div></div><br><br>';
                        }
                    } else {
                        echo "<p>No events found, add some using the <a href='create_event.php'>\"create event\" page</a></p>";                        
                    }               

                ?>

                

                <br><br><br><br><br><br><br><br><br><br>

            </center>

        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Logged in as: testuser (Logout)</div>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
