<?php

    include "../includes/connect.php";
    include "../includes/constants.php";

    $participants = array('9f16e788457c44fc8c24b90167569420','47d4bf0a89dd4eba9d198c03baf3b980','0f639d26aa51462f81b3d602604eb204','38839c0e43ac4b1aa0e6c189ca15412f','bb0b8eeedc584ee9bbf7c590d5aa2319','82df5a8fa7934e6087d186d8741a1d23','4995579a28f647dfbc03f33fd2aec058','83f44cd9ca9d4712a6bf9e618574f0de','84baea6eb660472eb9b8b20a3f446346','a82811c82b394da8a7767e28d9248a45','d052e63b70ba454d825326ca80b0ee0d','d1d9c04d16474a3cbb2cc1087747a7d2','56d9ab39794444d7ad77d8f3cb20ac78','718c6eaa52434a0e8f3d6c71b2ba6a0f','9a02fb46b9fa445fba8c5db62c9cbf3b','ff7ce8cdfdf64d3e8f91cad7a063ec53','648b236c66684bfbb622d01be7a2d5b3','60fb367459ae4f48812e16b28d8d8afa','3075f56a40ea4f14b1d754fdfc69f7b6','4abdba1d9b274bf7867d5bb4cda287ba','babaee4d60d34732ad3b6ac0775a5a33','82fc95c49afc4b8182b6cefeac42874e','aa6c6113f2e74be6ac14bd0417de66ff','96e0180e19a2494f8559e9cac1887acd','20f1f6cf342b466784acb60ddd9ee38c','43df06bcff994034b0e9bc7507d1f126');

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

    function timeSinceUpdate($last_updated) {
        $start_date = new DateTime($last_updated);
        $since_start = $start_date->diff(new DateTime(date('Y-m-d H:i:s')));

        $mins = $since_start->i;
        $hours = $since_start->h;
        $days = $since_start->d;

        return (($days * 60 * 60) + ($hours * 60) + $mins);
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

        if (empty($last_updated) || $since_start->i >= 10 || $since_start->y != 0 || $since_start->m != 0 || $since_start->d != 0 || $since_start->h != 0) {
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

    function getRealName($connection, $uuid) {
        $mojang_url = file_get_contents("https://api.mojang.com/user/profiles/" . $uuid . "/names");
        $mojang_decoded_url = json_decode($mojang_url, true);
        $real_name = array_pop($mojang_decoded_url);
        $name = $real_name['name'];
        return $name;
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
        $query = "INSERT INTO event (UUID, name, starting_kills, starting_wins, starting_ff, starting_deaths, total_points, last_updated, current_kills, current_wins, current_ff, current_deaths)
                  VALUES (?, ?, ?, ?, ?, ?, ?, now(), ?, ?, ?, ?)";

        if($statement = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($statement, "ssiiiiiiiii", $uuid, $name, $kills, $wins, $forcefield_time, $deaths, $zero, $kills, $wins, $forcefield_time, $deaths);
            mysqli_stmt_execute($statement);
        } else {
            echo '<b>[PAINTBALL] ' . $name . ' </b>An Error Occured!<br>'; 
        }
    }

    function apiLimitReached($API_KEY) {
        $url = file_get_contents("https://api.hypixel.net/key?key=" . $API_KEY);
        $decoded_url = json_decode($url);
        $queries = $decoded_url->record->queriesInPastMin;
        if ($queries >= 110) {
            return true;
        } else {
            return false;
        }
    }

?>