<?php

	include "../includes/connect.php";
    include "event_functions.php";

    if (eventStarted()) {
        echo "Error: Event has not started";
        header("Refresh:2; url=leaderboard.php");
    }

    if (needsUpdating()) {

        foreach($participants as $uuid) {
            $player_url = file_get_contents("https://api.hypixel.net/player?key=".$API_KEY."&uuid=".$uuid);
            $player_decoded_url = json_decode($player_url);
            $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/".$uuid."/names");
            $mojang_decoded_url = json_decode($mojang_url, true);
            $real_name = array_pop($mojang_decoded_url);
            $name = $real_name['name'];

            $current_kills = 0;
            $current_wins = 0;
            $current_forcefield = 0;
            $current_deaths = 0;

            $current_kills = !empty($player_decoded_url->player->stats->Paintball->kills) ? $player_decoded_url->player->stats->Paintball->kills : 0;
            $current_wins = !empty($player_decoded_url->player->stats->Paintball->wins) ? $player_decoded_url->player->stats->Paintball->wins : 0;
            $current_deaths = !empty($player_decoded_url->player->stats->Paintball->deaths) ? $player_decoded_url->player->stats->Paintball->deaths : 0;
            $current_forcefield = !empty($player_decoded_url->player->stats->Paintball->forcefieldTime) ? $player_decoded_url->player->stats->Paintball->forcefieldTime : 0;

            $query = "UPDATE event SET current_kills = ?, current_deaths = ?, current_wins = ?, current_forcefield = ? WHERE UUID = ?";

            if($statement = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($statement, "iiiss", $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid);
                mysqli_stmt_execute($statement);
            } else {
                echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
            }

            header("Refresh:0.01; url=leaderboard.php");
        }
    } else {
        echo "Database was updated less than an 10 minutes ago. Redirecting.";
        header("Refresh:2; url=leaderboard.php");
    }

    $connection->close();

?>