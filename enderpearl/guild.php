<?php
/**
 * Admin guild management page - Graphs for guild management.
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
require "../functions/backend_functions.php";
require "../includes/connect.php";
require "../functions/display_functions.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

if (isLoggedIn($connection)) {
    $week = array_reverse(getLastWeekExperience($connection));
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Guild Manager - AyeBallers</title>
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
                                            New Members (Last 7 Days)
                                        </div>
                                        <div class="card-body">
                                            
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Members Left (Last 7 Days)
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild Experience (Last 7 Days)
                                        </div>
                                        <div class="card-body">
                                            <canvas id="viewChart" style="max-width: 1000px; margin: auto; width: 50%; padding: 10px;"></canvas>
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

    <script src="js/mdb.js"></script>

    <script type="text/javascript">
        var ctx = document.getElementById("viewChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Today - 6", "Today - 5", "Today - 4", "Today - 3", "Today - 2", "Today - 1", "Today"],
                datasets: [{
                    label: 'Guild Experience',
                    data: ["<?php echo $week[0]; ?>", "<?php echo $week[1]; ?>", "<?php echo $week[2]; ?>", "<?php echo $week[3]; ?>", "<?php echo $week[4]; ?>", "<?php echo $week[5]; ?>", "<?php echo $week[6]; ?>"],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>

</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>
