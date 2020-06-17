<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Home - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";

            updatePageViews($connection, 'home_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php include "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <center>
                        <img class="website_header" src="assets/img/ayeballers.png"/>
                    </center>

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
                        <p>
                            <a href="https://hypixel.net/threads/%E2%9C%A9-ayeballers-pb-all-games-1-paintball-applications-open-%E2%9C%A9.2801206/">
                                <?php echo $GUILD_THREAD; ?>
                            </a>
                        </p>
                    </center>

                    <center>
                        <h2 class="ayeballers_font">Staff Team</h2>
                    </center>

                    <center>
                        <div class="row">

                            <?php displayStaffMember("AyeCool", "Leader", "Leadership"); ?>
                            <?php displayStaffMember("PotAccuracy", "Leader", "Staff Management / Recruitment"); ?>
                            <?php displayStaffMember("ExKay", "Admin", "Site Management"); ?>
                            <?php displayStaffMember("Emilyie", "Admin", "Event Management"); ?>

                        </div>
                    </center>

                </main>

                <?php include "includes/footer.php"; ?>

            </div>

    </body>
</html>
