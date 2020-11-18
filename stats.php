<!DOCTYPE html>
<html lang="en">

    <head>

    	<?php
    		include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";
            include "functions/player_functions.php";

            $name = $_GET["player"];
            $uuid = getUUID($connection, $name);
            
            if (updatePlayerInDatabase($connection, $uuid, $name, $API_KEY)) {
                $result = getPlayerInformation($connection, $uuid);
            } else {
            	header("Refresh:0.01; url=player.php");
            }

            updatePageViews($connection, 'stats_page', $DEV_IP);
               
    	?>

        <title><?php echo $name; ?>'s Stats - AyeBallers</title>

    </head>

    <body class="sb-nav-fixed">

        <?php include "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <?php 
		            if ($result->num_rows > 0) {
		                while($row = $result->fetch_assoc()) {
		                    $kills_paintball = $row['kills_paintball'];
		                    $wins_paintball = $row['wins_paintball'];
		                    $coins_paintball = $row['coins_paintball'];
		                    $kill_prefix_paintball = $row['kill_prefix_paintball'];
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
		                    $headstart_paintball = $row['headstart_paintball'] + 1;

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

		                    if ($hat_paintball == "speed_hat") {
		                    	$hat_paintball = "Speed Hat";
		                    }

		                    $first_login = $row['first_login'];
		                    $last_login = $row['last_login'];
		                    $first_login = gmdate('r', $first_login);
		                    $last_login = gmdate('r', $last_login);
		                }
		            } else {
		            	echo $query;
		            }

                	?>

	                <main>

	                	<div class="card">
	            			<div class="card-body">

	                			<h1>
	                				<?php echo '<img style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/' . $uuid . '"/>'; ?>
	                				[RANK] <?php echo $name; ?> [GTAG]
	                			</h1>

	                			<div class="row">

		                			<div class="col-md-4" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">
			                			<div class="card">
		        							<div class="card-body">
					                			<p><b>Network Level:</b> </p>
					                			<p><b>Achievement Points:</b> <?php echo number_format($achievement_points); ?></p>
					                			<p><b>Quests Completed:</b> </p>
					                			<p><b>Guild:</b> </p>
					                			<p><b>Karma:</b> <?php echo number_format($karma); ?></p>
					                			<p>Time Played: </p>
					                			<p><b>First Login:</b> <?php echo $first_login; ?></p>
					                			<p><b>Last Login:</b> <?php echo $last_login; ?></p>
					                			<p><b>Recent Game:</b> <?php echo $recent_game; ?></p>
					                			<p>Parkours Completed: </p>
					                		</div>
					                	</div>
				                	</div>

				                	<div class="col-md-4" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">
			                			<div class="card">
		        							<div class="card-body">
					                			<h3>GuildName</h3>
					                			<p>Members: </p>
					                			<p>Guild Level: </p>
					                			<p>Guild: </p>
					                			<p>Created: </p>
					                			<p>Leader: </p>
					                			<p>Tag: </p>
					                			<p>Most Played Game: </p>
					                			<p><?php echo $name; ?>'s Role In Guild: </p>
					                			<p>Quests Contributed To: </p>
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
	                			<button data-toggle="collapse">Arena Brawl</button>
	                			<button data-toggle="collapse">Turbo Kart Racers</button>
	                			<button data-toggle="collapse">VampireZ</button>
	                			<button data-toggle="collapse">The Walls</button>
	                			<button data-toggle="collapse">Bedwars</button>
	                			<button data-toggle="collapse">TNT Games</button>
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
				                			<h2>Paintball</h2>
				                			<p><b>Leaderboard Position:</b> </p>
				                			<p><b>Kills:</b> <?php echo number_format($kills_paintball); ?></p>
				                			<p><b>Wins:</b> <?php echo number_format($wins_paintball); ?></p>
				                			<p><b>Kill Prefix:</b> [<?php echo $kill_prefix_paintball + substr($kills_paintball, 0, 3) ?>k]</p>
				                			<p><b>Coins:</b> <?php echo number_format($coins_paintball); ?></p>
				                			<p><b>Deaths:</b> <?php echo number_format($deaths_paintball); ?></p>
				                			<p><b>Forcefield Time:</b> <?php echo $forcefield_time_paintball; ?></p>
				                			<p><b>Killstreaks:</b> <?php echo number_format($killstreaks_paintball); ?></p>
				                			<p><b>Shots Fired:</b> <?php echo number_format($shots_fired_paintball); ?></p>
				                			<p><b>Equipped Hat:</b> <?php echo $hat_paintball; ?></p>

				                			<br>

				                			<p><b>K/D:</b> <?php echo round(($kills_paintball / $deaths_paintball), 2); ?></p>
				                			<p><b>S/K:</b> <?php echo round(($shots_fired_paintball / $kills_paintball), 2); ?></p>

				                			<br>

				                			<p><b>Adrenaline:</b> <?php echo $adrenaline_paintball; ?></p>
				                			<p><b>Endurance:</b> <?php echo $endurance_paintball; ?></p>
				                			<p><b>Headstart:</b> <?php echo $headstart_paintball; ?></p>
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
				                			<p><b>K/D:</b> <?php echo round((($kills_teams_quake + $kills_quake) / ($deaths_teams_quake + $deaths_quake)), 2); ?></p>
				                			<p><b>S/K:</b> <?php echo round((($shots_fired_quake + $shots_fired_teams_quake) / ($kills_quake + $kills_teams_quake)), 2); ?></p>

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

					        </div>
					    </div>

                	</main>

                <?php include "includes/footer.php"; ?>

            </div>

    </body>
</html>
