<?php

	function updatePlayerInDatabase($connection, $uuid, $name, $API_KEY) {
		$player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
		$player_decoded_url = json_decode($player_url);

		$first_login = !empty($player_decoded_url->player->firstLogin) ? $player_decoded_url->player->firstLogin : 0;
		$karma = !empty($player_decoded_url->player->karma) ? $player_decoded_url->player->karma : 0;
		$last_login = !empty($player_decoded_url->player->lastLogin) ? $player_decoded_url->player->lastLogin : 0;
		$network_exp = !empty($player_decoded_url->player->networkExp) ? $player_decoded_url->player->networkExp : 0;
		$time_played = !empty($player_decoded_url->player->timePlaying) ? $player_decoded_url->player->timePlaying : 0;
		$rank_colour = !empty($player_decoded_url->player->rankPlusColor) ? $player_decoded_url->player->rankPlusColor : "None";
		$achievement_points = !empty($player_decoded_url->player->achievementPoints) ? $player_decoded_url->player->achievementPoints : 0;
		$most_recent_game = !empty($player_decoded_url->player->mostRecentGameType) ? $player_decoded_url->player->mostRecentGameType : "Unknown";
		$rank = !empty($player_decoded_url->player->packageRank) ? $player_decoded_url->player->packageRank : 'DEFAULT';

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
        $hat_paintball = !empty($player_decoded_url->player->stats->Paintball->hat) ? $player_decoded_url->player->stats->Paintball->hat : "NONE";
        $kill_prefix_paintball = !empty($player_decoded_url->player->stats->Paintball->selectedKillPrefix) ? $player_decoded_url->player->stats->Paintball->selectedKillPrefix : "DEFAULT";

        $coins_quake = !empty($player_decoded_url->player->stats->Quake->coins) ? $player_decoded_url->player->stats->Quake->coins : 0;
        $deaths_quake = !empty($player_decoded_url->player->stats->Quake->deaths) ? $player_decoded_url->player->stats->Quake->deaths : 0;
       	$kills_quake = !empty($player_decoded_url->player->stats->Quake->kills) ? $player_decoded_url->player->stats->Quake->kills : 0;
        $killstreaks_quake = !empty($player_decoded_url->player->stats->Quake->killstreaks) ? $player_decoded_url->player->stats->Quake->killstreaks : 0;
        $wins_quake = !empty($player_decoded_url->player->stats->Quake->wins) ? $player_decoded_url->player->stats->Quake->wins : 0;
       	$kills_teams_quake = !empty($player_decoded_url->player->stats->Quake->kills_teams) ? $player_decoded_url->player->stats->Quake->kills_teams : 0;
        $deaths_teams_quake = !empty($player_decoded_url->player->stats->Quake->deaths_teams) ? $player_decoded_url->player->stats->Quake->deaths_teams : 0;
        $wins_teams_quake = !empty($player_decoded_url->player->stats->Quake->wins_teams) ? $player_decoded_url->player->stats->Quake->wins_teams : 0;
        $killstreaks_teams_quake = !empty($player_decoded_url->player->stats->Quake->killstreaks_teams) ? $player_decoded_url->player->stats->Quake->killstreaks_teams : 0;
        $highest_killstreak_quake = !empty($player_decoded_url->player->stats->Quake->highest_killstreak) ? $player_decoded_url->player->stats->Quake->highest_killstreak : 0;
        $shots_fired_teams_quake = !empty($player_decoded_url->player->stats->Quake->shots_fired_teams) ? $player_decoded_url->player->stats->Quake->shots_fired_teams : 0;
        $headshots_teams_quake = !empty($player_decoded_url->player->stats->Quake->headshots_teams) ? $player_decoded_url->player->stats->Quake->headshots_teams : 0;
        $headshots_quake = !empty($player_decoded_url->player->stats->Quake->headshots) ? $player_decoded_url->player->stats->Quake->headshots : 0;
        $shots_fired_quake = !empty($player_decoded_url->player->stats->Quake->shots_fired) ? $player_decoded_url->player->stats->Quake->shots_fired : 0;
        $distance_travelled_teams_quake = !empty($player_decoded_url->player->stats->Quake->distance_travelled_teams) ? $player_decoded_url->player->stats->Quake->distance_travelled_teams : 0;
        $distance_travelled_quake = !empty($player_decoded_url->player->stats->Quake->distance_travelled) ? $player_decoded_url->player->stats->Quake->distance_travelled : 0;

        $coins_arena = !empty($player_decoded_url->player->stats->Arena->coins) ? $player_decoded_url->player->stats->Arena->coins : 0;
        $coins_spent_arena = !empty($player_decoded_url->player->stats->Arena->coins_spent) ? $player_decoded_url->player->stats->Arena->coins_spent : 0;
        $keys_arena = !empty($player_decoded_url->player->stats->Arena->keys) ? $player_decoded_url->player->stats->Arena->keys : 0;
        $rating_arena = !empty($player_decoded_url->player->stats->Arena->rating) ? $player_decoded_url->player->stats->Arena->rating : 0;
        $damage_2v2_arena = !empty($player_decoded_url->player->stats->Arena->damage_2v2) ? $player_decoded_url->player->stats->Arena->damage_2v2 : 0;
        $damage_4v4_arena = !empty($player_decoded_url->player->stats->Arena->damage_4v4) ? $player_decoded_url->player->stats->Arena->damage_4v4 : 0;
        $damage_1v1_arena = !empty($player_decoded_url->player->stats->Arena->damage_1v1) ? $player_decoded_url->player->stats->Arena->damage_1v1 : 0;
        $deaths_2v2_arena = !empty($player_decoded_url->player->stats->Arena->deaths_2v2) ? $player_decoded_url->player->stats->Arena->deaths_2v2 : 0;
        $deaths_4v4_arena = !empty($player_decoded_url->player->stats->Arena->deaths_4v4) ? $player_decoded_url->player->stats->Arena->deaths_4v4 : 0;
        $deaths_1v1_arena = !empty($player_decoded_url->player->stats->Arena->deaths_1v1) ? $player_decoded_url->player->stats->Arena->deaths_1v1 : 0;
        $games_2v2_arena = !empty($player_decoded_url->player->stats->Arena->games_2v2) ? $player_decoded_url->player->stats->Arena->games_2v2 : 0;
        $games_4v4_arena = !empty($player_decoded_url->player->stats->Arena->games_4v4) ? $player_decoded_url->player->stats->Arena->games_4v4 : 0;
        $games_1v1_arena = !empty($player_decoded_url->player->stats->Arena->games_1v1) ? $player_decoded_url->player->stats->Arena->games_1v1 : 0;
        $healed_2v2_arena = !empty($player_decoded_url->player->stats->Arena->healed_2v2) ? $player_decoded_url->player->stats->Arena->healed_2v2 : 0;
        $healed_4v4_arena = !empty($player_decoded_url->player->stats->Arena->healed_4v4) ? $player_decoded_url->player->stats->Arena->healed_4v4 : 0;
        $healed_1v1_arena = !empty($player_decoded_url->player->stats->Arena->healed_1v1) ? $player_decoded_url->player->stats->Arena->healed_1v1 : 0;
        $kills_2v2_arena = !empty($player_decoded_url->player->stats->Arena->kills_2v2) ? $player_decoded_url->player->stats->Arena->kills_2v2 : 0;
        $kills_4v4_arena = !empty($player_decoded_url->player->stats->Arena->kills_4v4) ? $player_decoded_url->player->stats->Arena->kills_4v4 : 0;
        $kills_1v1_arena = !empty($player_decoded_url->player->stats->Arena->kills_1v1) ? $player_decoded_url->player->stats->Arena->kills_1v1 : 0;
        $losses_2v2_arena = !empty($player_decoded_url->player->stats->Arena->losses_2v2) ? $player_decoded_url->player->stats->Arena->losses_2v2 : 0;
        $losses_4v4_arena = !empty($player_decoded_url->player->stats->Arena->losses_4v4) ? $player_decoded_url->player->stats->Arena->losses_4v4 : 0;
        $losses_1v1_arena = !empty($player_decoded_url->player->stats->Arena->losses_1v1) ? $player_decoded_url->player->stats->Arena->losses_1v1 : 0;
        $wins_2v2_arena = !empty($player_decoded_url->player->stats->Arena->wins_2v2) ? $player_decoded_url->player->stats->Arena->wins_2v2 : 0;
        $wins_4v4_arena = !empty($player_decoded_url->player->stats->Arena->wins_4v4) ? $player_decoded_url->player->stats->Arena->wins_4v4 : 0;
        $wins_1v1_arena = !empty($player_decoded_url->player->stats->Arena->wins_1v1) ? $player_decoded_url->player->stats->Arena->wins_1v1 : 0;

        $coins_tkr = !empty($player_decoded_url->player->stats->GingerBread->coins) ? $player_decoded_url->player->stats->GingerBread->coins : 0;
        $box_pickups_tkr = !empty($player_decoded_url->player->stats->GingerBread->box_pickups) ? $player_decoded_url->player->stats->GingerBread->box_pickups : 0;
        $coins_picked_up_tkr = !empty($player_decoded_url->player->stats->GingerBread->coins_picked_up) ? $player_decoded_url->player->stats->GingerBread->coins_picked_up : 0;
        $silver_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->silver_trophy) ? $player_decoded_url->player->stats->GingerBread->silver_trophy : 0;
        $wins_tkr = !empty($player_decoded_url->player->stats->GingerBread->wins) ? $player_decoded_url->player->stats->GingerBread->wins : 0;
        $laps_completed_tkr = !empty($player_decoded_url->player->stats->GingerBread->laps_completed) ? $player_decoded_url->player->stats->GingerBread->laps_completed : 0;
        $gold_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->gold_trophy) ? $player_decoded_url->player->stats->GingerBread->gold_trophy : 0;
        $bronze_trophy_tkr = !empty($player_decoded_url->player->stats->GingerBread->bronze_trophy) ? $player_decoded_url->player->stats->GingerBread->bronze_trophy : 0;
        $olympus_tkr = !empty($player_decoded_url->player->stats->GingerBread->olympus_plays) ? $player_decoded_url->player->stats->GingerBread->olympus_plays : 0;
        $junglerush_tkr = !empty($player_decoded_url->player->stats->GingerBread->junglerush_plays) ? $player_decoded_url->player->stats->GingerBread->junglerush_plays : 0;
        $hypixelgp_tkr = !empty($player_decoded_url->player->stats->GingerBread->hypixelgp_plays) ? $player_decoded_url->player->stats->GingerBread->hypixelgp_plays : 0;
        $retro_tkr = !empty($player_decoded_url->player->stats->GingerBread->retro_plays) ? $player_decoded_url->player->stats->GingerBread->retro_plays : 0;
        $canyon_tkr = !empty($player_decoded_url->player->stats->GingerBread->canyon_plays) ? $player_decoded_url->player->stats->GingerBread->canyon_plays : 0;

        if (alreadyInPlayerTable($connection, $uuid)) {
        	$query = "UPDATE player SET name = ?, kills_paintball = ?, wins_paintball = ?, kill_prefix_paintball = ?, coins_paintball = ?, deaths_paintball = ?, forcefield_time_paintball = ?, killstreaks_paintball = ?, shots_fired_paintball = ?, hat_paintball = ?, adrenaline_paintball = ?, endurance_paintball = ?, fortune_paintball = ?, godfather_paintball = ?, headstart_paintball = ?, superluck_paintball = ?, transfusion_paintball = ?, karma = ?, most_recent_game = ?, achievement_points = ?, rank_colour = ?, coins_quake = ?, deaths_quake = ?, kills_quake = ?, killstreaks_quake = ?, wins_quake = ?, kills_teams_quake = ?, deaths_teams_quake = ?, wins_teams_quake = ?, killstreaks_teams_quake = ?, highest_killstreak_quake = ?, shots_fired_teams_quake = ?, headshots_teams_quake = ?, headshots_quake = ?, shots_fired_quake = ?, distance_travelled_teams_quake = ?, distance_travelled_quake = ?, coins_arena = ?, coins_spent_arena = ?, keys_arena = ?, rating_arena = ?, damage_2v2_arena = ?, damage_4v4_arena = ?, damage_1v1_arena = ?, deaths_2v2_arena = ?, deaths_4v4_arena = ?, deaths_1v1_arena = ?, games_2v2_arena = ?, games_4v4_arena = ?, games_1v1_arena = ?, healed_2v2_arena = ?, healed_4v4_arena = ?, healed_1v1_arena = ?, kills_2v2_arena = ?, kills_4v4_arena = ?, kills_1v1_arena = ?, losses_2v2_arena = ?, losses_4v4_arena = ?, losses_1v1_arena = ?, wins_2v2_arena = ?, wins_4v4_arena = ?, wins_1v1_arena = ?, rank = ?, coins_tkr = ?, box_pickups_tkr = ?, coins_picked_up_tkr = ?, silver_trophy_tkr = ?, wins_tkr = ?, laps_completed_tkr = ?, gold_trophy_tkr = ?, bronze_trophy_tkr = ?, olympus_tkr = ?, junglerush_tkr = ?, hypixelgp_tkr = ?, retro_tkr = ?, canyon_tkr = ?, last_updated = now() WHERE UUID = '" . $uuid . "'";

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "siisiiiiisiiiiiiiisisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiiiii", $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $headstart_paintball, $superluck_paintball, $transfusion_paintball, $karma, $most_recent_game, $achievement_points, $rank_colour, $coins_quake, $deaths_quake, $kills_quake, $killstreaks_quake, $wins_quake, $kills_teams_quake, $deaths_teams_quake, $wins_teams_quake, $killstreaks_teams_quake, $highest_killstreak_quake, $shots_fired_teams_quake, $headshots_teams_quake, $headshots_quake, $shots_fired_quake, $distance_travelled_teams_quake, $distance_travelled_quake, $coins_arena, $coins_spent_arena, $keys_arena, $rating_arena, $damage_2v2_arena, $damage_4v4_arena, $damage_1v1_arena, $deaths_2v2_arena, $deaths_4v4_arena, $deaths_1v1_arena, $games_2v2_arena, $games_4v4_arena, $games_1v1_arena, $healed_2v2_arena, $healed_4v4_arena, $healed_1v1_arena, $kills_2v2_arena, $kills_4v4_arena, $kills_1v1_arena, $losses_2v2_arena, $losses_4v4_arena, $losses_1v1_arena, $wins_2v2_arena, $wins_4v4_arena, $wins_1v1_arena, $rank, $coins_tkr, $box_pickups_tkr, $coins_picked_up_tkr, $silver_trophy_tkr, $wins_tkr, $laps_completed_tkr, $gold_trophy_tkr, $bronze_trophy_tkr, $olympus_tkr, $junglerush_tkr, $hypixelgp_tkr, $retro_tkr, $canyon_tkr);
	            mysqli_stmt_execute($statement);
	            return true;
	        } else {
	            echo '<b>[ERROR:1] ' . $name . ' </b>An Error Occured!<br>'; 
	            return false;
	        }
        } else {
			$query = "INSERT INTO player (UUID, name, kills_paintball, wins_paintball, kill_prefix_paintball, coins_paintball, deaths_paintball, forcefield_time_paintball, killstreaks_paintball, shots_fired_paintball, hat_paintball, adrenaline_paintball, endurance_paintball, fortune_paintball, godfather_paintball, headstart_paintball, superluck_paintball, transfusion_paintball, karma, most_recent_game, achievement_points, rank_colour, coins_quake, deaths_quake, kills_quake, killstreaks_quake, wins_quake, kills_teams_quake, deaths_teams_quake, wins_teams_quake, killstreaks_teams_quake, highest_killstreak_quake, shots_fired_teams_quake, headshots_teams_quake, headshots_quake, shots_fired_quake, distance_travelled_teams_quake, distance_travelled_quake, coins_arena, coins_spent_arena, keys_arena, rating_arena, damage_2v2_arena, damage_4v4_arena, damage_1v1_arena, deaths_2v2_arena, deaths_4v4_arena, deaths_1v1_arena, games_2v2_arena, games_4v4_arena, games_1v1_arena, healed_2v2_arena, healed_4v4_arena, healed_1v1_arena, kills_2v2_arena, kills_4v4_arena, kills_1v1_arena, losses_2v2_arena, losses_4v4_arena, losses_1v1_arena, wins_2v2_arena, wins_4v4_arena, wins_1v1_arena, rank, coins_tkr, box_pickups_tkr, coins_picked_up_tkr, silver_trophy_tkr, wins_tkr, laps_completed_tkr, gold_trophy_tkr, bronze_trophy_tkr, olympus_tkr, junglerush_tkr, hypixelgp_tkr, retro_tkr, canyon_tkr, last_updated)
	                    		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "ssiisiiiiisiiiiiiiisisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiiiii", $uuid, $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $headstart_paintball, $superluck_paintball, $transfusion_paintball, $karma, $most_recent_game, $achievement_points, $rank_colour, $coins_quake, $deaths_quake, $kills_quake, $killstreaks_quake, $wins_quake, $kills_teams_quake, $deaths_teams_quake, $wins_teams_quake, $killstreaks_teams_quake, $highest_killstreak_quake, $shots_fired_teams_quake, $headshots_teams_quake, $headshots_quake, $shots_fired_quake, $distance_travelled_teams_quake, $distance_travelled_quake, $coins_arena, $coins_spent_arena, $keys_arena, $rating_arena, $damage_2v2_arena, $damage_4v4_arena, $damage_1v1_arena, $deaths_2v2_arena, $deaths_4v4_arena, $deaths_1v1_arena, $games_2v2_arena, $games_4v4_arena, $games_1v1_arena, $healed_2v2_arena, $healed_4v4_arena, $healed_1v1_arena, $kills_2v2_arena, $kills_4v4_arena, $kills_1v1_arena, $losses_2v2_arena, $losses_4v4_arena, $losses_1v1_arena, $wins_2v2_arena, $wins_4v4_arena, $wins_1v1_arena, $rank, $coins_tkr, $box_pickups_tkr, $coins_picked_up_tkr, $silver_trophy_tkr, $wins_tkr, $laps_completed_tkr, $gold_trophy_tkr, $bronze_trophy_tkr, $olympus_tkr, $junglerush_tkr, $hypixelgp_tkr, $retro_tkr, $canyon_tkr);
	            mysqli_stmt_execute($statement);
	            return true;
	        } else {
	            echo '<b>[ERROR:2] ' . $name . ' </b>An Error Occured!<br>'; 
	            return false;
	        }
	    }

	}

	function alreadyInPlayerTable($connection, $uuid) {
		$query = "SELECT * FROM player WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
	}

	function getPlayerInformation($connection, $uuid) {
        $query = "SELECT * FROM player WHERE UUID = '" . $uuid . "'";
        $result = $connection->query($query);
        return $result;
	}

	function getPlayersGuild($connection, $uuid, $API_KEY) {
		$api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&player=" . $uuid);
		$decoded_url  = json_decode($api_guild_url);
		return $decoded_url;
	}

?>