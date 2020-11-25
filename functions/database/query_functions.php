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

    function getWallsGuildLeaderboard($connection) {
        $query = "SELECT guild_members_current.name, player.rank, player.rank_colour, player.coins_walls, player.deaths_walls, player.assists_walls, player.wins_walls, player.losses_walls, player.kills_walls FROM player INNER JOIN guild_members_current ON player.UUID = guild_members_current.UUID ORDER BY player.wins_walls DESC";
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