<?php
	include 'functions/backend_functions.php';
      include 'includes/connect.php';
      include 'includes/constants.php';
      include "functions/player_functions.php";
      include "includes/links.php";
  
      $playerName = $_GET['q'];
      $uuid = getUUID($connection, $playerName);
      $formatted_name = getRealName($uuid);

      if (!updatePlayer($mongo_mng, $uuid, $API_KEY)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Oh no!</strong> Player cannot be found, please try again.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                  </div>';
      } else {
            updateStatsLog($connection, $formatted_name);

            $filter = ['uuid' => $uuid]; 
            $query = new MongoDB\Driver\Query($filter);     
            
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            
            $player = current($res->toArray());

            if (!empty($player)) {
                  $rank = $player->rank;
                  $rank_colour = $player->rankColour;
                  $network_exp = $player->networkExp;
                  $name = $player->name;

                  $first_login = $player->firstLogin;
                  $first_login = date("d M Y (H:i:s)", (int)substr($first_login, 0, 10));
                  $last_login = $player->lastLogin;
                  $last_login = date("d M Y (H:i:s)", (int)substr($last_login, 0, 10));
                  $last_vote = $player->lastVote;
                  $last_vote = date("d M Y (H:i:s)", (int)substr($last_vote, 0, 10));

                  $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                  $network_level = getNetworkLevel($network_exp);

                  $recent_game = formatRecentGame($player->recentGameType);

                  $guild_name = "";
                  $guild_tag = "";
                  $guild_members = 0;
                  $guildRole = "";

                  if ($guild = getPlayersGuild($mongo_mng, $uuid)) {
                        $user_in_guild = true;
                        $guild_name = $guild->name;
                        $guild_tag = $guild->tag;
                        $guild_members = sizeof($guild->members);
                  } else {
                        $user_in_guild = false;
                  }

            }

      echo '<div class="card">
                  <div class="card-header">
                        ' . $rank_with_name . '
                  </div>
                  <div class="card-body">';

      echo '<div class="row">
                  <div class="col-md-4">
                        <div class="card">
                              <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    General Statistics
                              </div>

                  <div class="card-body">
                        <div class="row">
                              <div class="col-md-8">
                                    <p><b>Network Level:</b> ' . $network_level . '</p>
                                    <p><b>Achievement Points:</b> ' . number_format($player->achievementPoints) . '</p>
                                    <p><b>Karma:</b> ' . number_format($player->karma) . '</p>
                                    <p><b>First Login:</b> ' . $first_login . '</p>
                                    <p><b>Last Login:</b> ' . $last_login . '</p>
                                    <p><b>Selected Gadget:</b> ' . $player->selectedGadget . '</p>
                                    <p><b>Thanks Received:</b> ' . number_format($player->thanksReceived) . '</p>
                                    <p><b>Rewards Claimed:</b> ' . $player->rewardsClaimed . '</p>
                                    <p><b>Gifts Given:</b> ' . $player->giftsGiven . '</p>
                                    <p><b>Recent Game:</b> ' . $recent_game . '</p>

                                    <br>

                                    <p><b>Total Votes:</b> ' . $player->totalVotes . '</p>
                                    <p><b>Last Vote:</b> ' . $last_vote . '</p>

                                    <br>

                                    <p><b>UUID:</b> ' . $uuid . '</p>
                              </div>
                              <div class="col-md-4">
                                    <img alt="Player Avatar" style="height: 200px; width: auto;" src="https://crafatar.com/renders/body/' . $uuid . '"/>
                              </div>
                        </div>
                  </div>
            </div><br>';
      if ($user_in_guild) {
      echo '<div class="card mb-4">
                  <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        ' . $name . '\'s Guild
                  </div>

                  <div class="card-body">
                        <div class="row">
                              <div class="col-md-8">
                              <p><b>Guild Name:</b> <a href="guild.php?guild=' . $guild_name . '">' . $guild_name . '</a></p>
                              <p><b>Guild Tag:</b> ' . $guild_tag . ' </p>
                              <p><b>Guild Members:</b> ' . $guild_members . '</p>
                        </div>
                  </div>
                  </div>
            </div>';
      }

      echo '</div>';

      echo '<div class="col-md-8">
                  <div class="card mb-4">
                        <div class="card-header">
                              <i class="fas fa-list mr-1"></i>
                              Game Statistics
                        </div>';
      echo '<div class="card-body">

            <a href="#statistics" title="Paintball" data-toggle="collapse" data-target="#paintball"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/paintball-img.png"/></a>
            <a href="#statistics" title="Quakecraft" data-toggle="collapse" data-target="#quakecraft"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/quakecraft-img.png"/></a>
            <a href="#statistics" title="The Walls" data-toggle="collapse" data-target="#walls"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/walls-img.png"/></a>
            <a href="#statistics" title="VampireZ" data-toggle="collapse" data-target="#vampirez"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/vampirez-img.png"/></a>
            <a href="#statistics" title="Turbo Kart Racers" data-toggle="collapse" data-target="#tkr"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/tkr-img.png"/></a>
            <a href="#statistics" title="Arena Brawl" data-toggle="collapse" data-target="#arena"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/arena-img.png"/></a>
            <a href="#statistics" title="Warlords" data-toggle="collapse" data-target="#warlords"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/warlords-img.png"/></a>
            <a href="#statistics" title="TNT Games" data-toggle="collapse" data-target="#tnt"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/tnt-img.png"/></a>
            <a href="#statistics" title="Bedwars" data-toggle="collapse" data-target="#bedwars"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/bedwars-img.png"/></a>
            <a href="#statistics" title="Skywars" data-toggle="collapse" data-target="#skywars"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/skywars-img.png"/></a>
            <a href="#statistics" title="Murder Mystery" data-toggle="collapse" data-target="#murdermystery"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/murdermystery-img.png"/></a>
            <a href="#statistics" title="Arcade Games" data-toggle="collapse" data-target="#arcade"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/arcade-img.png"/></a>
            <a href="#statistics" title="UHC Champions" data-toggle="collapse" data-target="#uhc"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/uhc-img.png"/></a>
            <a href="#statistics" title="Build Battle" data-toggle="collapse" data-target="#buildbattle"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/buildbattle-img.png"/></a>
            <a href="#statistics" title="Cops and Crims" data-toggle="collapse" data-target="#cac"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/cac-img.png"/></a>
            <a href="#statistics" title="Duels" data-toggle="collapse" data-target="#duels"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/duels-img.png"/></a>
            <a href="#statistics" title="Mega Walls" data-toggle="collapse" data-target="#megawalls"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/megawalls-img.png"/></a>
            <a href="#statistics" title="Blitz Survival Games" data-toggle="collapse" data-target="#bsg"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/bsg-img.png"/></a>
            <a href="#statistics" title="Smash Heroes" data-toggle="collapse" data-target="#smash"><img style="box-shadow: 3px 3px 5px grey; padding-top: 2px" src="assets/img/smash-img.png"/></a>


            <div id="paintball" class="collapse">

                  <br>

                  <div class="card">
                        <div class="card-header">
                              <i class="fas fa-table mr-1"></i>
                              Paintball
                        </div>

                        <div class="card-body">
                              <div class="row">
                                    <div class="col-md-6">';

                                          $kd_pb = 0.0;
                                          $sk_pb = 0.0;

                                          if ($player->paintball->deaths != 0) {
                                                $kd_pb = round(($player->paintball->kills / $player->paintball->deaths), 2);
                                          }
                                          if ($player->paintball->kills != 0) {
                                                $sk_pb = round(($player->paintball->shotsFired / $player->paintball->kills), 2);
                                          }

                                    echo '<p><b>Kills:</b> ' . number_format($player->paintball->kills) . '</p>
                                          <p><b>Wins:</b> ' .  number_format($player->paintball->wins) . '</p>
                                          <p><b>Coins:</b> ' . number_format($player->paintball->coins) . '</p>
                                          <p><b>Deaths:</b> ' . number_format($player->paintball->deaths) . '</p>
                                          <p><b>Forcefield Time:</b> ' . gmdate("H:i:s", $player->paintball->forcefieldTime) . '</p>
                                          <p><b>Killstreaks:</b> ' . number_format($player->paintball->killstreaks) . '</p>
                                          <p><b>Shots Fired:</b> ' . number_format($player->paintball->shotsFired) . '</p>
                                          <p><b>Equipped Hat:</b> ' . formatPaintballHat($player->paintball->hat) . '</p>

                                          <br>

                                          <p><b>Kill-Death Ratio:</b> ' . $kd_pb . '</p>
                                          <p><b>Shot-Kill Ratio:</b> ' . $sk_pb . '</p>

                                          <br>

                                          <p><b>Endurance:</b> ' . ($player->paintball->endurance + 1) . '/50</p>
                                          <p><b>Godfather:</b> ' . ($player->paintball->godfather + 1) . '/50</p>
                                          <p><b>Fortune:</b> ' . ($player->paintball->fortune + 1) . '/20</p>
                                          <p><b>Superluck:</b> ' . ($player->paintball->superluck + 1) . '/20</p>
                                          <p><b>Adrenaline:</b> ' . ($player->paintball->adrenaline + 1) . '/10</p>
                                          <p><b>Transfusion:</b> ' . ($player->paintball->transfusion + 1) . '/10</p>
                                    </div>
            
                                    <div class="col-md-6">
                                          <br><br>

                                          <center><h4>Kill / Death Ratio</h4></center>
                                          <canvas id="paintball-kd-pie"></canvas>

                                          <br><hr><br>

                                          <center><h4>Perk Levels</h4></center>
                                          <canvas id="paintball-perk-bar"></canvas>

                                    </div>
                              </div>
                        </div>
                        <br>
                  </div>
            </div>

            <div id="quakecraft" class="collapse">
            
                  <br>

                  <div class="card">
                        <div class="card-header">
                              <i class="fas fa-table mr-1"></i>
                              Quakecraft
                        </div>

                        <div class="card-body">
                              <div class="row">
                                    <div class="col-md-6">';

                                          $kd_qc = 0.0;
                                          $sk_qc = 0.0;

                                          if ($player->quakecraft->soloDeaths != 0 || $player->quakecraft->teamDeaths != 0) {
                                                $kd_qc = round((($player->quakecraft->teamKills + $player->quakecraft->soloKills) / ($player->quakecraft->teamDeaths + $player->quakecraft->soloDeaths)), 2);
                                          }
                                          if ($player->quakecraft->soloKills != 0 || $player->quakecraft->teamKills != 0) {
                                                $sk_qc = round((($player->quakecraft->soloShotsFired + $player->quakecraft->teamShotsFired) / ($player->quakecraft->soloKills + $player->quakecraft->teamKills)), 2);
                                          }
                                          
                                    echo '<p><b>Coins:</b> ' . number_format($player->quakecraft->coins) . '</p>
                                          <p><b>Highest Killstreak:</b> ' . number_format($player->quakecraft->highestKillstreak) . '</p>

                                          <br>

                                          <p><b>Total Kills:</b> ' . number_format($player->quakecraft->soloKills + $player->quakecraft->teamKills) . '</p>
                                          <p><b>Total Wins:</b> ' . number_format($player->quakecraft->soloWins + $player->quakecraft->teamWins) . '</p>
                                          <p><b>Total Deaths:</b> ' . number_format($player->quakecraft->soloDeaths + $player->quakecraft->teamDeaths) . '</p>
                                          <p><b>Total Killstreaks:</b> ' . number_format($player->quakecraft->soloKillstreaks + $player->quakecraft->teamKillstreaks) . '</p>
                                          <p><b>Total Headshots:</b> ' . number_format($player->quakecraft->soloHeadshots + $player->quakecraft->teamHeadshots) . '</p>
                                          <p><b>Total Distance Travelled:</b> ' . number_format($player->quakecraft->soloDistanceTravelled + $player->quakecraft->teamDistanceTravelled) . ' blocks</p>
                                          <p><b>Total Shots Fired:</b> ' . number_format($player->quakecraft->soloShotsFired + $player->quakecraft->teamShotsFired) . '</p>

                                          <br>

                                          <p><b>Kill-Death Ratio:</b> ' . $kd_qc . '</p>
                                          <p><b>Shot-Kill Ratio:</b> '  . $sk_qc . '</p>

                                          <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#quakesolo">Solo</button><br><br>

                                          <div id="quakesolo" class="collapse">

                                                <p><b>Kills:</b> ' . number_format($player->quakecraft->soloKills) . '</p>
                                                <p><b>Wins:</b> ' . number_format($player->quakecraft->soloWins) . '</p>
                                                <p><b>Deaths:</b> ' . number_format($player->quakecraft->soloDeaths) . '</p>
                                                <p><b>Killstreaks:</b> ' . number_format($player->quakecraft->soloKillstreaks) . '</p>
                                                <p><b>Headshots:</b> ' . number_format($player->quakecraft->soloHeadshots) . '</p>
                                                <p><b>Distance Travelled:</b> ' . number_format($player->quakecraft->soloDistanceTravelled) . ' blocks</p>
                                                <p><b>Shots Fired:</b> ' . number_format($player->quakecraft->soloShotsFired) . '</p>

                                          </div>

                                          <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#quaketeams">Teams</button><br><br>

                                          <div id="quaketeams" class="collapse">

                                                <p><b>Kills:</b> ' . number_format($player->quakecraft->teamKills) . '</p>
                                                <p><b>Wins:</b> ' . number_format($player->quakecraft->teamWins) . '</p>
                                                <p><b>Deaths:</b> ' . number_format($player->quakecraft->teamDeaths) . '</p>
                                                <p><b>Killstreaks:</b> ' . number_format($player->quakecraft->teamKillstreaks) . '</p>
                                                <p><b>Headshots:</b> ' . number_format($player->quakecraft->teamHeadshots) . '</p>
                                                <p><b>Distance Travelled:</b> ' . number_format($player->quakecraft->teamDistanceTravelled) . ' blocks</p>
                                                <p><b>Shots Fired:</b> ' . number_format($player->quakecraft->teamShotsFired) . '</p>

                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                          <br><br>

                                          <center><h4>Kill / Death Ratio</h4></center>
                                          <canvas id="quakePie"></canvas>

                                          <br><hr><br>

                                          <center><h4>Wins: Solo vs Teams</h4></center>
                                          <canvas id="quakeBar"></canvas>

                                    </div>

                              </div>
                        </div>
                        <br>
                  </div>
            </div>

            <div id="arena" class="collapse">
            
                  <br>

                  <div class="card">
                        <div class="card-header">
                              <i class="fas fa-table mr-1"></i>
                              Arena Brawl
                        </div>

                        <div class="card-body">
                              <div class="row">
                                    <div class="col-md-6">';

                                          $kd_ab_o = 0.0;
                                          $wl_ab_o = 0.0;
                                          $kd_ab_1 = 0.0;
                                          $wl_ab_1 = 0.0;
                                          $kd_ab_2 = 0.0;
                                          $wl_ab_2 = 0.0;
                                          $kd_ab_4 = 0.0;
                                          $wl_ab_4 = 0.0;

                                          if ($player->arena->ones->deaths != 0 || $player->arena->twos->deaths != 0 || $player->arena->fours->deaths != 0) {
                                                $kd_ab_o = round((($player->arena->ones->kills + $player->arena->twos->kills + $player->arena->fours->kills) / ($player->arena->ones->deaths + $player->arena->twos->deaths + $player->arena->fours->deaths)), 2);
                                          }

                                          if ($player->arena->ones->losses != 0 || $player->arena->twos->losses != 0 || $player->arena->fours->losses != 0) {
                                                $wl_ab_o = round((($player->arena->ones->wins + $player->arena->twos->wins + $player->arena->fours->wins) / ($player->arena->ones->losses + $player->arena->twos->losses + $player->arena->fours->losses)), 2);
                                          }

                                          if ($player->arena->ones->deaths != 0) {
                                                $kd_ab_1 = round(($player->arena->ones->kills / $player->arena->ones->deaths), 2);
                                          }

                                          if ($player->arena->ones->losses != 0) {
                                                $wl_ab_1 = round(($player->arena->ones->wins / $player->arena->ones->losses), 2);
                                          }

                                          if ($player->arena->twos->deaths != 0) {
                                                $kd_ab_2 = round(($player->arena->twos->kills / $player->arena->twos->deaths), 2);
                                          }

                                          if ($player->arena->twos->losses != 0) {
                                                $wl_ab_2 = round(($player->arena->twos->wins / $player->arena->twos->losses), 2);
                                          }

                                          if ($player->arena->fours->deaths != 0) {
                                                $kd_ab_4 = round(($player->arena->fours->kills / $player->arena->fours->deaths), 2);
                                          }

                                          if ($player->arena->fours->losses != 0) {
                                                $wl_ab_4 = round(($player->arena->fours->wins / $player->arena->fours->losses), 2);
                                          }
                                    
                              echo '<p><b>Rating:</b> ' . number_format($player->arena->rating) . '</p>
                                    <p><b>Coins:</b> ' . number_format($player->arena->coins) . '</p>
                                    <p><b>Coins Spent:</b> ' . number_format($player->arena->coinsSpent) . '</p>
                                    <p><b>Keys Used:</b> ' . number_format($player->arena->keys) . '</p>
                                    <p><b>Kills:</b> ' . number_format($player->arena->ones->kills + $player->arena->twos->kills + $player->arena->fours->kills) . '</p>
                                    <p><b>Wins:</b> ' . number_format($player->arena->ones->wins + $player->arena->twos->wins + $player->arena->fours->wins) . '</p>
                                    <p><b>Deaths:</b> ' . number_format($player->arena->ones->deaths + $player->arena->twos->deaths + $player->arena->fours->deaths) . '</p>
                                    <p><b>Losses:</b> ' . number_format($player->arena->ones->losses + $player->arena->twos->losses + $player->arena->fours->losses) . '</p>
                                    <p><b>Games Played:</b> ' . number_format($player->arena->ones->games + $player->arena->twos->games + $player->arena->fours->games) . '</p>
                                    <p><b>Damage:</b> ' . number_format($player->arena->ones->damage + $player->arena->twos->damage + $player->arena->fours->damage) . '</p>
                                    <p><b>Healed:</b> ' . number_format($player->arena->ones->healed + $player->arena->twos->healed + $player->arena->fours->healed) . '</p>

                                    <br>

                                    <p><b>K/D:</b> ' . $kd_ab_o . '</p>
                                    <p><b>W/L:</b> ' . $wl_ab_o . '</p>

                                    <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_1">1v1</button><br><br>

                                    <div id="arena_1" class="collapse">
                                          <p><b>Kills:</b> ' . number_format($player->arena->ones->kills) . '</p>
                                          <p><b>Wins:</b> ' . number_format($player->arena->ones->wins) . '</p>
                                          <p><b>Deaths:</b> ' . number_format($player->arena->ones->deaths) . '</p>
                                          <p><b>Losses:</b> ' . number_format($player->arena->ones->losses) . '</p>
                                          <p><b>Games Played:</b> ' . number_format($player->arena->ones->games) . '</p>
                                          <p><b>Damage:</b> ' . number_format($player->arena->ones->damage) . '</p>
                                          <p><b>Healed:</b> ' . number_format($player->arena->ones->healed) . '</p>
                                          <p><b>K/D:</b> ' . $kd_ab_1 . '</p>
                                          <p><b>W/L:</b> ' . $wl_ab_1 . '</p>
                                    
                                    </div>
                                    
                                    <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_2">2v2</button><br><br>

                                    <div id="arena_2" class="collapse">
                                          <p><b>Kills:</b> ' . number_format($player->arena->twos->kills) . '</p>
                                          <p><b>Wins:</b> ' . number_format($player->arena->twos->wins) . '</p>
                                          <p><b>Deaths:</b> ' . number_format($player->arena->twos->deaths) . '</p>
                                          <p><b>Losses:</b> ' . number_format($player->arena->twos->losses) . '</p>
                                          <p><b>Games Played:</b> ' . number_format($player->arena->twos->games) . '</p>
                                          <p><b>Damage:</b> ' . number_format($player->arena->twos->damage) . '</p>
                                          <p><b>Healed:</b> ' . number_format($player->arena->twos->healed) . '</p>
                                          <p><b>K/D:</b> ' . $kd_ab_2 . '</p>
                                          <p><b>W/L:</b> ' . $wl_ab_2 . '</p>

                                    </div>

                                    <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_4">4v4</button><br><br>

                                    <div id="arena_4" class="collapse">
                                          <p><b>Kills:</b> ' . number_format($player->arena->fours->kills) . '</p>
                                          <p><b>Wins:</b> ' . number_format($player->arena->fours->wins) . '</p>
                                          <p><b>Deaths:</b> ' . number_format($player->arena->fours->deaths) . '</p>
                                          <p><b>Losses:</b> ' . number_format($player->arena->fours->losses) . '</p>
                                          <p><b>Games Played:</b> ' . number_format($player->arena->fours->games) . '</p>
                                          <p><b>Damage:</b> ' . number_format($player->arena->fours->damage) . '</p>
                                          <p><b>Healed:</b> ' . number_format($player->arena->fours->healed) . '</p>
                                          <p><b>K/D:</b> ' . $kd_ab_4 . '</p>
                                          <p><b>W/L:</b> ' . $wl_ab_4 . '</p>

                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <br><br>

                                    <center><h4>Wins By Mode</h4></center>
                                    <canvas id="arenaBar"></canvas>

                                    <br><hr><br>

                                    <center><h4>Damage vs Healing</h4></center>
                                    <canvas id="arenaPie"></canvas>

                              </div>
                        </div>
                        <br>
                  </div>
            </div>

            </div>';

            echo '</div></div>';


      echo '</div>';
      }

?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

<script>
      var paintballKdPie = document.getElementById("paintball-kd-pie").getContext('2d');
      var pbPie = new Chart(paintballKdPie, {
            type: 'doughnut',
            data: {
                  labels: ["Kills", "Deaths"],
                  datasets: [{
                  data: ["<?php echo $player->paintball->kills; ?>", "<?php echo $player->paintball->deaths; ?>"],
                  backgroundColor: ["#46BFBD", "#F7464A"],
                  hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
            }]
      },
      options: {
            responsive: true
      }
      });

      var paintballPerksBar = document.getElementById("paintball-perks-bar").getContext('2d');
      var pbBar = new Chart(paintballPerksBar, {
            type: 'horizontalBar',
            data: {
                  labels: ["Endurance", "Godfather", "Fortune", "Superluck", "Adrenaline", "Transfusion"],
                  datasets: [{
                  label: "Perk Level",
                  data: ["<?php echo $player->paintball->endurance + 1; ?>", "<?php echo $player->paintball->godfather + 1; ?>", "<?php echo $player->paintball->fortune + 1; ?>", "<?php echo $player->paintball->superluck + 1; ?>", "<?php echo $player->paintball->adrenaline + 1; ?>", "<?php echo $player->paintball->transfusion + 1; ?>"],
                  backgroundColor: [
                        'rgba(105, 0, 132, .2)', 'rgba(105, 0, 132, .2)', 'rgba(105, 0, 132, .2)', 'rgba(105, 0, 132, .2)', 'rgba(105, 0, 132, .2)', 'rgba(105, 0, 132, .2)',
                  ],
                  borderColor: [
                        'rgba(200, 99, 132, .7)', 'rgba(200, 99, 132, .7)', 'rgba(200, 99, 132, .7)', 'rgba(200, 99, 132, .7)', 'rgba(200, 99, 132, .7)', 'rgba(200, 99, 132, .7)',
                  ],
                  borderWidth: 1
                  }]
            },

            options: {
                  scales: {
                  xAxes: [{
                        ticks: {
                              beginAtZero: true
                        }
                  }]
                  }
            }
      });
</script>