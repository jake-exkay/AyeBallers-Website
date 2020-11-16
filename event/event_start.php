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

                $name = getRealName($connection, $uuid);

                $wins = 0;

                $wins = !empty($player_decoded_url->player->stats->Walls3->wins) ? $player_decoded_url->player->stats->Walls3->wins : 0;
                $fo_wins = !empty($player_decoded_url->player->stats->Walls3->wins_face_off) ? $player_decoded_url->player->stats->Walls3->wins_face_off : 0;
                $standard_wins = $wins - $fo_wins;

                changeEventStatus($connection, 1);
                insertNewPlayer($connection, $uuid, $name, $standard_wins);
                insertBackupPlayer($connection, $uuid, $name, $standard_wins);

                header("Refresh:0.01; url=megawalls.php");
            }

            updateLog($connection, 'E_START');

        }
    } else {
        header("Refresh:0.01; url=../error/403.php");
    }

    $connection->close();

?>