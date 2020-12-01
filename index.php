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
require "includes/constants.php";
require "functions/functions.php";
require "functions/display_functions.php";

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
		                        Our name might sound a little familiar to you, and with good reason. We were THE Paintball guild back in the day. Due to some unfortunate circumstances, the guild died. After many years, we have recently decided to rebuild AyeBallers and bring it back to its former glory. However, many of our OG members have diversified their gameplay or moved on from Paintball entirely, so we have made the decision to have AyeBallers continue as an all games guild with a Paintball past (though we are the #1 Paintball guild, amassing more than 100k wins). We're very excited to have this new beginning and see where the road takes us. As far as what we have to offer, it's a lot. An active and friendly community, daily questing parties, a Discord server, and guild events. We host weekly GEXP contests and other larger events as well.
		                    </p>

		                    <center>
		                        <h2 class="ayeballers_font">Requirements and Applications</h2>
		                    </center>

		                    <p class="home_paragraph">
		                        We have a few requirements to apply, which you can find on the official guild forum post. You should be near or above these requirements if you are applying. We reserve the right to waive these requirements for cool people, but just know that you're probably not one of those. We also reserve the right to change these requirements in the future. Requirements do not apply to current guild members. Meeting requirements does not guarantee acceptance. We also take activity and character into account.
		                    </p>

		                    <center>
		                        <h2 class="ayeballers_font">Website Information</h2>
		                    </center>

		                    <p class="home_paragraph">
		                        This website contains various guild tools such as member list, guild leaderboards and event information. We also provide overall leaderboards for most games on the Hypixel Network so you can see where you stand against others!
		                    </p>

		                    <center>
		                        <p>
		                            <a href="https://hypixel.net/threads/%E2%9C%A9-ayeballers-pb-all-games-1-paintball-applications-open-%E2%9C%A9.2801206/">
		                                Click here to visit the guild thread!
		                            </a>
		                        </p>
		                    </center>
		                </div>

		                <div class="col-md-4">
		                    <center>
		                        <h2 class="ayeballers_font">Staff Team</h2>
		                    </center>

		                    <center>
		                        
                                    <?php displayStaffMember("PotAccuracy", "Leader"); ?>
		                            <?php displayStaffMember("Emirichuwu", "Admin"); ?>
		                            <?php displayStaffMember("AyeCool", "Admin"); ?>
		                            <?php displayStaffMember("ExKay", "Admin"); ?>
		                            <?php displayStaffMember("Penderdrill", "Officer"); ?>
		                            <?php displayStaffMember("zweg", "Officer"); ?>
		                            <?php displayStaffMember("Spinominus_Rex", "Officer"); ?>
		                            <?php displayStaffMember("Da_Boss106", "Officer"); ?>

		                    </center>
		                </div>
		            </div>
                </main>

                <?php require "includes/footer.php"; ?>

            </div>

    </body>
</html>
