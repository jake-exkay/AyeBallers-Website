<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Player Search - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";
            include "functions/player_functions.php";

            updatePageViews($connection, 'player_page', $DEV_IP);

            $viewingStats = false;

            if (isset($_POST['submit'])) {
                $playerName = $_POST["playerName"];
                $uuid = getUUID($connection, $playerName);
                
                if (updatePlayerInDatabase($connection, $uuid, $playerName, $API_KEY)) {
                	$result = getPlayerInformation($connection, $uuid);
                	$viewingStats = true;
                }
               
            }

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php include "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

            	<?php if ($viewingStats == false) { ?>
	                <main>

	                	<div class="card">
	            			<div class="card-body">

	                			<form style="padding: 300px;" class="form-signin" name="playerForm" action="player.php" method="POST" enctype="multipart/form-data">

	                    			<div class="form-label-group">
	                        			<center>
	                            			<label>Player</label>
	                        			</center>
	                        			<input type="text" class="form-control" name="playerName" placeholder="Player Name" required>
	                    			</div> 

	                    			<br>

				                    <center>
				                        <button name="submit" type="submit" class="btn btn-lg btn-primary">Search</button>
				                    </center>

	                			</form>

				            </div>
				        </div>

                	</main>
                <?php 

            		} else { 
            			$uuid = "";
            			$name = "";
            			$kills_paintball = 0;
            			$wins_paintball = 0;

			            if ($result->num_rows > 0) {
			                while($row = $result->fetch_assoc()) {
			                	$uuid = $row['UUID'];
			                    $name = $row['name'];
			                    $kills_paintball = $row['kills_paintball'];
			                    $wins_paintball = $row['wins_paintball'];
			                    $coins_paintball = $row['coins_paintball'];
			                    $kill_prefix_paintball = $row['kill_prefix_paintball'];
			                    $deaths_paintball = $row['deaths_paintball'];
			                    $forcefield_time_paintball = $row['forcefield_time_paintball'];
			                    $killstreaks_paintball = $row['killstreaks_paintball'];
			                    $shots_fired_paintball = $row['shots_fired_paintball'];
			                    $hat_paintball = $row['hat_paintball'];
			                    $adrenaline_paintball = $row['adrenaline_paintball'] + 1;
			                    $endurance_paintball = $row['endurance_paintball'] + 1;
			                    $fortune_paintball = $row['fortune_paintball'] + 1;
			                    $godfather_paintball = $row['godfather_paintball'] + 1;
			                    $superluck_paintball = $row['superluck_paintball'] + 1;
			                    $transfusion_paintball = $row['transfusion_paintball'] + 1;
			                    $headstart_paintball = $row['headstart_paintball'] + 1;
			                }
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
					                			<p>Network Level: </p>
					                			<p>Achievement Points: </p>
					                			<p>Quests Completed: </p>
					                			<p>Guild: </p>
					                			<p>Karma: </p>
					                			<p>Time Played: </p>
					                			<p>First Login: </p>
					                			<p>Last Login: </p>
					                			<p>Recent Game: </p>
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
	                			<button data-toggle="collapse">Quakecraft</button>
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
				                			<p>Leaderboard Position: </p>
				                			<p>Kills: <?php echo $kills_paintball; ?></p>
				                			<p>Wins: <?php echo $wins_paintball; ?></p>
				                			<p>Kill Prefix: [selectedKillPrefix <?php echo substr($kills_paintball, 0, 3) ?>k]</p>
				                			<p>Coins: <?php echo $coins_paintball; ?></p>
				                			<p>Deaths: <?php echo $deaths_paintball; ?></p>
				                			<p>Forcefield Time: <?php echo $forcefield_time_paintball; ?></p>
				                			<p>Killstreaks: <?php echo $killstreaks_paintball; ?></p>
				                			<p>Shots Fired: <?php echo $shots_fired_paintball; ?></p>
				                			<p>Hotbar Perks: [0:0:0] </p>
				                			<p>Equipped Hat: <?php echo $hat_paintball; ?></p>

				                			<br>

				                			<p>K/D: </p>
				                			<p>W/L: </p>
				                			<p>S/K: </p>

				                			<br>

				                			<p>Adrenaline: <?php echo $adrenaline_paintball; ?></p>
				                			<p>Endurance: <?php echo $endurance_paintball; ?></p>
				                			<p>Headstart: <?php echo $headstart_paintball; ?></p>
				                			<p>Fortune: <?php echo $fortune_paintball; ?></p>
				                			<p>Godfather: <?php echo $godfather_paintball; ?></p>
				                			<p>Superluck: <?php echo $superluck_paintball; ?></p>
				                			<p>Transfusion: <?php echo $transfusion_paintball; ?></p>
				                		</div>
				                	</div>
		                		</div>

					        </div>
					    </div>

                	</main>

                <?php } ?>

                <?php include "includes/footer.php"; ?>

            </div>

    </body>
</html>
