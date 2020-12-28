<?php
/**
 * Admin dashboard page - Showing basic statistics and information.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/admin/dashboard
 */

require "../includes/links.php";
require "../includes/constants.php";
require "../functions/functions.php";
require "../includes/connect.php";
require "../functions/display_functions.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

if (isLoggedIn($connection)) {

updatePageViews($connection, 'admin_dashboard', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Admin Panel - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            General Statistics
                                        </div>
                                        <div class="card-body">
                                            <b>Total Stored Players: </b><?php echo getTotalCachedPlayers($mongo_mng); ?><br>
                                            <b>Total Stored Guilds: </b><?php echo getTotalCachedGuilds($mongo_mng); ?><br>
                                            <b>Total Admins: </b><?php echo getTotalAdmins($connection); ?><br>
                                            <b>Total Tracked Pages: </b><?php echo getTotalTrackedPages($connection); ?><br>
                                            <b>Total Page Views: </b><?php echo getTotalPageViews($connection); ?>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Admins
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                $result = getAdmins($connection);

                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        $name = $row["username"];
                                                        $last_online = $row["last_login"];
                                                        if ($name == "ExKay") {
                                                            echo "<p><span style='color:#ce1c1c;'>[DEVELOPER] " . $name . "</span>: Last Login: " . $last_online . "</p>";
                                                        } else if ($name == "Emilyie" || $name == "PotAccuracy" || $name == "Penderdrill") {
                                                            echo "<p><span style='color:#ce1c1c;'>[ADMIN] " . $name . "</span>: Last Login: " . $last_online . "</p>";
                                                        } else {
                                                            echo "<p><span style='color:#ce1c1c;'>[RESERVE] " . $name . "</span>: Last Login: " . $last_online . "</p>";
                                                        }
                                                    }
                                                }

                                            ?>
                                            
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Page Views
                                        </div>
                                        <div class="card-body">
                                            <canvas id="viewChart" style="max-width: 1000px; margin: auto; width: 50%; padding: 10px;"></canvas>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $home_views = getPageViews($connection, "home_page");
                        $guild_views = getPageViews($connection, "guild_page");
                        $player_views = getPageViews($connection, "stats_page");

                        $pb_o = getPageViews($connection, "paintball_overall_leaderboard");
                        $vz_o = getPageViews($connection, "vz_overall_leaderboard");
                        $qc_o = getPageViews($connection, "quake_overall_leaderboard");
                        $tkr_o = getPageViews($connection, "tkr_overall_leaderboard");
                        $walls_o = getPageViews($connection, "walls_overall_leaderboard");
                        $arena_o = getPageViews($connection, "arena_overall_leaderboard");
                        $tnt_o = getPageViews($connection, "tnt_overall_leaderboard");
                        $skywars_o = getPageViews($connection, "skywars_overall_leaderboard");
                        $bedwars_o = getPageViews($connection, "bedwars_overall_leaderboard");

                        $leaderboard_views = $pb_o + $vz_o + $qc_o + $tkr_o + $walls_o + $arena_o + $tnt_o + $skywars_o + $bedwars_o;

                        $pb2 = getPageViews($connection, "pb2_leaderboard");
                        $pb3 = getPageViews($connection, "pb3_leaderboard");
                        $event_views = $pb2 + $pb3;

                    ?>

                </main>

                <?php require "../includes/footer.php"; ?>

            </div>

    </body>

    <script src="js/mdb.js"></script>

    <script type="text/javascript">
        var ctx = document.getElementById("viewChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Home", "Player Stats", "Guild Stats", "Leaderboards (Total)", "Event Leaderboard (Total)"],
                datasets: [{
                    label: 'Public Views',
                    data: ["<?php echo $home_views; ?>", "<?php echo $player_views; ?>", "<?php echo $guild_views; ?>", "<?php echo $leaderboard_views; ?>", "<?php echo $event_views; ?>"],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>
