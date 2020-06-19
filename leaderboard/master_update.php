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

		if ($since_start->i >= 5 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {

		    $api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=".$API_KEY."&player=82df5a8fa7934e6087d186d8741a1d23");
		    $decoded_url  = json_decode($api_guild_url);
		    $guild_members = $decoded_url->guild->members;

		    $truncate_paintball_query = "DELETE FROM paintball";
		    $truncate_quakecraft_query = "DELETE FROM quakecraft";
		    $truncate_tntgames_query = "DELETE FROM tntgames";
		    $truncate_tkr_query = "DELETE FROM tkr";
		    $truncate_vz_query = "DELETE FROM vampirez";
		    $truncate_walls_query = "DELETE FROM walls";
		    $truncate_arena_query = "DELETE FROM arena";
		    $truncate_bedwars_query = "DELETE FROM bedwars";
		    $truncate_skywars_query = "DELETE FROM skywars";

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

		    if($truncate_vz_statement = mysqli_prepare($connection, $truncate_vz_query)) {
		        mysqli_stmt_execute($truncate_vz_statement);
		    } else {
		        echo 'Error truncating vampirez<br>' . mysqli_error($connection); 
		    }

		  	if($truncate_walls_statement = mysqli_prepare($connection, $truncate_walls_query)) {
		        mysqli_stmt_execute($truncate_walls_statement);
		    } else {
		        echo 'Error truncating walls<br>' . mysqli_error($connection); 
		    }

		    if($truncate_arena_statement = mysqli_prepare($connection, $truncate_arena_query)) {
		        mysqli_stmt_execute($truncate_arena_statement);
		    } else {
		        echo 'Error truncating arena<br>' . mysqli_error($connection); 
		    }

		    if($truncate_bedwars_statement = mysqli_prepare($connection, $truncate_bedwars_query)) {
		        mysqli_stmt_execute($truncate_bedwars_statement);
		    } else {
		        echo 'Error truncating bedwars<br>' . mysqli_error($connection); 
		    }

		    if($truncate_skywars_statement = mysqli_prepare($connection, $truncate_skywars_query)) {
		        mysqli_stmt_execute($truncate_skywars_statement);
		    } else {
		        echo 'Error truncating skywars<br>' . mysqli_error($connection); 
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

		        // VZ VARS
		        $coins_vz = 0;
		        $human_wins_vz = 0;
		        $human_kills_vz = 0;
		        $vampire_wins_vz = 0;
		        $vampire_kills_vz = 0;
		        $zombie_kills_vz = 0;

		        // WALLS VARS
		        $coins_walls = 0;
		        $deaths_walls = 0;
		        $kills_walls = 0;
		        $wins_walls = 0;
		        $assists_walls = 0;

		        // ARENA VARS
		        $coins_arena = 0;
		        $kills2v2_arena = 0;
		        $kills4v4_arena = 0;
		        $rating_arena = 0;
		        $wins2v2_arena = 0;
		        $wins4v4_arena = 0;

		        // BEDWARS VARS
		        $coins_bw = 0;
		        $kills_bw = 0;
		        $deaths_bw = 0;
		        $beds_broken_bw = 0;
		        $finals_bw = 0;
		        $wins_bw = 0;

		        // SKYWARS VARS
		        $coins_sw = 0;
		        $kills_sw = 0;
		        $deaths_sw = 0;
		        $wins_sw = 0;
		        $assists_sw = 0;

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

		        // VZ CHECKS
		        $coins_vz = !empty($player_decoded_url->player->stats->VampireZ->coins) ? $player_decoded_url->player->stats->VampireZ->coins : 0;
		        $human_wins_vz = !empty($player_decoded_url->player->stats->VampireZ->human_wins) ? $player_decoded_url->player->stats->VampireZ->human_wins : 0;
		        $human_kills_vz = !empty($player_decoded_url->player->stats->VampireZ->human_kills) ? $player_decoded_url->player->stats->VampireZ->human_kills : 0;
		        $zombie_kills_vz = !empty($player_decoded_url->player->stats->VampireZ->zombie_kills) ? $player_decoded_url->player->stats->VampireZ->zombie_kills : 0;
		        $vampire_wins_vz = !empty($player_decoded_url->player->stats->VampireZ->vampire_wins) ? $player_decoded_url->player->stats->VampireZ->vampire_wins : 0;
		        $vampire_kills_vz = !empty($player_decoded_url->player->stats->VampireZ->vampire_kills) ? $player_decoded_url->player->stats->VampireZ->vampire_kills : 0;

		        // WALLS CHECKS
		        $coins_walls = !empty($player_decoded_url->player->stats->Walls->coins) ? $player_decoded_url->player->stats->Walls->coins : 0;
		        $deaths_walls = !empty($player_decoded_url->player->stats->Walls->deaths) ? $player_decoded_url->player->stats->Walls->deaths : 0;
		        $wins_walls = !empty($player_decoded_url->player->stats->Walls->wins) ? $player_decoded_url->player->stats->Walls->wins : 0;
		        $kills_walls = !empty($player_decoded_url->player->stats->Walls->kills) ? $player_decoded_url->player->stats->Walls->kills : 0;
		        $assists_walls = !empty($player_decoded_url->player->stats->Walls->assists) ? $player_decoded_url->player->stats->Walls->assists : 0;

		        // ARENA CHECKS
		        $coins_arena = !empty($player_decoded_url->player->stats->Arena->coins) ? $player_decoded_url->player->stats->Arena->coins : 0;
		        $wins4v4_arena = !empty($player_decoded_url->player->stats->Arena->wins_4v4) ? $player_decoded_url->player->stats->Arena->wins_4v4 : 0;
		        $wins2v2_arena = !empty($player_decoded_url->player->stats->Arena->wins_2v2) ? $player_decoded_url->player->stats->Arena->wins_4v4 : 0;
		        $kills2v2_arena = !empty($player_decoded_url->player->stats->Arena->kills_2v2) ? $player_decoded_url->player->stats->Arena->kills_2v2 : 0;
		        $kills4v4_arena = !empty($player_decoded_url->player->stats->Arena->kills_4v4) ? $player_decoded_url->player->stats->Arena->kills_4v4 : 0;
		        $rating_arena = !empty($player_decoded_url->player->stats->Arena->rating) ? $player_decoded_url->player->stats->Arena->rating : 0;

		        // BEDWARS CHECKS
		        $coins_bw = !empty($player_decoded_url->player->stats->Bedwars->coins) ? $player_decoded_url->player->stats->Bedwars->coins : 0;
		        $wins_bw = !empty($player_decoded_url->player->stats->Bedwars->wins_bedwars) ? $player_decoded_url->player->stats->Bedwars->wins_bedwars : 0;
		        $kills_bw = !empty($player_decoded_url->player->stats->Bedwars->kills_bedwars) ? $player_decoded_url->player->stats->Bedwars->kills_bedwars : 0;
		        $finals_bw = !empty($player_decoded_url->player->stats->Bedwars->final_kills_bedwars) ? $player_decoded_url->player->stats->Bedwars->final_kills_bedwars : 0;
		        $deaths_bw = !empty($player_decoded_url->player->stats->Bedwars->deaths_bedwars) ? $player_decoded_url->player->stats->Bedwars->deaths_bedwars : 0;
		        $beds_broken_bw = !empty($player_decoded_url->player->stats->Bedwars->beds_broken_bedwars) ? $player_decoded_url->player->stats->Bedwars->beds_broken_bedwars : 0;

		        // SKYWARS CHECKS
		        $coins_sw = !empty($player_decoded_url->player->stats->SkyWars->coins) ? $player_decoded_url->player->stats->SkyWars->coins : 0;
		        $wins_sw = !empty($player_decoded_url->player->stats->SkyWars->wins) ? $player_decoded_url->player->stats->SkyWars->wins : 0;
		        $kills_sw = !empty($player_decoded_url->player->stats->SkyWars->kills) ? $player_decoded_url->player->stats->SkyWars->kills : 0;
		        $assists_sw = !empty($player_decoded_url->player->stats->SkyWars->assists) ? $player_decoded_url->player->stats->SkyWars->assists : 0;
		        $deaths_sw = !empty($player_decoded_url->player->stats->SkyWars->deaths) ? $player_decoded_url->player->stats->SkyWars->deaths : 0;

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

		        // VZ INSERT
		        $query_vz = "INSERT INTO vampirez (UUID, name, last_updated, mvp_plus_colour, rank, coins, human_wins, human_kills, vampire_wins, vampire_kills, zombie_kills)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_vz = mysqli_prepare($connection, $query_vz)) {
		            mysqli_stmt_bind_param($statement_vz, "ssssiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_vz, $human_wins_vz, $human_kills_vz, $vampire_wins_vz, $vampire_kills_vz, $zombie_kills_vz);
		            mysqli_stmt_execute($statement_vz);
		        } else {
		            echo '<b>[VZ] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // WALLS INSERT
		        $query_walls = "INSERT INTO walls (UUID, name, last_updated, mvp_plus_colour, rank, coins, wins, kills, deaths, assists)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_walls = mysqli_prepare($connection, $query_walls)) {
		            mysqli_stmt_bind_param($statement_walls, "ssssiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_walls, $wins_walls, $kills_walls, $deaths_walls, $assists_walls);
		            mysqli_stmt_execute($statement_walls);
		        } else {
		            echo '<b>[WALLS] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // ARENA INSERT
		        $query_arena = "INSERT INTO arena (UUID, name, last_updated, mvp_plus_colour, rank, coins, wins_4v4, wins_2v2, kills_4v4, kills_2v2, rating)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_arena = mysqli_prepare($connection, $query_arena)) {
		            mysqli_stmt_bind_param($statement_arena, "ssssiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_arena, $wins4v4_arena, $wins2v2_arena, $kills4v4_arena, $kills2v2_arena, $rating_arena);
		            mysqli_stmt_execute($statement_arena);
		        } else {
		            echo '<b>[ARENA] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // BEDWARS INSERT
		        $query_bedwars = "INSERT INTO bedwars (UUID, name, last_updated, mvp_plus_colour, rank, coins, wins, kills, finals, deaths, beds_broken)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_bedwars = mysqli_prepare($connection, $query_bedwars)) {
		            mysqli_stmt_bind_param($statement_bedwars, "ssssiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_bw, $wins_bw, $kills_bw, $finals_bw, $deaths_bw, $beds_broken_bw);
		            mysqli_stmt_execute($statement_bedwars);
		        } else {
		            echo '<b>[BEDWARS] '.$name.' </b>An Error Occured!<br>'; 
		        }

		        // SKYWARS INSERT
		        $query_skywars = "INSERT INTO skywars (UUID, name, last_updated, mvp_plus_colour, rank, coins, wins, kills, assists, deaths)
		            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?)";

		        if($statement_skywars = mysqli_prepare($connection, $query_skywars)) {
		            mysqli_stmt_bind_param($statement_skywars, "ssssiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_sw, $wins_sw, $kills_sw, $assists_sw, $deaths_sw);
		            mysqli_stmt_execute($statement_skywars);
		        } else {
		            echo '<b>[SKYWARS] '.$name.' </b>An Error Occured!<br>'; 
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