<?php

	function getOverallPaintballLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['paintball.kills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
	}

    function getOverallTntLeaderboard($mongo_mng, $mode) {
        if ($mode == "Overall") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "TNTRun") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.tntrun.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "TNTTag") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.tntag.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "Wizards") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.wizards.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "BowSpleef") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.bowspleef.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "PVPRun") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.pvprun.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else {
            $query = new MongoDB\Driver\Query([], ['sort' => ['tntgames.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        }
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

    function getOverallUHCLeaderboard($mongo_mng, $mode) {
        if ($mode == "Solo") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.score' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "Teams") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.team.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "NoDiamonds") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.nodiamonds.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "RedVsBlue") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.redvsblue.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "Brawl") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.brawl.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "SoloBrawl") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.solobrawl.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "DuoBrawl") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.duobrawl.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "VanillaDoubles") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.vanilladoubles.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else {
            $query = new MongoDB\Driver\Query([], ['sort' => ['uhc.score' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        }
    }

    function getOverallCvcLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['copsandcrims.defusal.gameWins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getOverallArcadeLeaderboard($mongo_mng, $mode) {
        if ($mode == "Overall") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.coins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "BountyHunters") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.bountyHunters.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "ThrowOut") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.throwOut.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "BlockingDead") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.blockingDead.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "DragonWars") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.dragonWars.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "FarmHunt") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.farmHunt.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "EnderSpleef") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.enderSpleef.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "PartyGames") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.partyGamesOne' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "GalaxyWars") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.galaxyWars.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "HoleInTheWall") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.holeInTheWall.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "HypixelSays") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.hypixelSays.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "MiniWalls") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.miniWalls.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "Football") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.football.wins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "Zombies") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.zombies.bestRound' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else if ($mode == "HideAndSeek") {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.hideAndSeek.hiderWins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        } else {
            $query = new MongoDB\Driver\Query([], ['sort' => ['arcade.coins' => -1], 'limit' => 1000]);
            $res = $mongo_mng->executeQuery("ayeballers.player", $query);
            return $res;
        }
    }

    function getOverallFirstLoginLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['firstLogin' => 1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

?>