<?php
	  include 'functions/leaderboard_functions.php';
    include 'includes/connect.php';
    include "functions/player_functions.php";

    $gameType = $_GET['q'];

    echo '<table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%"><thead class="thead-dark">';

    if ($gameType == "Paintball") {
        $result = getOverallPaintballLeaderboard($mongo_mng);
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Paintball Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Kills)</th>';
        echo '<th>Name</th>';
        echo '<th>Kills</th>';
        echo '<th>Wins</th>';
        echo '<th>Coins</th>';
        echo '<th>Shots Fired</th>';
        echo '<th>Deaths</th>';
        echo '<th>Forcefield Time</th>';
        echo '<th>Killstreaks</th>';
        echo '<th>K/D</th>';
        echo '<th>S/K</th>';
        echo '<th>Selected Hat</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
            $name = $player->name;
            $rank = $player->rank;
            $rank_colour = $player->rankColour;
            $kills = $player->paintball->kills;
            $wins = $player->paintball->wins;
            $coins = $player->paintball->coins;
            $deaths = $player->paintball->deaths;
            $shots_fired = $player->paintball->shotsFired;
            $hat = $player->paintball->hat;
            $ff_time = $player->paintball->forcefieldTime;
            $killstreaks = $player->paintball->killstreaks;
            $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

            if ($kills == 0) {
                $kd = 0;
                $sk = 0;
            } else {
                $kd = $kills / $deaths;
                $sk = $shots_fired / $kills;
                $kd = round($kd, 2);
                $sk = round($sk, 2);
            }

            echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                echo '<td>' . number_format($kills) . '</td>';
                echo '<td>' . number_format($wins) . '</td>';
                echo '<td>' . number_format($coins) . '</td>';
                echo '<td>' . number_format($shots_fired) . '</td>';
                echo '<td>' . number_format($deaths) . '</td>';
                echo '<td>' . gmdate("H:i:s", $ff_time) . '</td>';
                echo '<td>' . number_format($killstreaks) . '</td>';

                if ($kd > 3) {
                    echo '<td class="table-success">' . $kd . '</td>';
                } else if ($kd > 1 && $kd < 3) {
                    echo '<td class="table-warning">' . $kd . '</td>';
                } else {
                    echo '<td class="table-danger">' . $kd . '</td>';
                }

                if ($sk < 30) {
                    echo '<td class="table-success">' . $sk . '</td>';
                } else if ($sk > 30 && $sk < 45) {
                    echo '<td class="table-warning">' . $sk . '</td>';
                } else {
                    echo '<td class="table-danger">' . $sk . '</td>';
                }

                echo '<td>' . formatPaintballHat($hat) . '</td>';
                
            echo '</tr>'; 
            $i = $i + 1;
        }
    } else if ($gameType == "Quakecraft") {
        $result = getOverallQuakeLeaderboard($mongo_mng);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Quakecraft Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Kills)</th>';
        echo '<th>Name</th>';
        echo '<th>Kills</th>';
        echo '<th>Wins</th>';
        echo '<th>Coins</th>';
        echo '<th>Deaths</th>';
        echo '<th>Shots Fired</th>';
        echo '<th>Killstreaks</th>';
        echo '<th>Headshots</th>';
        echo '<th>Distance Travelled</th>';
        echo '<th>Highest Killstreak</th>';
        echo '<th>K/D</th>';
        echo '<th>S/K</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $coins = $player->quakecraft->coins;
          $kills = $player->quakecraft->soloKills;
          $deaths_quake = $player->quakecraft->soloDeaths;
          $wins_quake = $player->quakecraft->soloWins;
          $killstreaks_quake = $player->quakecraft->soloKillstreaks;
          $kills_teams_quake = $player->quakecraft->teamKills;
          $deaths_teams_quake = $player->quakecraft->teamDeaths;
          $wins_teams_quake = $player->quakecraft->teamWins;
          $killstreaks_teams_quake = $player->quakecraft->teamKillstreaks;
          $highest_killstreak_quake = $player->quakecraft->highestKillstreak;
          $shots_fired_teams_quake = $player->quakecraft->teamShotsFired;
          $headshots_teams_quake = $player->quakecraft->teamHeadshots;
          $headshots_quake = $player->quakecraft->soloHeadshots;
          $shots_fired_quake = $player->quakecraft->soloShotsFired;
          $distance_travelled_quake = $player->quakecraft->soloDistanceTravelled;
          $distance_travelled_teams_quake = $player->quakecraft->teamDistanceTravelled;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          if ($kills == 0 && $kills_teams_quake == 0) {
              $kd = 0;
              $sk = 0;
          } else {
              $kd = ($kills + $kills_teams_quake) / ($deaths_quake + $deaths_teams_quake);
              $sk = ($shots_fired_quake + $shots_fired_teams_quake) / ($kills + $kills_teams_quake);
              $kd = round($kd, 2);
              $sk = round($sk, 2);
          }

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($kills + $kills_teams_quake) . '</td>';
              echo '<td>' . number_format($wins_quake + $wins_teams_quake) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($deaths_quake + $deaths_teams_quake) . '</td>';
              echo '<td>' . number_format($shots_fired_quake + $shots_fired_teams_quake) . '</td>';
              echo '<td>' . number_format($killstreaks_quake + $killstreaks_teams_quake) . '</td>';
              echo '<td>' . number_format($headshots_quake + $headshots_teams_quake) . '</td>';
              echo '<td>' . number_format($distance_travelled_quake + $distance_travelled_teams_quake) . '</td>';
              echo '<td>' . number_format($highest_killstreak_quake) . '</td>';

              if ($kd > 5) {
                  echo '<td class="table-success">' . $kd . '</td>';
              } else if ($kd > 2 && $kd < 5) {
                  echo '<td class="table-warning">' . $kd . '</td>';
              } else {
                  echo '<td class="table-danger">' . $kd . '</td>';
              }

              if ($sk < 1) {
                  echo '<td class="table-success">' . $sk . '</td>';
              } else if ($sk > 1 && $sk < 1.5) {
                  echo '<td class="table-warning">' . $sk . '</td>';
              } else {
                  echo '<td class="table-danger">' . $sk . '</td>';
              }
                
            echo '</tr>'; 
            $i = $i + 1;
        }
      } else if ($gameType == "Walls") {
        $result = getOverallWallsLeaderboard($mongo_mng);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">The Walls Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Coins</th>';
        echo '<th>Assists</th>';
        echo '<th>Deaths</th>';
        echo '<th>Losses</th>';
        echo '<th>K/D</th>';
        echo '<th>S/K</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->walls->kills;
          $wins = $player->walls->wins;
          $coins = $player->walls->coins;
          $deaths = $player->walls->deaths;
          $assists = $player->walls->assists;
          $losses = $player->walls->losses;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          if ($deaths == 0 || $losses == 0) {
            $kd = 0;
            $wl = 0;
          } else {
              $kd = $kills / $deaths;
              $wl = $wins / $losses;
              $kd = round($kd, 2);
              $wl = round($wl, 2);
          }

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($assists) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($losses) . '</td>';

              if ($kd > 5) {
                  echo '<td class="table-success">' . $kd . '</td>';
              } else if ($kd > 2 && $kd < 5) {
                  echo '<td class="table-warning">' . $kd . '</td>';
              } else {
                  echo '<td class="table-danger">' . $kd . '</td>';
              }

              if ($wl > 2) {
                  echo '<td class="table-success">' . $wl . '</td>';
              } else if ($wl > 1 && $wl < 2) {
                  echo '<td class="table-warning">' . $wl . '</td>';
              } else {
                  echo '<td class="table-danger">' . $wl . '</td>';
              }
              
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "Tkr") {
        $result = getOverallTkrLeaderboard($mongo_mng);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Turbo Kart Racers Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Trophies)</th>';
        echo '<th>Name</th>';
        echo '<th>Total Trophies</th>';
        echo '<th>Gold Trophies</th>';
        echo '<th>Silver Trophies</th>';
        echo '<th>Bronze Trophies</th>';
        echo '<th>Coins</th>';
        echo '<th>Laps Completed</th>';
        echo '<th>Coin Pickups</th>';
        echo '<th>Box Pickups</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $coins = $player->tkr->coins;
          $wins = $player->tkr->wins;
          $gold_trophy = $player->tkr->goldTrophy;
          $silver_trophy = $player->tkr->silverTrophy;
          $bronze_trophy = $player->tkr->bronzeTrophy;
          $laps_completed = $player->tkr->lapsCompleted;
          $box_pickups = $player->tkr->boxPickups;
          $coin_pickups = $player->tkr->coinPickups;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
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
      } else if ($gameType == "VampireZ") {
        $result = getOverallVampirezLeaderboard($mongo_mng);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">VampireZ Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Human Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Human Wins</th>';
        echo '<th>Vampire Wins</th>';
        echo '<th>Coins</th>';
        echo '<th>Vampire Kills</th>';
        echo '<th>Human Kills</th>';
        echo '<th>Gold Bought</th>';
        echo '<th>Zombie Kills</th>';
        echo '<th>Most Vampire Kills</th>';
        echo '<th>Human Deaths</th>';
        echo '<th>Vampire Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $coins = $player->vampirez->coins;
          $human_wins = $player->vampirez->asHuman->humanWins;
          $vampire_wins = $player->vampirez->asVampire->vampireWins;
          $vampire_kills = $player->vampirez->asHuman->vampireKills;
          $human_kills = $player->vampirez->asVampire->humanKills;
          $gold_bought = $player->vampirez->asHuman->goldBought;
          $zombie_kills = $player->vampirez->asHuman->zombieKills;
          $most_vampire_kills = $player->vampirez->asHuman->mostVampireKills;
          $human_deaths = $player->vampirez->asHuman->humanDeaths;
          $vampire_deaths = $player->vampirez->asVampire->vampireDeaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
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
      } else if ($gameType == "Arena") {
        $result = getOverallArenaLeaderboard($mongo_mng);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Arena Brawl Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Rating)</th>';
        echo '<th>Name</th>';
        echo '<th>Rating</th>';
        echo '<th>Coins</th>';
        echo '<th>Coins Spent</th>';
        echo '<th>Keys Used</th>';
        echo '<th>Damage (All Modes)</th>';
        echo '<th>Kills (All Modes)</th>';
        echo '<th>Wins (All Modes)</th>';
        echo '<th>Losses (All Modes)</th>';
        echo '<th>Healing (All Modes)</th>';
        echo '<th>Games Played (All Modes)</th>';
        echo '<th>Deaths (All Modes)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $rating = $player->arena->rating;
          $coins = $player->arena->coins;
          $coins_spent = $player->arena->coinsSpent;
          $keys = $player->arena->keys;
          $damage_1 = $player->arena->ones->damage;
          $damage_2 = $player->arena->twos->damage;
          $damage_4 = $player->arena->fours->damage;
          $healing_1 = $player->arena->ones->healed;
          $healing_2 = $player->arena->twos->healed;
          $healing_4 = $player->arena->fours->healed;
          $wins_1 = $player->arena->ones->wins;
          $wins_2 = $player->arena->twos->wins;
          $wins_4 = $player->arena->fours->wins;
          $kills_1 = $player->arena->ones->damage;
          $kills_2 = $player->arena->twos->kills;
          $kills_4 = $player->arena->fours->kills;
          $losses_1 = $player->arena->ones->losses;
          $losses_2 = $player->arena->twos->losses;
          $losses_4 = $player->arena->fours->losses;
          $games_1 = $player->arena->ones->games;
          $games_2 = $player->arena->twos->games;
          $games_4 = $player->arena->fours->games;
          $deaths_1 = $player->arena->ones->deaths;
          $deaths_2 = $player->arena->twos->deaths;
          $deaths_4 = $player->arena->fours->deaths;
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
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
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
      } else if ($gameType == "Bedwars") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "Skywars") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "TNT") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "Warlords") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "Duels") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "Arcade") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "UHC") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "MurderMystery") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "CopsAndCrims") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "Smash") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "BSG") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "MegaWalls") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else if ($gameType == "BuildBattle") {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Coming Soon</h2></center><br>';
      } else {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Error</h2></center><br>';
      }
    
    echo '</tbody></table>';

?>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="../../../js/new-scripts.js"></script>
</html>