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

?>