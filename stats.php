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
require "functions/functions.php";
require "functions/display_functions.php";
require "functions/player_functions.php";
require "error/error_messages.php";

updatePageViews($connection, 'stats_page', $DEV_IP);
   
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php 
	        $name = $_GET["player"];
			$uuid = getUUID($connection, $name);
			updatePlayer($mongo_mng, $uuid, $name, $API_KEY);
			updateStatsLog($connection, $name);
		?>

		<title><?php echo $name; ?>'s Stats - AyeBallers</title>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <?php 

	                $filter = ['uuid' => $uuid]; 
				    $query = new MongoDB\Driver\Query($filter);     
				    
				    $res = $mongo_mng->executeQuery("ayeballers.player", $query);
				    
				    $player = current($res->toArray());
				    
				    if (!empty($player)) {
				   		$rank = $player->rank;
				   		$rank_colour = $player->rankColour;
				   		$network_exp = $player->networkExp;

	            		$guild_json = updateGuild($mongo_mng, $uuid, $API_KEY);
	            		$guild_members = sizeof($guild_json->guild->members);
	            		$guild_name = $guild_json->guild->name;
	            		$guild_created = $guild_json->guild->created;
	            		$guild_created = date("m/d/Y H:i:s", (int)substr($guild_created, 0, 10));
	            		$guild_desc = $guild_json->guild->description;
	            		$guild_tag = $guild_json->guild->tag;
	            		$guild_exp = $guild_json->guild->exp;
	            		$guild_level = getGuildLevel($guild_exp);
	            		$guild_tag_colour = $guild_json->guild->tagColor;

	            		if ($guild_tag_colour == "DARK_GREEN") {
	            			$tag_colour = "#297e25";
	            		} else if ($guild_tag_colour == "YELLOW") {
	            			$tag_colour = "#faf36b";
	            		} else if ($guild_tag_colour == "DARK_AQUA") {
	            			$tag_colour = "#1684c0";
	            		} else if ($guild_tag_colour == "GOLD") {
	            			$tag_colour = "#ebc61e";
	            		} else if ($guild_tag_colour == "GRAY") {
	            			$tag_colour = "#a7aaa1";
	            		} else {
	            			$tag_colour = "#a7aaa1";
	            		}

	            		$rank_with_name = getRankFormatting($name, $rank, $rank_colour);
	            		$network_level = getLevel($network_exp);

	            		$previous = "javascript:history.go(-1)";
			            if (isset($_SERVER['HTTP_REFERER'])) {
			                $previous = $_SERVER['HTTP_REFERER'];
			            }
			        } else {
				        echo "No match found\n";
				    }

	            ?>

                <main>

                	<div class="card">

            			<div class="card-body">
            				<form style="margin-right: 10px;" action="<?= $previous ?>">
	                            <button type="submit" class="btn btn-danger">< Back</button>
	                        </form>

                			<h1>
                				<?php 

                					if ($guild_tag) {
                						echo $rank_with_name . '<span style="color:' . $tag_colour . ';">' . ' [' . $guild_tag . ']' . '</span>'; 
                					} else {
                						echo $rank_with_name;
                					}

                				?>
                			</h1>

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
						                			<p><b>First Login:</b> <?php echo $player->firstLogin; ?></p>
						                			<p><b>Last Login:</b> <?php echo $player->lastLogin; ?></p>
						                			<p><b>Selected Gadget:</b> <?php echo $player->selectedGadget; ?></p>
						                			<p><b>Thanks Received:</b> <?php echo $player->thanksReceived; ?></p>
						                			<p><b>Rewards Claimed:</b> <?php echo $player->rewardsClaimed; ?></p>
						                			<p><b>Gifts Given:</b> <?php echo $player->giftsGiven; ?></p>
						                			<p><b>Recent Game:</b> <?php echo $player->recentGameType; ?></p>

						                			<br>

						                			<p><b>Total Votes:</b> <?php echo $player->totalVotes; ?></p>
						                			<p><b>Last Vote:</b> <?php echo $player->lastVote; ?></p>

						                			<br>

						                			<p><b>UUID:</b> <?php echo $uuid; ?></p>
						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#previousnames">Previous Names</button>
						                			<div id="previousnames" class="collapse">
						                			</div>
						                		</div>
						                		<div class="col-md-4">
						                			<?php echo '<img style="height: 200px; width: auto;" src="https://crafatar.com/renders/body/' . $uuid . '"/>'; ?>
						                		</div>
					                		</div>
				                		</div>
				                	</div>

		                			<div class="card mb-4">
		                                <div class="card-header">
		                                    <i class="fas fa-users mr-1"></i>
		                                    <?php echo $name; ?>'s Guild
		                                </div>

	        							<div class="card-body">
	        								<div class="row">
	        									<div class="col-md-8">
	        										<?php
	        											if ($guild_name == "AyeBallers") {
	        										?>
						                				<p><b>Guild:</b> <?php echo $guild_name; ?> <img title="AyeBallers" height="15" width="auto" src="assets/img/star.png"/></p>
						                			<?php } else { ?>
						                				<p><b>Guild:</b> <?php echo $guild_name; ?></p>
						                			<?php } ?>
						                			<p><b>Members:</b> <?php echo $guild_members; ?>/125</p>
						                			<p><b>Guild Level:</b> <?php echo $guild_level; ?></p>
						                			<p><b>Created:</b> <?php echo $guild_created; ?></p>
						                			<p><b>Description:</b> <?php echo $guild_desc; ?></p>
						                			<p><b>Tag:</b> <?php echo '<span style="color:' . $tag_colour . ';">' . '[' . $guild_tag . ']' . '</span>'; ?></p>
						                		</div>
						                		<div class="col-md-4">
						                			<?php 
							                			if ($guild_name == "AyeBallers") {
							                				echo '<img style="height: 100px; width: auto;" src="assets/img/favicon.png"/>'; 
							                			}
						                			?>
						                		</div>
					                		</div>
				                		</div>
				                	</div>
				                	
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

										                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

										                			<p><b>Kills:</b> <?php echo number_format($player->paintball->kills); ?></p>
										                			<p><b>Wins:</b> <?php echo number_format($player->paintball->wins); ?></p>
										                			<p><b>Coins:</b> <?php echo number_format($player->paintball->coins); ?></p>
										                			<p><b>Deaths:</b> <?php echo number_format($player->paintball->deaths); ?></p>
										                			<p><b>Forcefield Time:</b> <?php echo gmdate("H:i:s", $player->paintball->forcefieldTime); ?></p>
										                			<p><b>Killstreaks:</b> <?php echo number_format($player->paintball->killstreaks); ?></p>
										                			<p><b>Shots Fired:</b> <?php echo number_format($player->paintball->shotsFired); ?></p>
										                			<p><b>Equipped Hat:</b> <?php echo translatePaintballHat($player->paintball->hat); ?></p>

										                			<br>

										                			<p><b>K/D:</b> <?php echo $kd_pb; ?></p>
										                			<p><b>S/K:</b> <?php echo $sk_pb; ?></p>

										                			<br>

										                			<p><b>Endurance:</b> <?php echo $player->paintball->endurance + 1; ?>/50</p>
										                			<p><b>Godfather:</b> <?php echo $player->paintball->godfather + 1; ?>/50</p>
										                			<p><b>Fortune:</b> <?php echo $player->paintball->fortune + 1; ?>/20</p>
										                			<p><b>Adrenaline:</b> <?php echo $player->paintball->adrenaline + 1; ?>/10</p>
										                			<p><b>Superluck:</b> <?php echo $player->paintball->superluck + 1; ?>/20</p>
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

							                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

							                			<p><b>Coins:</b> <?php echo number_format($player->quakecraft->coins); ?></p>
							                			<p><b>Highest Killstreak:</b> <?php echo number_format($player->quakecraft->highestKillstreak); ?></p>

							                			<br>

							                			<p><b>Kills:</b> <?php echo number_format($player->quakecraft->soloKills + $player->quakecraft->teamKills); ?></p>
							                			<p><b>Wins:</b> <?php echo number_format($player->quakecraft->soloWins + $player->quakecraft->teamWins); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->quakecraft->soloDeaths + $player->quakecraft->teamDeaths); ?></p>
							                			<p><b>Killstreaks:</b> <?php echo number_format($player->quakecraft->soloKillstreaks + $player->quakecraft->teamKillstreaks); ?></p>
							                			<p><b>Headshots:</b> <?php echo number_format($player->quakecraft->soloHeadshots + $player->quakecraft->teamHeadshots); ?></p>
							                			<p><b>Distance Travelled:</b> <?php echo number_format($player->quakecraft->soloDistanceTravelled + $player->quakecraft->teamDistanceTravelled); ?> blocks</p>
							                			<p><b>Shots Fired:</b> <?php echo number_format($player->quakecraft->soloShotsFired + $player->quakecraft->teamShotsFired); ?></p>

							                			<br>

							                			<p><b>K/D:</b> <?php echo $kd_qc; ?></p>
							                			<p><b>S/K:</b> <?php echo $sk_qc; ?></p>

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

							                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

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
														<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

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
							                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

							                			<p><b>Coins:</b> <?php echo number_format($player->vampirez->coins); ?></p>

							                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#human">As Human</button><br><br>

							                			<div id="human" class="collapse">
								                			<p><b>Human Wins:</b> <?php echo number_format($player->vampirez->asHuman->humanWins); ?></p>
								                			<p><b>Vampire Kills:</b> <?php echo number_format($player->vampirez->asHuman->vampireKills); ?></p>
								                			<p><b>Human Deaths:</b> <?php echo number_format($player->vampirez->asHuman->humanDeaths); ?></p>
								                			<p><b>Zombie Kills:</b> <?php echo number_format($player->vampirez->asHuman->zombieKills); ?></p>
								                			<p><b>Most Vampire Kills:</b> <?php echo number_format($player->vampirez->asHuman->mostVampireKills); ?></p>
								                			<p><b>Gold Bought:</b> <?php echo number_format($player->vampirez->asHuman->goldBought); ?></p>
								                		</div>

							                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#vampire">As Vampire</button><br><br>

							                			<div id="vampire" class="collapse">
								                			<p><b>Vampire Wins:</b> <?php echo number_format($player->vampirez->asVampire->vampireWins); ?></p>
								                			<p><b>Vampire Deaths:</b> <?php echo number_format($player->vampirez->asVampire->vampireDeaths); ?></p>
								                			<p><b>Human Kills:</b> <?php echo number_format($player->vampirez->asVampire->humanKills); ?></p>
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
							                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

							                			<p><b>Coins:</b> <?php echo number_format($player->walls->coins); ?></p>
							                			<p><b>Wins:</b> <?php echo number_format($player->walls->wins); ?></p>
							                			<p><b>Kills:</b> <?php echo number_format($player->walls->kills); ?></p>
							                			<p><b>Deaths:</b> <?php echo number_format($player->walls->deaths); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->walls->losses); ?></p>
							                			<p><b>Assists:</b> <?php echo number_format($player->walls->assists); ?></p>
							                		</div>
							                	</div>
					                		</div>
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

						                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

						                			<p><b>Coins:</b> <?php echo number_format($player->tntgames->coins); ?></p>
						                			<p><b>Total Wins:</b> <?php echo number_format($player->tntgames->wins); ?></p>
						                			<p><b>Selected Hat:</b> <?php echo $player->tntgames->hat; ?></p>
						                			<p><b>Current Winstreak:</b> <?php echo number_format($player->tntgames->winstreak); ?></p>

						                			<button data-toggle="collapse" class="btn btn-light btn-outline-success" data-target="#tntrun">TNT Run</button><br><br>

						                			<div id="tntrun" class="collapse">
							                			<p><b>Wins:</b> <?php echo number_format($player->tntgames->tntrun->wins); ?></p>
							                			<p><b>Losses:</b> <?php echo number_format($player->tntgames->tntrun->deaths); ?></p>
							                			<p><b>Record:</b> <?php echo number_format($player->tntgames->tntrun->record); ?></p>
							                			<p><b>W/L:</b> <?php echo $tntrun_wl; ?></p>
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
					                			<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

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
			        							<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

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
			        							<?php echo "<p><b>Leaderboard Position:</b> Not in Top #500</p>"; ?> 

					                			<p><b>Coins:</b> <?php echo number_format($player->warlords->coins); ?></p>
					                			<p><b>Wins:</b> <?php echo number_format($player->warlords->wins); ?></p>
					                			<p><b>Kills:</b> <?php echo number_format($player->warlords->kills); ?></p>
					                			<p><b>Assists:</b> <?php echo number_format($player->warlords->assists); ?></p>
					                			<p><b>Deaths:</b> <?php echo number_format($player->warlords->deaths); ?></p>
					                			<p><b>Losses:</b> <?php echo number_format($player->warlords->losses); ?></p>
					                			<p><b>Powerups Collected:</b> <?php echo number_format($player->warlords->powerups); ?></p>
					                			<p><b>Blue Wins:</b> <?php echo number_format($player->warlords->winsBlue); ?></p>
					                			<p><b>Red Wins:</b> <?php echo number_format($player->warlords->winsRed); ?></p>
					                			<p><b>Current Class:</b> <?php echo number_format($player->warlords->currentClass); ?></p>

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
							labels: ["Endurance", "Godfather", "Fortune", "Adrenaline", "Superluck", "Transfusion"],
							datasets: [{
								label: "Perk Level",
								data: ["<?php echo $player->paintball->endurance; ?>", "<?php echo $player->paintball->godfather; ?>", "<?php echo $player->paintball->fortune; ?>", "<?php echo $player->paintball->adrenaline; ?>", "<?php echo $player->paintball->superluck; ?>", "<?php echo $player->paintball->transfusion; ?>"],
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
            </div>
    </body>
</html>
