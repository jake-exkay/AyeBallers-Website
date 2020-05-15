<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="css/custom_styles.css" rel="stylesheet" />
        <title>AyeBallers Event Management</title>

        <?php
            include "../CONSTANTS.php";

            $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
               
            if($connection->connect_error) {
                echo 'Error connecting to the database';
            }

            $event_name = basename(__FILE__, '.php');

            $query = "SELECT * FROM events where event_title='$event_name'";
            $result = $connection->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $event_type = $row["event_type"];
                    $game_type = $row["game_type"];
                    $start_date = $row["start_date"];
                    $end_date = $row["end_date"];
                    $event_host = $row["event_host"];
                    $event_status = $row["event_status"];

                   
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
                            Error: We could not retrieve the event data! Please contact an administrator. 
                      </div>';
            }
        ?>

    </head>

    <body>

        <main>
            <center>
                <img class="website_header" src="assets/img/ayeballers.png"/>
                <h1 style="font-family: BKANT, sans-serif">Events Management Panel</h1>

                <br><br><br><br>

                <form action="events/current_events.php">
                    <button style="font-family: BKANT, sans-serif" type="submit" class="btn btn-dark">View Current Events</button>
                </form>

                <br><br>

                <form action="events/create_event.php">
                    <button style="font-family: BKANT, sans-serif" type="submit" class="btn btn-dark">Create An Event</button>
                </form>

                <br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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
