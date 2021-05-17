<?php

    $participants = array('82df5a8fa7934e6087d186d8741a1d23','38839c0e43ac4b1aa0e6c189ca15412f', 'fe101e8a30d14137b1101bd22031bf35', '4e8f4a8960e3458f86f8cc59ea06d1eb', '31ff34353b4c451aa0a14d1185e17f68', '4533c7cd718d4fd1b46b1376e5849ac4');

    function eventStatus($connection) {
        $query = "SELECT * FROM event_management";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $event_started = $row['event_started'];
            }
        }

        return $event_started;
    }

    function updateLog($connection, $event_function) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $query = "INSERT INTO update_log (IP, time_update, function)
                  VALUES (?, now(), ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ss", $ip, $event_function);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[LOG]</b> An Error Occured!<br>'; 
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

    function calculatePoints($connection, $uuid) {
        $query = "SELECT * FROM event WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $starting_wins = $row['starting_wins'];
                $current_wins = $row['current_wins'];
                $starting_kills = $row['starting_kills'];
                $current_kills = $row['current_kills'];
                $starting_deaths = $row['starting_deaths'];
                $current_deaths = $row['current_deaths'];
                $starting_ff = $row['starting_ff'];
                $current_ff = $row['current_ff'];
            }
        }

        $wins_points = ($current_wins - $starting_wins) * 5;
        $kills_points = $current_kills - $starting_kills;
        $deaths_points = $current_deaths - $starting_deaths;
        $ff_points = ($current_ff - $starting_ff) * 3;

        return ($wins_points + $kills_points + $ff_points - $deaths_points);
       
    }

    function setLastUpdated($connection) {
        $last_updated_query = "UPDATE event_management SET last_updated = now()";

        if($last_updated_statement = mysqli_prepare($connection, $last_updated_query)) {
            mysqli_stmt_execute($last_updated_statement);
        } else {
            echo '<b>[ERROR] </b>An Error Occured Updating Time!<br>'; 
        }
    }

    function updateTournamentPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour) {
        $query = "UPDATE event SET rank = ?, rank_colour = ?, current_wins = ?, current_kills = ?, current_ff = ?, current_deaths = ?, total_points = ? WHERE UUID = ?";

        $points = calculatePoints($connection, $uuid);

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiis", $rank, $rank_colour, $wins, $kills, $forcefield_time, $deaths, $points, $uuid);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function insertNewPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour) {
        $query = "INSERT INTO event (UUID, name, starting_wins, current_wins, starting_kills, current_kills, starting_ff, current_ff, starting_deaths, current_deaths, rank, rank_colour, total_points)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $zero = 0;

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiissi", $uuid, $name, $wins, $wins, $kills, $kills, $forcefield_time, $forcefield_time, $deaths, $deaths, $rank, $rank_colour, $zero);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PB] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
        }
    }

    function insertBackupPlayer($connection, $uuid, $name, $wins, $deaths, $forcefield_time, $kills, $rank, $rank_colour) {
        $query = "INSERT INTO event_backup (UUID, name, starting_wins, current_wins, starting_kills, current_kills, starting_ff, current_ff, starting_deaths, current_deaths, rank, rank_colour, total_points)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $zero = 0;

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiissi", $uuid, $name, $wins, $wins, $kills, $kills, $forcefield_time, $forcefield_time, $deaths, $deaths, $rank, $rank_colour, $zero);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PB] ' . $name . ' </b>An Error Occured!<br> ' . $query . ' ' . mysqli_error($connection); 
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

    function changeEventStatus($connection, $status) {
        $query = "UPDATE event_management SET event_started = $status";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[ERROR] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function devViewing($connection, $dev_ip) {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($ip == $dev_ip) {
            return true;
        } else {
            return false;
        }
    }

    function getParticipantsData($connection) 
    {
        $query = "SELECT name, UUID, rank, rank_colour FROM event ORDER BY name";
        $result = $connection->query($query);
        return $result;
    }

    function getEventLeaderboard($connection) 
    {
        $query = "SELECT * FROM event ORDER BY total_points DESC";
        $result = $connection->query($query);
        return $result;
    }

?>