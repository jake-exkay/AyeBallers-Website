<?php

	function getOverallPaintballLeaderboard($connection) {
		$query = "SELECT * FROM paintball_overall ORDER BY kills DESC";
        $result = $connection->query($query);
        return $result;
	}

    function getOverallWallsLeaderboard($connection) {
        $query = "SELECT name, coins_walls, deaths_walls, assists_walls, wins_walls, losses_walls, kills_walls FROM player ORDER BY wins_walls DESC";
        $result = $connection->query($query);
        return $result;
    }

	function getTntLeaderboard($connection) {
        $query = "SELECT * FROM tntgames ORDER BY total_wins DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getBedwarsLeaderboard($connection) {
        $query = "SELECT * FROM bedwars ORDER BY wins DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getSkywarsLeaderboard($connection) {
        $query = "SELECT * FROM skywars ORDER BY wins DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getArenaLeaderboard($connection) {
        $query = "SELECT * FROM arena ORDER BY rating DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getQuakeLeaderboard($connection) {
        $query = "SELECT * FROM quakecraft ORDER BY kills DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getTkrLeaderboard($connection) {
        $query = "SELECT * FROM tkr ORDER BY gold_trophy DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getPaintballLeaderboard($connection) {
        $query = "SELECT * FROM paintball ORDER BY kills DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getVampirezLeaderboard($connection) {
        $query = "SELECT * FROM vampirez ORDER BY human_wins DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getWallsLeaderboard($connection) {
        $query = "SELECT * FROM walls ORDER BY wins DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getWarlordsLeaderboard($connection) {
        $query = "SELECT * FROM warlords ORDER BY wins DESC";
        $result = $connection->query($query);
        return $result;
    }

?>