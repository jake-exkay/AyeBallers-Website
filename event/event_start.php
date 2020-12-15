<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";
    include "../functions/functions.php";

    if (devViewing($connection, $DEV_IP)) {
        if (eventStatus($connection) == 1) {
            header("Refresh:0.01; url=../error/event/event_started.php");
        } elseif (eventStatus($connection) == 2) {
            header("Refresh:0.01; url=../error/event/event_finished.php");
        } else {

            $truncate_query = "DELETE FROM event_backup";

            if ($truncate_statement = mysqli_prepare($connection, $truncate_query)) {
                mysqli_stmt_execute($truncate_statement);
            } else {
                echo 'Error truncating backup table <br>' . mysqli_error($connection); 
            }

            echo '
                <center>
                    <b>
                        <h1 style="padding-top: 400px; font-family: BKANT, sans-serif">Loading...</h1>
                    </b>
                    <h3 style="font-family: BKANT, sans-serif">Getting user data from Hypixel API...</h2>
                    <h3>You will be redirected when loading is complete.</h3>
                </center>
            ';

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

                changeEventStatus($connection, 1);
                insertNewPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour);
                insertBackupPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour);

                header("Refresh:0.01; url=leaderboard.php");
            }

            updateLog($connection, 'E_START');

        }
    } else {
        header("Refresh:0.01; url=../error/403.php");
    }

    $connection->close();

?>