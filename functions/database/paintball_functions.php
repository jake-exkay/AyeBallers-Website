<?php

	include "../../../includes/connect.php";

	$err = "Error";

	function getOverallLeaderboard($connection) {
		$query = "SELECT * FROM paintball_overall ORDER BY kills DESC";
        $result = $connection->query($query);
        return $result;
	}

?>