<?php

	function getOverallPaintballLeaderboard($connection) {
        $query = "SELECT name, rank, rank_colour, coins_paintball, deaths_paintball, forcefield_time_paintball, wins_paintball, kills_paintball, killstreaks_paintball, shots_fired_paintball, hat_paintball FROM player ORDER BY kills_paintball DESC LIMIT 500";
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

    function getWarlordsLeaderboard($connection) {
        $query = "SELECT * FROM warlords ORDER BY wins DESC";
        $result = $connection->query($query);
        return $result;
    }

?>