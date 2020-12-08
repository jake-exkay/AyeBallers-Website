<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../includes/links.php"; ?>

        <title>AyeBallers Leaderboard - Turbo Kart Racers</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/functions.php";
            include "../../functions/player_functions.php";
            include "../../functions/display_functions.php";
            include "../../functions/database/query_functions.php";

            updatePageViews($connection, 'tkr_guild_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Turbo Kart Racers Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="../overall/tkr.php">
                                <button type="submit" class="btn btn-primary">Overall Leaderboard</button>
                            </form>

                            <form action="tkr.php">
                                <button type="submit" class="btn btn-primary active">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                AyeBallers Leaderboard - Turbo Kart Racers
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">     
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Trophies)</th>
                                                <th>Name</th>
                                                <th>Total Trophies</th>
                                                <th>Gold Trophies</th>
                                                <th>Silver Trophies</th>
                                                <th>Bronze Trophies</th>
                                                <th>Coins</th>
                                                <th>Laps Completed</th>
                                                <th>Coin Pickups</th>
                                                <th>Box Pickups</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getTkrGuildLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $coins = $row['coins_tkr'];
                                                    $wins = $row['wins_tkr'];
                                                    $gold_trophy = $row['gold_trophy_tkr'];
                                                    $silver_trophy = $row['silver_trophy_tkr'];
                                                    $bronze_trophy = $row['bronze_trophy_tkr'];
                                                    $laps_completed = $row['laps_completed_tkr'];
                                                    $box_pickups = $row['box_pickups_tkr'];
                                                    $coin_pickups = $row['coins_picked_up_tkr'];

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        echo '<td>' . number_format($wins) . '</td>';
                                                        echo '<td>' . number_format($gold_trophy) . '</td>';
                                                        echo '<td>' . number_format($silver_trophy) . '</td>';
                                                        echo '<td>' . number_format($bronze_trophy) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($laps_completed) . '</td>';
                                                        echo '<td>' . number_format($coin_pickups) . '</td>';
                                                        echo '<td>' . number_format($box_pickups) . '</td>';

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

                <?php include "../../includes/footer.php"; ?>
                <script>
                    $(document).ready(function () {
                    $('#leaderboard').DataTable({
                    });
                    $('.dataTables_length').addClass('bs-select');
                    });
                </script>
                
            </div>
        </div>

    </body>
</html>
