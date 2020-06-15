<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Overall Leaderboard - Paintball</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/database/paintball_functions.php";

            updatePageViews($connection, 'paintball_overall_leaderboard', $DEV_IP);

            $result = getOverallLeaderboard($connection);

            $last_updated = getLastUpdated($connection, 'paintball_overall');

            $mins = timeSinceUpdate($last_updated);

            $total_kills = $total_wins = $total_deaths = $total_shots = $total_coins = $total_killstreaks = 
            $total_godfather = $total_endurance = $total_fortune = $avg_kd = $avg_sk = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $kills = $row['kills'];
                    $wins = $row['wins'];
                    $coins = $row['coins'];
                    $deaths = $row['deaths'];
                    $shots_fired = $row['shots_fired'];
                    $killstreaks = $row['killstreaks'];
                    $godfather = $row['godfather'];
                    $endurance = $row['endurance'];
                    $fortune = $row['fortune'];

                    $total_kills = $total_kills + $kills;
                    $total_wins = $total_wins + $wins;
                    $total_deaths = $total_deaths + $deaths;
                    $total_shots = $total_shots + $shots_fired;
                    $total_coins = $total_coins + $coins;
                    $total_killstreaks = $total_killstreaks + $killstreaks;
                    $total_godfather = $total_godfather + $godfather;
                    $total_endurance = $total_endurance + $endurance;
                    $total_fortune = $total_fortune + $fortune;

                    $format_total_kills = number_format($total_kills);
                    $format_total_wins = number_format($total_wins);
                    $format_total_deaths = number_format($total_deaths);
                    $format_total_coins = number_format($total_coins);
                    $format_total_killstreaks = number_format($total_killstreaks);
                    $format_total_shots = number_format($total_shots);
                    $format_total_godfather = number_format($total_godfather);
                    $format_total_endurance = number_format($total_endurance);
                    $format_total_fortune = number_format($total_fortune);

                    $avg_kd = $total_kills / $total_deaths;
                    $avg_sk = $total_shots / $total_kills;
                    $avg_kd = round($avg_kd, 2);
                    $avg_sk = round($avg_sk, 2);
                }
            }

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Paintball Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                        	<form style="margin-right: 10px;" action="paintball.php">
	                            <button type="submit" class="btn btn-success">Overall Leaderboard</button>
	                        </form>

	                        <form action="../guild/paintball.php">
	                            <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
	                        </form>

	                    </ol>

                        <?php displayUpdateButton($mins); ?>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Paintball
                            </div>
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
                                                <th>Godfather</th>
                                                <th>Endurance</th>
                                                <th>Fortune</th>
                                                <th>K/D</th>
                                                <th>S/K</th>
                                                <th>Selected Hat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-info">
                                                <td>0</td>
                                                <td>Overall (Top 100)</td>
                                                <td><?php echo $format_total_kills; ?></td>
                                                <td><?php echo $format_total_wins; ?></td>
                                                <td><?php echo $format_total_coins; ?></td>
                                                <td><?php echo $format_total_shots; ?></td>
                                                <td><?php echo $format_total_deaths; ?></td>
                                                <td><?php echo $format_total_godfather; ?></td>
                                                <td><?php echo $format_total_endurance; ?></td>
                                                <td><?php echo $format_total_fortune; ?></td>
                                                <td><?php echo $avg_kd; ?> (Average)</td>
                                                <td><?php echo $avg_sk; ?> (Average)</td>
                                                <td>N/A</td>
                                            </tr>

                                        <?php

                                            $i = 1;

                                            $result = getOverallLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $kills = $row['kills'];
                                                    $wins = $row['wins'];
                                                    $coins = $row['coins'];
                                                    $deaths = $row['deaths'];
                                                    $shots_fired = $row['shots_fired'];
                                                    $godfather = $row['godfather'];
                                                    $endurance = $row['endurance'];
                                                    $fortune = $row['fortune'];
                                                    $killstreaks = $row['killstreaks'];
                                                    $hat = $row['hat'];

                                                    if ($kills == 0) {
                                                        $kd = 0;
                                                        $sk = 0;
                                                    } else {
                                                        $kd = $kills / $deaths;
                                                        $sk = $shots_fired / $kills;

                                                        $kd = round($kd, 2);
                                                        $sk = round($sk, 2);
                                                    }

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
                                                        echo '<td>' . $godfather . '</td>';
                                                        echo '<td>' . $endurance . '</td>';
                                                        echo '<td>' . $fortune . '</td>';
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
                                                        if ($hat == "NoxyD" || $hat == "Rezzus") {
                                                            echo '<td class="table-danger">' . $hat . '</td>';
                                                        } else if ($hat == "No Hat") {
                                                            echo '<td class="table-secondary">' . $hat . '</td>';
                                                        } else {
                                                            echo '<td class="table-success">' . $hat . '</td>';
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

                <?php include "../../../includes/footer.php"; ?>
                
            </div>
        </div>

    </body>
</html>
