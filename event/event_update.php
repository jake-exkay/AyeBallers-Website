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

            $wins = 0;
            $kills = 0;
            $deaths = 0;
            $forcefield_time = 0;

            $gen = !empty($player_decoded_url->player) ? $player_decoded_url->player : "No Stats";

            $staff_rank = !empty($gen->rank) ? $gen->rank : "NONE";
            $monthly_package_rank = !empty($gen->monthlyPackageRank) ? $gen->monthlyPackageRank : "NONE";
            $package_rank = !empty($gen->packageRank) ? $gen->packageRank : "NONE";
            $new_package_rank = !empty($gen->newPackageRank) ? $gen->newPackageRank : "NONE";

            if ($staff_rank == "NORMAL" || $staff_rank == "NONE") {
                if ($monthly_package_rank == "NONE") {
                    if ($new_package_rank == "NONE") {
                        $rank = $package_rank;
                    } else {
                        $rank = $new_package_rank;
                    }
                } else {
                    $rank = $monthly_package_rank;
                }
            } else {
                $rank = $staff_rank;
            }

            $name = !empty($gen->displayname) ? $gen->displayname : "Unknown";
            $rank_colour = !empty($gen->rankPlusColor) ? $gen->rankPlusColor : "None";

            $wins = !empty($player_decoded_url->player->stats->Paintball->wins) ? $player_decoded_url->player->stats->Paintball->wins : 0;
            $kills = !empty($player_decoded_url->player->stats->Paintball->kills) ? $player_decoded_url->player->stats->Paintball->kills : 0;
            $deaths = !empty($player_decoded_url->player->stats->Paintball->deaths) ? $player_decoded_url->player->stats->Paintball->deaths : 0;
            $forcefield_time = !empty($player_decoded_url->player->stats->Paintball->forcefieldTime) ? $player_decoded_url->player->stats->Paintball->forcefieldTime : 0;

            if (isPlayerInDatabase($connection, $uuid)) {
                updateTournamentPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour);
            } else {
                insertNewPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour);
            }

            setLastUpdated($connection);

            header("Refresh:0.01; url=leaderboard.php");
        }

        updateLog($connection, 'E_UPDATE');

    }

    $connection->close();

?>