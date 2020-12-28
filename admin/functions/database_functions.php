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
        return $count;
    }

    function getTotalCachedGuilds($mongo_mng) {
        $query = new MongoDB\Driver\Query([]);
        $res = $mongo_mng->executeQuery("ayeballers.guild", $query);
        $count = 0;
        foreach ($res as $i) {
            $count = $count + $i;
        }
        return $count;
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
        return $row['views'];
    }

    function getTotalPageViews($connection) {
        $query = "SELECT SUM(views) AS 'views' FROM page_views";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        $views = number_format($row['views']);
        return $views;
    }

?>