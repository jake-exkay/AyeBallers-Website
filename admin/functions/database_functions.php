<?php

    function getPageViews($connection, $page) {
        $query = "SELECT * FROM page_views WHERE page = '$page'";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['views'];
            }
        }
    }

    function getRecentLookups($connection) {
        $query = "SELECT * FROM stats_log ORDER BY updated_time DESC LIMIT 20";
        $result = $connection->query($query);
        return $result;
    }

    function getMostRecentLookup($connection) {
        $query = "SELECT * FROM stats_log ORDER BY updated_time DESC LIMIT 1";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row['action'];
            }
        }
    }

    function getLastWeekExperience($connection) {
        $week = array();

        $query = "SELECT * FROM exp_history ORDER BY day DESC LIMIT 7";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $exp = $row['exp'];
                array_push($week, $exp);
                return $week;
            }
        }
    }

    function getAdmins($connection) {
        $query = "SELECT * FROM user";
        $result = $connection->query($query);
        return $result;
    }

    function getTotalCachedPlayers($mongo_mng) {
        $query = new MongoDB\Driver\Query([]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        $count = 0;
        foreach ($res as $i) {
            $count = $count + $i;
        }
        return number_format($count);
    }

    function getTotalCachedGuilds($mongo_mng) {
        $query = new MongoDB\Driver\Query([]);
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $count = 0;
        foreach ($res as $i) {
            $count = $count + $i;
        }
        return number_format($count);
    }

    function getTotalAdmins($connection) {
        $query = "SELECT COUNT(*) AS 'admins' FROM user";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        return $row['admins'];
    }

    function getTotalTrackedPages($connection) {
        $query = "SELECT COUNT(*) AS 'views' FROM page_views";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        return number_format($row['views']);
    }

    function getTotalPlayerLookups($connection) {
        $query = "SELECT COUNT(*) AS 'views' FROM stats_log";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        return number_format($row['views']);
    }

    function getTotalPageViews($connection) {
        $query = "SELECT SUM(views) AS 'views' FROM page_views";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        $views = number_format($row['views']);
        return $views;
    }

?>