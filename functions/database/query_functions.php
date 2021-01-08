<?php

	function getOverallPaintballLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['paintball.kills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
	}

    function getOverallTntLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallWallsLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['walls.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallQuakeLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['quakecraft.soloKills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallVampirezLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['vampirez.asHuman.humanWins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallTkrLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['tkr.goldTrophy' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallArenaLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['arena.rating' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallBedwarsLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['bedwars.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallSkywarsLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['skywars.overall.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallWarlordsLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['warlords.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallUHCLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.score' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallCvcLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['copsandcrims.defusal.gameWins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallArcadeLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.coins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

?>