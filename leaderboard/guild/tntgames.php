<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../includes/links.php"; ?>

        <title>AyeBallers Leaderboard - TNT Games</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/functions.php";
            include "../../functions/player_functions.php";
            include "../../functions/display_functions.php";
            include "../../functions/database/query_functions.php";
            include "../../admin/functions/login_functions.php";

            updatePageViews($connection, 'tntgames_guild_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">TNT Games Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="../overall/tntgames.php">
                                <button type="submit" class="btn btn-primary">Overall Leaderboard</button>
                            </form>

                            <form action="tntgames.php">
                                <button type="submit" class="btn btn-primary active">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                AyeBallers Leaderboard - TNT Games
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">     
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Wins)</th>
                                                <th>Name</th>
                                                <th>Wins</th>
                                                <th>Coins</th>
                                                <th>TNT Run Wins</th>
                                                <th>Bow Spleef Wins</th>
                                                <th>TNT Tag Wins</th>
                                                <th>PVP Run Wins</th>
                                                <th>TNT Wizards Wins</th>
                                                <th>Winstreak</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getTntGuildLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $wins = $row['wins_tnt'];
                                                    $coins = $row['coins_tnt'];
                                                    $tntrun_wins = $row['wins_tntrun_tnt'];
                                                    $bowspleef_wins = $row['wins_bowspleef_tnt'];
                                                    $tntag_wins = $row['wins_tnttag_tnt'];
                                                    $pvprun_wins = $row['wins_pvprun_tnt'];
                                                    $wizards_wins = $row['wins_wizards_tnt'];
                                                    $winstreak = $row['winstreak_tnt'];

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        
                                                        echo '<td>' . number_format($wins) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($tntrun_wins) . '</td>';
                                                        echo '<td>' . number_format($bowspleef_wins) . '</td>';
                                                        echo '<td>' . number_format($tntag_wins) . '</td>';
                                                        echo '<td>' . number_format($pvprun_wins) . '</td>';
                                                        echo '<td>' . number_format($wizards_wins) . '</td>';
                                                        echo '<td>' . number_format($winstreak) . '</td>';

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
