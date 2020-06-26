<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";

    if (eventStarted($connection)) {
        echo "Error: Event has already started. Redirecting.";
        header("Refresh:2; url=leaderboard.php");
    } else {
        foreach($participants as $uuid) {
            $player_url = file_get_contents("https://api.hypixel.net/player?key=".$API_KEY."&uuid=".$uuid);
            $player_decoded_url = json_decode($player_url);

            $name = getRealName($connection, $uuid);

            $kills = 0;
            $wins = 0;
            $deaths = 0;
            $forcefield_time = 0;

            $kills = !empty($player_decoded_url->player->stats->Paintball->kills) ? $player_decoded_url->player->stats->Paintball->kills : 0;
            $wins = !empty($player_decoded_url->player->stats->Paintball->wins) ? $player_decoded_url->player->stats->Paintball->wins : 0;
            $deaths = !empty($player_decoded_url->player->stats->Paintball->deaths) ? $player_decoded_url->player->stats->Paintball->deaths : 0;
            $forcefield_time = !empty($player_decoded_url->player->stats->Paintball->forcefieldTime) ? $player_decoded_url->player->stats->Paintball->forcefieldTime : 0;

            changeEventStatus($connection, 1);
            insertNewPlayer($connection, $uuid, $name, $kills, $wins, $forcefield_time, $deaths, 0);
            insertBackupPlayer($connection, $uuid, $name, $kills, $wins, $forcefield_time, $deaths, 0);

            header("Refresh:0.01; url=leaderboard.php");
        }
    }

    $connection->close();

?>