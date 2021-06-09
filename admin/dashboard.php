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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Side navbar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AyeBallers Admin</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                General
            </div>

            <li class="nav-item">
                <a class="nav-link" href="player.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Player Statistics</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Guild Statistics</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="staff.php">
                    <i class="fas fa-fw fa-star"></i>
                    <span>Hypixel Staff</span>
                </a>
            </li>

            <div class="sidebar-heading">
                Management
            </div>

            <li class="nav-item">
                <a class="nav-link" href="../enderpearl/dashboard.php">
                    <i class="fa fa-circle"></i>
                    <span>Enderpearl</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tournament.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Tournament</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of side navbar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Top navbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo getUsername($connection); ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End of top navbar -->

                <!-- Main content -->
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <div class="row">

                        <!-- Stored Players Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Stored Players</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format(getTotalCachedPlayers($mongo_mng)); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stored Guilds Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Stored Guilds</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format(getTotalCachedGuilds($mongo_mng)); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Lookups Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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

                        <!-- Total Page Views Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Page Views</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo getTotalPageViews($connection); ?></div>
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

                        <!-- Page Views Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Page Views</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="viewChart" style="max-width: 1000px; margin: auto; width: 50%; padding: 10px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Top Player Searches List -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Top Searches</h6>
                                </div>
                                <div class="card-body">
                                <table id="popularplayers" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Position</th>
                                            <th>Player</th>
                                            <th>Times Looked Up</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                            $result = getPopularLookups($connection, 10);

                                            $i = 1;
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row["action"];
                                                    $lookups = $row["lookups"];
                                                    $player = getPlayerByName($mongo_mng, $name);
                                                    $rank = $player->rank;
                                                    $rank_colour = $player->rankColour;
                                                    
                                                    $prefix = $player->prefix;
                                                    if ($prefix == "NONE" || $prefix == NULL) {
                                                          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                                                    } else {
                                                          $rank_with_name = parseMinecraftColors($prefix, $name);
                                                    }

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        echo '<td>' . $lookups . '</td>';
                                                    echo '</tr>'; 

                                                    $i++;
                                                }
                                            }

                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of main content -->

            </div>

        </div>

    </div>

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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="../js/mdb.js"></script>

    <?php
        $home_views = getPageViews($connection, "home_page");
        $guild_views = getPageViews($connection, "guild_page");
        $player_views = getPageViews($connection, "stats_page");

        $paintball_lb = getPageViews($connection, "paintball_leaderboard");
        $vampirez_lb = getPageViews($connection, "vampirez_leaderboard");
        $quakecraft_lb = getPageViews($connection, "quakecraft_leaderboard");
        $tkr_lb = getPageViews($connection, "tkr_leaderboard");
        $walls_lb = getPageViews($connection, "walls_leaderboard");
        $arena_lb = getPageViews($connection, "arena_leaderboard");
        $skywars_lb = getPageViews($connection, "skywars_leaderboard");
        $bedwars_lb = getPageViews($connection, "bedwars_leaderboard");
        $warlords_lb = getPageViews($connection, "warlords_leaderboard");
        $smash_lb = getPageViews($connection, "smash_leaderboard");
        $megawalls_lb = getPageViews($connection, "megawalls_leaderboard");
        $duels_lb = getPageViews($connection, "duels_leaderboard");
        $bsg_lb = getPageViews($connection, "bsg_leaderboard");
        $cvc_lb = getPageViews($connection, "copsandcrims_leaderboard");
        $bb_lb = getPageViews($connection, "buildbattle_leaderboard");
        $firstlogin_lb = getPageViews($connection, "firstlogin_leaderboard");
        $karma_lb = getPageViews($connection, "karma_leaderboard");
        $ach_lb = getPageViews($connection, "achievements_leaderboard");
        $level_lb = getPageViews($connection, "networklevel_leaderboard");
        $tntrun_lb = getPageViews($connection, "tntrun_leaderboard");
        $tntag_lb = getPageViews($connection, "tntag_leaderboard");
        $pvprun_lb = getPageViews($connection, "pvprun_leaderboard");
        $bowspleef_lb = getPageViews($connection, "bowspleef_leaderboard");
        $wizards_lb = getPageViews($connection, "wizards_leaderboard");

        $leaderboard_views = $paintball_lb + $vampirez_lb + $quakecraft_lb + $tkr_lb + $walls_lb + $arena_lb + $skywars_lb + 
                            $bedwars_lb + $warlords_lb + $cvc_lb + $smash_lb + $megawalls_lb + $duels_lb + $bsg_lb +
                            $bb_lb + $firstlogin_lb + $karma_lb + $level_lb + $ach_lb + $tntag_lb + $tntrun_lb + $pvprun_lb + $bowspleef_lb + $wizards_lb;

    ?>

    <script type="text/javascript">
        var ctx = document.getElementById("viewChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Home", "Player Statistics", "Guild Statistics", "Leaderboards (Total)"],
                datasets: [{
                    label: 'Public Views',
                    data: ["<?php echo $home_views; ?>", "<?php echo $player_views; ?>", "<?php echo $guild_views; ?>", "<?php echo $leaderboard_views; ?>"],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</body>

</html>
<?php } ?>