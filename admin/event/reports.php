<?php
/**
 * Event reports page - Showing images of reports.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/admin/event/reports.php
 */

require "../../includes/links.php";
require "../../includes/constants.php";
require "../../functions/functions.php";
require "../../functions/display_functions.php";
require "../functions/database_functions.php";
require "../functions/login_functions.php";

if (isLoggedIn($connection)) {

$images = glob("reports/*.png");

$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Event Reports - AyeBallers</title>
	</head>

	<body class="sb-nav-fixed">

        <?php require "../functions/admin-navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

            		<div class="card">
                        <div class="card-body">
                            <form style="margin-right: 10px;" action="<?= $previous ?>">
                                <button type="submit" class="btn btn-danger">< Back</button>
                            </form>
                            <center><h2>Report Viewer</h2></center>

                            <hr><br>

                            <?php               
                                foreach ($images as $image) {
                                    echo '<img width="800" height="auto" src="reports/' . $image . '"/>';
                                } 
                            ?>
                        </div>
                    </div>

                </main>

            <?php require "../../includes/footer.php"; ?>

        </div>

	</body>
</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>