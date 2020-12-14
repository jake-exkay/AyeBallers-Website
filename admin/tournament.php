<?php
/**
 * Admin tournament page - Showing tournament management.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/admin/tournament.php
 */

require "../includes/links.php";
require "../includes/constants.php";
require "../functions/functions.php";
require "../functions/display_functions.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

if (isLoggedIn($connection)) {

updatePageViews($connection, 'admin_tournament', $DEV_IP);

$filter = ['tournamentID' => 'pb3']; 
$query = new MongoDB\Driver\Query($filter);     

$res = $mongo_mng->executeQuery("ayeballers.tournament", $query);

$tournament = current($res->toArray());

$start_time = $tournament->startTime;
$start_time = date("d M Y (H:i:s)", (int)substr($start_time, 0, 10));
$end_time = $tournament->endTime;
$end_time = date("d M Y (H:i:s)", (int)substr($end_time, 0, 10));

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Tournament Manager - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Tournament Status
                                        </div>
                                        <div class="card-body">
                                            <p><b>Next Tournament: </b><?php echo $tournament->title; ?></p>
                                            <p><b>Status: </b><?php echo $tournament->status; ?></p>
                                            <p><b>Start Date: </b><?php echo $start_time; ?></p>
                                            <p><b>End Date: </b><?php echo $end_time; ?></p>
                                            <p><b>Host: </b><?php echo $tournament->host; ?></p>
                                            <form action="">
                                                <button class="btn btn-success">Start Tournament</button><br>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Report Management
                                        </div>
                                        <div class="card-body">
                                            <p><b>Banned Hats:</b></p>
                                            <p>Rezzus</p>
                                            <p>NoxyD</p>
                                            <form action="event/reports.php">
                                                <button class="btn btn-success">View Reports</button><br>
                                            </form>
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-3">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Participants
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-9">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Leaderboard
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Add Player
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </main>

                <?php require "../includes/footer.php"; ?>

            </div>

    </body>

</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>
