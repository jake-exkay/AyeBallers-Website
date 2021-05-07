<?php
/**
 * Admin hypixel staff list.
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
require "functions/database_functions.php";
require "functions/login_functions.php";
require "../functions/player_functions.php";

if (isLoggedIn($connection)) {

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Hypixel Staff List - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Hypixel Staff List</h1>
                        <p>Please note that Hypixel staff lists are not allowed to prevent staff recieving spam. Please do not share this list outside of the admin panel.</p>
                        <hr>

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-table mr-1"></i>
                                                Hypixel Admins
                                            </div>
                                            <div class="card-body">
                                                <table id="helpers" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                            $admins = getListOfAdmins($mongo_mng);

                                                            foreach ($admins as $admin) {
                                                                echo '<tr>';
                                                                    echo '<td><a href="../stats.php?player=' . $admin . '">' . getRankFormatting($admin, "ADMIN", "None") . '</a></td>';
                                                                echo '</tr>'; 
                                                            }

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-table mr-1"></i>
                                                Hypixel Moderators
                                            </div>
                                            <div class="card-body">
                                                <table id="helpers" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                            $mods = getListOfMods($mongo_mng);

                                                            foreach ($mods as $mod) {
                                                                echo '<tr>';
                                                                    echo '<td><a href="../stats.php?player=' . $mod . '">' . getRankFormatting($mod, "MODERATOR", "None") . '</a></td>';
                                                                echo '</tr>'; 
                                                            }

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-table mr-1"></i>
                                                Hypixel Helpers
                                            </div>
                                            <div class="card-body">
                                                <table id="helpers" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                            $helpers = getListOfHelpers($mongo_mng);

                                                            foreach ($helpers as $helper) {
                                                                echo '<tr>';
                                                                    echo '<td><a href="../stats.php?player=' . $helper . '">' . getRankFormatting($helper, "HELPER", "None") . '</a></td>';
                                                                echo '</tr>'; 
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
                    </div>

                </main>

                <?php require "../includes/footer.php"; ?>

            </div>

    </body>

</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>
