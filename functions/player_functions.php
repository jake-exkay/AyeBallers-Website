<?php

	function updatePlayerInDatabase($connection, $uuid, $name, $API_KEY) {
		$player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
		$player_decoded_url = json_decode($player_url);

		$rank = !empty($player_decoded_url->player->packageRank) ? $player_decoded_url->player->packageRank : 'Error';
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
        $hat_paintball = !empty($player_decoded_url->player->stats->Paintball->hat) ? $player_decoded_url->player->stats->Paintball->hat : "No Hat";
        $kill_prefix_paintball = !empty($player_decoded_url->player->stats->Paintball->selectedKillPrefix) ? $player_decoded_url->player->stats->Paintball->selectedKillPrefix : "No Hat";

        if (alreadyInPlayerTable($connection, $uuid)) {
        	$query = "UPDATE player SET name = ?, kills_paintball = ?, wins_paintball = ?, kill_prefix_paintball = ?, coins_paintball = ?, deaths_paintball = ?, forcefield_time_paintball = ?, killstreaks_paintball = ?, shots_fired_paintball = ?, hat_paintball = ?, adrenaline_paintball = ?, endurance_paintball = ?, fortune_paintball = ?, godfather_paintball = ?, headstart_paintball = ?, superluck_paintball = ?, transfusion_paintball = ?, last_updated = now() WHERE UUID = '" . $uuid . "'";

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "siisiiiiisiiiiiii", $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $headstart_paintball, $superluck_paintball, $transfusion_paintball);
	            mysqli_stmt_execute($statement);
	            return true;
	        } else {
	            echo '<b>[ERROR:1] ' . $name . ' </b>An Error Occured!<br>'; 
	            return false;
	        }
        } else {
			$query = "INSERT INTO player (UUID, name, kills_paintball, wins_paintball, kill_prefix_paintball, coins_paintball, deaths_paintball, forcefield_time_paintball, killstreaks_paintball, shots_fired_paintball, hat_paintball, adrenaline_paintball, endurance_paintball, fortune_paintball, godfather_paintball, headstart_paintball, superluck_paintball, transfusion_paintball, last_updated)
	                    		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";

	        if($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "ssiisiiiiisiiiiiii", $uuid, $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $headstart_paintball, $superluck_paintball, $transfusion_paintball);
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

?>