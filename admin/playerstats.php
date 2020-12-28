<?php
/**
 * Admin player statistics page - showing information about player lookups.
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

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Player Statistics - AyeBallers</title>
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
                                            Player Statistics
                                        </div>
                                        <div class="card-body">
                                            <b>Total Stored Players: </b><?php echo getTotalCachedPlayers($mongo_mng); ?><br>
                                            <b>Total Player Lookups: </b><?php echo getTotalPlayerLookups($connection); ?><br>
                                            <b>Most Recent Lookup: </b><?php echo getMostRecentLookup($connection); ?><br>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Recent Lookups
                                        </div>
                                        <div class="card-body">
                                            <table id="admin" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Player Viewed</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                        $result = getRecentLookups($connection);

                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                $name = $row["action"];
                                                                $accessed_time = $row["updated_time"];

                                                                echo '<tr>';
                                                                    echo '<td>' . $name . '</td>';
                                                                    echo '<td>' . $accessed_time . '</td>';
                                                                echo '</tr>'; 
                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
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
