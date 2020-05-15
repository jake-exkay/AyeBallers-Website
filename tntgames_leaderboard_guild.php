<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - TNT Games</title>

        <?php

            include "CONSTANTS.php";

            $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
               
            if($connection->connect_error) {
                echo 'Error connecting to the database';
            }

            $query = "SELECT * FROM tntgames ORDER BY total_wins DESC";
            $result = $connection->query($query);

            $stats_query = "UPDATE page_views SET views = views + 1 WHERE page='tntgames_guild_leaderboard'";
                            
            if($stats_statement = mysqli_prepare($connection, $stats_query)) {
                mysqli_stmt_execute($stats_statement);
            }

            $total_wins = 0;
            $total_coins = 0;
            $total_wizards_kills = 0;
            $total_bowspleef_wins = 0;
            $total_wizards_wins = 0;
            $total_tntrun_wins = 0;
            $total_pvprun_kills = 0;
            $total_tnttag_wins = 0;
            $total_pvprun_wins = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $wizards_kills = $row['wizards_kills'];
                    $wins_bowspleef = $row['wins_bowspeef'];
                    $coins = $row['coins'];
                    $wins_wizards = $row['wins_wizards'];
                    $wins_tntrun = $row['wins_tntrun'];
                    $wins = $row['total_wins'];
                    $wins_pvprun = $row['wins_pvprun'];
                    $kills_pvprun = $row['kills_pvprun'];
                    $wins_tnttag = $row['wins_tnttag'];

                    $total_wins = $total_wins + $wins;
                    $total_coins = $total_coins + $coins;
                    $total_wizards_kills = $total_wizards_kills + $wizards_kills;
                    $total_bowspleef_wins = $total_bowspleef_wins + $wins_bowspleef;
                    $total_wizards_wins = $total_wizards_wins + $wins_wizards;
                    $total_tntrun_wins = $total_tntrun_wins + $wins_tntrun;
                    $total_pvprun_kills = $total_pvprun_kills + $kills_pvprun;
                    $total_tnttag_wins = $total_tnttag_wins + $wins_tnttag;
                    $total_pvprun_wins = $total_pvprun_wins + $wins_pvprun;

                    $format_total_wins = number_format($total_wins);
                    $format_total_coins = number_format($total_coins);
                    $format_total_wizards_kills = number_format($total_wizards_kills);
                    $format_total_bowspleef_wins = number_format($total_bowspleef_wins);
                    $format_total_wizards_wins = number_format($total_wizards_wins);
                    $format_total_tntrun_wins = number_format($total_tntrun_wins);
                    $format_total_pvprun_kills = number_format($total_pvprun_kills);
                    $format_total_tnttag_wins = number_format($total_tnttag_wins);
                    $format_total_pvprun_wins = number_format($total_pvprun_wins);

                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">AyeBallers</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Home
                            </a>
                            <div class="sb-sidenav-menu-heading">Leaderboards</div>
                            <a class="nav-link" href="paintball_leaderboard_guild.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Paintball
                            </a>
                            <a class="nav-link" href="tntgames_leaderboard_guild.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                TNT Games
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">TNT Games Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                        	<form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Overall Leaderboard</button>
	                        </form>

	                        <form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Monthly Leaderboard</button>
	                        </form>

	                        <form style="margin-right: 10px;">
	                            <button type="submit" class="btn btn-secondary" disabled>Weekly Leaderboard</button>
	                        </form>

	                        <form action="tntgames_leaderboard_guild.php">
	                            <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
	                        </form>

	                    </ol>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - TNT Games</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Total Wins)</th>
                                                <th>Name</th>
                                                <th>Total Wins</th>
                                                <th>Coins</th>
                                                <th>TNT Run Wins</th>
                                                <th>PVP Run Wins</th>
                                                <th>Bow Spleef Wins</th>
                                                <th>TNT Tag Wins</th>
                                                <th>Wizards Wins</th>
                                                <th>Wizards Kills</th>
                                                <th>PVP Run Kills</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_tntrun_wins; ?></td>
                                                <td><?php echo $format_total_pvprun_wins; ?></td>
                                                <td><?php echo $format_total_bowspleef_wins; ?></td>
                                                <td><?php echo $format_total_tnttag_wins; ?></td>
                                                <td><?php echo $format_total_wizards_wins; ?></td>
                                                <td><?php echo $format_total_wizards_kills; ?></td>
                                                <td><?php echo $format_total_pvprun_kills; ?></td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $wizards_kills = $row['wizards_kills'];
                                                    $wins_bowspleef = $row['wins_bowspeef'];
                                                    $coins = $row['coins'];
                                                    $wins_wizards = $row['wins_wizards'];
                                                    $wins_tntrun = $row['wins_tntrun'];
                                                    $wins = $row['total_wins'];
                                                    $wins_pvprun = $row['wins_pvprun'];
                                                    $kills_pvprun = $row['kills_pvprun'];
                                                    $wins_tnttag = $row['wins_tnttag'];
                                                    $name = $row['name'];

                                                    $format_wins = number_format($wins);
                                                    $format_coins = number_format($coins);
                                                    $format_wizards_kills = number_format($wizards_kills);
                                                    $format_bowspleef_wins = number_format($wins_bowspleef);
                                                    $format_wizards_wins = number_format($wins_wizards);
                                                    $format_tntrun_wins = number_format($wins_tntrun);
                                                    $format_pvprun_kills = number_format($kills_pvprun);
                                                    $format_tnttag_wins = number_format($wins_tnttag);
                                                    $format_pvprun_wins = number_format($wins_pvprun);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $format_wins . '</td>';
                                                        echo '<td>' . $format_coins . '</td>';
                                                        echo '<td>' . $format_tntrun_wins . '</td>';
                                                        echo '<td>' . $format_pvprun_wins . '</td>';
                                                        echo '<td>' . $format_bowspleef_wins . '</td>';
                                                        echo '<td>' . $format_tnttag_wins . '</td>';
                                                        echo '<td>' . $format_wizards_wins . '</td>';
                                                        echo '<td>' . $format_wizards_kills . '</td>';
                                                        echo '<td>' . $format_pvprun_kills . '</td>';
                                                    echo '</tr>'; 
                                                    $i = $i + 1;

                                                }
                                            }


                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; AyeBallers / ExKay 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
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
