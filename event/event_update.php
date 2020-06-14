<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";

    if (!eventStarted($connection)) {
        echo "Error: Event has not started";
        header("Refresh:2; url=leaderboard.php");
    } elseif (apiLimitReached($API_KEY)) {
        echo "Error: Too many concurrent API requests, please try again in a minute.";
        header("Refresh:2; url=leaderboard.php");
    } else {

        if (needsUpdating($connection)) {

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

                $total_points = calculatePoints($connection, $uuid, $current_kills, $current_wins, $current_deaths, $current_forcefield);

                updatePlayer($connection, $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid, $name);

                setLastUpdated($connection);

                header("Refresh:0.01; url=leaderboard.php");
            }
        } else {
            echo "Database was updated less than an 10 minutes ago. Redirecting.";
            header("Refresh:2; url=leaderboard.php");
        }

    }

    $connection->close();

?>