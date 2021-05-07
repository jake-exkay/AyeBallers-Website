<?php
/**
 * Stats page - Shows customised stats for players based on GET data.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/stats.php
 */

require "includes/links.php";
require "includes/connect.php";
require "includes/constants.php";
require "functions/backend_functions.php";
require "functions/player_functions.php";
require "error/error_messages.php";
include "admin/functions/login_functions.php";

updatePageViews($connection, 'stats_page', $DEV_IP);
   
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php 

        	$get_name = htmlspecialchars($_GET["player"]);
        	$uuid = getUUID($connection, $get_name);
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

                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }

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
		?>

		<title><?php echo $name; ?>'s Stats - AyeBallers</title>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>

					<div class="card" style="background-image: url('assets/img/background-2.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">

            			<div class="card-body">
            				<form style="margin-right: 10px;" action="<?= $previous ?>">
	                            <button type="submit" class="btn btn-danger">< Back</button>
	                        </form>

                			<center>
								<h1>
									<?php 
									if ($user_in_guild) {
										echo $rank_with_name . " [" . $guild_tag . "]";
									} else {
										echo $rank_with_name;
									}
									?>
								</h1>
							</center>

                			<br>

                			<div class="row">
                				<div class="col-md-4">

		                			<div class="card mb-4">
		                                <div class="card-header">
		                                    <i class="fas fa-table mr-1"></i>
		                                    General Statistics
		                                </div>

	        							<div class="card-body">
	        								<div class="row">
	        									<div class="col-md-8">
						                			<p><b>Network Level:</b> <?php echo $network_level; ?> </p>
						                			<p><b>Achievement Points:</b> <?php echo number_format($player->achievementPoints); ?></p>
						                			<p><b>Karma:</b> <?php echo number_format($player->karma); ?></p>
						                			<p><b>First Login:</b> <?php echo $first_login; ?></p>
						                			<p><b>Last Login:</b> <?php echo $last_login; ?></p>
						                			<p><b>Selected Gadget:</b> <?php echo $player->selectedGadget; ?></p>
						                			<p><b>Thanks Received:</b> <?php echo number_format($player->thanksReceived); ?></p>
						                			<p><b>Rewards Claimed:</b> <?php echo $player->rewardsClaimed; ?></p>
						                			<p><b>Gifts Given:</b> <?php echo $player->giftsGiven; ?></p>
						                			<p><b>Recent Game:</b> <?php echo $recent_game; ?></p>

						                			<br>

						                			<p><b>Total Votes:</b> <?php echo $player->totalVotes; ?></p>
						                			<p><b>Last Vote:</b> <?php echo $last_vote; ?></p>

						                			<br>

						                			<p><b>UUID:</b> <?php echo $uuid; ?></p>
						                		</div>
						                		<div class="col-md-4">
						                			<?php echo '<img alt="Player Avatar" style="height: 200px; width: auto;" src="https://crafatar.com/renders/body/' . $uuid . '"/>'; ?>
						                		</div>
					                		</div>
				                		</div>
				                	</div>

				                	<?php if ($user_in_guild) { ?>
				                	<div class="card mb-4">
		                                <div class="card-header">
		                                    <i class="fas fa-table mr-1"></i>
		                                    <?php echo $name; ?>'s guild
		                                </div>

	        							<div class="card-body">
	        								<div class="row">
	        									<div class="col-md-8">
						                			<p><b>Guild Name:</b> <a href="guild.php?guild=<?php echo $guild_name; ?>"><?php echo $guild_name; ?></a></p>
						                			<p><b>Guild Tag:</b> <?php echo $guild_tag; ?> </p>
						                			<p><b>Guild Members:</b> <?php echo $guild_members; ?> </p>
						                		</div>
					                		</div>
				                		</div>
				                	</div>
				                	<?php } ?>

                                </div>

                				<br>

	                			<div class="col-md-8">
	                				<div class="card mb-4">
				                        <div class="card-header">
				                        	<i class="fas fa-list mr-1"></i>
				                        	Game Statistics
				                    	</div>

			        				<div class="card-body">

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
						        								<div class="col-md-6">

								        							<?php
										                				$kd_pb = 0.0;
										                				$sk_pb = 0.0;

										                				if ($player->paintball->deaths != 0) {
										                					$kd_pb = round(($player->paintball->kills / $player->paintball->deaths), 2);
										                				}
										                				if ($player->paintball->kills != 0) {
										                					$sk_pb = round(($player->paintball->shotsFired / $player->paintball->kills), 2);
										                				}
										                			?>

										                			<p><b>Kills:</b> <?php echo number_format($player->paintball->kills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->paintball->wins); ?></p>
										                			<p><b>Coins:</b> <?php echo number_format($player->paintball->coins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->paintball->deaths); ?></p>
										                			<p><b>Forcefield Time:</b> <?php echo gmdate("H:i:s", $player->paintball->forcefieldTime); ?></p>
										                			<p><b>Killstreaks:</b> <?php echo number_format($player->paintball->killstreaks); ?></p>
										                			<p><b>Shots Fired:</b> <?php echo number_format($player->paintball->shotsFired); ?></p>
										                			<p><b>Equipped Hat:</b> <?php echo formatPaintballHat($player->paintball->hat); ?></p>

										                			<br>

										                			<p><b>Kill-Death Ratio:</b> <?php echo $kd_pb; ?></p>
										                			<p><b>Shot-Kill Ratio:</b> <?php echo $sk_pb; ?></p>

										                			<br>

										                			<p><b>Endurance:</b> <?php echo $player->paintball->endurance + 1; ?>/50</p>
										                			<p><b>Godfather:</b> <?php echo $player->paintball->godfather + 1; ?>/50</p>
										                			<p><b>Fortune:</b> <?php echo $player->paintball->fortune + 1; ?>/20</p>
																	<p><b>Superluck:</b> <?php echo $player->paintball->superluck + 1; ?>/20</p>
										                			<p><b>Adrenaline:</b> <?php echo $player->paintball->adrenaline + 1; ?>/10</p>
										                			<p><b>Transfusion:</b> <?php echo $player->paintball->transfusion + 1; ?>/10</p>
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

						                	<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#quakecraft">Quakecraft</button><br><br>

					                		<div id="quakecraft" class="collapse">
												<div class="card">
													<div class="card-header">
					                                    <i class="fas fa-table mr-1"></i>
					                                    	Quakecraft
				                                	</div>

					        						<div class="card-body">
					        							<div class="row">
						        							<div class="col-md-6">

							        							<?php
									                				$kd_qc = 0.0;
									                				$sk_qc = 0.0;

									                				if ($player->quakecraft->soloDeaths != 0 || $player->quakecraft->teamDeaths != 0) {
									                					$kd_qc = round((($player->quakecraft->teamKills + $player->quakecraft->soloKills) / ($player->quakecraft->teamDeaths + $player->quakecraft->soloDeaths)), 2);
									                				}
									                				if ($player->quakecraft->soloKills != 0 || $player->quakecraft->teamKills != 0) {
									                					$sk_qc = round((($player->quakecraft->soloShotsFired + $player->quakecraft->teamShotsFired) / ($player->quakecraft->soloKills + $player->quakecraft->teamKills)), 2);
									                				}
									                			?>

									                			<p><b>Coins:</b> <?php echo number_format($player->quakecraft->coins); ?></p>
									                			<p><b>Highest Killstreak:</b> <?php echo number_format($player->quakecraft->highestKillstreak); ?></p>

									                			<br>

									                			<p><b>Total Kills:</b> <?php echo number_format($player->quakecraft->soloKills + $player->quakecraft->teamKills); ?></p>
									                			<p><b>Total Wins:</b> <?php echo number_format($player->quakecraft->soloWins + $player->quakecraft->teamWins); ?></p>
									                			<p><b>Total Deaths:</b> <?php echo number_format($player->quakecraft->soloDeaths + $player->quakecraft->teamDeaths); ?></p>
									                			<p><b>Total Killstreaks:</b> <?php echo number_format($player->quakecraft->soloKillstreaks + $player->quakecraft->teamKillstreaks); ?></p>
									                			<p><b>Total Headshots:</b> <?php echo number_format($player->quakecraft->soloHeadshots + $player->quakecraft->teamHeadshots); ?></p>
									                			<p><b>Total Distance Travelled:</b> <?php echo number_format($player->quakecraft->soloDistanceTravelled + $player->quakecraft->teamDistanceTravelled); ?> blocks</p>
									                			<p><b>Total Shots Fired:</b> <?php echo number_format($player->quakecraft->soloShotsFired + $player->quakecraft->teamShotsFired); ?></p>

									                			<br>

									                			<p><b>Kill-Death Ratio:</b> <?php echo $kd_qc; ?></p>
									                			<p><b>Shot-Kill Ratio:</b> <?php echo $sk_qc; ?></p>

									                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#quakesolo">Solo</button><br><br>

									                			<div id="quakesolo" class="collapse">

										                			<p><b>Kills:</b> <?php echo number_format($player->quakecraft->soloKills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->quakecraft->soloWins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->quakecraft->soloDeaths); ?></p>
										                			<p><b>Killstreaks:</b> <?php echo number_format($player->quakecraft->soloKillstreaks); ?></p>
										                			<p><b>Headshots:</b> <?php echo number_format($player->quakecraft->soloHeadshots); ?></p>
										                			<p><b>Distance Travelled:</b> <?php echo number_format($player->quakecraft->soloDistanceTravelled); ?> blocks</p>
										                			<p><b>Shots Fired:</b> <?php echo number_format($player->quakecraft->soloShotsFired); ?></p>

										                		</div>

										                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#quaketeams">Teams</button><br><br>

									                			<div id="quaketeams" class="collapse">

										                			<p><b>Kills:</b> <?php echo number_format($player->quakecraft->teamKills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->quakecraft->teamWins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->quakecraft->teamDeaths); ?></p>
										                			<p><b>Killstreaks:</b> <?php echo number_format($player->quakecraft->teamKillstreaks); ?></p>
										                			<p><b>Headshots:</b> <?php echo number_format($player->quakecraft->teamHeadshots); ?></p>
										                			<p><b>Distance Travelled:</b> <?php echo number_format($player->quakecraft->teamDistanceTravelled); ?> blocks</p>
										                			<p><b>Shots Fired:</b> <?php echo number_format($player->quakecraft->teamShotsFired); ?></p>

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
							                	</div>
							                	<br>
					                		</div>

					                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#arena">Arena Brawl</button><br><br>

					                		<div id="arena" class="collapse">
												<div class="card">
													<div class="card-header">
					                                    <i class="fas fa-table mr-1"></i>
					                                    	Arena Brawl
				                                	</div>

					        						<div class="card-body">
					        							<div class="row">
					        								<div class="col-md-6">

							        							<?php
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
									                			?>

									                			<p><b>Rating:</b> <?php echo number_format($player->arena->rating); ?></p>
									                			<p><b>Coins:</b> <?php echo number_format($player->arena->coins); ?></p>
									                			<p><b>Coins Spent:</b> <?php echo number_format($player->arena->coinsSpent); ?></p>
									                			<p><b>Keys Used:</b> <?php echo number_format($player->arena->keys); ?></p>
																<p><b>Kills:</b> <?php echo number_format($player->arena->ones->kills + $player->arena->twos->kills + $player->arena->fours->kills); ?></p>
									                			<p><b>Wins:</b> <?php echo number_format($player->arena->ones->wins + $player->arena->twos->wins + $player->arena->fours->wins); ?></p>
									                			<p><b>Deaths:</b> <?php echo number_format($player->arena->ones->deaths + $player->arena->twos->deaths + $player->arena->fours->deaths); ?></p>
									                			<p><b>Losses:</b> <?php echo number_format($player->arena->ones->losses + $player->arena->twos->losses + $player->arena->fours->losses); ?></p>
									                			<p><b>Games Played:</b> <?php echo number_format($player->arena->ones->games + $player->arena->twos->games + $player->arena->fours->games); ?></p>
									                			<p><b>Damage:</b> <?php echo number_format($player->arena->ones->damage + $player->arena->twos->damage + $player->arena->fours->damage); ?></p>
									                			<p><b>Healed:</b> <?php echo number_format($player->arena->ones->healed + $player->arena->twos->healed + $player->arena->fours->healed); ?></p>

									                			<br>

									                			<p><b>K/D:</b> <?php echo $kd_ab_o; ?></p>
									                			<p><b>W/L:</b> <?php echo $wl_ab_o; ?></p>

									                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_1">1v1</button><br><br>

									                			<div id="arena_1" class="collapse">

																	<p><b>Kills:</b> <?php echo number_format($player->arena->ones->kills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->arena->ones->wins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->arena->ones->deaths); ?></p>
										                			<p><b>Losses:</b> <?php echo number_format($player->arena->ones->losses); ?></p>
										                			<p><b>Games Played:</b> <?php echo number_format($player->arena->ones->games); ?></p>
										                			<p><b>Damage:</b> <?php echo number_format($player->arena->ones->damage); ?></p>
										                			<p><b>Healed:</b> <?php echo number_format($player->arena->ones->healed); ?></p>
										                			<p><b>K/D:</b> <?php echo $kd_ab_1; ?></p>
										                			<p><b>W/L:</b> <?php echo $wl_ab_1; ?></p>
									                			
									                			</div>
									                			
									                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_2">2v2</button><br><br>

									                			<div id="arena_2" class="collapse">

																	<p><b>Kills:</b> <?php echo number_format($player->arena->twos->kills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->arena->twos->wins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->arena->twos->deaths); ?></p>
										                			<p><b>Losses:</b> <?php echo number_format($player->arena->twos->losses); ?></p>
										                			<p><b>Games Played:</b> <?php echo number_format($player->arena->twos->games); ?></p>
										                			<p><b>Damage:</b> <?php echo number_format($player->arena->twos->damage); ?></p>
										                			<p><b>Healed:</b> <?php echo number_format($player->arena->twos->healed); ?></p>
										                			<p><b>K/D:</b> <?php echo $kd_ab_2; ?></p>
										                			<p><b>W/L:</b> <?php echo $wl_ab_2; ?></p>

									                			</div>

									                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#arena_4">4v4</button><br><br>

									                			<div id="arena_4" class="collapse">

																	<p><b>Kills:</b> <?php echo number_format($player->arena->fours->kills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->arena->fours->wins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->arena->fours->deaths); ?></p>
										                			<p><b>Losses:</b> <?php echo number_format($player->arena->fours->losses); ?></p>
										                			<p><b>Games Played:</b> <?php echo number_format($player->arena->fours->games); ?></p>
										                			<p><b>Damage:</b> <?php echo number_format($player->arena->fours->damage); ?></p>
										                			<p><b>Healed:</b> <?php echo number_format($player->arena->fours->healed); ?></p>
										                			<p><b>K/D:</b> <?php echo $kd_ab_4; ?></p>
										                			<p><b>W/L:</b> <?php echo $wl_ab_4; ?></p>

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
							                		</div>
							                	</div>
							                	<br>
					                		</div>

					                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#tkr">Turbo Kart Racers</button><br><br>

					                		<div id="tkr" class="collapse">
												<div class="card">
													<div class="card-header">
					                                    <i class="fas fa-table mr-1"></i>
					                                    	Turbo Kart Racers
				                                	</div>

					        						<div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">

        							                			<p><b>Wins:</b> <?php echo number_format($player->tkr->wins); ?></p>
        							                			<p><b>Coins:</b> <?php echo number_format($player->tkr->coins); ?></p>
        							                			<p><b>Gold Trophies:</b> <?php echo number_format($player->tkr->goldTrophy); ?></p>
        							                			<p><b>Silver Trophies:</b> <?php echo number_format($player->tkr->silverTrophy); ?></p>
        							                			<p><b>Bronze Trophies:</b> <?php echo number_format($player->tkr->bronzeTrophy); ?></p>
        							                			<p><b>Box Pickups:</b> <?php echo number_format($player->tkr->boxPickups); ?></p>
        							                			<p><b>Laps Completed:</b> <?php echo number_format($player->tkr->lapsCompleted); ?></p>
        							                			<p><b>Coin Pickups:</b> <?php echo number_format($player->tkr->coinPickups); ?></p>

        							                			<br>

        							                			<p><b>Olympus Plays:</b> <?php echo $player->tkr->mapPlays->olympus; ?></p>
        							                			<p><b>Jungle Rush Plays:</b> <?php echo $player->tkr->mapPlays->junglerush; ?></p>
        							                			<p><b>Hypixel GP Plays:</b> <?php echo $player->tkr->mapPlays->hypixelgp; ?></p>
        							                			<p><b>Retro Plays:</b> <?php echo $player->tkr->mapPlays->retro; ?></p>
        							                			<p><b>Canyon Plays:</b> <?php echo $player->tkr->mapPlays->canyon; ?></p>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <br><br>

                                                                <center><h4>Trophy Wins</h4></center>
                                                                <canvas id="tkrPie"></canvas>

                                                                <br><hr><br>

                                                                <center><h4>Map Plays</h4></center>
                                                                <canvas id="tkrPie2"></canvas>

                                                            </div>

                                                        </div>
							                		</div>
							                	</div>
							                	<br>
					                		</div>

					                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#vz">VampireZ</button><br><br>

					                		<div id="vz" class="collapse">
												<div class="card">
													<div class="card-header">
					                                    <i class="fas fa-table mr-1"></i>
					                                    	VampireZ
				                                	</div>
					        						<div class="card-body">

							                			<p><b>Coins:</b> <?php echo number_format($player->vampirez->coins); ?></p>

							                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#human">As Human</button><br><br>

							                			<div id="human" class="collapse">
                                                            <div class="row">
                                                                <div class="col-md-6">
        								                			<p><b>Human Wins:</b> <?php echo number_format($player->vampirez->asHuman->humanWins); ?></p>
        								                			<p><b>Vampire Kills:</b> <?php echo number_format($player->vampirez->asHuman->vampireKills); ?></p>
        								                			<p><b>Human Deaths:</b> <?php echo number_format($player->vampirez->asHuman->humanDeaths); ?></p>
        								                			<p><b>Zombie Kills:</b> <?php echo number_format($player->vampirez->asHuman->zombieKills); ?></p>
        								                			<p><b>Most Vampire Kills:</b> <?php echo number_format($player->vampirez->asHuman->mostVampireKills); ?></p>
        								                			<p><b>Gold Bought:</b> <?php echo number_format($player->vampirez->asHuman->goldBought); ?></p>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <br><br>

                                                                    <center><h4>Human Kills / Deaths</h4></center>
                                                                    <canvas id="humanPie"></canvas>

                                                                </div>
                                                            </div>
								                		</div>

							                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#vampire">As Vampire</button><br><br>

							                			<div id="vampire" class="collapse">
                                                            <div class="row">
                                                                <div class="col-md-6">
        								                			<p><b>Vampire Wins:</b> <?php echo number_format($player->vampirez->asVampire->vampireWins); ?></p>
        								                			<p><b>Vampire Deaths:</b> <?php echo number_format($player->vampirez->asVampire->vampireDeaths); ?></p>
        								                			<p><b>Human Kills:</b> <?php echo number_format($player->vampirez->asVampire->humanKills); ?></p>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <br><br>

                                                                    <center><h4>Vampire Kills / Deaths</h4></center>
                                                                    <canvas id="vampPie"></canvas>

                                                                </div>
                                                            </div>
								                		</div>

							                		</div>
							                	</div>
							                	<br>
					                		</div>

					                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#walls">The Walls</button><br><br>

					                		<div id="walls" class="collapse">
												<div class="card">
													<div class="card-header">
					                                    <i class="fas fa-table mr-1"></i>
					                                    	The Walls
				                                	</div>
					        						<div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
        							                			<p><b>Coins:</b> <?php echo number_format($player->walls->coins); ?></p>
        							                			<p><b>Wins:</b> <?php echo number_format($player->walls->wins); ?></p>
        							                			<p><b>Kills:</b> <?php echo number_format($player->walls->kills); ?></p>
        							                			<p><b>Deaths:</b> <?php echo number_format($player->walls->deaths); ?></p>
        							                			<p><b>Losses:</b> <?php echo number_format($player->walls->losses); ?></p>
        							                			<p><b>Assists:</b> <?php echo number_format($player->walls->assists); ?></p>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <br><br>

                                                                <center><h4>Kills / Deaths / Assists</h4></center>
                                                                <canvas id="wallsPie"></canvas>

                                                            </div>
                                                        </div>
							                		</div>
							                	</div>
					                		</div>

                                            <br><hr><br>

					                		<center><h4>Coins By Game</h4></center>
											<canvas id="classicPie"></canvas>

					                		<hr>
					                	</div>

			                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#tnt">TNT Games</button><br><br>

				                		<div id="tnt" class="collapse">
											<div class="card">
												<div class="card-header">
				                                    <i class="fas fa-table mr-1"></i>
				                                    	TNT Games
			                                	</div>
				        						<div class="card-body">
				        							<?php
				        								$tntrun_wl = 0.0;
				        								$bs_wl = 0.0;
				        								$pvprun_kd = 0.0;
				        								$wiz_kd = 0.0;
						                			
						                				if ($player->tntgames->tntrun->deaths != 0) {
						                					$tntrun_wl = round(($player->tntgames->tntrun->wins / $player->tntgames->tntrun->deaths), 2);
						                				}

						                				if ($player->tntgames->bowspleef->deaths != 0) {
						                					$bs_wl = round(($player->tntgames->bowspleef->wins / $player->tntgames->bowspleef->deaths), 2);
						                				}

						                				if ($player->tntgames->pvprun->deaths != 0) {
						                					$pvprun_kd = round(($player->tntgames->pvprun->kills / $player->tntgames->pvprun->deaths), 2);
						                				}

						                				if ($player->tntgames->wizards->deaths != 0) {
						                					$wiz_kd = round(($player->tntgames->wizards->kills / $player->tntgames->wizards->deaths), 2);
						                				}

						                			?>

						                			<p><b>Coins:</b> <?php echo number_format($player->tntgames->coins); ?></p>
						                			<p><b>Total Wins:</b> <?php echo number_format($player->tntgames->wins); ?></p>
						                			<p><b>Selected Hat:</b> <?php echo formatTntHat($player->tntgames->hat); ?></p>
						                			<p><b>Current Winstreak:</b> <?php echo number_format($player->tntgames->winstreak); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#tntrun">TNT Run</button><br><br>

						                			<div id="tntrun" class="collapse">
														<div class="row">
                                                            <div class="col-md-6">
																<p><b>Wins:</b> <?php echo number_format($player->tntgames->tntrun->wins); ?></p>
																<p><b>Losses:</b> <?php echo number_format($player->tntgames->tntrun->deaths); ?></p>
																<p><b>Record:</b> <?php echo number_format($player->tntgames->tntrun->record); ?></p>
																<p><b>W/L:</b> <?php echo $tntrun_wl; ?></p>
															</div>

															<div class="col-md-6">
																<br><br>

																<center><h4>Win / Loss Ratio</h4></center>
																<canvas id="tntrunpie"></canvas>

															</div>
                                                        </div>
							                		</div>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#bowspleef">Bow Spleef</button><br><br>

						                			<div id="bowspleef" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->tntgames->bowspleef->wins); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->tntgames->bowspleef->deaths); ?></p>
							                			<p><b>W/L:</b> <?php echo $bs_wl; ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#pvprun">PVP Run</button><br><br>

						                			<div id="pvprun" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->tntgames->pvprun->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->tntgames->pvprun->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->tntgames->pvprun->deaths); ?></p>
							                			<p><b>Record:</b> <?php echo number_format($player->tntgames->pvprun->record); ?></p>
							                			<p><b>K/D:</b> <?php echo $pvprun_kd; ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#tntag">TNT Tag</button><br><br>

						                			<div id="tntag" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->tntgames->tntag->wins); ?></p>
				                						<p><b>Kills:</b> <?php echo number_format($player->tntgames->tntag->kills); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#wizards">TNT Wizards</button><br><br>

						                			<div id="wizards" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->tntgames->wizards->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->tntgames->wizards->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->tntgames->wizards->deaths); ?></p>
							                			<p><b>Assists:</b> <?php echo number_format($player->tntgames->wizards->assists); ?></p>
							                			<p><b>Points Captured:</b> <?php echo number_format($player->tntgames->wizards->points); ?></p>
							                			<p><b>K/D:</b> <?php echo $wiz_kd; ?></p>
							                		</div>

						                		</div>
						                	</div>
						                	<br>
				                		</div>

			                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#bedwars">Bedwars</button><br><br>

			                		<div id="bedwars" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Bedwars
				                            </div>
			        						<div class="card-body">

					                			<p><b>Coins:</b> <?php echo number_format($player->bedwars->coins); ?></p>
					                			<p><b>Wins:</b> <?php echo number_format($player->bedwars->wins); ?></p>
					                			<p><b>Experience:</b> <?php echo number_format($player->bedwars->experience); ?></p>
					                			<p><b>Losses:</b> <?php echo number_format($player->bedwars->losses); ?></p>
					                			<p><b>Games Played:</b> <?php echo number_format($player->bedwars->gamesPlayed); ?></p>
					                			<p><b>Beds Broken:</b> <?php echo number_format($player->bedwars->bedsBroken); ?></p>
					                			<p><b>Winstreak:</b> <?php echo number_format($player->bedwars->winstreak); ?></p>

					                			<br>

												<p><b>Kills:</b> <?php echo number_format($player->bedwars->kills); ?></p>
					                			<p><b>Void Kills:</b> <?php echo number_format($player->bedwars->voidKills); ?></p>
					                			<p><b>Final Kills:</b> <?php echo number_format($player->bedwars->finalKills); ?></p>

					                			<br>

					                			<p><b>Resources Collected:</b> <?php echo number_format($player->bedwars->resourcesCollected->total); ?></p>
					                			<p><b>Iron Collected:</b> <?php echo number_format($player->bedwars->resourcesCollected->iron); ?></p>
					                			<p><b>Gold Collected:</b> <?php echo number_format($player->bedwars->resourcesCollected->gold); ?></p>
					                			<p><b>Diamonds Collected:</b> <?php echo number_format($player->bedwars->resourcesCollected->diamond); ?></p>
					                			<p><b>Emeralds Collected:</b> <?php echo number_format($player->bedwars->resourcesCollected->emerald); ?></p>

					                		</div>
					                	</div>
					                	<br>
			                		</div>

			                		<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#skywars">SkyWars</button><br><br>

			                		<div id="skywars" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                SkyWars
				                            </div>
			        						<div class="card-body">

					                			<p><b>Coins:</b> <?php echo number_format($player->skywars->overall->coins); ?></p>
					                			<p><b>Wins:</b> <?php echo number_format($player->skywars->overall->wins); ?></p>
					                			<p><b>Kills:</b> <?php echo number_format($player->skywars->overall->kills); ?></p>
					                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->overall->deaths); ?></p>
					                			<p><b>Assists:</b> <?php echo number_format($player->skywars->overall->assists); ?></p>
					                			<p><b>Losses:</b> <?php echo number_format($player->skywars->overall->losses); ?></p>
					                			<p><b>Games Played:</b> <?php echo number_format($player->skywars->overall->games); ?></p>
					                			<p><b>Arrows Shot:</b> <?php echo number_format($player->skywars->overall->arrowsShot); ?></p>
					                			<p><b>Arrows Hit:</b> <?php echo number_format($player->skywars->overall->arrowsHit); ?></p>
					                			<p><b>Souls Gathered:</b> <?php echo number_format($player->skywars->overall->soulsGathered); ?></p>
					                			<p><b>Winstreak:</b> <?php echo number_format($player->skywars->overall->winstreak); ?></p>
					                			<p><b>Blocks Broken:</b> <?php echo number_format($player->skywars->overall->blocksBroken); ?></p>
					                			<p><b>Blocks Placed:</b> <?php echo number_format($player->skywars->overall->blocksPlaced); ?></p>
					                			<p><b>Survived Players:</b> <?php echo number_format($player->skywars->overall->survivedPlayers); ?></p>
					                			<p><b>Ender Pearls Thrown:</b> <?php echo number_format($player->skywars->overall->pearlsThrown); ?></p>
					                			<p><b>Items Enchanted:</b> <?php echo number_format($player->skywars->overall->itemsEnchanted); ?></p>
					                			<p><b>Eggs Thrown:</b> <?php echo number_format($player->skywars->overall->eggsThrown); ?></p>
					                			<p><b>Fastest Win:</b> <?php echo number_format($player->skywars->overall->fastestWin); ?></p>

					                			<br>

												<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#normal">Normal</button><br><br>

					                			<div id="normal" class="collapse">

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#solo_normal">Solo</button><br><br>

						                			<div id="solo_normal" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->skywars->normal->solo->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->skywars->normal->solo->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->normal->solo->deaths); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->skywars->normal->solo->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#team_normal">Teams</button><br><br>

						                			<div id="team_normal" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->skywars->normal->team->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->skywars->normal->team->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->normal->team->deaths); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->skywars->normal->team->losses); ?></p>
							                		</div>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#insane">Insane</button><br><br>

						                		<div id="insane" class="collapse">

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#solo_insane">Solo</button><br><br>

						                			<div id="solo_insane" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->skywars->insane->solo->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->skywars->insane->solo->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->insane->solo->deaths); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->skywars->insane->solo->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#team_insane">Teams</button><br><br>

						                			<div id="team_insane" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->skywars->insane->team->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->skywars->insane->team->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->insane->team->deaths); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->skywars->insane->team->losses); ?></p>
							                		</div>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#mega">Mega</button><br><br>

					                			<div id="mega" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->skywars->mega->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->skywars->mega->kills); ?></p>
						                			<p><b>Assists:</b> <?php echo number_format($player->skywars->mega->assists); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->skywars->mega->deaths); ?></p>
						                			<p><b>Losses:</b> <?php echo number_format($player->skywars->mega->losses); ?></p>
						                			<p><b>Games Played:</b> <?php echo number_format($player->skywars->mega->games); ?></p>
						                			<p><b>Survived Players:</b> <?php echo number_format($player->skywars->mega->survivedPlayers); ?></p>
						                		</div>


					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#warlords">Warlords</button><br><br>

		                			<div id="warlords" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Warlords
				                            </div>
			        						<div class="card-body">

					                			<p><b>Coins:</b> <?php echo number_format($player->warlords->coins); ?></p>
					                			<p><b>Wins:</b> <?php echo number_format($player->warlords->wins); ?></p>
					                			<p><b>Kills:</b> <?php echo number_format($player->warlords->kills); ?></p>
					                			<p><b>Assists:</b> <?php echo number_format($player->warlords->assists); ?></p>
					                			<p><b>Deaths:</b> <?php echo number_format($player->warlords->deaths); ?></p>
					                			<p><b>Losses:</b> <?php echo number_format($player->warlords->losses); ?></p>
					                			<p><b>Powerups Collected:</b> <?php echo number_format($player->warlords->powerups); ?></p>
					                			<p><b>Blue Wins:</b> <?php echo number_format($player->warlords->winsBlue); ?></p>
					                			<p><b>Red Wins:</b> <?php echo number_format($player->warlords->winsRed); ?></p>
					                			<p><b>Current Class:</b> <?php echo $player->warlords->currentClass; ?></p>

					                			<br>

												<p><b>Damage:</b> <?php echo number_format($player->warlords->damage); ?></p>
					                			<p><b>Healing:</b> <?php echo number_format($player->warlords->heal); ?></p>
					                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->damagePrevented); ?></p>
					                			<p><b>Damage Delayed:</b> <?php echo number_format($player->warlords->damageDelayed); ?></p>
					                			<p><b>Damage Taken:</b> <?php echo number_format($player->warlords->damageTaken); ?></p>
					                			<p><b>Life Leeched:</b> <?php echo number_format($player->warlords->lifeLeeched); ?></p>

					                			<br>

					                			<p><b>Magic Dust:</b> <?php echo number_format($player->warlords->magicDust); ?></p>
					                			<p><b>Void Shards:</b> <?php echo number_format($player->warlords->voidShards); ?></p>

					                			<br>
					                			
					                			<p><b>Repaired Weapons:</b> <?php echo number_format($player->warlords->repairedWeapons); ?></p>
					                			<p><b>Common Repairs:</b> <?php echo number_format($player->warlords->repairedCommon); ?></p>
					                			<p><b>Rare Repairs:</b> <?php echo number_format($player->warlords->repairedRare); ?></p>
					                			<p><b>Epic Repairs:</b> <?php echo number_format($player->warlords->repairedEpic); ?></p>
					                			<p><b>Legendary Repairs:</b> <?php echo number_format($player->warlords->repairedLegendary); ?></p>

					                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#warrior">Warrior</button><br><br>

					                			<div id="warrior" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->warlords->warrior->wins); ?></p>
						                			<p><b>Plays:</b> <?php echo number_format($player->warlords->warrior->plays); ?></p>
						                			<p><b>Damage:</b> <?php echo number_format($player->warlords->warrior->damage); ?></p>
						                			<p><b>Healing:</b> <?php echo number_format($player->warlords->warrior->heal); ?></p>
						                			<p><b>Life Leeched:</b> <?php echo number_format($player->warlords->warrior->lifeLeeched); ?></p>
						                			<p><b>Losses:</b> <?php echo number_format($player->warlords->warrior->losses); ?></p>
						                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->warrior->damagePrevented); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#berserker">Berserker</button><br><br>

						                			<div id="berserker" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->warrior->berserker->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->warrior->berserker->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->warrior->berserker->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->warrior->berserker->heal); ?></p>
							                			<p><b>Life Leeched:</b> <?php echo number_format($player->warlords->warrior->berserker->lifeLeeched); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->warrior->berserker->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->warrior->berserker->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#revenant">Revenant</button><br><br>

						                			<div id="revenant" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->warrior->revenant->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->warrior->revenant->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->warrior->revenant->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->warrior->revenant->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->warrior->revenant->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->warrior->revenant->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#defender">Defender</button><br><br>

						                			<div id="defender" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->warrior->defender->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->warrior->defender->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->warrior->defender->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->warrior->defender->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->warrior->defender->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->warrior->defender->losses); ?></p>
							                		</div>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#mage">Mage</button><br><br>

						                		<div id="mage" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->warlords->mage->wins); ?></p>
						                			<p><b>Plays:</b> <?php echo number_format($player->warlords->mage->plays); ?></p>
						                			<p><b>Damage:</b> <?php echo number_format($player->warlords->mage->damage); ?></p>
						                			<p><b>Healing:</b> <?php echo number_format($player->warlords->mage->heal); ?></p>
						                			<p><b>Losses:</b> <?php echo number_format($player->warlords->mage->losses); ?></p>
						                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->mage->damagePrevented); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#pyro">Pyromancer</button><br><br>

						                			<div id="pyro" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->mage->pyromancer->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->mage->pyromancer->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->mage->pyromancer->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->mage->pyromancer->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->mage->pyromancer->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->mage->pyromancer->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#aqua">Aquamancer</button><br><br>

						                			<div id="aqua" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->mage->aquamancer->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->mage->aquamancer->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->mage->aquamancer->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->mage->aquamancer->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->mage->aquamancer->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->mage->aquamancer->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#cryo">Cryomancer</button><br><br>

						                			<div id="cryo" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->mage->cryomancer->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->mage->cryomancer->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->mage->cryomancer->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->mage->cryomancer->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->mage->cryomancer->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->mage->cryomancer->losses); ?></p>
							                		</div>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#paladin">Paladin</button><br><br>

						                		<div id="paladin" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->warlords->paladin->wins); ?></p>
						                			<p><b>Plays:</b> <?php echo number_format($player->warlords->paladin->plays); ?></p>
						                			<p><b>Damage:</b> <?php echo number_format($player->warlords->paladin->damage); ?></p>
						                			<p><b>Healing:</b> <?php echo number_format($player->warlords->paladin->heal); ?></p>
						                			<p><b>Losses:</b> <?php echo number_format($player->warlords->paladin->losses); ?></p>
						                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->paladin->damagePrevented); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#avenger">Avenger</button><br><br>

						                			<div id="avenger" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->paladin->avenger->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->paladin->avenger->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->paladin->avenger->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->paladin->avenger->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->paladin->avenger->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->paladin->avenger->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#protector">Protector</button><br><br>

						                			<div id="protector" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->paladin->protector->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->paladin->protector->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->paladin->protector->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->paladin->protector->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->paladin->protector->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->paladin->protector->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#crusader">Crusader</button><br><br>

						                			<div id="crusader" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->paladin->crusader->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->paladin->crusader->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->paladin->crusader->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->paladin->crusader->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->paladin->crusader->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->paladin->crusader->losses); ?></p>
							                		</div>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#shaman">Shaman</button><br><br>

						                		<div id="shaman" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->warlords->shaman->wins); ?></p>
						                			<p><b>Plays:</b> <?php echo number_format($player->warlords->shaman->plays); ?></p>
						                			<p><b>Damage:</b> <?php echo number_format($player->warlords->shaman->damage); ?></p>
						                			<p><b>Healing:</b> <?php echo number_format($player->warlords->shaman->heal); ?></p>
						                			<p><b>Losses:</b> <?php echo number_format($player->warlords->shaman->losses); ?></p>
						                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->shaman->damagePrevented); ?></p>
						                			<p><b>Damage Delayed:</b> <?php echo number_format($player->warlords->shaman->damageDelayed); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#thunderlord">Thunderlord</button><br><br>

						                			<div id="thunderlord" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->shaman->thunderlord->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->shaman->thunderlord->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->shaman->thunderlord->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->shaman->thunderlord->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->shaman->thunderlord->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->shaman->thunderlord->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#earthwarden">Earthwarden</button><br><br>

						                			<div id="earthwarden" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->shaman->earthwarden->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->shaman->earthwarden->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->shaman->earthwarden->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->shaman->earthwarden->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->shaman->earthwarden->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->shaman->earthwarden->losses); ?></p>
							                		</div>

							                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#spiritguard">Spiritguard</button><br><br>

						                			<div id="spiritguard" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->warlords->shaman->spiritguard->wins); ?></p>
							                			<p><b>Plays:</b> <?php echo number_format($player->warlords->shaman->spiritguard->plays); ?></p>
							                			<p><b>Damage:</b> <?php echo number_format($player->warlords->shaman->spiritguard->damage); ?></p>
							                			<p><b>Healing:</b> <?php echo number_format($player->warlords->shaman->spiritguard->heal); ?></p>
							                			<p><b>Damage Prevented:</b> <?php echo number_format($player->warlords->shaman->spiritguard->damagePrevented); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->warlords->shaman->spiritguard->losses); ?></p>
							                			<p><b>Damage Delayed:</b> <?php echo number_format($player->warlords->shaman->spiritguard->damageDelayed); ?></p>
							                		</div>
						                		</div>

					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#murder">Murder Mystery</button><br><br>

		                			<div id="murder" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Murder Mystery
				                            </div>
			        						<div class="card-body">
                                                <p><b>Coins:</b> <?php echo number_format($player->murdermystery->coins); ?></p>
                                                <p><b>Wins:</b> <?php echo number_format($player->murdermystery->wins); ?></p>
                                                <p><b>Games:</b> <?php echo number_format($player->murdermystery->games); ?></p>
                                                <p><b>Deaths:</b> <?php echo number_format($player->murdermystery->deaths); ?></p>
                                                <p><b>Coins Picked Up:</b> <?php echo number_format($player->murdermystery->coinsPickedUp); ?></p>
                                                <p><b>Detective Wins:</b> <?php echo number_format($player->murdermystery->detectiveWins); ?></p>
                                                <p><b>Was Hero:</b> <?php echo number_format($player->murdermystery->wasHero); ?></p>

                                                <br>

                                                <p><b>Kills:</b> <?php echo number_format($player->murdermystery->kills); ?></p>
                                                <p><b>Kills As Murderer:</b> <?php echo number_format($player->murdermystery->killsAsMurderer); ?></p>
                                                <p><b>Kills As Survivor:</b> <?php echo number_format($player->murdermystery->killsAsSurvivor); ?></p>
                                                <p><b>Knife Kills:</b> <?php echo number_format($player->murdermystery->knifeKills); ?></p>
                                                <p><b>Bow Kills:</b> <?php echo number_format($player->murdermystery->bowKills); ?></p>                                
                                                <p><b>Thrown Knife Kills:</b> <?php echo number_format($player->murdermystery->thrownKnifeKills); ?></p>

                                                <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#classicmm">Classic</button><br><br>

                                                <div id="classicmm" class="collapse">
                                                    <p><b>Wins:</b> <?php echo number_format($player->murdermystery->classic->wins); ?></p>
                                                    <p><b>Kills:</b> <?php echo number_format($player->murdermystery->classic->kills); ?></p>
                                                    <p><b>Deaths:</b> <?php echo number_format($player->murdermystery->classic->deaths); ?></p>
                                                    <p><b>Games:</b> <?php echo number_format($player->murdermystery->classic->games); ?></p>
                                                    <p><b>Knife Kills:</b> <?php echo number_format($player->murdermystery->classic->knifeKills); ?></p>
                                                    <p><b>Thrown Knife Kills:</b> <?php echo number_format($player->murdermystery->classic->thrownKnifeKills); ?></p>
                                                    <p><b>Bow Kills:</b> <?php echo number_format($player->murdermystery->classic->bowKills); ?></p>
                                                </div>

                                                <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#assassins">Assassins</button><br><br>

                                                <div id="assassins" class="collapse">
                                                    <p><b>Wins:</b> <?php echo number_format($player->murdermystery->assassins->wins); ?></p>
                                                    <p><b>Kills:</b> <?php echo number_format($player->murdermystery->assassins->kills); ?></p>
                                                    <p><b>Deaths:</b> <?php echo number_format($player->murdermystery->assassins->deaths); ?></p>
                                                    <p><b>Games:</b> <?php echo number_format($player->murdermystery->assassins->games); ?></p>
                                                    <p><b>Knife Kills:</b> <?php echo number_format($player->murdermystery->assassins->knifeKills); ?></p>
                                                    <p><b>Thrown Knife Kills:</b> <?php echo number_format($player->murdermystery->assassins->thrownKnifeKills); ?></p>
                                                    <p><b>Bow Kills:</b> <?php echo number_format($player->murdermystery->assassins->bowKills); ?></p>
                                                </div>

                                                <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#doubleup">Double Up</button><br><br>

                                                <div id="doubleup" class="collapse">
                                                    <p><b>Wins:</b> <?php echo number_format($player->murdermystery->doubleup->wins); ?></p>
                                                    <p><b>Kills:</b> <?php echo number_format($player->murdermystery->doubleup->kills); ?></p>
                                                    <p><b>Deaths:</b> <?php echo number_format($player->murdermystery->doubleup->deaths); ?></p>
                                                    <p><b>Games:</b> <?php echo number_format($player->murdermystery->doubleup->games); ?></p>
                                                    <p><b>Knife Kills:</b> <?php echo number_format($player->murdermystery->doubleup->knifeKills); ?></p>
                                                    <p><b>Thrown Knife Kills:</b> <?php echo number_format($player->murdermystery->doubleup->thrownKnifeKills); ?></p>
                                                    <p><b>Bow Kills:</b> <?php echo number_format($player->murdermystery->doubleup->bowKills); ?></p>
                                                </div>

                                                <button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#infection">Infection</button><br><br>

                                                <div id="infection" class="collapse">
                                                    <p><b>Wins:</b> <?php echo number_format($player->murdermystery->infection->wins); ?></p>
                                                    <p><b>Games:</b> <?php echo number_format($player->murdermystery->infection->games); ?></p>
                                                    <p><b>Deaths:</b> <?php echo number_format($player->murdermystery->infection->deaths); ?></p>

                                                    <br>
                                                    
                                                    <p><b>Kills As Infected:</b> <?php echo number_format($player->murdermystery->infection->killsAsInfected); ?></p>
                                                    <p><b>Kills As Survivor:</b> <?php echo number_format($player->murdermystery->infection->killsAsSurvivor); ?></p>
                                                </div>
					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#arcade">Arcade</button><br><br>

		                			<div id="arcade" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Arcade
				                            </div>
			        						<div class="card-body">

					                			<p><b>Coins:</b> <?php echo number_format($player->arcade->coins); ?></p>
					                			<p><b>Creeper Attack Record:</b> <?php echo number_format($player->arcade->creeperAttack->maxWave); ?></p>
					                			<p><b>Ender Spleef Wins:</b> <?php echo number_format($player->arcade->enderSpleef->wins); ?></p>
					                			<p><b>Party Games 1 Wins:</b> <?php echo number_format($player->arcade->partyGamesOne->wins); ?></p>
					                			<p><b>Party Games 2 Wins:</b> <?php echo number_format($player->arcade->partyGamesTwo->wins); ?></p>
					                			<p><b>Party Games 3 Wins:</b> <?php echo number_format($player->arcade->partyGamesThree->wins); ?></p>
					                			<p><b>Farm Hunt Wins:</b> <?php echo number_format($player->arcade->farmHunt->wins); ?></p>
					                			<p><b>Farm Hunt Poop Collected:</b> <?php echo number_format($player->arcade->farmHunt->poopCollected); ?></p>
					                			<p><b>Hole In The Wall Wins:</b> <?php echo number_format($player->arcade->holeInTheWall->wins); ?></p>
					                			<p><b>Hypixel Says Wins:</b> <?php echo number_format($player->arcade->hypixelSays->wins); ?></p>
					                			<p><b>Hypixel Says Rounds:</b> <?php echo number_format($player->arcade->hypixelSays->rounds); ?></p>
					                			<p><b>Dragon Wars Wins:</b> <?php echo number_format($player->arcade->dragonWars->wins); ?></p>
					                			<p><b>Dragon Wars Kills:</b> <?php echo number_format($player->arcade->dragonWars->kills); ?></p>

												<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#miniwalls">Mini Walls</button><br><br>

						                		<div id="miniwalls" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->miniWalls->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->arcade->miniWalls->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->arcade->miniWalls->deaths); ?></p>
						                			<p><b>Final Kills:</b> <?php echo number_format($player->arcade->miniWalls->finalKills); ?></p>
						                			<p><b>Wither Kills:</b> <?php echo number_format($player->arcade->miniWalls->witherKills); ?></p>
						                			<p><b>Wither Damage:</b> <?php echo number_format($player->arcade->miniWalls->witherDamage); ?></p>
						                			<p><b>Arrows Shot:</b> <?php echo number_format($player->arcade->miniWalls->arrowsShot); ?></p>
						                			<p><b>Arrows Hit:</b> <?php echo number_format($player->arcade->miniWalls->arrowsHit); ?></p>
						                		</div>

												<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#bounty">Bounty Hunters</button><br><br>

						                		<div id="bounty" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->bountyHunters->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->arcade->bountyHunters->kills); ?></p>
						                			<p><b>Bounty Kills:</b> <?php echo number_format($player->arcade->bountyHunters->bountyKills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->arcade->bountyHunters->deaths); ?></p>
						                		</div>

												<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#throwout">Throw Out</button><br><br>

						                		<div id="throwout" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->throwOut->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->arcade->throwOut->wins); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->arcade->throwOut->deaths); ?></p>
						                		</div>

												<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#blockingdead">Blocking Dead</button><br><br>

						                		<div id="blockingdead" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->blockingDead->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->arcade->blockingDead->kills); ?></p>
						                			<p><b>Headshots:</b> <?php echo number_format($player->arcade->blockingDead->headshots); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#galaxy">Galaxy Wars</button><br><br>

						                		<div id="galaxy" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->galaxyWars->wins); ?></p>
						                			<p><b>Kills:</b> <?php echo number_format($player->arcade->galaxyWars->kills); ?></p>
						                			<p><b>Shots Fired:</b> <?php echo number_format($player->arcade->galaxyWars->shotsFired); ?></p>
						                			<p><b>Rebel Kills:</b> <?php echo number_format($player->arcade->galaxyWars->rebelKills); ?></p>
						                			<p><b>Empire Kills:</b> <?php echo number_format($player->arcade->galaxyWars->empireKills); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#football">Football</button><br><br>

						                		<div id="football" class="collapse">
						                			<p><b>Wins:</b> <?php echo number_format($player->arcade->football->wins); ?></p>
						                			<p><b>Goals:</b> <?php echo number_format($player->arcade->football->goals); ?></p>
						                			<p><b>Power Kicks:</b> <?php echo number_format($player->arcade->football->powerKicks); ?></p>
						                			<p><b>Kicks:</b> <?php echo number_format($player->arcade->football->kicks); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#hideandseek">Hide And Seek</button><br><br>

						                		<div id="hideandseek" class="collapse">
						                			<p><b>Seeker Wins:</b> <?php echo number_format($player->arcade->hideAndSeek->seekerWins); ?></p>
						                			<p><b>Hider Wins:</b> <?php echo number_format($player->arcade->hideAndSeek->hiderWins); ?></p>
						                			<p><b>Party Pooper Seeker Wins:</b> <?php echo number_format($player->arcade->hideAndSeek->partyPooper->seekerWins); ?></p>
						                			<p><b>Party Pooper Hider Wins:</b> <?php echo number_format($player->arcade->hideAndSeek->partyPooper->hiderWins); ?></p>
						                			<p><b>Prop Hunt Hider Wins:</b> <?php echo number_format($player->arcade->hideAndSeek->propHunt->hiderWins); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#zombies">Zombies</button><br><br>

						                		<div id="zombies" class="collapse">
						                			<p><b>Best Round:</b> <?php echo number_format($player->arcade->zombies->bestRound); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#seasonal">Seasonal</button><br><br>

						                		<div id="seasonal" class="collapse">
						                			<p><b>Santa Says Rounds:</b> <?php echo number_format($player->arcade->seasonal->santaSays->rounds); ?></p>
						                			<p><b>Santa Simulator Wins:</b> <?php echo number_format($player->arcade->seasonal->santaSimulator->wins); ?></p>
						                			<p><b>Santa Simulator Delivered:</b> <?php echo number_format($player->arcade->seasonal->santaSimulator->delivered); ?></p>
						                			<p><b>Santa Simulator Spotted:</b> <?php echo number_format($player->arcade->seasonal->santaSimulator->spotted); ?></p>
						                			<p><b>Easter Simulator Wins:</b> <?php echo number_format($player->arcade->seasonal->easterSimulator->wins); ?></p>
						                			<p><b>Easter Simulator Eggs Found:</b> <?php echo number_format($player->arcade->seasonal->easterSimulator->eggsFound); ?></p>
						                			<p><b>Scuba Simulator Points:</b> <?php echo number_format($player->arcade->seasonal->scubaSimulator->totalPoints); ?></p>
						                			<p><b>Scuba Simulator Items:</b> <?php echo number_format($player->arcade->seasonal->scubaSimulator->itemsFound); ?></p>
						                		</div>

					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#uhc">UHC</button><br><br>

		                			<div id="uhc" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                UHC
				                            </div>
			        						<div class="card-body">

					                			<p><b>Coins:</b> <?php echo number_format($player->uhc->coins); ?></p>
					                			<p><b>Score:</b> <?php echo number_format($player->uhc->score); ?></p>

			        							<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#teamsuhc">Teams</button><br><br>

						                		<div id="teamsuhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->team->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->team->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->team->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->team->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#solouhc">Solo</button><br><br>

						                		<div id="solouhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->solo->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->solo->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->solo->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->solo->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#redvsblueuhc">Red vs Blue</button><br><br>

						                		<div id="redvsblueuhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->redvsblue->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->redvsblue->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->redvsblue->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->redvsblue->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#nodiamondsuhc">No Diamonds</button><br><br>

						                		<div id="nodiamondsuhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->nodiamonds->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->nodiamonds->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->nodiamonds->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->nodiamonds->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#vanilladoublesuhc">Vanilla Doubles</button><br><br>

						                		<div id="vanilladoublesuhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->vanilladoubles->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->vanilladoubles->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->vanilladoubles->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->vanilladoubles->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#brawluhc">Brawl</button><br><br>

						                		<div id="brawluhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->brawl->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->brawl->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->brawl->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->brawl->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#solobrawluhc">Solo Brawl</button><br><br>

						                		<div id="solobrawluhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->solobrawl->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->solobrawl->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->solobrawl->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->solobrawl->headsEaten); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#duobrawluhc">Duo Brawl</button><br><br>

						                		<div id="duobrawluhc" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->uhc->duobrawl->kills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->uhc->duobrawl->deaths); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->uhc->duobrawl->wins); ?></p>
						                			<p><b>Heads Eaten:</b> <?php echo number_format($player->uhc->duobrawl->headsEaten); ?></p>
						                		</div>

					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#cac">Cops and Crims</button><br><br>

		                			<div id="cac" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Cops and Crims
				                            </div>
			        						<div class="card-body">

			        							<p><b>Coins:</b> <?php echo number_format($player->copsandcrims->coins); ?></p>

			        							<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#defusalcac">Defusal</button><br><br>

						                		<div id="defusalcac" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->copsandcrims->defusal->kills); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->copsandcrims->defusal->gameWins); ?></p>
						                			<p><b>Headshots:</b> <?php echo number_format($player->copsandcrims->defusal->headshots); ?></p>
						                			<p><b>Cop Kills:</b> <?php echo number_format($player->copsandcrims->defusal->copKills); ?></p>
						                			<p><b>Criminal Kills:</b> <?php echo number_format($player->copsandcrims->defusal->crimKills); ?></p>
						                			<p><b>Shots Fired:</b> <?php echo number_format($player->copsandcrims->defusal->shotsFired); ?></p>
						                			<p><b>Round Wins:</b> <?php echo number_format($player->copsandcrims->defusal->roundWins); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->copsandcrims->defusal->deaths); ?></p>
						                			<p><b>Bombs Planted:</b> <?php echo number_format($player->copsandcrims->defusal->bombsPlanted); ?></p>
						                			<p><b>Bombs Defused:</b> <?php echo number_format($player->copsandcrims->defusal->bombsDefused); ?></p>
						                		</div>

						                		<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#deathmatchcac">Team Deathmatch</button><br><br>

						                		<div id="deathmatchcac" class="collapse">
						                			<p><b>Kills:</b> <?php echo number_format($player->copsandcrims->deathmatch->kills); ?></p>
						                			<p><b>Wins:</b> <?php echo number_format($player->copsandcrims->deathmatch->gameWins); ?></p>
						                			<p><b>Cop Kills:</b> <?php echo number_format($player->copsandcrims->deathmatch->copKills); ?></p>
						                			<p><b>Criminal Kills:</b> <?php echo number_format($player->copsandcrims->deathmatch->crimKills); ?></p>
						                			<p><b>Deaths:</b> <?php echo number_format($player->copsandcrims->deathmatch->deaths); ?></p>
						                			<p><b>Assists:</b> <?php echo number_format($player->copsandcrims->deathmatch->assists); ?></p>
						                		</div>

					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#buildbattle">Build Battle</button><br><br>

		                			<div id="buildbattle" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Build Battle
				                            </div>
			        						<div class="card-body">
                                                <p><b>Score:</b> <?php echo number_format($player->buildbattle->score); ?></p>

                                                <br>

                                                <p><b>Solo Wins:</b> <?php echo number_format($player->buildbattle->soloWins); ?></p>
                                                <p><b>Team Wins:</b> <?php echo number_format($player->buildbattle->teamsWins); ?></p>
                                                <p><b>Pro Wins:</b> <?php echo number_format($player->buildbattle->proWins); ?></p>
                                                <p><b>Guess The Build Wins:</b> <?php echo number_format($player->buildbattle->guessTheBuildWins); ?></p>

                                                <br>

                                                <p><b>Games Played:</b> <?php echo number_format($player->buildbattle->gamesPlayed); ?></p>
                                                <p><b>Coins:</b> <?php echo number_format($player->buildbattle->coins); ?></p>
                                                <p><b>Total Votes:</b> <?php echo number_format($player->buildbattle->totalVotes); ?></p>
                                                <p><b>Correct Guess The Build Guesses:</b> <?php echo number_format($player->buildbattle->correctGuesses); ?></p>
					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#megawalls">Mega Walls</button><br><br>

		                			<div id="megawalls" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Mega Walls
				                            </div>
			        						<div class="card-body">
                                                <p><b>Wins:</b> <?php echo number_format($player->megawalls->wins); ?></p>

                                                <br>

                                                <p><b>Kills:</b> <?php echo number_format($player->megawalls->kills); ?></p>
                                                <p><b>Final Kills:</b> <?php echo number_format($player->megawalls->finalKills); ?></p>
                                                <p><b>Deaths:</b> <?php echo number_format($player->megawalls->deaths); ?></p>
                                                <p><b>Final Deaths:</b> <?php echo number_format($player->megawalls->finalDeaths); ?></p>

                                                <br>

                                                <p><b>Coins:</b> <?php echo number_format($player->megawalls->coins); ?></p>
                                                <p><b>Chosen Class:</b> <?php echo $player->megawalls->chosenClass; ?></p>
                                                <p><b>Losses:</b> <?php echo number_format($player->megawalls->losses); ?></p>
                                                <p><b>Assists:</b> <?php echo number_format($player->megawalls->assists); ?></p>
                                                <p><b>Final Assists:</b> <?php echo number_format($player->megawalls->finalAssists); ?></p>

                                                <br>

                                                <p>Class statistics coming soon!</p>
                                            </div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#duels">Duels</button><br><br>

		                			<div id="duels" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Duels
				                            </div>
			        						<div class="card-body">
                                                <p><b>Wins:</b> <?php echo number_format($player->duels->wins); ?></p>
                                                <p><b>Kills:</b> <?php echo number_format($player->duels->kills); ?></p>
                                                <p><b>Deaths:</b> <?php echo number_format($player->duels->deaths); ?></p>
                                                <p><b>Losses:</b> <?php echo number_format($player->duels->losses); ?></p>
                                                <p><b>Rounds Played:</b> <?php echo number_format($player->duels->roundsPlayed); ?></p>
                                                <p><b>Melee Swings</b> <?php echo number_format($player->duels->swings); ?></p>
                                                <p><b>Bow Shots:</b> <?php echo number_format($player->duels->bowShots); ?></p>
                                                <p><b>Games Played:</b> <?php echo number_format($player->duels->games); ?></p>

                                                <br>

                                                <p>Class statistics and more coming soon!</p>
					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#bsg">Blitz Survival Games</button><br><br>

		                			<div id="bsg" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Blitz Survival Games
				                            </div>
			        						<div class="card-body">
                                                <p><b>Wins:</b> <?php echo number_format($player->bsg->wins); ?></p>
                                                <p><b>Kills:</b> <?php echo number_format($player->bsg->kills); ?></p>
                                                <p><b>Deaths:</b> <?php echo number_format($player->bsg->deaths); ?></p>
                                                <p><b>Coins:</b> <?php echo number_format($player->bsg->coins); ?></p>

                                                <br>

                                                <p>Class statistics and more coming soon!</p>
					                		</div>
					                	</div>
					                	<br>
			                		</div>

		                			<button data-toggle="collapse" class="btn btn-light btn-outline-info" data-target="#smash">Smash Heroes</button><br><br>

		                			<div id="smash" class="collapse">
										<div class="card">
											<div class="card-header">
					                            <i class="fas fa-table mr-1"></i>
					                                Smash Heroes
				                            </div>
			        						<div class="card-body">
                                                <p><b>Wins:</b> <?php echo number_format($player->smash->wins); ?></p>
                                                <p><b>Kills:</b> <?php echo number_format($player->smash->kills); ?></p>
                                                <p><b>Deaths:</b> <?php echo number_format($player->smash->deaths); ?></p>
                                                <p><b>Coins:</b> <?php echo number_format($player->smash->coins); ?></p>
                                                <p><b>Games:</b> <?php echo number_format($player->smash->games); ?></p>
                                                <p><b>Quits:</b> <?php echo number_format($player->smash->quits); ?></p>
                                                <p><b>Losses:</b> <?php echo number_format($player->smash->losses); ?></p>
                                                <p><b>Winstreak:</b> <?php echo number_format($player->smash->winstreak); ?></p>
                                                <p><b>Smash Level:</b> <?php echo number_format($player->smash->smashLevel); ?></p>

                                                <br>

                                                <p>Class statistics and more coming soon!</p>
					                		</div>
					                	</div>
					                	<br>
			                		</div>


						        </div>
						    </div>
						</div>
					</div>
            	</main>

                <?php require "includes/footer.php"; ?>

                <script>
                	var ctxP = document.getElementById("paintballPie").getContext('2d');
					var pbPie = new Chart(ctxP, {
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

					var ctxR = document.getElementById("paintballBar").getContext('2d');
					var pbBar = new Chart(ctxR, {
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

					var ctxQ = document.getElementById("quakePie").getContext('2d');
					var qcPie = new Chart(ctxQ, {
						type: 'doughnut',
						data: {
							labels: ["Kills", "Deaths"],
							datasets: [{
							data: ["<?php echo ($player->quakecraft->soloKills + $player->quakecraft->teamKills); ?>", "<?php echo ($player->quakecraft->soloDeaths + $player->quakecraft->teamDeaths); ?>"],
							backgroundColor: ["#46BFBD", "#F7464A"],
							hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
						}]
					},
					options: {
						responsive: true
					}
					});

					var ctxBar = document.getElementById("quakeBar").getContext('2d');
					var quakeBar = new Chart(ctxBar, {
						type: 'bar',
						data: {
							labels: ["Solo", "Teams"],
							datasets: [{
								label: 'Wins',
								data: ["<?php echo $player->quakecraft->soloWins; ?>", "<?php echo $player->quakecraft->teamWins; ?>"],
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(54, 162, 235, 0.2)'
								],
								borderColor: [
									'rgba(255,99,132,1)',
									'rgba(54, 162, 235, 1)'
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
							}
						}
					});

                    var ctxTkr = document.getElementById("tkrPie").getContext('2d');
                    var tkrPie = new Chart(ctxTkr, {
                        type: 'doughnut',
                        data: {
                            labels: ["Gold", "Silver", "Bronze"],
                            datasets: [{
                            data: ["<?php echo ($player->tkr->goldTrophy); ?>", "<?php echo ($player->tkr->silverTrophy); ?>", "<?php echo ($player->tkr->bronzeTrophy); ?>"],
                            backgroundColor: ["#ffd700", "#c0c0c0", "#954535"],
                            hoverBackgroundColor: ["#ffd700", "#c0c0c0", "#954535"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

                    var ctxTkr2 = document.getElementById("tkrPie2").getContext('2d');
                    var tkrPie2 = new Chart(ctxTkr2, {
                        type: 'doughnut',
                        data: {
                            labels: ["Jungle Rush", "Hypixel GP", "Canyon", "Retro", "Olympus"],
                            datasets: [{
                            data: ["<?php echo ($player->tkr->mapPlays->junglerush); ?>", "<?php echo ($player->tkr->mapPlays->hypixelgp); ?>", "<?php echo ($player->tkr->mapPlays->canyon); ?>", "<?php echo ($player->tkr->mapPlays->retro); ?>", "<?php echo ($player->tkr->mapPlays->olympus); ?>"],
                            backgroundColor: ["#f7f736", "#c4c408", "#f9f9be", "#f2c673", "#e99f16"],
                            hoverBackgroundColor: ["#f7f736", "#c4c408", "#f9f9be", "#f2c673", "#e99f16"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

					var ctxClassic = document.getElementById("classicPie").getContext('2d');
					var classicPie = new Chart(ctxClassic, {
						type: 'doughnut',
						data: {
							labels: ["Paintball", "Quakecraft", "Turbo Kart Racers", "The Walls", "VampireZ", "Arena Brawl"],
							datasets: [{
							data: ["<?php echo $player->paintball->coins; ?>", "<?php echo $player->quakecraft->coins; ?>", "<?php echo $player->tkr->coins; ?>", "<?php echo $player->walls->coins; ?>", "<?php echo $player->vampirez->coins; ?>", "<?php echo $player->arena->coins; ?>"],
							backgroundColor: ["#f7f736", "#c4c408", "#f9f9be", "#f2c673", "#e99f16", "#e97116"],
							hoverBackgroundColor: ["#f7f736", "#c4c408", "#f9f9be", "#f2c673", "#e99f16", "#e97116"]
						}]
					},
					options: {
						responsive: true
					}
					});

                    var ctxVamp = document.getElementById("vampPie").getContext('2d');
                    var vampPie = new Chart(ctxVamp, {
                        type: 'doughnut',
                        data: {
                            labels: ["Human Kills", "Vampire Deaths"],
                            datasets: [{
                            data: ["<?php echo $player->vampirez->asVampire->humanKills; ?>", "<?php echo $player->vampirez->asVampire->vampireDeaths; ?>"],
                            backgroundColor: ["#46BFBD", "#F7464A"],
                            hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

                    var ctxHuman = document.getElementById("humanPie").getContext('2d');
                    var humanPie = new Chart(ctxHuman, {
                        type: 'doughnut',
                        data: {
                            labels: ["Vampire Kills", "Human Deaths"],
                            datasets: [{
                            data: ["<?php echo $player->vampirez->asHuman->vampireKills; ?>", "<?php echo $player->vampirez->asHuman->humanDeaths; ?>"],
                            backgroundColor: ["#46BFBD", "#F7464A"],
                            hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

                    var ctxWalls = document.getElementById("wallsPie").getContext('2d');
                    var wallsPie = new Chart(ctxWalls, {
                        type: 'doughnut',
                        data: {
                            labels: ["Kills", "Deaths", "Assists"],
                            datasets: [{
                            data: ["<?php echo ($player->walls->kills); ?>", "<?php echo ($player->walls->deaths); ?>", "<?php echo ($player->walls->assists); ?>"],
                            backgroundColor: ["#46BFBD", "#F7464A", "#f7f736"],
                            hoverBackgroundColor: ["#5AD3D1", "#FF5A5E", "#f7f736"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

					var ctxArena = document.getElementById("arenaBar").getContext('2d');
					var arenaBar = new Chart(ctxArena, {
						type: 'bar',
						data: {
							labels: ["1v1 Wins", "2v2 Wins", "4v4 Wins"],
							datasets: [{
								label: 'Wins By Mode',
								data: ["<?php echo $player->arena->ones->wins; ?>", "<?php echo $player->arena->twos->wins; ?>", "<?php echo $player->arena->fours->wins; ?>"],
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(54, 162, 235, 0.2)',
									'rgba(54, 255, 235, 0.2)'
								],
								borderColor: [
									'rgba(255,99,132,1)',
									'rgba(54, 162, 235, 1)',
									'rgba(54, 255, 235, 1)'

								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
							}
						}
					});

					var ctxArenaPie = document.getElementById("arenaPie").getContext('2d');
					var arenaPie = new Chart(ctxArenaPie, {
						type: 'doughnut',
						data: {
							labels: ["Damage", "Healing"],
							datasets: [{
							data: ["<?php echo ($player->arena->ones->damage + $player->arena->twos->damage + $player->arena->fours->damage); ?>", "<?php echo ($player->arena->ones->healed + $player->arena->twos->healed + $player->arena->fours->healed); ?>"],
							backgroundColor: [
									'rgba(255, 99, 132, 0.2)',
									'rgba(54, 255, 235, 0.2)'
								],
								borderColor: [
									'rgba(255,99,132,1)',
									'rgba(54, 255, 235, 1)'
								]
						}]
					},
					options: {
						responsive: true
					}
					});

					var ctxTntRun = document.getElementById("tntrunpie").getContext('2d');
					var tntRunPie = new Chart(ctxTntRun, {
						type: 'doughnut',
						data: {
							labels: ["Wins", "Losses"],
							datasets: [{
							data: ["<?php echo $player->tntgames->tntrun->wins; ?>", "<?php echo $player->tntgames->tntrun->deaths; ?>"],
							backgroundColor: ["#46BFBD", "#F7464A"],
							hoverBackgroundColor: ["#5AD3D1", "#FF5A5E"]
						}]
					},
					options: {
						responsive: true
					}
					});


                </script>
            </div>
    </body>
<?php } ?>
</html>
