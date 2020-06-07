<?php

	include "../includes/connect.php";
    include "event_functions.php";

    $last_updated_query = "SELECT * FROM event_management";
    $last_updated_result = $connection->query($last_updated_query);

    if ($last_updated_result->num_rows > 0) {
        while($last_updated_row = $last_updated_result->fetch_assoc()) {
            $last_updated = $last_updated_row['last_updated'];
            $event_started = $last_updated_row['event_started'];
        }
    }

    if ($event_started == 0) {
        echo "Error: Event has not started";
        header("Refresh:2; url=leaderboard.php");
    }

    $start_date = new DateTime($last_updated);
    $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

    if ($since_start->i >= 10 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {

        $truncate_paintball_query = "DELETE FROM paintball_overall";

        if($truncate_paintball_statement = mysqli_prepare($connection, $truncate_paintball_query)) {
            mysqli_stmt_execute($truncate_paintball_statement);
        } else {
            echo 'Error truncating paintball<br>' . mysqli_error($connection); 
        }

        foreach($top_100 as $uuid) {
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

            // GENERAL CHECKS
            $rank = !empty($player_decoded_url->player->packageRank) ? $player_decoded_url->player->packageRank : 'Error';
            $mvp_plus_colour = !empty($player_decoded_url->player->rankPlusColor) ? $player_decoded_url->player->rankPlusColor : 'Error';

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

            // PAINTBALL INSERT
            $query_paintball = "INSERT INTO paintball_overall (UUID, kills, wins, coins, shots_fired, deaths, godfather, endurance, superluck, fortune, headstart, adrenaline, forcefield_time, killstreaks, transfusion, hat, rank, mvp_plus_colour, last_updated, name)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";

            if($statement_paintball = mysqli_prepare($connection, $query_paintball)) {
                mysqli_stmt_bind_param($statement_paintball, "siiiiiiiiiiisiissss", $uuid, $kills_paintball, $wins_paintball, $coins_paintball, $shots_fired_paintball, $deaths_paintball, $godfather_paintball, $endurance_paintball, $superluck_paintball, $fortune_paintball, $headstart_paintball, $adrenaline_paintball, $forcefield_time_paintball, $killstreaks_paintball, $transfusion_paintball, $hat_paintball, $rank, $mvp_plus_colour, $name);
                mysqli_stmt_execute($statement_paintball);
            } else {
                echo '<b>[PAINTBALL] '.$name.' </b>An Error Occured!<br>'; 
            }

            header("Refresh:0.01; url=classic/overall/paintball.php");
        }
    } else {
        echo "Database was updated less than an 10 minutes ago. Redirecting.";
        header("Refresh:2; url=classic/overall/paintball.php");
    }

    $connection->close();

?>