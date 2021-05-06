<?php
/**
 * Contains functions used to get leaderboards from mongo.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

include "guild_functions.php";

    /**
     * Gets overall paintball leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getOverallPaintballLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['paintball.kills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
	}

    /**
     * Gets TNT Games leaderboard using a specific TNT gamemode.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @param mode - TNT games mode.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallTntLeaderboard($mongo_mng, $mode) 
    {
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
    
    /**
     * Gets overall walls leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallWallsLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['walls.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall quake leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallQuakeLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['quakecraft.soloKills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall VampireZ leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallVampirezLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['vampirez.asHuman.humanWins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall Turbo Kart Racers leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallTkrLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['tkr.goldTrophy' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall arena brawl leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallArenaLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['arena.rating' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall BedWars leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallBedwarsLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['bedwars.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall Skywars leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallSkywarsLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['skywars.overall.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall Warlords leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallWarlordsLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['warlords.wins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall UHC leaderboard using a specific gamemode.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @param mode - UHC game mode.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallUHCLeaderboard($mongo_mng, $mode) 
    {
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

    /**
     * Gets overall Cops vs Crims leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallCvcLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['copsandcrims.defusal.gameWins' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    /**
     * Gets overall arcade leaderboard using a specific gamemode.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @param mode - Arcade game mode.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallArcadeLeaderboard($mongo_mng, $mode) 
    {
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

    /**
     * Gets overall first login leaderboard.
     *
     * @param mongo_mng - MongoDB driver manager.
     * @return res - Leaderboard result.
     * @author ExKay <exkay61@hotmail.com>
     */
    function getOverallFirstLoginLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['sort' => ['firstLogin' => 1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
    }

    function getGuildPaintballLeaderboard($mongo_mng) 
    {
        $query = new MongoDB\Driver\Query([], ['limit' => 50]);
        $guilds = $mongo_mng->executeQuery("ayeballers.guild", $query);

        $guild_lb = array();

        foreach ($guilds as $guild) {
            $name = $guild->name;
            $kills = getGuildPaintballKills($mongo_mng, $name);
            $guild_lb[$name] = $kills;
        }

        arsort($guild_lb);

        return $guild_lb;
    }

?>