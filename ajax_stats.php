<?php
	include 'functions/backend_functions.php';
      include 'includes/connect.php';
      include 'includes/constants.php';
      include "functions/player_functions.php";
  
      $playerName = $_GET['q'];
      $uuid = getUUID($connection, $playerName);
      $formatted_name = getRealName($uuid);

      if (!updatePlayer($mongo_mng, $uuid, $API_KEY)) {
            header("Refresh:0.01; url=error/playernotfound.php");
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

      } else {
            header("Refresh:0.01; url=error/playernotfound.php");
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

                  <button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#classic">Classic Games</button><br><br>

                  <div id="classic" class="collapse">

                        <hr>

                        <button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#paintball">Paintball</button><br><br>

                        <div id="paintball" class="collapse">
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

                                                      <p><b>Endurance:</b> ' . $player->paintball->endurance + 1 . '/50</p>
                                                      <p><b>Godfather:</b> ' . $player->paintball->godfather + 1 . '/50</p>
                                                      <p><b>Fortune:</b> ' . $player->paintball->fortune + 1 . '/20</p>
                                                      <p><b>Superluck:</b> ' . $player->paintball->superluck + 1 . '/20</p>
                                                      <p><b>Adrenaline:</b> ' . $player->paintball->adrenaline + 1 . '/10</p>
                                                      <p><b>Transfusion:</b> ' . $player->paintball->transfusion + 1 . '/10</p>
                                                </div>
                        
                                                <div class="col-md-6">
                                                      <br><br>

                                                      <center><h4>Kill / Death Ratio</h4></center>
                                                      <canvas id="paintballPie"></canvas>

                                                      <br><hr><br>

                                                      <center><h4>Perk Levels</h4></center>
                                                      <canvas id="paintballBar"></canvas>

                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <br>
                        </div>
                  </div>';

            echo '</div></div>';


      echo '</div>';

?>