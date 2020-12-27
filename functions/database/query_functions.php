<?php

	function getOverallPaintballLeaderboard($mongo_mng) {
        $query = new MongoDB\Driver\Query([], ['sort' => ['paintball.kills' => -1], 'limit' => 1000]);
        $res = $mongo_mng->executeQuery("ayeballers.player", $query);
        return $res;
	}

    function getOverallTntLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_tnt, wins_tnt, wins_tntrun_tnt, winstreak_tnt, wins_bowspleef_tnt, wins_tnttag_tnt, wins_pvprun_tnt, wins_wizards_tnt FROM player ORDER BY wins_tnt DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getOverallWallsLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_walls, deaths_walls, assists_walls, wins_walls, losses_walls, kills_walls FROM player ORDER BY wins_walls DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getOverallQuakeLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_quake, kills_quake, wins_quake, deaths_quake, killstreaks_quake, kills_teams_quake, deaths_teams_quake, wins_teams_quake, killstreaks_teams_quake, highest_killstreak_quake, shots_fired_teams_quake, headshots_teams_quake, headshots_quake, shots_fired_quake, distance_travelled_teams_quake, distance_travelled_quake FROM player ORDER BY (kills_quake + kills_teams_quake) DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getOverallVampirezLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_vz, human_deaths_vz, human_kills_vz, vampire_kills_vz, vampire_deaths_vz, zombie_kills_vz, most_vampire_kills_vz, human_wins_vz, gold_bought_vz, vampire_wins_vz FROM player ORDER BY human_wins_vz DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getOverallTkrLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_tkr, box_pickups_tkr, coins_picked_up_tkr, silver_trophy_tkr, wins_tkr, laps_completed_tkr, gold_trophy_tkr, bronze_trophy_tkr FROM player ORDER BY wins_tkr DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getOverallArenaLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_arena, coins_spent_arena, keys_arena, rating_arena, damage_2v2_arena, damage_4v4_arena, damage_1v1_arena, deaths_2v2_arena, deaths_4v4_arena, deaths_1v1_arena, games_2v2_arena, games_4v4_arena, games_1v1_arena, healed_2v2_arena, healed_4v4_arena, healed_1v1_arena, kills_2v2_arena, kills_4v4_arena, kills_1v1_arena, losses_2v2_arena, losses_4v4_arena, losses_1v1_arena, wins_2v2_arena, wins_4v4_arena, wins_1v1_arena FROM player ORDER BY rating_arena DESC LIMIT 500";
        $result = $connection->query($query);
        return $result;
    }

    function getTntGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_tnt, player.wins_tnt, player.wins_tntrun_tnt, player.winstreak_tnt, player.wins_bowspleef_tnt, player.wins_tnttag_tnt, player.wins_pvprun_tnt, player.wins_wizards_tnt FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.wins_tnt DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getVampirezGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_vz, player.human_wins_vz, player.human_deaths_vz, player.human_kills_vz, player.vampire_wins_vz, player.vampire_deaths_vz, player.vampire_kills_vz, player.most_vampire_kills_vz, player.zombie_kills_vz, player.gold_bought_vz FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.human_wins_vz DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getWallsGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_walls, player.deaths_walls, player.assists_walls, player.wins_walls, player.losses_walls, player.kills_walls FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.wins_walls DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getTkrGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_tkr, player.wins_tkr, player.gold_trophy_tkr, player.silver_trophy_tkr, player.bronze_trophy_tkr, player.laps_completed_tkr, player.coins_picked_up_tkr, player.box_pickups_tkr FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.wins_tkr DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getQuakeGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_quake, player.kills_quake, player.kills_teams_quake, player.wins_teams_quake, player.wins_quake, player.deaths_quake, player.deaths_teams_quake, player.headshots_quake, player.headshots_teams_quake, player.shots_fired_teams_quake, player.shots_fired_quake, player.distance_travelled_teams_quake, player.distance_travelled_quake, player.highest_killstreak_quake, player.killstreaks_teams_quake, player.killstreaks_quake FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY (player.kills_quake + player.kills_teams_quake) DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getPaintballGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_paintball, player.deaths_paintball, player.wins_paintball, player.kills_paintball, player.hat_paintball, player.shots_fired_paintball, player.forcefield_time_paintball, player.killstreaks_paintball FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.kills_paintball DESC";
        $result = $connection->query($query);
        return $result;
    }

    function getArenaGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_arena, player.coins_spent_arena, player.keys_arena, player.rating_arena, player.damage_2v2_arena, player.damage_4v4_arena, player.damage_1v1_arena, player.deaths_2v2_arena, player.deaths_4v4_arena, player.deaths_1v1_arena, player.games_2v2_arena, player.games_4v4_arena, player.games_1v1_arena, player.healed_2v2_arena, player.healed_4v4_arena, player.healed_1v1_arena, player.kills_2v2_arena, player.kills_4v4_arena, player.kills_1v1_arena, player.losses_2v2_arena, player.losses_4v4_arena, player.losses_1v1_arena, player.wins_2v2_arena, player.wins_4v4_arena, player.wins_1v1_arena FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.rating_arena DESC";
        $result = $connection->query($query);
        return $result;
    }

?>