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
require "functions/text_constants.php";
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

			if (updatePlayerInDatabase($connection, $uuid, $name, $API_KEY)) {
			    $result = getPlayerInformation($connection, $uuid);
			} else {
				echo $ERR_CANT_UPDATE_PLAYER;
			}
		?>
		<title><?php echo $name; ?>'s Stats - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <?php 

		            if ($result->num_rows > 0) {
		                while ($row = $result->fetch_assoc()) {
		                    $kills_paintball = $row['kills_paintball'];
		                    $wins_paintball = $row['wins_paintball'];
		                    $coins_paintball = $row['coins_paintball'];
		                    $deaths_paintball = $row['deaths_paintball'];
		                    $forcefield_time_paintball = $row['forcefield_time_paintball'];
		                    $killstreaks_paintball = $row['killstreaks_paintball'];
		                    $shots_fired_paintball = $row['shots_fired_paintball'];
		                    $hat_paintball = $row['hat_paintball'];
		                    $karma = $row['karma'];
		                    $achievement_points = $row['achievement_points'];
		                    $recent_game = $row['most_recent_game'];
		                    $adrenaline_paintball = $row['adrenaline_paintball'] + 1;
		                    $endurance_paintball = $row['endurance_paintball'] + 1;
		                    $fortune_paintball = $row['fortune_paintball'] + 1;
		                    $godfather_paintball = $row['godfather_paintball'] + 1;
		                    $superluck_paintball = $row['superluck_paintball'] + 1;
		                    $transfusion_paintball = $row['transfusion_paintball'] + 1;

		                    $coins_quake = $row['coins_quake'];
		                    $deaths_quake = $row['deaths_quake'];
		                    $kills_quake = $row['kills_quake'];
		                    $killstreaks_quake = $row['killstreaks_quake'];
		                    $wins_quake = $row['wins_quake'];
		                    $kills_teams_quake = $row['kills_teams_quake'];
		                    $deaths_teams_quake = $row['deaths_teams_quake'];
		                    $wins_teams_quake = $row['wins_teams_quake'];
		                    $killstreaks_teams_quake = $row['killstreaks_teams_quake'];
		                    $highest_killstreak_quake = $row['highest_killstreak_quake'];
		                    $shots_fired_teams_quake = $row['shots_fired_teams_quake'];
		                    $headshots_teams_quake = $row['headshots_teams_quake'];
		                    $headshots_quake = $row['headshots_quake'];
		                    $shots_fired_quake = $row['shots_fired_quake'];
		                    $distance_travelled_teams_quake = $row['distance_travelled_teams_quake'];
		                    $distance_travelled_quake = $row['distance_travelled_quake'];

		                    $coins_arena = $row['coins_arena'];
		                    $coins_spent_arena = $row['coins_spent_arena'];
		                    $keys_arena = $row['keys_arena'];
		                    $rating_arena = $row['rating_arena'];
		                    $damage_2v2_arena = $row['damage_2v2_arena'];
		                    $damage_4v4_arena = $row['damage_4v4_arena'];
		                    $damage_1v1_arena = $row['damage_1v1_arena'];
		                    $deaths_2v2_arena = $row['deaths_2v2_arena'];
		                    $deaths_4v4_arena = $row['deaths_4v4_arena'];
		                    $deaths_1v1_arena = $row['deaths_1v1_arena'];
		                    $games_2v2_arena = $row['games_2v2_arena'];
		                    $games_4v4_arena = $row['games_4v4_arena'];
		                    $games_1v1_arena = $row['games_1v1_arena'];
		                    $healed_2v2_arena = $row['healed_2v2_arena'];
		                    $healed_4v4_arena = $row['healed_4v4_arena'];
		                    $healed_1v1_arena = $row['healed_1v1_arena'];
		                    $kills_2v2_arena = $row['kills_2v2_arena'];
		                    $kills_4v4_arena = $row['kills_4v4_arena'];
		                    $kills_1v1_arena = $row['kills_1v1_arena'];
		                    $losses_2v2_arena = $row['losses_2v2_arena'];
		                    $losses_4v4_arena = $row['losses_4v4_arena'];
		                    $losses_1v1_arena = $row['losses_1v1_arena'];
		                    $wins_2v2_arena = $row['wins_2v2_arena'];
		                    $wins_4v4_arena = $row['wins_4v4_arena'];
		                    $wins_1v1_arena = $row['wins_1v1_arena'];

		                    $coins_tkr = $row['coins_tkr'];
		                    $box_pickups_tkr = $row['box_pickups_tkr'];
		                    $coins_picked_up_tkr = $row['coins_picked_up_tkr'];
		                    $silver_trophy_tkr = $row['silver_trophy_tkr'];
		                    $wins_tkr = $row['wins_tkr'];
		                    $gold_trophy_tkr = $row['gold_trophy_tkr'];
		                    $laps_completed_tkr = $row['laps_completed_tkr'];
		                    $bronze_trophy_tkr = $row['bronze_trophy_tkr'];
		                    $olympus_tkr = $row['olympus_tkr'];
		                    $junglerush_tkr = $row['junglerush_tkr'];
		                    $hypixelgp_tkr = $row['hypixelgp_tkr'];
		                    $retro_tkr = $row['retro_tkr'];
		                    $canyon_tkr = $row['canyon_tkr'];

		                    $coins_vz = $row['coins_vz'];
		                    $human_deaths_vz = $row['human_deaths_vz'];
		                    $human_kills_vz = $row['human_kills_vz'];
		                    $vampire_kills_vz = $row['vampire_kills_vz'];
		                    $vampire_deaths_vz = $row['vampire_deaths_vz'];
		                    $zombie_kills_vz = $row['zombie_kills_vz'];
		                    $most_vampire_kills_vz = $row['most_vampire_kills_vz'];
		                    $human_wins_vz = $row['human_wins_vz'];
		                    $gold_bought_vz = $row['gold_bought_vz'];
		                    $vampire_wins_vz = $row['vampire_wins_vz'];

		                    $kills_walls = $row['kills_walls'];
		                    $wins_walls = $row['wins_walls'];
		                    $deaths_walls = $row['deaths_walls'];
		                    $assists_walls = $row['assists_walls'];
		                    $losses_walls = $row['losses_walls'];
		                    $coins_walls = $row['coins_walls'];

		                    $experience_bw = $row['experience_bw'];
		                   	$coins_bw = $row['coins_bw'];
		                   	$deaths_bw = $row['deaths_bw'];
		                   	$diamond_collected_bw = $row['diamond_collected_bw'];
		                   	$iron_collected_bw = $row['iron_collected_bw'];
		                   	$gold_collected_bw = $row['gold_collected_bw'];
		                   	$emerald_collected_bw = $row['emerald_collected_bw'];
		                   	$final_deaths_bw = $row['final_deaths_bw'];
		                   	$games_played_bw = $row['games_played_bw'];
		                   	$losses_bw = $row['losses_bw'];
		                   	$kills_bw = $row['kills_bw'];
		                   	$items_purchased_bw = $row['items_purchased_bw'];
		                   	$resources_collected_bw = $row['resources_collected_bw'];
		                   	$void_kills_bw = $row['void_kills_bw'];
		                   	$void_deaths_bw = $row['void_deaths_bw'];
		                   	$beds_broken_bw = $row['beds_broken_bw'];
		                   	$winstreak_bw = $row['winstreak_bw'];
		                   	$final_kills_bw = $row['final_kills_bw'];
		                   	$wins_bw = $row['wins_bw'];

		                   	$coins_tnt = $row['coins_tnt'];
		                   	$deaths_bowspleef_tnt = $row['deaths_bowspleef_tnt'];
		                   	$deaths_wizards_tnt = $row['deaths_wizards_tnt'];
		                   	$kills_wizards_tnt = $row['kills_wizards_tnt'];
		                   	$wins_bowspleef_tnt = $row['wins_bowspleef_tnt'];
		                   	$wins_wizards_tnt = $row['wins_wizards_tnt'];
		                   	$wins_tntrun_tnt = $row['wins_tntrun_tnt'];
		                   	$record_tntrun_tnt = $row['record_tntrun_tnt'];
		                   	$selected_hat_tnt = $row['selected_hat_tnt'];
		                   	$assists_wizards_tnt = $row['assists_wizards_tnt'];
							$deaths_tntrun_tnt = $row['deaths_tntrun_tnt'];
		                   	$winstreak_tnt = $row['winstreak_tnt'];
		                   	$wins_tnt = $row['wins_tnt'];
		                   	$kills_tnttag_tnt = $row['kills_tnttag_tnt'];
		                   	$wins_tnttag_tnt = $row['wins_tnttag_tnt'];
		                   	$points_wizards_tnt = $row['points_wizards_tnt'];
		                   	$kills_pvprun_tnt = $row['kills_pvprun_tnt'];
		                   	$wins_pvprun_tnt = $row['wins_pvprun_tnt'];
		                   	$deaths_pvprun_tnt = $row['deaths_pvprun_tnt'];
		                   	$record_pvprun_tnt = $row['record_pvprun_tnt'];

		                    if ($hat_paintball == "speed_hat") {
		                    	$hat_paintball = "Speed Hat";
		                    }

		                    $network_exp = $row['network_exp'];
		                    $rank = $row['rank'];
		                    $rank_colour = $row['rank_colour'];
		                    $first_login = $row['first_login'];
		                    $last_login = $row['last_login'];
		                    $first_login = date("Y-m-d H:i:s", (int)substr($first_login, 0, 10));
		                    $last_login = date("Y-m-d H:i:s", (int)substr($last_login, 0, 10));
		                }
		            } else {
		            	echo $ERR_CANT_GET_PLAYER;
		            }
	            		$guild_json = getPlayersGuild($connection, $uuid, $API_KEY);
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

	            	?>

	                <main>

	                	<div class="card">
	            			<div class="card-body">
	            				<form style="margin-right: 10px;" action="<?= $previous ?>">
		                            <button type="submit" class="btn btn-danger">< Back</button>
		                        </form>

	                			<h1>
	                				<?php echo '<img style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/' . $uuid . '"/>'; ?>
	                				<?php 

	                					if ($guild_tag) {
	                						echo $rank_with_name . '<span style="color:' . $tag_colour . ';">' . ' [' . $guild_tag . ']' . '</span>'; 
	                					} else {
	                						echo $rank_with_name;
	                					}

	                				?>
	                			</h1>

	                			<div class="row">

		                			<div class="col-md-4" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">
			                			<div class="card">
		        							<div class="card-body">
		        								<h3>General Statistics</h3>
		        								<br>
					                			<p><b>Network Level:</b> <?php echo $network_level; ?> </p>
					                			<p><b>Achievement Points:</b> <?php echo number_format($achievement_points); ?></p>
					                			<p><b>Karma:</b> <?php echo number_format($karma); ?></p>
					                			<p><b>First Login:</b> <?php echo $first_login; ?></p>
					                			<p><b>Last Login:</b> <?php echo $last_login; ?></p>
					                			<p><b>Recent Game:</b> <?php echo $recent_game; ?></p>
					                		</div>
					                	</div>
				                	</div>

				                	<div class="col-md-4" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">
			                			<div class="card">
		        							<div class="card-body">
					                			<h3><?php echo $name; ?>'s Guild</h3>
					                			<br>
					                			<p><b>Guild:</b> <?php echo $guild_name; ?></p>
					                			<p><b>Members:</b> <?php echo $guild_members; ?>/125</p>
					                			<p><b>Guild Level:</b> <?php echo $guild_level; ?></p>
					                			<p><b>Created:</b> <?php echo $guild_created; ?></p>
					                			<p><b>Description:</b> <?php echo $guild_desc; ?></p>
					                			<p><b>Tag:</b> <?php echo '<span style="color:' . $tag_colour . ';">' . '[' . $guild_tag . ']' . '</span>'; ?></p>
					                		</div>
					                	</div>
				                	</div>

				                	<div class="col-md-4" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">
			                			<div class="card">
		        							<div class="card-body">
					                			<h3><?php echo $name; ?>'s Friends</h3>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                			<br>
					                		</div>
					                	</div>
				                	</div>

				                </div>

	                			<br>

	                			<button data-toggle="collapse" data-target="#paintball">Paintball</button>
	                			<button data-toggle="collapse" data-target="#quakecraft">Quakecraft</button>
	                			<button data-toggle="collapse" data-target="#arena">Arena Brawl</button>
	                			<button data-toggle="collapse" data-target="#tkr">Turbo Kart Racers</button>
	                			<button data-toggle="collapse" data-target="#vz">VampireZ</button>
	                			<button data-toggle="collapse" data-target="#walls">The Walls</button>
	                			<button data-toggle="collapse" data-target="#bedwars">Bedwars</button>
	                			<button data-toggle="collapse" data-target="#tnt">TNT Games</button>
	                			<button data-toggle="collapse">SkyWars</button>
	                			<button data-toggle="collapse">Warlords</button>
	                			<button data-toggle="collapse">Murder Mystery</button>
	                			<button data-toggle="collapse">Arcade</button>
	                			<button data-toggle="collapse">UHC</button>
	                			<button data-toggle="collapse">Cops and Crims</button>
	                			<button data-toggle="collapse">Build Battle</button>
	                			<button data-toggle="collapse">Mega Walls</button>
	                			<button data-toggle="collapse">Duels</button>
	                			<button data-toggle="collapse">Blitz Survival Games</button>
	                			<button data-toggle="collapse">Smash Heroes</button>
	                			<button data-toggle="collapse">SkyBlock</button>

								<div id="paintball" class="collapse">
									<div class="card">
		        						<div class="card-body">

		        							<?php
				                				$kd_pb = 0.0;
				                				$sk_pb = 0.0;

				                				if ($deaths_paintball != 0) {
				                					$kd_pb = round(($kills_paintball / $deaths_paintball), 2);
				                				}
				                				if ($kills_paintball != 0) {
				                					$sk_pb = round(($shots_fired_paintball / $kills_paintball), 2);
				                				}
				                			?>

				                			<h2>Paintball</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_paintball); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_paintball); ?></p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_paintball); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_paintball); ?></p>
				                			<p><b>Forcefield Time:</b> <?php echo $forcefield_time_paintball; ?></p>
				                			<p><b>Killstreaks:</b> <?php echo number_format($killstreaks_paintball); ?></p>
				                			<p><b>Shots Fired:</b> <?php echo number_format($shots_fired_paintball); ?></p>
				                			<p><b>Equipped Hat:</b> <?php echo $hat_paintball; ?></p>

				                			<br>

				                			<p><b>K/D:</b> <?php echo $kd_pb; ?></p>
				                			<p><b>S/K:</b> <?php echo $sk_pb; ?></p>

				                			<br>

				                			<p><b>Adrenaline:</b> <?php echo $adrenaline_paintball; ?></p>
				                			<p><b>Endurance:</b> <?php echo $endurance_paintball; ?></p>
				                			<p><b>Fortune:</b> <?php echo $fortune_paintball; ?></p>
				                			<p><b>Godfather:</b> <?php echo $godfather_paintball; ?></p>
				                			<p><b>Superluck:</b> <?php echo $superluck_paintball; ?></p>
				                			<p><b>Transfusion:</b> <?php echo $transfusion_paintball; ?></p>
				                		</div>
				                	</div>
		                		</div>

		                		<div id="quakecraft" class="collapse">
									<div class="card">
		        						<div class="card-body">

		        							<?php
				                				$kd_qc = 0.0;
				                				$sk_qc = 0.0;

				                				if ($deaths_quake != 0 || $deaths_teams_quake != 0) {
				                					$kd_qc = round((($kills_teams_quake + $kills_quake) / ($deaths_teams_quake + $deaths_quake)), 2);
				                				}
				                				if ($kills_quake != 0 || $kills_teams_quake != 0) {
				                					$sk_qc = round((($shots_fired_quake + $shots_fired_teams_quake) / ($kills_quake + $kills_teams_quake)), 2);
				                				}
				                			?>

				                			<h2>Quakecraft</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_quake); ?></p>
				                			<p><b>Highest Killstreak:</b> <?php echo number_format($highest_killstreak_quake); ?></p>

				                			<br>

				                			<h3>Overall</h3>
				                			<p><b>Kills:</b> <?php echo number_format($kills_teams_quake + $kills_quake); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_teams_quake + $wins_quake); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_teams_quake + $deaths_quake); ?></p>
				                			<p><b>Killstreaks:</b> <?php echo number_format($killstreaks_teams_quake + $killstreaks_quake); ?></p>
				                			<p><b>Headshots:</b> <?php echo number_format($headshots_teams_quake + $headshots_quake); ?></p>
				                			<p><b>Distance Travelled:</b> <?php echo number_format($distance_travelled_teams_quake + $distance_travelled_quake); ?></p>
				                			<p><b>Shots Fired:</b> <?php echo number_format($shots_fired_teams_quake + $shots_fired_quake); ?></p>
				                			<p><b>K/D:</b> <?php echo $kd_qc; ?></p>
				                			<p><b>S/K:</b> <?php echo $sk_qc; ?></p>

				                			<br>

				                			<h3>Solo</h3>
				                			<p><b>Kills:</b> <?php echo number_format($kills_quake); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_quake); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_quake); ?></p>
				                			<p><b>Killstreaks:</b> <?php echo number_format($killstreaks_quake); ?></p>
				                			<p><b>Headshots:</b> <?php echo number_format($headshots_quake); ?></p>
				                			<p><b>Distance Travelled:</b> <?php echo number_format($distance_travelled_quake); ?></p>
				                			<p><b>Shots Fired:</b> <?php echo number_format($shots_fired_quake); ?></p>
				                			

				                			<br>

				                			<h3>Teams</h3>
				                			<p><b>Kills:</b> <?php echo number_format($kills_teams_quake); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_teams_quake); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_teams_quake); ?></p>
				                			<p><b>Killstreaks:</b> <?php echo number_format($killstreaks_teams_quake); ?></p>
				                			<p><b>Headshots:</b> <?php echo number_format($headshots_teams_quake); ?></p>
				                			<p><b>Distance Travelled:</b> <?php echo number_format($distance_travelled_teams_quake); ?></p>
				                			<p><b>Shots Fired:</b> <?php echo number_format($shots_fired_teams_quake); ?></p>

				                		</div>
				                	</div>
		                		</div>

		                		<div id="arena" class="collapse">
									<div class="card">
		        						<div class="card-body">

		        							<?php
		        								$kd_ab_o = 0.0;
				                				$wl_ab_o = 0.0;
				                				$wl_ab_1 = 0.0;
				                				$kd_ab_2 = 0.0;
				                				$wl_ab_2 = 0.0;
				                				$kd_ab_4 = 0.0;
				                				$wl_ab_4 = 0.0;

				                				if ($deaths_1v1_arena != 0 || $deaths_2v2_arena != 0 || $deaths_4v4_arena != 0) {
				                					$kd_ab_o = round((($kills_1v1_arena + $kills_2v2_arena + $kills_4v4_arena) / ($deaths_1v1_arena + $deaths_2v2_arena + $deaths_4v4_arena)), 2);
				                				}

				                				if ($losses_1v1_arena != 0 || $losses_2v2_arena != 0 || $losses_4v4_arena != 0) {
				                					$wl_ab_o = round((($wins_1v1_arena + $wins_2v2_arena + $wins_4v4_arena) / ($losses_1v1_arena + $losses_2v2_arena + $losses_4v4_arena)), 2);
				                				}

				                				if ($deaths_1v1_arena != 0) {
				                					$kd_ab_1 = round(($kills_1v1_arena / $deaths_1v1_arena), 2);
				                				}

				                				if ($losses_1v1_arena != 0) {
				                					$wl_ab_1 = round(($wins_1v1_arena / $losses_1v1_arena), 2);
				                				}

				                				if ($deaths_2v2_arena != 0) {
				                					$kd_ab_2 = round(($kills_2v2_arena / $deaths_2v2_arena), 2);
				                				}

				                				if ($losses_2v2_arena != 0) {
				                					$wl_ab_2 = round(($wins_2v2_arena / $losses_2v2_arena), 2);
				                				}

				                				if ($deaths_4v4_arena != 0) {
				                					$kd_ab_4 = round(($kills_4v4_arena / $deaths_4v4_arena), 2);
				                				}

				                				if ($losses_4v4_arena != 0) {
				                					$wl_ab_4 = round(($wins_4v4_arena / $losses_4v4_arena), 2);
				                				}
				                			?>

				                			<h2>Arena Brawl</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_arena); ?></p>
				                			<p><b>Coins Spent:</b> <?php echo number_format($coins_spent_arena); ?></p>
				                			<p><b>Keys:</b> <?php echo number_format($keys_arena); ?></p>
				                			<p><b>Rating:</b> <?php echo number_format($rating_arena); ?></p>

				                			<br>

				                			<h3>Overall</h3>
											<p><b>Kills:</b> <?php echo number_format($kills_1v1_arena + $kills_2v2_arena + $kills_4v4_arena); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_1v1_arena + $wins_2v2_arena + $wins_4v4_arena); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_1v1_arena + $deaths_2v2_arena + $deaths_4v4_arena); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_1v1_arena + $losses_2v2_arena + $losses_4v4_arena); ?></p>
				                			<p><b>Games Played:</b> <?php echo number_format($games_1v1_arena + $games_2v2_arena + $games_4v4_arena); ?></p>
				                			<p><b>Damage:</b> <?php echo number_format($damage_1v1_arena + $damage_2v2_arena + $damage_4v4_arena); ?></p>
				                			<p><b>Healed:</b> <?php echo number_format($healed_1v1_arena + $healed_2v2_arena + $healed_4v4_arena); ?></p>
				                			<p><b>K/D:</b> <?php echo $kd_ab_o; ?></p>
				                			<p><b>W/L:</b> <?php echo $wl_ab_o; ?></p>

				                			<br>

				                			<h3>1v1</h3>
											<p><b>Kills:</b> <?php echo number_format($kills_1v1_arena); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_1v1_arena); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_1v1_arena); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_1v1_arena); ?></p>
				                			<p><b>Games Played:</b> <?php echo number_format($games_1v1_arena); ?></p>
				                			<p><b>Damage:</b> <?php echo number_format($damage_1v1_arena); ?></p>
				                			<p><b>Healed:</b> <?php echo number_format($healed_1v1_arena); ?></p>
				                			<p><b>K/D:</b> <?php echo $kd_ab_1; ?></p>
				                			<p><b>W/L:</b> <?php echo $wl_ab_1; ?></p>
				                			
				                			<br>

				                			<h3>2v2</h3>
											<p><b>Kills:</b> <?php echo number_format($kills_2v2_arena); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_2v2_arena); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_2v2_arena); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_2v2_arena); ?></p>
				                			<p><b>Games Played:</b> <?php echo number_format($games_2v2_arena); ?></p>
				                			<p><b>Damage:</b> <?php echo number_format($damage_2v2_arena); ?></p>
				                			<p><b>Healed:</b> <?php echo number_format($healed_2v2_arena); ?></p>
				                			<p><b>K/D:</b> <?php echo $kd_ab_2; ?></p>
				                			<p><b>W/L:</b> <?php echo $wl_ab_2; ?></p>

				                			<br>

				                			<h3>4v4</h3>
											<p><b>Kills:</b> <?php echo number_format($kills_4v4_arena); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_4v4_arena); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_4v4_arena); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_4v4_arena); ?></p>
				                			<p><b>Games Played:</b> <?php echo number_format($games_4v4_arena); ?></p>
				                			<p><b>Damage:</b> <?php echo number_format($damage_4v4_arena); ?></p>
				                			<p><b>Healed:</b> <?php echo number_format($healed_4v4_arena); ?></p>
				                			<p><b>K/D:</b> <?php echo $kd_ab_4; ?></p>
				                			<p><b>W/L:</b> <?php echo $wl_ab_4; ?></p>

				                		</div>
				                	</div>
		                		</div>

		                		<div id="tkr" class="collapse">
									<div class="card">
		        						<div class="card-body">
				                			<h2>Turbo Kart Racers</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_tkr); ?></p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_tkr); ?></p>
				                			<p><b>Gold Trophies:</b> <?php echo number_format($gold_trophy_tkr); ?></p>
				                			<p><b>Silver Trophies:</b> <?php echo number_format($silver_trophy_tkr); ?></p>
				                			<p><b>Bronze Trophies:</b> <?php echo number_format($bronze_trophy_tkr); ?></p>
				                			<p><b>Box Pickups:</b> <?php echo number_format($box_pickups_tkr); ?></p>
				                			<p><b>Laps Completed:</b> <?php echo number_format($laps_completed_tkr); ?></p>
				                			<p><b>Coin Pickups:</b> <?php echo number_format($coins_picked_up_tkr); ?></p>

				                			<br>

				                			<p><b>Olympus Plays:</b> <?php echo $olympus_tkr; ?></p>
				                			<p><b>Jungle Rush Plays:</b> <?php echo $junglerush_tkr; ?></p>
				                			<p><b>Hypixel GP Plays:</b> <?php echo $hypixelgp_tkr; ?></p>
				                			<p><b>Retro Plays:</b> <?php echo $retro_tkr; ?></p>
				                			<p><b>Canyon Plays:</b> <?php echo $canyon_tkr; ?></p>
				                		</div>
				                	</div>
		                		</div>

		                		<div id="vz" class="collapse">
									<div class="card">
		        						<div class="card-body">
				                			<h2>VampireZ</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_vz); ?></p>

				                			<br>

				                			<h3>As Human</h3>
				                			<p><b>Human Wins:</b> <?php echo number_format($human_wins_vz); ?></p>
				                			<p><b>Vampire Kills:</b> <?php echo number_format($vampire_kills_vz); ?></p>
				                			<p><b>Human Deaths:</b> <?php echo number_format($human_deaths_vz); ?></p>
				                			<p><b>Zombie Kills:</b> <?php echo number_format($zombie_kills_vz); ?></p>
				                			<p><b>Most Vampire Kills:</b> <?php echo number_format($most_vampire_kills_vz); ?></p>
				                			<p><b>Gold Bought:</b> <?php echo number_format($gold_bought_vz); ?></p>

				                			<br>

				                			<h3>As Vampire</h3>
				                			<p><b>Vampire Wins:</b> <?php echo number_format($vampire_wins_vz); ?></p>
				                			<p><b>Vampire Deaths:</b> <?php echo number_format($vampire_deaths_vz); ?></p>
				                			<p><b>Human Kills:</b> <?php echo number_format($human_kills_vz); ?></p>
				                		</div>
				                	</div>
		                		</div>

		                		<div id="walls" class="collapse">
									<div class="card">
		        						<div class="card-body">
				                			<h2>The Walls</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_walls); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_walls); ?></p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_walls); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_walls); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_walls); ?></p>
				                			<p><b>Assists:</b> <?php echo number_format($assists_walls); ?></p>
				                		</div>
				                	</div>
		                		</div>

		                		<div id="bedwars" class="collapse">
									<div class="card">
		        						<div class="card-body">
				                			<h2>BedWars</h2>
				                			<p><b>Leaderboard Position:</b> <?php echo getLeaderboardPosition($connection, $name, "bedwars"); ?></p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_bw); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_bw); ?></p>
				                			<p><b>Experience:</b> <?php echo number_format($experience_bw); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($losses_bw); ?></p>
				                			<p><b>Games Played:</b> <?php echo number_format($games_played_bw); ?></p>
				                			<p><b>Items Purchased:</b> <?php echo number_format($items_purchased_bw); ?></p>
				                			<p><b>Beds Broken:</b> <?php echo number_format($beds_broken_bw); ?></p>
				                			<p><b>Winstreak:</b> <?php echo number_format($winstreak_bw); ?></p>

				                			<br>

											<p><b>Kills:</b> <?php echo number_format($kills_bw); ?></p>
				                			<p><b>Void Kills:</b> <?php echo number_format($void_kills_bw); ?></p>
				                			<p><b>Final Kills:</b> <?php echo number_format($final_kills_bw); ?></p>

				                			<br>

				                			<p><b>Resources Collected:</b> <?php echo number_format($resources_collected_bw); ?></p>
				                			<p><b>Iron Collected:</b> <?php echo number_format($iron_collected_bw); ?></p>
				                			<p><b>Gold Collected:</b> <?php echo number_format($gold_collected_bw); ?></p>
				                			<p><b>Diamonds Collected:</b> <?php echo number_format($diamond_collected_bw); ?></p>
				                			<p><b>Emeralds Collected:</b> <?php echo number_format($emerald_collected_bw); ?></p>

				                		</div>
				                	</div>
		                		</div>

		                		<div id="tnt" class="collapse">
									<div class="card">
		        						<div class="card-body">

		        							<?php
		        								$tntrun_wl = 0.0;
		        								$bs_wl = 0.0;
		        								$pvprun_kd = 0.0;
		        								$wiz_kd = 0.0;
				                			
				                				if ($deaths_tntrun_tnt != 0) {
				                					$tntrun_wl = round(($wins_tntrun_tnt / $deaths_tntrun_tnt), 2);
				                				}

				                				if ($deaths_bowspleef_tnt != 0) {
				                					$bs_wl = round(($wins_bowspleef_tnt / $deaths_bowspleef_tnt), 2);
				                				}

				                				if ($deaths_pvprun_tnt != 0) {
				                					$pvprun_kd = round(($kills_pvprun_tnt / $deaths_pvprun_tnt), 2);
				                				}

				                				if ($deaths_wizards_tnt != 0) {
				                					$wiz_kd = round(($kills_wizards_tnt / $deaths_wizards_tnt), 2);
				                				}

				                			?>

				                			<h2>TNTGames</h2>
				                			<p><b>Leaderboard Position:</b> <?php echo getLeaderboardPosition($connection, $name, "tnt"); ?></p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_tnt); ?></p>
				                			<p><b>Total Wins:</b> <?php echo number_format($wins_tnt); ?></p>
				                			<p><b>Selected Hat:</b> <?php echo $selected_hat_tnt; ?></p>
				                			<p><b>Current Winstreak:</b> <?php echo number_format($winstreak_tnt); ?></p>

				                			<br>

				                			<h3>TNT Run</h3>
				                			<p><b>Wins:</b> <?php echo number_format($wins_tntrun_tnt); ?></p>
				                			<p><b>Losses:</b> <?php echo number_format($deaths_tntrun_tnt); ?></p>
				                			<p><b>Record:</b> <?php echo number_format($record_tntrun_tnt); ?></p>
				                			<p><b>W/L:</b> <?php echo $tntrun_wl; ?></p>


				                			<br>

				                			<h3>TNT Tag</h3>
				                			<p><b>Wins:</b> <?php echo number_format($wins_tnttag_tnt); ?></p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_tnttag_tnt); ?></p>

				                			<br>

				                			<h3>Bow Spleef</h3>
				                			<p><b>Wins:</b> <?php echo number_format($wins_bowspleef_tnt); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_bowspleef_tnt); ?></p>
				                			<p><b>W/L:</b> <?php echo $bs_wl; ?></p>

				                			<br>

				                			<h3>PVP Run</h3>
				                			<p><b>Wins:</b> <?php echo number_format($wins_pvprun_tnt); ?></p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_pvprun_tnt); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_pvprun_tnt); ?></p>
				                			<p><b>Record:</b> <?php echo number_format($record_pvprun_tnt); ?></p>
				                			<p><b>K/D:</b> <?php echo $pvprun_kd; ?></p>

				                			<h3>TNT Wizards</h3>
				                			<p><b>Wins:</b> <?php echo number_format($wins_wizards_tnt); ?></p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_wizards_tnt); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_wizards_tnt); ?></p>
				                			<p><b>Assists:</b> <?php echo number_format($assists_wizards_tnt); ?></p>
				                			<p><b>Points Captured:</b> <?php echo number_format($points_wizards_tnt); ?></p>
				                			<p><b>K/D:</b> <?php echo $wiz_kd; ?></p>

				                		</div>
				                	</div>
		                		</div>

					        </div>
					    </div>

                	</main>

                <?php require "includes/footer.php"; ?>

            </div>

    </body>
</html>
