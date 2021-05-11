<?php
require "../includes/links.php";
require "../includes/constants.php";
require "../functions/backend_functions.php";
require "../functions/player_functions.php";
require "../includes/connect.php";
require "functions/database_functions.php";
require "functions/login_functions.php";

if (isLoggedIn($connection)) {
?>

<head>

    <title>AyeBallers - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AyeBallers Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                General
            </div>

            <li class="nav-item">
                <a class="nav-link" href="player.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Player Statistics</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Guild Statistics</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="staff.php">
                    <i class="fas fa-fw fa-star"></i>
                    <span>Hypixel Staff</span></a>
            </li>

            <div class="sidebar-heading">
                Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="../enderpearl/dashboard.php">
                    <i class="fa fa-circle"></i>
                    <span>Enderpearl</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tournament.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Tournament</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo getUsername($connection); ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Player Statistics</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Lookups</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo getTotalPlayerLookups($connection); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Stored Players</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo getTotalCachedPlayers($mongo_mng); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                                </div>
                                <div class="card-body">
                                <?php
                                    $name = getMostRecentLookup($connection);
                                    $player = getPlayerByName($mongo_mng, $name);
                                    $rank = $player->rank;
                                    $rank_colour = $player->rankColour;
                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                                ?>
                                <b>Total Stored Players: </b><?php echo getTotalCachedPlayers($mongo_mng); ?><br>
                                <b>Total Player Lookups: </b><?php echo getTotalPlayerLookups($connection); ?><br>
                                <b>Most Recent Lookup: </b><?php echo '<a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a>'; ?><br>
                                </div>
                            </div>

                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-table mr-1"></i>
                                        Import Players
                                    </div>
                                    <div class="card-body">
                                        <form class="form-signin" name="importForm" action="player.php" method="POST" enctype="multipart/form-data">
                                            <input type="text" class="form-control" name="player" placeholder="Player Name">
                                            <button name="submit" type="submit" class="btn btn-lg btn-primary">Import</button>
                                        </form>
                                    </div>
                                </div>
                        </div>

                        <div class="col-xl-7 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Recent Lookups</h6>
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
                                                        $player = getPlayerByName($mongo_mng, $name);
                                                        $rank = $player->rank;
                                                        $rank_colour = $player->rankColour;
                                                        $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                        echo '<tr>';
                                                            echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
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

                    <div class="row">
                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Manual Import Player</h6>
                                </div>
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

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="../js/mdb.js"></script>

    <?php
        $home_views = getPageViews($connection, "home_page");
        $guild_views = getPageViews($connection, "guild_page");
        $player_views = getPageViews($connection, "stats_page");

        $pb_o = getPageViews($connection, "paintball_overall_leaderboard");
        $vz_o = getPageViews($connection, "vz_overall_leaderboard");
        $qc_o = getPageViews($connection, "quake_overall_leaderboard");
        $tkr_o = getPageViews($connection, "tkr_overall_leaderboard");
        $walls_o = getPageViews($connection, "walls_overall_leaderboard");
        $arena_o = getPageViews($connection, "arena_overall_leaderboard");
        $tnt_o = getPageViews($connection, "tnt_overall_leaderboard");
        $skywars_o = getPageViews($connection, "skywars_overall_leaderboard");
        $bedwars_o = getPageViews($connection, "bedwars_overall_leaderboard");
        $warlords_o = getPageViews($connection, "warlords_overall_leaderboard");
        $cvc_o = getPageViews($connection, "copsandcrims_overall_leaderboard");
        $uhc_o = getPageViews($connection, "uhc_overall_leaderboard");
        $arc_o = getPageViews($connection, "arcade_overall_leaderboard");

        $leaderboard_views = $pb_o + $vz_o + $qc_o + $tkr_o + $walls_o + $arena_o + $tnt_o + $skywars_o + $bedwars_o + $warlords_o + $uhc_o + $cvc_o + $arc_o;

        $pb2 = getPageViews($connection, "pb2_leaderboard");
        $pb3 = getPageViews($connection, "pb3_leaderboard");
        $event_views = $pb2 + $pb3;

    ?>

</body>

</html>
<?php } ?>