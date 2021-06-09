<?php
require "../includes/links.php";
require "../includes/constants.php";
require "../functions/backend_functions.php";
require "../functions/player_functions.php";
require "../includes/connect.php";
require "functions/backend_functions.php";
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
                        <h1 class="h3 mb-0 text-gray-800">Hypixel Staff</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Admin Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Admins</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count(getPlayersByRank($mongo_mng, "ADMIN")); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- GM Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Game Masters</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count(getPlayersByRank($mongo_mng, "GAME_MASTER")); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mod Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Moderators</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count(getPlayersByRank($mongo_mng, "MODERATOR")); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- YouTuber Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                YouTubers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo count(getPlayersByRank($mongo_mng, "YOUTUBER")); ?></div>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Admin List</h6>
                                </div>
                                <div class="card-body">
                                    <table id="admin" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $admins = getPlayersByRank($mongo_mng, "ADMIN");

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

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Game Master List</h6>
                                </div>
                                <div class="card-body">
                                    <table id="mod" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $gms = getPlayersByRank($mongo_mng, "GAME_MASTER");

                                                foreach ($gms as $gm) {
                                                    echo '<tr>';
                                                        echo '<td><a href="../stats.php?player=' . $gm . '">' . getRankFormatting($gm, "GAME_MASTER", "None") . '</a></td>';
                                                    echo '</tr>'; 
                                                }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Moderator List</h6>
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

                                                $mods = getPlayersByRank($mongo_mng, "MODERATOR");

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

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">YouTuber List</h6>
                                </div>
                                <div class="card-body">
                                    <table id="yt" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $yts = getPlayersByRank($mongo_mng, "YOUTUBER");

                                                foreach ($yts as $yt) {
                                                    echo '<tr>';
                                                        echo '<td><a href="../stats.php?player=' . $yt . '">' . getRankFormatting($yt, "YOUTUBER", "None") . '</a></td>';
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