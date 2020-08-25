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

            $current_wins = 0;
            $current_wins = !empty($player_decoded_url->player->stats->Walls3->wins) ? $player_decoded_url->player->stats->Walls3->wins : 0;

            if (isPlayerInDatabase($connection, $uuid)) {
                updatePlayer($connection, $current_wins, $uuid, $name);
            } else {
                insertNewPlayer($connection, $uuid, $name, $current_wins);
            }

            setLastUpdated($connection);

            header("Refresh:0.01; url=megawalls.php");
        }

        updateLog($connection, 'E_UPDATE');

    }

    $connection->close();

?>