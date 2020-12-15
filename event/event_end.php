<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";
    include "../functions/functions.php";

    if (devViewing($connection, $DEV_IP)) {
        if (eventStatus($connection) == 0) {
            header("Refresh:0.01; url=../error/event/event_not_running.php");
        } else {
            echo "Event Ended. Redirecting.";

            changeEventStatus($connection, 2);
            updateLog($connection, 'E_END');

            header("Refresh:2; url=leaderboard.php");
        }
    } else {
        header("Refresh:0.01; url=../error/403.php");
    }

    $connection->close();

?>