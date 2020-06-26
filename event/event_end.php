<?php

	include "../includes/connect.php";
    include "../includes/constants.php";
    include "event_functions.php";

    if (!eventStarted($connection)) {
        echo "Error: Event has not started. Redirecting.";
        header("Refresh:2; url=leaderboard.php");
    } else {
        foreach($participants as $uuid) {
            echo "Event Ended. Redirecting.";

            changeEventStatus($connection, 0);

            header("Refresh:2; url=leaderboard.php");
        }
    }

    $connection->close();

?>