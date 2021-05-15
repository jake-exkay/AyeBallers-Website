<?php
	  include 'functions/backend_functions.php';
    include 'includes/connect.php';
    include 'includes/constants.php';
    include "functions/player_functions.php";

    $gameType = $_GET['q'];

    echo '<div class="card">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
                Leaderboard
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                <thead class="thead-dark">';

    if ($gameType == "Paintball") {
        $result = getLeaderboard($mongo_mng, "paintball.kills");
        updatePageViews($connection, 'paintball_leaderboard', $DEV_IP);
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
        $result = getLeaderboard($mongo_mng, 'quakecraft.soloKills');
        updatePageViews($connection, 'quakecraft_leaderboard', $DEV_IP);

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
        $result = getLeaderboard($mongo_mng, "walls.wins");
        updatePageViews($connection, 'walls_leaderboard', $DEV_IP);

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
        $result = getLeaderboard($mongo_mng, "tkr.goldTrophy");
        updatePageViews($connection, 'tkr_leaderboard', $DEV_IP);

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
        $result = getLeaderboard($mongo_mng, "vampirez.asHuman.humanWins");
        updatePageViews($connection, 'vampirez_leaderboard', $DEV_IP);

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
        $result = getLeaderboard($mongo_mng, "arena.rating");
        updatePageViews($connection, 'arena_leaderboard', $DEV_IP);

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
        $result = getLeaderboard($mongo_mng, "bedwars.wins");
        updatePageViews($connection, 'bedwars_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">BedWars Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Final Kills</th>';
        echo '<th>Coins</th>';
        echo '<th>Current Winstreak</th>';
        echo '<th>Beds Broken</th>';
        echo '<th>Games Played</th>';
        echo '<th>Resources Collected</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->bedwars->finalKills;
          $wins = $player->bedwars->wins;
          $coins = $player->bedwars->coins;
          $deaths = $player->bedwars->deaths;
          $winstreak = $player->bedwars->winstreak;
          $games = $player->bedwars->gamesPlayed;
          $beds = $player->bedwars->bedsBroken;
          $resources = $player->bedwars->resourcesCollected->total;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($winstreak) . '</td>';
              echo '<td>' . number_format($beds) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($resources) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "Skywars") {
        $result = getLeaderboard($mongo_mng, "skywars.overall.wins");
        updatePageViews($connection, 'skywars_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">SkyWars Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Coins</th>';
        echo '<th>Deaths</th>';
        echo '<th>Fastest Win</th>';
        echo '<th>Survived Players</th>';
        echo '<th>Eggs Thrown</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->skywars->overall->kills;
          $wins = $player->skywars->overall->wins;
          $coins = $player->skywars->overall->coins;
          $deaths = $player->skywars->overall->deaths;
          $fastest_win = $player->skywars->overall->fastestWin;
          $survived_players = $player->skywars->overall->survivedPlayers;
          $eggs_thrown = $player->skywars->overall->eggsThrown;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($fastest_win) . ' seconds</td>';
              echo '<td>' . number_format($survived_players) . '</td>';
              echo '<td>' . number_format($eggs_thrown) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "Warlords") {
        $result = getLeaderboard($mongo_mng, "warlords.wins");
        updatePageViews($connection, 'warlords_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Warlords Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Coins</th>';
        echo '<th>Assists</th>';
        echo '<th>Deaths</th>';
        echo '<th>Losses</th>';
        echo '<th>Current Class</th>';
        echo '<th>Damage</th>';
        echo '<th>Healing</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->warlords->kills;
          $wins = $player->warlords->wins;
          $coins = $player->warlords->coins;
          $deaths = $player->warlords->deaths;
          $assists = $player->warlords->assists;
          $losses = $player->warlords->losses;
          $current_class = $player->warlords->currentClass;
          $damage = $player->warlords->damage;
          $healing = $player->warlords->heal;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($assists) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($losses) . '</td>';
              echo '<td>' . ucfirst($current_class) . '</td>';
              echo '<td>' . number_format($damage) . '</td>';
              echo '<td>' . number_format($healing) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }      
      } else if ($gameType == "CopsAndCrims") {
        $result = getLeaderboard($mongo_mng, "copsandcrims.defusal.gameWins");
        updatePageViews($connection, 'copsandcrims_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Cops and Crims Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Headshots</th>';
        echo '<th>Shots Fired</th>';
        echo '<th>Deaths</th>';
        echo '<th>Bombs Planted</th>';
        echo '<th>Bombs Defused</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->copsandcrims->defusal->kills;
          $wins = $player->copsandcrims->defusal->gameWins;
          $shots_fired = $player->copsandcrims->defusal->shotsFired;
          $headshots = $player->copsandcrims->defusal->headshots;
          $deaths = $player->copsandcrims->defusal->deaths;
          $bombs_defused = $player->copsandcrims->defusal->bombsDefused;
          $bombs_planted = $player->copsandcrims->defusal->bombsPlanted;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($headshots) . '</td>';
              echo '<td>' . number_format($shots_fired) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($bombs_planted) . '</td>';
              echo '<td>' . number_format($bombs_defused) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }       
      } else if ($gameType == "Smash") {
        $result = getLeaderboard($mongo_mng, "smash.wins");
        updatePageViews($connection, 'smash_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Smash Heroes Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Smash Level</th>';
        echo '<th>Coins</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->smash->kills;
          $wins = $player->smash->wins;
          $deaths = $player->smash->deaths;
          $smash_level = $player->smash->smashLevel;
          $coins = $player->smash->coins;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($smash_level) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        } 
      } else if ($gameType == "BSG") {
        $result = getLeaderboard($mongo_mng, "bsg.wins");
        updatePageViews($connection, 'bsg_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Blitz Survival Games Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Coins</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->bsg->kills;
          $wins = $player->bsg->wins;
          $deaths = $player->bsg->deaths;
          $coins = $player->bsg->coins;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }       
      } else if ($gameType == "MegaWalls") {
        $result = getLeaderboard($mongo_mng, "megawalls.wins");
        updatePageViews($connection, 'megawalls_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Mega Walls Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Final Kills</th>';
        echo '<th>Kills</th>';
        echo '<th>Coins</th>';
        echo '<th>Assists</th>';
        echo '<th>Deaths</th>';
        echo '<th>Chosen Class</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $kills = $player->megawalls->kills;
          $wins = $player->megawalls->wins;
          $deaths = $player->megawalls->deaths;
          $coins = $player->megawalls->coins;
          $final_kills = $player->megawalls->finalKills;
          $assists = $player->megawalls->assists;
          $class = $player->megawalls->chosenClass;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($final_kills) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($assists) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . $class . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }       
      } else if ($gameType == "BuildBattle") {
        $result = getLeaderboard($mongo_mng, "buildBattle.wins");
        updatePageViews($connection, 'buildbattle_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Build Battle Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Score</th>';
        echo '<th>Coins</th>';
        echo '<th>Games</th>';
        echo '<th>Correct Guesses</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $score = $player->buildBattle->score;
          $wins = $player->buildBattle->wins;
          $coins = $player->buildBattle->coins;
          $games = $player->buildBattle->games;
          $correct_guesses = $player->buildBattle->correctGuesses;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($score) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($correct_guesses) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }         
      } else if ($gameType == "TNTRun") {
        $result = getLeaderboard($mongo_mng, "tntgames.tntrun.wins");
        updatePageViews($connection, 'tntrun_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">TNT Run Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Record</th>';
        echo '<th>Losses</th>';
        echo '<th>W/L</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $record = $player->tntgames->tntrun->record;
          $wins = $player->tntgames->tntrun->wins;
          $deaths = $player->tntgames->tntrun->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          if ($deaths == 0) {
            $wl = 0;
          } else {
              $wl = $wins / $deaths;
              $wl = round($wl, 2);
          }

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($record) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . $wl . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }   
      } else if ($gameType == "TNTTag") {
        $result = getLeaderboard($mongo_mng, "tntgames.tntag.wins");
        updatePageViews($connection, 'tntag_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">TNT Tag Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->tntgames->tntag->wins;
          $kills = $player->tntgames->tntag->kills;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }       
      } else if ($gameType == "BowSpleef") {
        $result = getLeaderboard($mongo_mng, "tntgames.bowspleef.wins");
        updatePageViews($connection, 'bowspleef_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Bow Spleef Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->tntgames->bowspleef->wins;
          $deaths = $player->tntgames->bowspleef->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }   
      } else if ($gameType == "Wizards") {
        $result = getLeaderboard($mongo_mng, "tntgames.wizards.wins");
        updatePageViews($connection, 'wizards_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">TNT Wizards Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Assists</th>';
        echo '<th>Points Captured</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->tntgames->wizards->wins;
          $kills = $player->tntgames->wizards->kills;
          $deaths = $player->tntgames->wizards->deaths;
          $assists = $player->tntgames->wizards->assists;
          $points = $player->tntgames->wizards->points;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($assists) . '</td>';
              echo '<td>' . number_format($points) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        } 
      } else if ($gameType == "PVPRun") {
        $result = getLeaderboard($mongo_mng, "tntgames.pvprun.wins");
        updatePageViews($connection, 'pvprun_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">PVP Run Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Record</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->tntgames->pvprun->wins;
          $kills = $player->tntgames->pvprun->kills;
          $deaths = $player->tntgames->pvprun->deaths;
          $record = $player->tntgames->pvprun->record;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($record) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }       
      } else if ($gameType == "Duels") {
        $result = getLeaderboard($mongo_mng, "duels.wins");
        updatePageViews($connection, 'duels_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Duels Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Games</th>';
        echo '<th>Bow Shots</th>';
        echo '<th>Sword Swings</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->duels->wins;
          $kills = $player->duels->kills;
          $deaths = $player->duels->deaths;
          $games = $player->duels->games;
          $shots = $player->duels->bowShots;
          $swings = $player->duels->swings;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($shots) . '</td>';
              echo '<td>' . number_format($swings) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "BountyHunters") {
        $result = getLeaderboard($mongo_mng, "arcade.bountyHunters.wins");
        updatePageViews($connection, 'bountyhunters_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Bounty Hunters Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Bounty Kills</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->bountyHunters->wins;
          $kills = $player->arcade->bountyHunters->kills;
          $bounty_kills = $player->arcade->bountyHunters->bountyKills;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($bounty_kills) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "ThrowOut") {
        $result = getLeaderboard($mongo_mng, "arcade.throwOut.wins");
        updatePageViews($connection, 'throwout_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Throw Out Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->throwOut->wins;
          $kills = $player->arcade->throwOut->kills;
          $deaths = $player->arcade->throwOut->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "BlockingDead") {
        $result = getLeaderboard($mongo_mng, "arcade.blockingDead.wins");
        updatePageViews($connection, 'blockingdead_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Blocking Dead Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Headshots</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->blockingDead->wins;
          $kills = $player->arcade->blockingDead->kills;
          $headshots = $player->arcade->blockingDead->headshots;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($headshots) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "DragonWars") {
        $result = getLeaderboard($mongo_mng, "arcade.dragonWars.wins");
        updatePageViews($connection, 'dragonwars_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Dragon Wars Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->dragonWars->wins;
          $kills = $player->arcade->dragonWars->kills;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "CreeperAttack") {
        $result = getLeaderboard($mongo_mng, "arcade.creeperAttack.maxWave");
        updatePageViews($connection, 'creeperattack_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Creeper Attack Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Max Wave)</th>';
        echo '<th>Name</th>';
        echo '<th>Max Wave</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wave = $player->arcade->creeperAttack->maxWave;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wave) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "FarmHunt") {
        $result = getLeaderboard($mongo_mng, "arcade.farmHunt.wins");
        updatePageViews($connection, 'farmhunt_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Farm Hunt Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Poop Collected</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->farmHunt->wins;
          $poop = $player->arcade->farmHunt->poopCollected;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($poop) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "EnderSpleef") {
        $result = getLeaderboard($mongo_mng, "arcade.enderSpleef.wins");
        updatePageViews($connection, 'enderspleef_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Ender Spleef Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->enderSpleef->wins;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "PartyGames") {
        $result = getLeaderboard($mongo_mng, "arcade.partyGamesOne.wins");
        updatePageViews($connection, 'partygames_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Party Games Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Party Games 1 Wins</th>';
        echo '<th>Party Games 2 Wins</th>';
        echo '<th>Party Games 3 Wins</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins1 = $player->arcade->partyGamesOne->wins;
          $wins2 = $player->arcade->partyGamesTwo->wins;
          $wins3 = $player->arcade->partyGamesThree->wins;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins1) . '</td>';
              echo '<td>' . number_format($wins2) . '</td>';
              echo '<td>' . number_format($wins3) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "GalaxyWars") {
        $result = getLeaderboard($mongo_mng, "arcade.galaxyWars.wins");
        updatePageViews($connection, 'galaxywars_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Galaxy Wars Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Shots Fired</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->galaxyWars->wins;
          $kills = $player->arcade->galaxyWars->kills;
          $shots_fired = $player->arcade->galaxyWars->shotsFired;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($shots_fired) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "HoleInTheWall") {
        $result = getLeaderboard($mongo_mng, "arcade.holeInTheWall.wins");
        updatePageViews($connection, 'holeinthewall_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Hole In The Wall Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Rounds</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->holeInTheWall->wins;
          $rounds = $player->arcade->holeInTheWall->rounds;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($rounds) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "HypixelSays") {
        $result = getLeaderboard($mongo_mng, "arcade.hypixelSays.wins");
        updatePageViews($connection, 'hypixelsays_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Hypixel Says Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Rounds</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->hypixelSays->wins;
          $rounds = $player->arcade->hypixelSays->rounds;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($rounds) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MiniWalls") {
        $result = getLeaderboard($mongo_mng, "arcade.miniWalls.wins");
        updatePageViews($connection, 'miniwalls_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Mini Walls Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Final Kills</th>';
        echo '<th>Deaths</th>';
        echo '<th>Wither Kills</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->miniWalls->wins;
          $kills = $player->arcade->miniWalls->kills;
          $deaths = $player->arcade->miniWalls->deaths;
          $final_kills = $player->arcade->miniWalls->finalKills;
          $wither_kills = $player->arcade->miniWalls->witherKills;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($final_kills) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
              echo '<td>' . number_format($wither_kills) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "Football") {
        $result = getLeaderboard($mongo_mng, "arcade.football.wins");
        updatePageViews($connection, 'football_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Football Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Goals</th>';
        echo '<th>Kicks</th>';
        echo '<th>Power Kicks</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->arcade->football->wins;
          $goals = $player->arcade->football->goals;
          $kicks = $player->arcade->football->kicks;
          $power_kicks = $player->arcade->football->powerKicks;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($goals) . '</td>';
              echo '<td>' . number_format($kicks) . '</td>';
              echo '<td>' . number_format($power_kicks) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "Zombies") {
        $result = getLeaderboard($mongo_mng, "arcade.zombies.bestRound");
        updatePageViews($connection, 'zombies_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Zombies Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Best Round)</th>';
        echo '<th>Name</th>';
        echo '<th>Best Round</th>';
        echo '<th>Kills</th>';
        echo '<th>Players Revived</th>';
        echo '<th>Doors Opened</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $best_round = $player->arcade->zombies->bestRound;
          $kills = $player->arcade->zombies->killsByType->total;
          $players_revived = $player->arcade->zombies->playersRevived;
          $doors_opened = $player->arcade->zombies->doorsOpened;
          $deaths = $player->arcade->zombies->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($best_round) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($players_revived) . '</td>';
              echo '<td>' . number_format($doors_opened) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "HideAndSeek") {
        $result = getLeaderboard($mongo_mng, "arcade.hideAndSeek.seekerWins");
        updatePageViews($connection, 'hideandseek_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Hide And Seek Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Seeker Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Seeker Wins</th>';
        echo '<th>Hider Wins</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $hider_wins = $player->arcade->hideAndSeek->hiderWins;
          $seeker_wins = $player->arcade->hideAndSeek->seekerWins;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($seeker_wins) . '</td>';
              echo '<td>' . number_format($hider_wins) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "UHCSolo") {
        $result = getLeaderboard($mongo_mng, "uhc.solo.wins");
        updatePageViews($connection, 'uhc_solo_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">UHC Solo Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Heads Eaten</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->uhc->solo->wins;
          $kills = $player->uhc->solo->kills;
          $heads_eaten = $player->uhc->solo->headsEaten;
          $deaths = $player->uhc->solo->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($heads_eaten) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "UHCTeams") {
        $result = getLeaderboard($mongo_mng, "uhc.team.wins");
        updatePageViews($connection, 'uhc_teams_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">UHC Teams Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Heads Eaten</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->uhc->team->wins;
          $kills = $player->uhc->team->kills;
          $heads_eaten = $player->uhc->team->headsEaten;
          $deaths = $player->uhc->team->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($heads_eaten) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "UHCBrawl") {
        $result = getLeaderboard($mongo_mng, "uhc.brawl.wins");
        updatePageViews($connection, 'uhc_brawl_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">UHC Brawl Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Heads Eaten</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->uhc->brawl->wins;
          $kills = $player->uhc->brawl->kills;
          $heads_eaten = $player->uhc->brawl->headsEaten;
          $deaths = $player->uhc->brawl->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($heads_eaten) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "UHCSoloBrawl") {
        $result = getLeaderboard($mongo_mng, "uhc.solobrawl.wins");
        updatePageViews($connection, 'uhc_solobrawl_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">UHC Solo Brawl Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Heads Eaten</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->uhc->solobrawl->wins;
          $kills = $player->uhc->solobrawl->kills;
          $heads_eaten = $player->uhc->solobrawl->headsEaten;
          $deaths = $player->uhc->solobrawl->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($heads_eaten) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "UHCDuoBrawl") {
        $result = getLeaderboard($mongo_mng, "uhc.duobrawl.wins");
        updatePageViews($connection, 'uhc_duobrawl_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">UHC Duo Brawl Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Heads Eaten</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->uhc->duobrawl->wins;
          $kills = $player->uhc->duobrawl->kills;
          $heads_eaten = $player->uhc->duobrawl->headsEaten;
          $deaths = $player->uhc->duobrawl->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($heads_eaten) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MMOverall") {
        $result = getLeaderboard($mongo_mng, "murdermystery.wins");
        updatePageViews($connection, 'mm_overall_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Murder Mystery Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Coins Picked Up</th>';
        echo '<th>Times As Hero</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->murdermystery->wins;
          $kills = $player->murdermystery->kills;
          $coins = $player->murdermystery->coinsPickedUp;
          $hero = $player->murdermystery->wasHero;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($coins) . '</td>';
              echo '<td>' . number_format($hero) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MMClassic") {
        $result = getLeaderboard($mongo_mng, "murdermystery.classic.wins");
        updatePageViews($connection, 'mm_classic_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Murder Mystery Classic Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Games Played</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->murdermystery->classic->wins;
          $kills = $player->murdermystery->classic->kills;
          $games = $player->murdermystery->classic->games;
          $deaths = $player->murdermystery->classic->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MMAssassins") {
        $result = getLeaderboard($mongo_mng, "murdermystery.assassins.wins");
        updatePageViews($connection, 'mm_assassins_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Murder Mystery Assassins Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Games Played</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->murdermystery->assassins->wins;
          $kills = $player->murdermystery->assassins->kills;
          $games = $player->murdermystery->assassins->games;
          $deaths = $player->murdermystery->assassins->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MMDoubleUp") {
        $result = getLeaderboard($mongo_mng, "murdermystery.doubleup.wins");
        updatePageViews($connection, 'mm_doubleup_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Murder Mystery Double Up Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Games Played</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->murdermystery->doubleup->wins;
          $kills = $player->murdermystery->doubleup->kills;
          $games = $player->murdermystery->doubleup->games;
          $deaths = $player->murdermystery->doubleup->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "MMInfection") {
        $result = getLeaderboard($mongo_mng, "murdermystery.infection.wins");
        updatePageViews($connection, 'mm_infection_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Murder Mystery Infection Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (Wins)</th>';
        echo '<th>Name</th>';
        echo '<th>Wins</th>';
        echo '<th>Kills</th>';
        echo '<th>Games Played</th>';
        echo '<th>Deaths</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $wins = $player->murdermystery->infection->wins;
          $kills = $player->murdermystery->infection->killsAsSurvivor;
          $games = $player->murdermystery->infection->games;
          $deaths = $player->murdermystery->infection->deaths;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($wins) . '</td>';
              echo '<td>' . number_format($kills) . '</td>';
              echo '<td>' . number_format($games) . '</td>';
              echo '<td>' . number_format($deaths) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "FirstLogin") {
        $result = getFirstLoginLeaderboard($mongo_mng);
        updatePageViews($connection, 'firstlogin_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">First Login Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position (First Login)</th>';
        echo '<th>Name</th>';
        echo '<th>Login Date (Server Time)</th>';
        echo '<th>Recent Game</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $first_login = $player->firstLogin;
          $recent_game = $player->recentGameType;

          $login_date = date("d M Y (H:i:s)", (int)substr($first_login, 0, 10));

          if ($login_date == "01 Jan 1970 (00:00:00)") {
              continue;
          }

          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . $login_date . '</td>';
              echo '<td>' . formatRecentGame($recent_game) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        } 
      } else if ($gameType == "AchievementPoints") {
        $result = getLeaderboard($mongo_mng, "achievementPoints");
        updatePageViews($connection, 'achievements_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Achievement Points Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position</th>';
        echo '<th>Name</th>';
        echo '<th>Achievement Points</th>';
        echo '<th>Recent Game</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $ach = $player->achievementPoints;
          $recent_game = $player->recentGameType;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($ach) . '</td>';
              echo '<td>' . formatRecentGame($recent_game) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }      
      } else if ($gameType == "Karma") {
        $result = getLeaderboard($mongo_mng, "karma");
        updatePageViews($connection, 'karma_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Karma Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position</th>';
        echo '<th>Name</th>';
        echo '<th>Karma</th>';
        echo '<th>Recent Game</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $karma = $player->karma;
          $recent_game = $player->recentGameType;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . number_format($karma) . '</td>';
              echo '<td>' . formatRecentGame($recent_game) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else if ($gameType == "NetworkLevel") {
        $result = getLeaderboard($mongo_mng, "networkExp");
        updatePageViews($connection, 'networklevel_leaderboard', $DEV_IP);

        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Network Level Leaderboard</h2></center><br>';
        echo '<tr>';
        echo '<th>Position</th>';
        echo '<th>Name</th>';
        echo '<th>Network Level</th>';
        echo '<th>Recent Game</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 1;

        foreach ($result as $player) {
          $name = $player->name;
          $rank = $player->rank;
          $rank_colour = $player->rankColour;
          $exp = $player->networkExp;
          $level = getNetworkLevel($exp);
          $recent_game = $player->recentGameType;
          $rank_with_name = getRankFormatting($name, $rank, $rank_colour);

          echo '<tr>';
              echo '<td>' . $i . '</td>';
              echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
              echo '<td>' . $level . '</td>';
              echo '<td>' . formatRecentGame($recent_game) . '</td>';
          echo '</tr>'; 
          $i = $i + 1;
        }
      } else {
        echo '<br><center><h2 class="masthead-heading text-uppercase mb-0">Leaderboard Coming Soon</h2></center><br>';
      }
    
    echo '</tbody></table></div></div></div>';

?>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
    $(document).ready(function () {
    $('#leaderboard').DataTable({
    });
    $('.dataTables_length').addClass('bs-select');
    });
</script>
</html>