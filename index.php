<?php
/**
 * Home page - Langing page, shows guild information.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

require "includes/links.php";
require "functions/functions.php";
require "functions/display_functions.php";
require "functions/text_constants.php";

updatePageViews($connection, 'home_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Home - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <center>
                        <img class="website_header" alt="AyeBallers Logo" src="assets/img/ayeballers.png"/>
                    </center>

                    <div class="row">
	                    <div class="col-md-8">
		                    <center>
		                        <h2 class="ayeballers_font">Yes, this is the real AyeBallers.</h2>
		                    </center>

		                    <p class="home_paragraph">
		                        <?php echo $GUILD_INTRO; ?>
		                    </p>

		                    <center>
		                        <h2 class="ayeballers_font">Requirements and Applications</h2>
		                    </center>

		                    <p class="home_paragraph">
		                        <?php echo $GUILD_RECRUIT; ?>
		                    </p>

		                    <center>
		                        <h2 class="ayeballers_font">Website Information</h2>
		                    </center>

		                    <p class="home_paragraph">
		                        <?php echo $WEB_INFO; ?>
		                    </p>

		                    <center>
		                        <p>
		                            <a href="https://hypixel.net/threads/%E2%9C%A9-ayeballers-pb-all-games-1-paintball-applications-open-%E2%9C%A9.2801206/">
		                                <?php echo $GUILD_THREAD; ?>
		                            </a>
		                        </p>
		                    </center>
		                </div>

		                <div class="col-md-4">
		                    <center>
		                        <h2 class="ayeballers_font">Staff Team</h2>
		                    </center>

		                    <center>
		                        
                                    <?php displayStaffMember("PotAccuracy", "Leader", "Founder"); ?>
		                            <?php displayStaffMember("Emirichuwu", "Admin", "Event Management"); ?>
		                            <?php displayStaffMember("AyeCool", "Admin", "Founder"); ?>
		                            <?php displayStaffMember("ExKay", "Admin", "Site Management"); ?>
		                            <?php displayStaffMember("Penderdrill", "Officer", "Officer"); ?>
		                            <?php displayStaffMember("zweg", "Officer", "Officer"); ?>
		                            <?php displayStaffMember("Spinominus_Rex", "Officer", "Officer"); ?>
		                            <?php displayStaffMember("Da_Boss106", "Officer", "Officer"); ?>

		                    </center>
		                </div>
		            </div>
                </main>

                <?php require "includes/footer.php"; ?>

            </div>

    </body>
</html>
