<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../../includes/links.php"; ?>

        <title>Overall Leaderboard - VampireZ</title>

        <?php

            include "../../../includes/connect.php";
            include "../../../functions/functions.php";
            include "../../../functions/player_functions.php";
            include "../../../functions/display_functions.php";
            include "../../../functions/database/query_functions.php";

            updatePageViews($connection, 'vz_overall_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">VampireZ Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="vampirez.php">
                                <button type="submit" class="btn btn-primary active">Overall Leaderboard</button>
                            </form>

                            <form action="../guild/vampirez.php">
                                <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - VampireZ
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">     
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Human Wins)</th>
                                                <th>Name</th>
                                                <th>Human Wins</th>
                                                <th>Vampire Wins</th>
                                                <th>Coins</th>
                                                <th>Vampire Kills</th>
                                                <th>Human Kills</th>
                                                <th>Gold Bought</th>
                                                <th>Zombie Kills</th>
                                                <th>Most Vampire Kills</th>
                                                <th>Human Deaths</th>
                                                <th>Vampire Deaths</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getOverallVampirezLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $coins = $row['coins_vz'];
                                                    $human_wins = $row['human_wins_vz'];
                                                    $vampire_wins = $row['vampire_wins_vz'];
                                                    $vampire_kills = $row['vampire_kills_vz'];
                                                    $human_kills = $row['human_kills_vz'];
                                                    $gold_bought = $row['gold_bought_vz'];
                                                    $zombie_kills = $row['zombie_kills_vz'];
                                                    $most_vampire_kills = $row['most_vampire_kills_vz'];
                                                    $human_deaths = $row['human_deaths_vz'];
                                                    $vampire_deaths = $row['vampire_deaths_vz'];

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" src="../../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        echo '<td>' . number_format($human_wins) . '</td>';
                                                        echo '<td>' . number_format($vampire_wins) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($vampire_kills) . '</td>';
                                                        echo '<td>' . number_format($human_kills) . '</td>';
                                                        echo '<td>' . number_format($gold_bought) . '</td>';
                                                        echo '<td>' . number_format($zombie_kills) . '</td>';
                                                        echo '<td>' . number_format($most_vampire_kills) . '</td>';
                                                        echo '<td>' . number_format($human_deaths) . '</td>';
                                                        echo '<td>' . number_format($vampire_deaths) . '</td>';

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
