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

                    <div class="row">
                        <div class="col-md-6">
                            <h2 style="text-align: center; margin: auto; width: 50%; padding: 10px;">Page Views</h2>
                            <canvas id="viewChart" style="max-width: 1000px; margin: auto; width: 50%; padding: 10px;"></canvas>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <?php
                        $home_views = getPageViews($connection, "home_page");
                        $guild_views = getPageViews($connection, "guild_page");
                        $player_views = getPageViews($connection, "player_page");
                        $stats_views = getPageViews($connection, "stats_page");

                        $pb_o = getPageViews($connection, "paintball_overall_leaderboard");
                        $pb_g = getPageViews($connection, "paintball_guild_leaderboard");
                        $vz_o = getPageViews($connection, "vz_overall_leaderboard");
                        $vz_g = getPageViews($connection, "vz_guild_leaderboard");
                        $qc_o = getPageViews($connection, "quake_overall_leaderboard");
                        $qc_g = getPageViews($connection, "quakecraft_guild_leaderboard");
                        $tkr_o = getPageViews($connection, "tkr_overall_leaderboard");
                        $tkr_g = getPageViews($connection, "tkr_guild_leaderboard");
                        $walls_o = getPageViews($connection, "walls_overall_leaderboard");
                        $walls_g = getPageViews($connection, "walls_guild_leaderboard");
                        $walls_g = getPageViews($connection, "arena_overall_leaderboard");
                        $walls_g = getPageViews($connection, "arena_guild_leaderboard");

                        $leaderboard_views = $pb_g + $pb_o + $vz_g + $vz_o + $qc_g + $qc_o + $tkr_g + $tkr_o + $walls_g + $walls_o + $arena_o + $arena_g;

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
                labels: ["Home", "Guild", "Player Search", "Player Statistics", "Leaderboards"],
                datasets: [{
                    label: 'Public Views',
                    data: ["<?php echo $home_views; ?>", "<?php echo $guild_views; ?>", "<?php echo $player_views; ?>", "<?php echo $stats_views; ?>", "<?php echo $leaderboard_views; ?>"],
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
