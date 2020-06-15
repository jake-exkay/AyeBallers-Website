<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="css/custom_styles.css" rel="stylesheet" />
        <title>Home - AyeBallers</title>

        <?php

            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";

            updatePageViews($connection, 'home_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

                    <center><img style="padding-top: 50px" class="website_header" src="assets/img/ayeballers.png"/></center>

                    <center>
                        <h2 style="font-family: BKANT, sans-serif">Yes, this is the real AyeBallers.</h2>
                    </center>
                    <p style="padding-left: 200px; padding-right: 200px; font-family: BKANT, sans-serif;">Our name might sound a little familiar to you, and with good reason. We were THE Paintball guild back in the day. Due to some unfortunate circumstances, the guild died. After many years, we have recently decided to rebuild AyeBallers and bring it back to its former glory. However, many of our OG members have diversified their gameplay or moved on from Paintball entirely, so we have made the decision to have AyeBallers continue as an all games guild with a Paintball past (though we are the #1 Paintball guild, amassing more than 100k wins). We're very excited to have this new beginning and see where the road takes us. As far as what we have to offer, it's a lot. An active and friendly community, daily questing parties, a Discord server, and guild events. We host weekly GEXP contests and other larger events as well.</p>

                    <center>
                        <h2 style="font-family: BKANT, sans-serif">Requirements and Applications</h2>
                    </center>
                    <p style="padding-left: 200px; padding-right: 200px; font-family: BKANT, sans-serif;">We have a few requirements to apply, which you can find on the official guild forum post. You should be near or above these requirements if you are applying. We reserve the right to waive these requirements for cool people, but just know that you're probably not one of those. We also reserve the right to change these requirements in the future. Requirements do not apply to current guild members. Meeting requirements does not guarantee acceptance. We also take activity and character into account.</p>

                    <center>
                        <p>
                            <a href="https://hypixel.net/threads/%E2%9C%A9-ayeballers-pb-all-games-1-paintball-applications-open-%E2%9C%A9.2801206/">Click here to visit the guild thread!</a>
                        </p>
                    </center>

                    <center>
                        <h2 style="font-family: BKANT, sans-serif">Staff Team</h2>
                    </center>

                    <center>
                        <div class="row">

                            <div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Leader</h5>
                                        <h5>AyeCool</h5>
                                        <img style="height: 200px; width: 200px;" src="assets/img/AyeCool.png"/>
                                        <p>Leadership</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Leader</h5>
                                        <h5>PotAccuracy</h5>
                                        <img style="height: 200px; width: 200px;" src="assets/img/PotAccuracy.png"/>
                                        <p>Staff Management + Recruitment</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Admin</h5>
                                        <h5>ExKay</h5>
                                        <img style="height: 200px; width: 200px;" src="assets/img/ExKay.png"/>
                                        <p>Development + Site Management</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Admin</h5>
                                        <h5>Emilyie</h5>
                                        <img style="height: 200px; width: 200px;" src="assets/img/Emilyie.png"/>
                                        <p>Events Management, Forums and Announcements</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </center>
                </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
                    </div>
                </div>
            </footer>

        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
