<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="../css/custom_styles.css" rel="stylesheet" />
        <title>AyeBallers Event Management</title>

        <?php

            include "../CONSTANTS.php";

            $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
               
            if($connection->connect_error) {
                echo 'Error connecting to the database';
            }

            if (isset($_POST['submit'])) {
                $event_name = $_POST['event_name'];
                $event_type = $_POST['event_type'];
                $game_type = $_POST['game_type'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $first_prize = $_POST['first_prize'];
                $second_prize = $_POST['second_prize'];
                $third_prize = $_POST['third_prize'];
                $event_host = $_POST['event_host'];

                if (strlen($event_name) > 99) {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Event name is too long! (Please keep the event name under 100 characters)
                          </div>';

                } else if (strlen($first_prize) > 99) {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: First Prize is too long! (Please keep it under 100 characters)
                          </div>';

                } else if (strlen($second_prize) > 99) {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Second Prize is too long! (Please keep it under 100 characters)
                          </div>';

                } else if (strlen($third_prize) > 99) {
                    echo '<div class="alert alert-danger" role="alert">
                                Error: Third Prize is too long! (Please keep it under 100 characters)
                          </div>';

                } else {

                    $query = "INSERT INTO events (event_title, game_type, event_type, start_date, end_date, first_prize, second_prize, third_prize, event_host, date_added, last_updated)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())";

                    if($statement = mysqli_prepare($connection, $query)) {
                        mysqli_stmt_bind_param($statement, "sssssssss", $event_name, $game_type, $event_type, $start_date, $end_date, $first_prize, $second_prize, $third_prize, $event_host);
                        mysqli_stmt_execute($statement);
                        echo '<div class="alert alert-success" role="alert">
                                    Successfully added event!
                              </div>'; 
                        copy('/var/www/html/events/event_template.php', ('/var/www/html/events/' . $event_name . '.php'));
                        mysqli_stmt_close($statement);
                        header("Refresh:0.01; url=create_event.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">
                                    Error: Could not add event! Please contact an administrator.
                              </div>'; 
                    }


                }

            }

            $connection->close();

    ?>

    </head>

    <body>

        <main>
            <center>
                <img class="website_header" src="../assets/img/ayeballers.png"/>
                <h1 style="font-family: BKANT, sans-serif">Events Management Panel</h1>

                <br><br><br><br>

                <form name="add_event_form" action="create_event.php" method="POST" enctype="multipart/form-data">

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Event Name</label>
                            <input type="text" class="form-control" name="event_name" required>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Event Host</label>
                            <select name="event_host">
                                <option>Emilyie</option>
                                <option>Ferozion</option>
                                <option>julikabum</option>
                                <option>Penderdrill</option>
                                <option>Christinekc</option>
                                <option>ExKay</option>
                                <option>AyeCool</option>
                                <option>PotAccuracy</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Event Type</label>
                            <select name="event_type">
                                <option>Community Event</option>
                                <option>Guild Event</option>
                                <option>GEXP Event</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Game Type</label>
                            <select name="game_type">
                                <option>Paintball</option>
                                <option>Arcade</option>
                                <option>Turbo Kart Racers</option>
                                <option>Mega Walls</option>
                                <option>The Walls</option>
                                <option>Blitz Survival Games</option>
                                <option>VampireZ</option>
                                <option>Quakecraft</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Start Date</label>
                            <input type="text" class="form-control" name="start_date" required data-validation-required-message="Start Date">
                        </div>
                    </div>

                    <div class="control-group form-group">
                        <div class="controls">
                            <label>End Date</label>
                            <input type="text" class="form-control" name="end_date" required data-validation-required-message="End Date">
                        </div>
                    </div>

                    <div class="row">
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>First Prize (Not Required)</label>
                                <input type="text" class="form-control" name="first_prize" data-validation-required-message="first_prize">
                            </div>
                        </div>


                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Second Prize (Not Required)</label>
                                <input type="text" class="form-control" name="second_prize" data-validation-required-message="second_prize">
                            </div>
                        </div>


                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Third Prize (Not Required)</label>
                                <input type="text" class="form-control" name="third_prize" data-validation-required-message="third_prize">
                            </div>
                        </div>
                    </div>

                    <button name="submit" type="submit" class="btn btn-primary" id="create_button">Create Event</button>
          
                </form>
                

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
