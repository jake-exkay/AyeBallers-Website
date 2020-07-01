<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "../functions/functions.php";
    include "event_functions.php";

    if (!eventStatus($connection) == 1) {
        header("Refresh:0.01; url=../error/event/event_not_running.php");
    } elseif (apiLimitReached($API_KEY)) {
        header("Refresh:0.01; url=../error/api_request.php");
    } else {

        foreach($participants as $uuid) {
            $player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
            $player_decoded_url = json_decode($player_url);

            $name = getRealName($connection, $uuid);

            $current_kills = 0;
            $current_wins = 0;
            $current_forcefield = 0;
            $current_deaths = 0;

            $current_kills = !empty($player_decoded_url->player->stats->Paintball->kills) ? $player_decoded_url->player->stats->Paintball->kills : 0;
            $current_wins = !empty($player_decoded_url->player->stats->Paintball->wins) ? $player_decoded_url->player->stats->Paintball->wins : 0;
            $current_deaths = !empty($player_decoded_url->player->stats->Paintball->deaths) ? $player_decoded_url->player->stats->Paintball->deaths : 0;
            $current_forcefield = !empty($player_decoded_url->player->stats->Paintball->forcefieldTime) ? $player_decoded_url->player->stats->Paintball->forcefieldTime : 0;

            $zero = 0;

            if (isPlayerInDatabase($connection, $uuid)) {
                $total_points = calculatePoints($connection, $uuid, $current_kills, $current_wins, $current_deaths, $current_forcefield);
                updatePlayer($connection, $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid, $name);
            } else {
                insertNewPlayer($connection, $uuid, $name, $current_kills, $current_wins, $current_forcefield, $current_deaths, $zero);
            }

            setLastUpdated($connection);

            header("Refresh:0.01; url=leaderboard.php");
        }

    }

    $connection->close();

?>