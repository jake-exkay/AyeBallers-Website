<?php

	include "../includes/connect.php";
	include "../functions/functions.php";

	if (!apiLimitReached($API_KEY)) {
		$last_updated_query = "SELECT * FROM paintball";
	    $last_updated_result = $connection->query($last_updated_query);

		if ($last_updated_result->num_rows > 0) {
	    	while($last_updated_row = $last_updated_result->fetch_assoc()) {
	     		$last_updated = $last_updated_row['last_updated'];
	     	}
	    }

		$start_date = new DateTime($last_updated);
		$since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

		if ($since_start->i >= 10 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {

		    $api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=".$API_KEY."&player=82df5a8fa7934e6087d186d8741a1d23");
		    $decoded_url  = json_decode($api_guild_url);
		    $guild_members = $decoded_url->guild->members;

		    $truncate_paintball_query = "DELETE FROM paintball";
		    $truncate_quakecraft_query = "DELETE FROM quakecraft";
		    $truncate_tntgames_query = "DELETE FROM tntgames";
		    $truncate_tkr_query = "DELETE FROM tkr";

		    if($truncate_paintball_statement = mysqli_prepare($connection, $truncate_paintball_query)) {
		        mysqli_stmt_execute($truncate_paintball_statement);
		    } else {
		        echo 'Error truncating paintball<br>' . mysqli_error($connection); 
		    }

		    if($truncate_quakecraft_statement = mysqli_prepare($connection, $truncate_quakecraft_query)) {
		        mysqli_stmt_execute($truncate_quakecraft_statement);
		    } else {
		        echo 'Error truncating quakecraft<br>' . mysqli_error($connection); 
		    }

		    if($truncate_tntgames_statement = mysqli_prepare($connection, $truncate_tntgames_query)) {
		        mysqli_stmt_execute($truncate_tntgames_statement);
		    } else {
		        echo 'Error truncating tntgames<br>' . mysqli_error($connection); 
		    }

		    if($truncate_tkr_statement = mysqli_prepare($connection, $truncate_tkr_query)) {
		        mysqli_stmt_execute($truncate_tkr_statement);
		    } else {
		        echo 'Error truncating tkr<br>' . mysqli_error($connection); 
		    }

		    foreach($guild_members as $member) {

		        // Get specific members' stats.
		        $uuid = $member->uuid;
		        $player_url = file_get_contents("https://api.hypixel.net/player?key=".$API_KEY."&uuid=".$uuid);
		        $player_decoded_url = json_decode($player_url);

		        // Get real name
		        $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/".$uuid."/names");
		        $mojang_decoded_url = json_decode($mojang_url, true);
		        $real_name = array_pop($mojang_decoded_url);
		        $name = $real_name['name'];

		        // GENERAL VARS
		        $rank = "Error";
		        $mvp_plus_colour = "RED";

		        // TNT GAMES VARS
		        $wins_tntrun = 0;
		        $wins_bowspleef = 0;
		        $wins_pvprun = 0;
		        $wins_tntag = 0;
		        $coins_tntgames = 0;
		        $kills_wizards = 0;
		        $wins_wizards = 0;
		        $total_wins_tntgames = 0;
		        $kills_pvprun = 0;

		        // PAINTBALL VARS
		        $kills_paintball = 0;
		        $wins_paintball = 0;
		        $coins_paintball = 0;
		        $shots_fired_paintball = 0;
		        $deaths_paintball = 0;
		        $godfather_paintball = 0;
		        $endurance_paintball = 0;
		        $superluck_paintball = 0;
		        $fortune_paintball = 0;
		        $headstart_paintball = 0;
		        $adrenaline_paintball = 0;
		        $forcefield_time_paintball = 0;
		        $killstreaks_paintball = 0;
		        $transfusion_paintball = 0;
		        $hat_paintball = 0;

		        // QUAKECRAFT VARS
		        $wins_quakecraft = 0;
		        $kills_quakecraft = 0;
		        $kills_teams_quakecraft = 0;
		        $headshots_quakecraft = 0;
		        $deaths_quakecraft = 0;
		        $coins_quakecraft = 0;
		        $shots_fired_quakecraft = 0;
		        $killstreaks_quakecraft = 0;

		        // TKR VARS
		        $coins_tkr = 0;
		        $box_pickups_tkr = 0;
		        $laps_completed_tkr = 0;
		        $silver_trophy_tkr = 0;
		        $gold_trophy_tkr = 0;
		        $bronze_trophy_tkr = 0;

		        // GENERAL CHECKS
		        $rank = !empty($player_decoded_url->player->packageRank) ? $player_decoded_url->player->packageRank : 'Error';
		        $mvp_plus_colour = !empty($player_decoded_url->player->rankPlusColor) ? $player_decoded_url->player->rankPlusColor : 'Error';

		        // TNT GAMES CHECKS
		        $wins_tntrun = !empty($player_decoded_url->player->stats->TNTGames->wins_tntrun) ? $player_decoded_url->player->stats->TNTGames->wins_tntrun : 0;
		        $wins_bowspleef = !empty($player_decoded_url->player->stats->TNTGames->wins_bowspleef) ? $player_decoded_url->player->stats->TNTGames->wins_bowspleef : 0;
		        $wins_pvprun = !empty($player_decoded_url->player->stats->TNTGames->wins_pvprun) ? $player_decoded_url->player->stats->TNTGames->wins_pvprun : 0;
		        $wins_tntag = !empty($player_decoded_url->player->stats->TNTGames->wins_tntag) ? $player_decoded_url->player->stats->TNTGames->wins_tntag : 0;
		        $coins_tntgames = !empty($player_decoded_url->player->stats->TNTGames->coins) ? $player_decoded_url->player->stats->TNTGames->coins : 0;
		        $kills_wizards = !empty($player_decoded_url->player->stats->TNTGames->kills_capture) ? $player_decoded_url->player->stats->TNTGames->kills_capture : 0;
		        $wins_wizards = !empty($player_decoded_url->player->stats->TNTGames->wins_capture) ? $player_decoded_url->player->stats->TNTGames->wins_capture : 0;
		        $total_wins_tntgames = !empty($player_decoded_url->player->stats->TNTGames->wins) ? $player_decoded_url->player->stats->TNTGames->wins : 0;
		        $kills_pvprun = !empty($player_decoded_url->player->stats->TNTGames->kills_pvprun) ? $player_decoded_url->player->stats->TNTGames->kills_pvprun : 0;

		        // PAINTBALL CHECKS
		        $kills_paintball = !empty($player_decoded_url->player->stats->Paintball->kills) ? $player_decoded_url->player->stats->Paintball->kills : 0;
		        $wins_paintball = !empty($player_decoded_url->player->stats->Paintball->wins) ? $player_decoded_url->player->stats->Paintball->wins : 0;
				$coins_paintball = !empty($player_decoded_url->player->stats->Paintball->coins) ? $player_decoded_url->player->stats->Paintball->coins : 0;
		        $shots_fired_paintball = !empty($player_decoded_url->player->stats->Paintball->shots_fired) ? $player_decoded_url->player->stats->Paintball->shots_fired : 0;
		        $deaths_paintball = !empty($player_decoded_url->player->stats->Paintball->deaths) ? $player_decoded_url->player->stats->Paintball->deaths : 0;
				$godfather_paintball = !empty($player_decoded_url->player->stats->Paintball->godfather) ? $player_decoded_url->player->stats->Paintball->godfather : 0;
		        $endurance_paintball = !empty($player_decoded_url->player->stats->Paintball->endurance) ? $player_decoded_url->player->stats->Paintball->endurance : 0;
				$superluck_paintball = !empty($player_decoded_url->player->stats->Paintball->superluck) ? $player_decoded_url->player->stats->Paintball->superluck : 0;
		        $fortune_paintball = !empty($player_decoded_url->player->stats->Paintball->fortune) ? $player_decoded_url->player->stats->Paintball->fortune : 0;
		        $headstart_paintball = !empty($player_decoded_url->player->stats->Paintball->headstart) ? $player_decoded_url->player->stats->Paintball->headstart : 0;
		        $adrenaline_paintball = !empty($player_decoded_url->player->stats->Paintball->adrenaline) ? $player_decoded_url->player->stats->Paintball->adrenaline : 0;
		        $forcefield_time_paintball = !empty($player_decoded_url->player->stats->Paintball->forcefieldTime) ? $player_decoded_url->player->stats->Paintball->forcefieldTime : 0;
		        $killstreaks_paintball = !empty($player_decoded_url->player->stats->Paintball->killstreaks) ? $player_decoded_url->player->stats->Paintball->killstreaks : 0;
		        $transfusion_paintball = !empty($player_decoded_url->player->stats->Paintball->transfusion) ? $player_decoded_url->player->stats->Paintball->transfusion : 0;
		        $hat_paintball = !empty($player_decoded_url->player->stats->Paintball->hat) ? $player_decoded_url->player->stats->Paintball->hat : "no hat";

		        // Format paintball hats
		        if ($hat_paintball == 'normal_hat') {
		            $hat_paintball = 'Normal Hat';
		        } elseif ($hat_paintball == 'trololol_hat') {
		            $hat_paintball = 'Trololol Hat';
		        } elseif ($hat_paintball == 'vip_hypixel_hat') {
		            $hat_paintball = 'Hypixel';
		        } elseif ($hat_paintball == 'vip_rezzus_hat') {
		            $hat_paintball = 'Rezzus';
		        } elseif ($hat_paintball == 'vip_paintballkitty_hat') {
		            $hat_paintball = 'PaintballKitty';
		        } elseif ($hat_paintball == 'drunk_hat') {
		            $hat_paintball = 'Drunk Hat';
		        } elseif ($hat_paintball == 'vip_noxyd_hat') {
		            $hat_paintball = 'NoxyD';
		        } elseif ($hat_paintball == 'vip_ghost_hat') {
		            $hat_paintball = 'Ghost Hat';
		        } elseif ($hat_paintball == 'shaky_hat') {
		            $hat_paintball = 'Shaky Hat';
		        } elseif ($hat_paintball == 'speed_hat') {
		            $hat_paintball = 'Speed Hat';
		        } elseif ($hat_paintball == 'vip_codename_b_hat') {
		            $hat_paintball = 'Codename B';
		        } elseif ($hat_paintball == 'tnt_hat') {
		            $hat_paintball = 'TNT Hat';
		        } elseif ($hat_paintball == 'snow_hat') {
		            $hat_paintball = 'Snow Hat';
		        } elseif ($hat_paintball == 'hard_hat') {
		            $hat_paintball = 'Hard Hat';
		        } elseif ($hat_paintball == 'ender_hat') {
		            $hat_paintball = 'Ender Hat';
		        } elseif ($hat_paintball == 'hat_of_darkness') {
		            $hat_paintball = 'Darkness Hat';
		        } elseif ($hat_paintball == 'squid_hat') {
		            $hat_paintball = 'Squid Hat';
		        } elseif ($hat_paintball == 'spider_hat') {
		            $hat_paintball = 'Spider Hat';
		        } elseif ($hat_paintball == 'vip_kevinkool_hat') {
		            $hat_paintball = 'Kevinkool';
		        } elseif ($hat_paintball == 'vip_neonmaster_hat') {
		            $hat_paintball = 'Neonmaster';
		        } elseif ($hat_paintball == 'vip_agentk_hat') {
		            $hat_paintball = 'AgentK';
		        } else {
		            $hat_paintball = 'No Hat';
		        }

		        $fortune_paintball += 1;
		        $endurance_paintball += 1;
		        $godfather_paintball += 1;
		        $superluck_paintball += 1;
		        $adrenaline_paintball += 1;
		        $headstart_paintball += 1;
		        $transfusion_paintball += 1;

		        // QUAKECRAFT CHECKS
		        $kills_quakecraft = !empty($player_decoded_url->player->stats->Quake->kills) ? $player_decoded_url->player->stats->Quake->kills : 0;
		        $wins_quakecraft = !empty($player_decoded_url->player->stats->Quake->wins) ? $player_decoded_url->player->stats->Quake->wins : 0;
		        $coins_quakecraft = !empty($player_decoded_url->player->stats->Quake->coins) ? $player_decoded_url->player->stats->Quake->coins : 0;
		        $shots_fired_quakecraft = !empty($player_decoded_url->player->stats->Quake->shots_fired) ? $player_decoded_url->player->stats->Quake->shots_fired : 0;
		        $deaths_quakecraft = !empty($player_decoded_url->player->stats->Quake->deaths) ? $player_decoded_url->player->stats->Quake->deaths : 0;
		        $headshots_quakecraft = !empty($player_decoded_url->player->stats->Quake->headshots) ? $player_decoded_url->player->stats->Quake->headshots : 0;
		        $killstreaks_quakecraft = !empty($player_decoded_url->player->stats->Quake->killstreaks) ? $player_decoded_url->player->stats->Quake->killstreaks : 0;
		        $kills_teams_quakecraft = !empty($player_decoded_url->player->stats->Quake->kills_teams) ? $player_decoded_url->player->stats->Quake->kills_teams : 0;
		        $deaths_teams_quakecraft = !empty($player_decoded_url->player->stats->Quake->deaths_teams) ? $player_decoded_url->player->stats->Quake->deaths_teams : 0;
		        $wins_teams_quakecraft = !empty($player_decoded_url->player->stats->Quake->wins_teams) ? $player_decoded_url->player->stats->Quake->wins_teams : 0;
		        $killstreaks_teams_quakecraft = !empty($player_decoded_url->player->stats->Quake->killstreaks_teams) ? $player_decoded_url->player->stats->Quake->killstreaks_teams : 0;

		        $kills_quakecraft = $kills_quakecraft + $kills_teams_quakecraft;
		        $killstreaks_quakecraft = $killstreaks_quakecraft + $killstreaks_teams_quakecraft;
		        $wins_quakecraft = $wins_quakecraft + $wins_teams_quakecraft;
		        $deaths_quakecraft = $deaths_quakecraft + $deaths_teams_quakecraft;

		        // TKR CHECKS
		        $coins_tkr = !empty($player_decoded_url->player->stats->GingerBread->coins) ? $player_decoded_url->player->stats->GingerBread->coins : 0;
		        $box_pickups_tkr = !empty($player_decoded_url->player->stats->GingerBread->box_pickups) ? $player_decoded_url->player->stats->GingerBread->box_pickups : 0;
		        $laps_completed_tkr = !empty($player_decoded_url->player->stats->GingerBread->laps_completed) ? $player_decoded_url->player->stats->GingerBread->laps_completed : 0;
		        $silver_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->silver_trophy) ? $player_decoded_url->player->stats->GingerBread->silver_trophy : 0;
		        $gold_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->gold_trophy) ? $player_decoded_url->player->stats->GingerBread->gold_trophy : 0;
		        $bronze_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->bronze_trophy) ? $player_decoded_url->player->stats->GingerBread->bronze_trophy : 0;

		        // TNT GAMES INSERT
		        $query_tntgames = "INSERT INTO tntgames (UUID, name, last_updated, mvp_plus_colour, rank, coins, wizards_kills, wins_bowspeef, wins_wizards, wins_tntrun, total_wins, kills_pvprun, wins_tnttag, wins_pvprun)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_tntgames = mysqli_prepare($connection, $query_tntgames)) {
		            mysqli_stmt_bind_param($statement_tntgames, "ssssiiiiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_tntgames, $kills_wizards, $wins_bowspleef, $wins_wizards, $wins_tntrun, $total_wins_tntgames, $kills_pvprun, $wins_tntag, $wins_pvprun);
		            mysqli_stmt_execute($statement_tntgames);
		        } else {
		            echo '<b>[TNT GAMES] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // PAINTBALL INSERT
		        $query_paintball = "INSERT INTO paintball (UUID, kills, wins, coins, shots_fired, deaths, godfather, endurance, superluck, fortune, headstart, adrenaline, forcefield_time, killstreaks, transfusion, hat, rank, mvp_plus_colour, last_updated, name)
		            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";

		        if($statement_paintball = mysqli_prepare($connection, $query_paintball)) {
		            mysqli_stmt_bind_param($statement_paintball, "siiiiiiiiiiisiissss", $uuid, $kills_paintball, $wins_paintball, $coins_paintball, $shots_fired_paintball, $deaths_paintball, $godfather_paintball, $endurance_paintball, $superluck_paintball, $fortune_paintball, $headstart_paintball, $adrenaline_paintball, $forcefield_time_paintball, $killstreaks_paintball, $transfusion_paintball, $hat_paintball, $rank, $mvp_plus_colour, $name);
		            mysqli_stmt_execute($statement_paintball);
		        } else {
		            echo '<b>[PAINTBALL] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // QUAKECRAFT INSERT
		        $query_quakecraft = "INSERT INTO quakecraft (UUID, kills, wins, coins, shots_fired, deaths, headshots, killstreaks, rank, mvp_plus_colour, last_updated, name)
		            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";

		        if($statement_quakecraft = mysqli_prepare($connection, $query_quakecraft)) {
		            mysqli_stmt_bind_param($statement_quakecraft, "siiiiiiisss", $uuid, $kills_quakecraft, $wins_quakecraft, $coins_quakecraft, $shots_fired_quakecraft, $deaths_quakecraft, $headshots_quakecraft, $killstreaks_quakecraft, $rank, $mvp_plus_colour, $name);
		            mysqli_stmt_execute($statement_quakecraft);
		        } else {
		            echo '<b>[QUAKE] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // TKR INSERT
		        $query_tkr = "INSERT INTO tkr (UUID, name, last_updated, mvp_plus_colour, rank, coins, box_pickups, laps_completed, silver_trophy, gold_trophy, bronze_trophy)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_tkr = mysqli_prepare($connection, $query_tkr)) {
		            mysqli_stmt_bind_param($statement_tkr, "ssssiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_tkr, $box_pickups_tkr, $laps_completed_tkr, $silver_trophy_tkr, $gold_trophy_tkr, $bronze_trophy_tkr);
		            mysqli_stmt_execute($statement_tkr);
		        } else {
		            echo '<b>[TKR] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        header("Refresh:0.01; url=../index.php");


		    }

		} else {
			echo "Database was updated less than an 10 minutes ago. Redirecting.";
		    header("Refresh:2; url=../index.php");
		}
	} else {
		echo "Error: Too many concurrent API requests, please try again in a minute.";
        header("Refresh:2; url=../index.php");
	}

	$connection->close();

?>