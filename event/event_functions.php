<?php

    include "../includes/connect.php";
    include "../includes/constants.php";

    $participants = array();

    function eventStarted($connection) {
        $query = "SELECT * FROM event_management";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $event_started = $row['event_started'];
            }
        }

        if ($event_started == 1 || (!empty($event_started))) {
            return true;
        } else {
            return false;
        }
    }

    function needsUpdating($connection) {
        $last_updated_query = "SELECT * FROM event_management";
        $last_updated_result = $connection->query($last_updated_query);

        if ($last_updated_result->num_rows > 0) {
            while($last_updated_row = $last_updated_result->fetch_assoc()) {
                $last_updated = $last_updated_row['last_updated'];
            }
        }

        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        if (empty($last_updated) || $since_start->i >= 5 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {
            return true;
        } else {
            return false;
        }
    }

    function calculatePoints($connection, $uuid, $kills, $wins, $deaths, $ff) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $starting_kills = $row['starting_kills'];
                $starting_wins = $row['starting_wins'];
                $starting_ff = $row['starting_ff'];
                $starting_deaths = $row['starting_deaths'];
            }
        }

        $kills_points = $kills - $starting_kills;
        $wins_points = $wins - $starting_wins;
        $ff_points = $ff - $starting_ff;
        $deaths_points = $deaths - $starting_deaths;

        $total_points = $kills_points + ($wins_points * 15) + ($ff_points * 5 / 60) - $deaths_points;
        return $total_points;
       
    }

    function setLastUpdated($connection) {
        $last_updated_query = "UPDATE event_management SET last_updated = now()";

        if($last_updated_statement = mysqli_prepare($connection, $last_updated_query)) {
            mysqli_stmt_execute($last_updated_statement);
        } else {
            echo '<b>[ERROR] </b>An Error Occured Updating Time!<br>'; 
        }
    }

    function updatePlayer($connection, $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid, $name) {
        $query = "UPDATE event SET total_points = ?, current_kills = ?, current_deaths = ?, current_wins = ?, current_ff = ? WHERE UUID = ?";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "iiiiis", $total_points, $current_kills, $current_deaths, $current_wins, $current_forcefield, $uuid);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function insertNewPlayer($connection, $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero) {
        $query = "INSERT INTO event (UUID, name, starting_kills, starting_wins, starting_ff, starting_deaths, total_points, current_kills, current_wins, current_ff, current_deaths)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiii", $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero, $kills, $wins, $forcefield_time, $deaths);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PAINTBALL] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
        }
    }

    function isPlayerInDatabase($connection, $uuid) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

?>