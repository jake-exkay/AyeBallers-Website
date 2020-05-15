<?php

	include "CONSTANTS.php";

    $connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASS, $DB_NAME);
           
    if($connection->connect_error) {
        echo 'Error connecting to the database';
    }

    $api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=".$API_KEY."&player=82df5a8fa7934e6087d186d8741a1d23");
    $decoded_url  = json_decode($api_guild_url);
    $guild_members = $decoded_url->guild->members;

    $truncate_query = "
    TRUNCATE paintball; 
    TRUNCATE tntgames;
    TRUNCATE quakecraft;";

    if($truncate_statement = mysqli_prepare($connection, $truncate_query)) {
        mysqli_stmt_execute($truncate_statement);
        echo 'Truncated tables successfully!<br>'; 
    } else {
        echo 'Error truncating tables<br>' . mysqli_error($connection); 
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
        $headshots_quakecraft = 0;
        $deaths_quakecraft = 0;
        $coins_quakecraft = 0;
        $shots_fired_quakecraft = 0;
        $killstreaks_quakecraft = 0;

        // GENERAL CHECKS
        if (!empty($player_decoded_url->player->packageRank)) {
            $rank = $player_decoded_url->player->packageRank;
        } else {
            $rank = "Error";
        }

        if (!empty($player_decoded_url->player->rankPlusColor)) {
            $mvp_plus_colour = $player_decoded_url->player->rankPlusColor;
        } else {
            $mvp_plus_colour = "Error";
        }

        // TNT GAMES CHECKS
        if (!empty($player_decoded_url->player->stats->TNTGames->wins_tntrun)) {
            $wins_tntrun = $player_decoded_url->player->stats->TNTGames->wins_tntrun;
        } else {
            $wins_tntrun = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->wins_bowspleef)) {
            $wins_bowspleef = $player_decoded_url->player->stats->TNTGames->wins_bowspleef;
        } else {
            $wins_bowspleef = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->wins_pvprun)) {
            $wins_pvprun = $player_decoded_url->player->stats->TNTGames->wins_pvprun;
        } else {
            $wins_pvprun = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->wins_tntag)) {
            $wins_tntag = $player_decoded_url->player->stats->TNTGames->wins_tntag;
        } else {
            $wins_tntag = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->coins)) {
            $coins_tntgames = $player_decoded_url->player->stats->TNTGames->coins;
        } else {
            $coins_tntgames = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->kills_capture)) {
            $kills_wizards = $player_decoded_url->player->stats->TNTGames->kills_capture;
        } else {
            $kills_wizards = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->wins_capture)) {
            $wins_wizards = $player_decoded_url->player->stats->TNTGames->wins_capture;
        } else {
            $wins_wizards = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->wins)) {
            $total_wins_tntgames = $player_decoded_url->player->stats->TNTGames->wins;
        } else {
            $total_wins_tntgames = 0;
        }

        if (!empty($player_decoded_url->player->stats->TNTGames->kills_pvprun)) {
            $kills_pvprun = $player_decoded_url->player->stats->TNTGames->kills_pvprun;
        } else {
            $kills_pvprun = 0;
        }

        // PAINTBALL CHECKS
        if (!empty($player_decoded_url->player->stats->Paintball->kills)) {
            $kills_paintball = $player_decoded_url->player->stats->Paintball->kills;
        } else {
            $kills_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->wins)) {
            $wins_paintball = $player_decoded_url->player->stats->Paintball->wins;
        } else {
            $wins_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->coins)) {
            $coins_paintball = $player_decoded_url->player->stats->Paintball->coins;
        } else {
            $coins_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->shots_fired)) {
            $shots_fired_paintball = $player_decoded_url->player->stats->Paintball->shots_fired;
        } else {
            $shots_fired_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->deaths)) {
            $deaths_paintball = $player_decoded_url->player->stats->Paintball->deaths;
        } else {
            $deaths_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->godfather)) {
            $godfather_paintball = $player_decoded_url->player->stats->Paintball->godfather;
        } else {
            $godfather_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->endurance)) {
            $endurance_paintball = $player_decoded_url->player->stats->Paintball->endurance;
        } else {
            $endurance_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->superluck)) {
            $superluck_paintball = $player_decoded_url->player->stats->Paintball->superluck;
        } else {
            $superluck_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->fortune)) {
            $fortune_paintball = $player_decoded_url->player->stats->Paintball->fortune;
        } else {
            $fortune_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->headstart)) {
            $headstart_paintball = $player_decoded_url->player->stats->Paintball->headstart;
        } else {
            $headstart_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->adrenaline)) {
            $adrenaline_paintball = $player_decoded_url->player->stats->Paintball->adrenaline;
        } else {
            $adrenaline_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->forcefieldTime)) {
            $forcefield_time_paintball = $player_decoded_url->player->stats->Paintball->forcefieldTime;
        } else {
            $forcefield_time_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->killstreaks)) {
            $killstreaks_paintball = $player_decoded_url->player->stats->Paintball->killstreaks;
        } else {
            $killstreaks_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->transfusion)) {
            $transfusion_paintball = $player_decoded_url->player->stats->Paintball->transfusion;
        } else {
            $transfusion_paintball = 0;
        }

        if (!empty($player_decoded_url->player->stats->Paintball->hat)) {
            $hat_paintball = $player_decoded_url->player->stats->Paintball->hat;
        } else {
            $hat_paintball = 0;
        }

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
        if (!empty($player_decoded_url->player->stats->Quake->kills)) {
            $kills_quakecraft = $player_decoded_url->player->stats->Quake->kills;
        } else {
            $kills_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->wins)) {
            $wins_quakecraft = $player_decoded_url->player->stats->Quake->wins;
        } else {
            $wins_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->coins)) {
            $coins_quakecraft = $player_decoded_url->player->stats->Quake->coins;
        } else {
            $coins_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->shots_fired)) {
            $shots_fired_quakecraft = $player_decoded_url->player->stats->Quake->shots_fired;
        } else {
            $shots_fired_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->deaths)) {
            $deaths_quakecraft = $player_decoded_url->player->stats->Quake->deaths;
        } else {
            $deaths_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->headshots)) {
            $headshots_quakecraft = $player_decoded_url->player->stats->Quake->headshots;
        } else {
            $headshots_quakecraft = 0;
        }

        if (!empty($player_decoded_url->player->stats->Quake->killstreaks)) {
            $killstreaks_quakecraft = $player_decoded_url->player->stats->Quake->killstreaks;
        } else {
            $killstreaks_quakecraft = 0;
        }


        // TNT GAMES INSERT
        $query_tntgames = "INSERT INTO tntgames (UUID, name, last_updated, mvp_plus_colour, rank, coins, wizards_kills, wins_bowspeef, wins_wizards, wins_tntrun, total_wins, kills_pvprun, wins_tnttag, wins_pvprun)
            VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($statement_tntgames = mysqli_prepare($connection, $query_tntgames)) {
            mysqli_stmt_bind_param($statement_tntgames, "ssssiiiiiiiii", $uuid, $name, $mvp_plus_colour, $rank, $coins_tntgames, $kills_wizards, $wins_bowspleef, $wins_wizards, $wins_tntrun, $total_wins_tntgames, $kills_pvprun, $wins_tntag, $wins_pvprun);
            mysqli_stmt_execute($statement_tntgames);
            echo '<b>[TNT GAMES] '.$name.' </b>Successfully Inserted!<br>'; 
        } else {
            echo '<b>[TNT GAMES] '.$name.' </b>An Error Occured!<br>'; 
        }

        // PAINTBALL INSERT
        $query_paintball = "INSERT INTO paintball (UUID, kills, wins, coins, shots_fired, deaths, godfather, endurance, superluck, fortune, headstart, adrenaline, forcefield_time, killstreaks, transfusion, hat, rank, mvp_plus_colour, last_updated, name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";

        if($statement_paintball = mysqli_prepare($connection, $query_paintball)) {
            mysqli_stmt_bind_param($statement_paintball, "siiiiiiiiiiisiissss", $uuid, $kills_paintball, $wins_paintball, $coins_paintball, $shots_fired_paintball, $deaths_paintball, $godfather_paintball, $endurance_paintball, $superluck_paintball, $fortune_paintball, $headstart_paintball, $adrenaline_paintball, $forcefield_time_paintball, $killstreaks_paintball, $transfusion_paintball, $hat_paintball, $rank, $mvp_plus_colour, $name);
            mysqli_stmt_execute($statement_paintball);
            echo '<b>[PAINTBALL] '.$name.' </b>Successfully Inserted!<br>'; 
        } else {
            echo '<b>[PAINTBALL] '.$name.' </b>An Error Occured!<br>'; 
        }

        // QUAKECRAFT INSERT
        $query_quakecraft = "INSERT INTO quakecraft (UUID, kills, wins, coins, shots_fired, deaths, headshots, killstreaks, rank, mvp_plus_colour, last_updated, name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), ?)";

        if($statement_quakecraft = mysqli_prepare($connection, $query_quakecraft)) {
            mysqli_stmt_bind_param($statement_quakecraft, "siiiiiiisss", $uuid, $kills_quakecraft, $wins_quakecraft, $coins_quakecraft, $shots_fired_quakecraft, $deaths_quakecraft, $headshots_quakecraft, $killstreaks_quakecraft, $rank, $mvp_plus_colour, $name);
            mysqli_stmt_execute($statement_quakecraft);
            echo '<b>[QUAKE] '.$name.' </b>Successfully Inserted!<br>'; 
        } else {
            echo '<b>[QUAKE] '.$name.' </b>An Error Occured!<br>' . mysqli_error($connection); 
        }


    }


?>