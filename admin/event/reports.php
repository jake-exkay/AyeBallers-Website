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

updatePageViews($connection, 'admin_dashboard', $DEV_IP);

$directory = "../reports";
$images = glob($directory . "/*.png");

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

            		<center>
            			<h2>AyeBallers Tournament Report Viewer</h2>
            		</center>

            		<br>

            		<?php 				
            			foreach ($images as $image) {
            				echo '<img width="800" height="auto" src="reports/' . $image . '"/>';
            			} 
            		?>

                </main>

            <?php require "../includes/footer.php"; ?>

        </div>

	</body>
</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>