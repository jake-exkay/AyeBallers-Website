<!DOCTYPE html>
<html lang="en">

    <head>

        <meta name="author" content="ExKay" />

        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>

        <title>Guild Leaderboard - QuakeCraft</title>

        <?php

            include "CONSTANTS.php";

            $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
               
            if($connection->connect_error) {
                echo 'Error connecting to the database';
            }

            $query = "SELECT * FROM quakecraft ORDER BY kills DESC";
            $result = $connection->query($query);

            $stats_query = "UPDATE page_views SET views = views + 1 WHERE page='quakecraft_guild_leaderboard'";
                            
            if($stats_statement = mysqli_prepare($connection, $stats_query)) {
                mysqli_stmt_execute($stats_statement);
            }

            $total_kills = 0;
            $total_wins = 0;
            $total_deaths = 0;
            $total_shots = 0;
            $total_coins = 0;
            $total_killstreaks = 0;
            $total_headshots = 0;
            $guild_kd = 0;
            $guild_sk = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $kills = $row['kills'];
                    $wins = $row['wins'];
                    $coins = $row['coins'];
                    $deaths = $row['deaths'];
                    $shots_fired = $row['shots_fired'];
                    $headshots = $row['headshots'];
                    $killstreaks = $row['killstreaks'];

                    $total_kills = $total_kills + $kills;
                    $total_wins = $total_wins + $wins;
                    $total_deaths = $total_deaths + $deaths;
                    $total_shots = $total_shots + $shots_fired;
                    $total_coins = $total_coins + $coins;
                    $total_killstreaks = $total_killstreaks + $killstreaks;
                    $total_headshots = $total_headshots + $headshots;

                    $format_total_kills = number_format($total_kills);
                    $format_total_wins = number_format($total_wins);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_coins = number_format($total_coins);
                    $format_total_killstreaks = number_format($total_killstreaks);
                    $format_total_shots = number_format($total_shots);
                    $format_total_headshots = number_format($total_headshots);

                    $guild_kd = $total_kills / $total_deaths;
                    $guild_sk = $total_shots / $total_kills;
                    $guild_kd = round($guild_kd, 2);
                    $guild_sk = round($guild_sk, 2);
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
                            <a class="nav-link" href="quakecraft_leaderboard_guild.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                QuakeCraft
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">QuakeCraft Leaderboard</h1>

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

	                        <form action="quakecraft_leaderboard_guild.php">
	                            <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
	                        </form>

	                    </ol>

                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>Guild Leaderboard - QuakeCraft</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Kills)</th>
                                                <th>Name</th>
                                                <th>Kills</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>Shots Fired</th>
                                                <th>Deaths</th>
                                                <th>Headshots</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall Guild</td>
                                                <td><?php echo $format_total_kills; ?></td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_shots; ?></td>
                                                <td><?php echo $format_total_deaths; ?></td>
                                                <td><?php echo $format_total_headshots; ?></td>
                                                <td><?php echo $guild_kd; ?> (Average)</td>
                                                <td><?php echo $guild_sk; ?> (Average)</td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = $connection->query($query);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $kills = $row['kills'];
                                                    $wins = $row['wins'];
                                                    $coins = $row['coins'];
                                                    $deaths = $row['deaths'];
                                                    $shots_fired = $row['shots_fired'];
                                                    $headshots = $row['headshots'];
                                                    $killstreaks = $row['killstreaks'];

                                                    $kd = $kills / $deaths;
                                                    $sk = $shots_fired / $kills;
                                                    $kd = round($kd, 2);
                                                    $sk = round($sk, 2);

                                                    $kills_format = number_format($kills);
                                                    $wins_format = number_format($wins);
                                                    $deaths_format = number_format($deaths);
                                                    $shots_fired_format = number_format($shots_fired);
                                                    $coins_format = number_format($coins);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        echo '<td>' . $name . '</td>';
                                                        echo '<td>' . $kills_format . '</td>';
                                                        echo '<td>' . $wins_format . '</td>';
                                                        echo '<td>' . $coins_format . '</td>';
                                                        echo '<td>' . $shots_fired_format . '</td>';
                                                        echo '<td>' . $deaths_format . '</td>';
                                                        echo '<td>' . $headshots . '</td>';
                                                        if ($kd > 2) {
                                                            echo '<td class="table-success">' . $kd . '</td>';
                                                        } else if ($kd > 1 && $kd < 2) {
                                                            echo '<td class="table-warning">' . $kd . '</td>';
                                                        } else {
                                                            echo '<td class="table-danger">' . $kd . '</td>';
                                                        }
                                                        if ($sk > 45) {
                                                            echo '<td class="table-danger">' . $sk . '</td>';
                                                        } else if ($sk > 30 && $sk < 45) {
                                                            echo '<td class="table-warning">' . $sk . '</td>';
                                                        } else {
                                                            echo '<td class="table-success">' . $sk . '</td>';
                                                        }
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
