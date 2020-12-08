<!DOCTYPE html>
<html lang="en">

    <head>

        <?php include "../../includes/links.php"; ?>

        <title>Overall Leaderboard - Arena Brawl</title>

        <?php

            include "../../includes/connect.php";
            include "../../functions/functions.php";
            include "../../functions/player_functions.php";
            include "../../functions/display_functions.php";
            include "../../functions/database/query_functions.php";
            include "../../admin/functions/login_functions.php";

            updatePageViews($connection, 'arena_overall_leaderboard', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Arena Brawl Leaderboard</h1>

                        <ol class="breadcrumb mb-4">

                            <form style="margin-right: 10px;" action="arena.php">
                                <button type="submit" class="btn btn-primary active">Overall Leaderboard</button>
                            </form>

                            <form action="../guild/arena.php">
                                <button type="submit" class="btn btn-primary">AyeBallers Leaderboard</button>
                            </form>

                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Overall Leaderboard - Arena Brawl
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Rating)</th>
                                                <th>Name</th>
                                                <th>Rating</th>
                                                <th>Coins</th>
                                                <th>Coins Spent</th>
                                                <th>Keys Used</th>
                                                <th>Damage (All Modes)</th>
                                                <th>Kills (All Modes)</th>
                                                <th>Wins (All Modes)</th>
                                                <th>Losses (All Modes)</th>
                                                <th>Healing (All Modes)</th>
                                                <th>Games Played (All Modes)</th>
                                                <th>Deaths (All Modes)</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $i = 1;

                                            $result = getOverallArenaLeaderboard($connection);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $name = $row['name'];
                                                    $rank = $row['rank'];
                                                    $rank_colour = $row['rank_colour'];
                                                    $rating = $row['rating_arena'];
                                                    $coins = $row['coins_arena'];
                                                    $coins_spent = $row['coins_spent_arena'];
                                                    $keys = $row['keys_arena'];
                                                    $damage_1 = $row['damage_1v1_arena'];
                                                    $damage_2 = $row['damage_2v2_arena'];
                                                    $damage_4 = $row['damage_4v4_arena'];
                                                    $healing_1 = $row['healed_1v1_arena'];
                                                    $healing_2 = $row['healed_2v2_arena'];
                                                    $healing_4 = $row['healed_4v4_arena'];
                                                    $wins_1 = $row['wins_1v1_arena'];
                                                    $wins_2 = $row['wins_2v2_arena'];
                                                    $wins_4 = $row['wins_4v4_arena'];
                                                    $kills_1 = $row['kills_1v1_arena'];
                                                    $kills_2 = $row['kills_2v2_arena'];
                                                    $kills_4 = $row['kills_4v4_arena'];
                                                    $losses_1 = $row['losses_1v1_arena'];
                                                    $losses_2 = $row['losses_2v2_arena'];
                                                    $losses_4 = $row['losses_4v4_arena'];
                                                    $games_1 = $row['games_1v1_arena'];
                                                    $games_2 = $row['games_2v2_arena'];
                                                    $games_4 = $row['games_4v4_arena'];
                                                    $deaths_1 = $row['deaths_1v1_arena'];
                                                    $deaths_2 = $row['deaths_2v2_arena'];
                                                    $deaths_4 = $row['deaths_4v4_arena'];
                                                    $damage = $damage_1 + $damage_2 + $damage_4;
                                                    $healing = $healing_1 + $healing_2 + $healing_4;
                                                    $wins = $wins_1 + $wins_2 + $wins_4;
                                                    $kills = $kills_1 + $kills_2 + $kills_4;
                                                    $losses = $losses_1 + $losses_2 + $losses_4;
                                                    $games = $games_1 + $games_2 + $games_4;
                                                    $deaths = $deaths_1 + $deaths_2 + $deaths_4;

                                                    $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

                                                    echo '<tr>';
                                                        echo '<td>' . $i . '</td>';
                                                        if (userInGuild($connection, $name)) {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a>  <img title="AyeBallers Member" height="25" width="auto" alt="AyeBallers Logo" src="../../assets/img/favicon.png"/></td>';
                                                        } else {
                                                            echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                        }
                                                        echo '<td>' . number_format($rating) . '</td>';
                                                        echo '<td>' . number_format($coins) . '</td>';
                                                        echo '<td>' . number_format($coins_spent) . '</td>';
                                                        echo '<td>' . number_format($keys) . '</td>';
                                                        echo '<td>' . number_format($damage) . '</td>';
                                                        echo '<td>' . number_format($kills) . '</td>';
                                                        echo '<td>' . number_format($wins) . '</td>';
                                                        echo '<td>' . number_format($losses) . '</td>';
                                                        echo '<td>' . number_format($healing) . '</td>';
                                                        echo '<td>' . number_format($games) . '</td>';
                                                        echo '<td>' . number_format($deaths) . '</td>';
                                                        
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
