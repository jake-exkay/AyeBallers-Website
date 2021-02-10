<?php
/**
 * Admin import page - Allows importing of multiple players.
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
require "../functions/player_functions.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

if (isLoggedIn($connection)) {

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Manual Import - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <div class="card">
                        <div class="card-body">

                            <?php
                                if (isset($_POST['player'])) {
                                    $player = $_POST["player"];
                                    $uuid = getUUID($connection, $player);
                                    $formatted_name = getRealName($uuid);

                                    if (!updatePlayer($mongo_mng, $uuid, $API_KEY)) {
                                        echo '<div class="alert alert-danger" role="alert">Error! Could not import ' . $player . '</div>';
                                    } else {
                                        updateStatsLog($connection, $formatted_name);
                                        echo '<div class="alert alert-success" role="alert">Success! Manually Imported ' . $player . '</div>';
                                    }
                                }
                            ?>

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Import Players
                                        </div>
                                        <div class="card-body">
                                            <form class="form-signin" name="importForm" action="manualimport.php" method="POST" enctype="multipart/form-data">
                                                <input type="text" class="form-control" name="player" placeholder="Player Name">
                                                <button name="submit" type="submit" class="btn btn-lg btn-primary">Import</button>
                                            </form>
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
