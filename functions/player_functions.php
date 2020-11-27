<?php
/**
 * Player Functions - Involves getting, manipulating and displaying player statistic data.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */
    
    /**
     * Uses player UUID to get data from the Hypixel API and enters into a local mySQL database.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to update.
     * @param $name       Name of the player to update.
     * @param $API_KEY    API key to the Hypixel API.
     *
     * @return boolean - whether update was successful.
     * @author ExKay <exkay61@hotmail.com>
     */
	function updatePlayerInDatabase($connection, $uuid, $name, $API_KEY) 
    {
        // Get player JSON data from the Hypixel API.
		$player_url = file_get_contents("https://api.hypixel.net/player?key=" . $API_KEY . "&uuid=" . $uuid);
		$player_decoded_url = json_decode($player_url);

        // JSON paths for specific stats endpoints.
        $gen_s = !empty($player_decoded_url->player) ? $player_decoded_url->player : "No Stats";
        $pb_s = !empty($gen_s->stats->Paintball) ? $gen_s->stats->Paintball : "No Stats";
        $qc_s = !empty($gen_s->stats->Quake) ? $gen_s->stats->Quake : "No Stats";
        $ab_s = !empty($gen_s->stats->Arena) ? $gen_s->stats->Arena : "No Stats";
        $tkr_s = !empty($gen_s->stats->GingerBread) ? $gen_s->stats->GingerBread : "No Stats";
        $vz_s = !empty($gen_s->stats->VampireZ) ? $gen_s->stats->VampireZ : "No Stats";
        $walls_s = !empty($gen_s->stats->Walls) ? $gen_s->stats->Walls : "No Stats";
        $bw_s = !empty($gen_s->stats->Bedwars) ? $gen_s->stats->Bedwars : "No Stats";
        $tnt_s = !empty($gen_s->stats->TNTGames) ? $gen_s->stats->TNTGames : "No Stats";

        // Define general data endpoints.
		$first_login = !empty($gen_s->firstLogin) ? $gen_s->firstLogin : 0;
		$karma = !empty($gen_s->karma) ? $gen_s->karma : 0;
		$last_login = !empty($gen_s->lastLogin) ? $gen_s->lastLogin : 0;
		$network_exp = !empty($gen_s->networkExp) ? $gen_s->networkExp : 0;
		$time_played = !empty($gen_s->timePlaying) ? $gen_s->timePlaying : 0;
		$rank_colour = !empty($gen_s->rankPlusColor) ? $gen_s->rankPlusColor : "None";
		$achievement_points = !empty($gen_s->achievementPoints) ? $gen_s->achievementPoints : 0;
		$most_recent_game = !empty($gen_s->mostRecentGameType) ? $gen_s->mostRecentGameType : "Unknown";

		// Define rank data endpoints.
		$staff_rank = !empty($gen_s->rank) ? $gen_s->rank : "NONE";
		$monthly_package_rank = !empty($gen_s->monthlyPackageRank) ? $gen_s->monthlyPackageRank : "NONE";
		$package_rank = !empty($gen_s->packageRank) ? $gen_s->packageRank : "NONE";
		$new_package_rank = !empty($gen_s->newPackageRank) ? $gen_s->newPackageRank : "NONE";

        if ($staff_rank == "NORMAL" || $staff_rank == "NONE") {
            if ($monthly_package_rank == "NONE") {
                if ($new_package_rank == "NONE") {
                    $rank = $package_rank;
                } else {
                    $rank = $new_package_rank;
                }
            } else {
                $rank = $monthly_package_rank;
            }
        } else {
            $rank = $staff_rank;
        }
    

        // Define Paintball endpoints.
        if ($pb_s == "No Stats") {
            $kills_paintball = 0;
            $wins_paintball = 0;
            $coins_paintball = 0;
            $shots_fired_paintball = 0;
            $deaths_paintball = 0;
            $godfather_paintball = 0;
            $endurance_paintball = 0;
            $superluck_paintball = 0;
            $fortune_paintball = 0;
            $adrenaline_paintball = 0;
            $forcefield_time_paintball = 0;
            $killstreaks_paintball = 0;
            $transfusion_paintball = 0;
            $hat_paintball = "None";
            $kill_prefix_paintball = "DEFAULT";
        } else {
    		$kills_paintball = !empty($pb_s->kills) ? $pb_s->kills : 0;
            $wins_paintball = !empty($pb_s->wins) ? $pb_s->wins : 0;
           	$coins_paintball = !empty($pb_s->coins) ? $pb_s->coins : 0;
            $shots_fired_paintball = !empty($pb_s->shots_fired) ? $pb_s->shots_fired : 0;
            $deaths_paintball = !empty($pb_s->deaths) ? $pb_s->deaths : 0;
           	$godfather_paintball = !empty($pb_s->godfather) ? $pb_s->godfather : 0;
            $endurance_paintball = !empty($pb_s->endurance) ? $pb_s->endurance : 0;
            $superluck_paintball = !empty($pb_s->superluck) ? $pb_s->superluck : 0;
            $fortune_paintball = !empty($pb_s->fortune) ? $pb_s->fortune : 0;
            $adrenaline_paintball = !empty($pb_s->adrenaline) ? $pb_s->adrenaline : 0;
            $forcefield_time_paintball = !empty($pb_s->forcefieldTime) ? $pb_s->forcefieldTime : 0;
            $killstreaks_paintball = !empty($pb_s->killstreaks) ? $pb_s->killstreaks : 0;
            $transfusion_paintball = !empty($pb_s->transfusion) ? $pb_s->transfusion : 0;
            $hat_paintball = !empty($pb_s->hat) ? $pb_s->hat : "NONE";
            $kill_prefix_paintball = !empty($pb_s->selectedKillPrefix) ? $pb_s->selectedKillPrefix : "DEFAULT";
        }

        // Define Quakecraft endpoints.
        if ($qc_s == "No Stats") {
            $coins_quake = 0;
            $deaths_quake = 0;
           	$kills_quake = 0;
            $killstreaks_quake = 0;
            $wins_quake = 0;
           	$kills_teams_quake = 0;
            $deaths_teams_quake = 0;
            $wins_teams_quake = 0;
            $killstreaks_teams_quake = 0;
            $highest_killstreak_quake = 0;
            $shots_fired_teams_quake = 0;
            $headshots_teams_quake = 0;
            $headshots_quake = 0;
            $shots_fired_quake = 0;
            $distance_travelled_teams_quake = 0;
            $distance_travelled_quake = 0;
        } else {
            $coins_quake = !empty($qc_s->coins) ? $qc_s->coins : 0;
            $deaths_quake = !empty($qc_s->deaths) ? $qc_s->deaths : 0;
            $kills_quake = !empty($qc_s->kills) ? $qc_s->kills : 0;
            $killstreaks_quake = !empty($qc_s->killstreaks) ? $qc_s->killstreaks : 0;
            $wins_quake = !empty($qc_s->wins) ? $qc_s->wins : 0;
            $kills_teams_quake = !empty($qc_s->kills_teams) ? $qc_s->kills_teams : 0;
            $deaths_teams_quake = !empty($qc_s->deaths_teams) ? $qc_s->deaths_teams : 0;
            $wins_teams_quake = !empty($qc_s->wins_teams) ? $qc_s->wins_teams : 0;
            $killstreaks_teams_quake = !empty($qc_s->killstreaks_teams) ? $qc_s->killstreaks_teams : 0;
            $highest_killstreak_quake = !empty($qc_s->highest_killstreak) ? $qc_s->highest_killstreak : 0;
            $shots_fired_teams_quake = !empty($qc_s->shots_fired_teams) ? $qc_s->shots_fired_teams : 0;
            $headshots_teams_quake = !empty($qc_s->headshots_teams) ? $qc_s->headshots_teams : 0;
            $headshots_quake = !empty($qc_s->headshots) ? $qc_s->headshots : 0;
            $shots_fired_quake = !empty($qc_s->shots_fired) ? $qc_s->shots_fired : 0;
            $distance_travelled_teams_quake = !empty($qc_s->distance_travelled_teams) ? $qc_s->distance_travelled_teams : 0;
            $distance_travelled_quake = !empty($qc_s->distance_travelled) ? $qc_s->distance_travelled : 0;
        }

        // Define Arena Brawl endpoints.
        if ($ab_s == "No Stats") {
            $coins_arena = 0;
            $coins_spent_arena = 0;
            $keys_arena = 0;
            $rating_arena = 0;
            $damage_2v2_arena = 0;
            $damage_4v4_arena = 0;
            $damage_1v1_arena = 0;
            $deaths_2v2_arena = 0;
            $deaths_4v4_arena = 0;
            $deaths_1v1_arena = 0;
            $games_2v2_arena = 0;
            $games_4v4_arena = 0;
            $games_1v1_arena = 0;
            $healed_2v2_arena = 0;
            $healed_4v4_arena = 0;
            $healed_1v1_arena = 0;
            $kills_2v2_arena = 0;
            $kills_4v4_arena = 0;
            $kills_1v1_arena = 0;
            $losses_2v2_arena = 0;
            $losses_4v4_arena = 0;
            $losses_1v1_arena = 0;
            $wins_2v2_arena = 0;
            $wins_4v4_arena = 0;
            $wins_1v1_arena = 0;
        } else {
            $coins_arena = !empty($ab_s->coins) ? $ab_s->coins : 0;
            $coins_spent_arena = !empty($ab_s->coins_spent) ? $ab_s->coins_spent : 0;
            $keys_arena = !empty($ab_s->keys) ? $ab_s->keys : 0;
            $rating_arena = !empty($ab_s->rating) ? $ab_s->rating : 0;
            $damage_2v2_arena = !empty($ab_s->damage_2v2) ? $ab_s->damage_2v2 : 0;
            $damage_4v4_arena = !empty($ab_s->damage_4v4) ? $ab_s->damage_4v4 : 0;
            $damage_1v1_arena = !empty($ab_s->damage_1v1) ? $ab_s->damage_1v1 : 0;
            $deaths_2v2_arena = !empty($ab_s->deaths_2v2) ? $ab_s->deaths_2v2 : 0;
            $deaths_4v4_arena = !empty($ab_s->deaths_4v4) ? $ab_s->deaths_4v4 : 0;
            $deaths_1v1_arena = !empty($ab_s->deaths_1v1) ? $ab_s->deaths_1v1 : 0;
            $games_2v2_arena = !empty($ab_s->games_2v2) ? $ab_s->games_2v2 : 0;
            $games_4v4_arena = !empty($ab_s->games_4v4) ? $ab_s->games_4v4 : 0;
            $games_1v1_arena = !empty($ab_s->games_1v1) ? $ab_s->games_1v1 : 0;
            $healed_2v2_arena = !empty($ab_s->healed_2v2) ? $ab_s->healed_2v2 : 0;
            $healed_4v4_arena = !empty($ab_s->healed_4v4) ? $ab_s->healed_4v4 : 0;
            $healed_1v1_arena = !empty($ab_s->healed_1v1) ? $ab_s->healed_1v1 : 0;
            $kills_2v2_arena = !empty($ab_s->kills_2v2) ? $ab_s->kills_2v2 : 0;
            $kills_4v4_arena = !empty($ab_s->kills_4v4) ? $ab_s->kills_4v4 : 0;
            $kills_1v1_arena = !empty($ab_s->kills_1v1) ? $ab_s->kills_1v1 : 0;
            $losses_2v2_arena = !empty($ab_s->losses_2v2) ? $ab_s->losses_2v2 : 0;
            $losses_4v4_arena = !empty($ab_s->losses_4v4) ? $ab_s->losses_4v4 : 0;
            $losses_1v1_arena = !empty($ab_s->losses_1v1) ? $ab_s->losses_1v1 : 0;
            $wins_2v2_arena = !empty($ab_s->wins_2v2) ? $ab_s->wins_2v2 : 0;
            $wins_4v4_arena = !empty($ab_s->wins_4v4) ? $ab_s->wins_4v4 : 0;
            $wins_1v1_arena = !empty($ab_s->wins_1v1) ? $ab_s->wins_1v1 : 0;
        }

        // Define Turbo Kart Racers endpoints.
        if ($tkr_s == "No Stats") {
            $coins_tkr = 0;
            $box_pickups_tkr = 0;
            $coins_picked_up_tkr = 0;
            $silver_trophy_tkr = 0;
            $wins_tkr = 0;
            $laps_completed_tkr = 0;
            $gold_trophy_tkr = 0;
            $bronze_trophy_tkr = 0;
            $olympus_tkr = 0;
            $junglerush_tkr = 0;
            $hypixelgp_tkr = 0;
            $retro_tkr = 0;
            $canyon_tkr = 0;
        } else {
            $coins_tkr = !empty($tkr_s->coins) ? $tkr_s->coins : 0;
            $box_pickups_tkr = !empty($tkr_s->box_pickups) ? $tkr_s->box_pickups : 0;
            $coins_picked_up_tkr = !empty($tkr_s->coins_picked_up) ? $tkr_s->coins_picked_up : 0;
            $silver_trophy_tkr = !empty($tkr_s->silver_trophy) ? $tkr_s->silver_trophy : 0;
            $wins_tkr = !empty($tkr_s->wins) ? $tkr_s->wins : 0;
            $laps_completed_tkr = !empty($tkr_s->laps_completed) ? $tkr_s->laps_completed : 0;
            $gold_trophy_tkr = !empty($tkr_s->gold_trophy) ? $tkr_s->gold_trophy : 0;
            $bronze_trophy_tkr = !empty($tkr_s->bronze_trophy) ? $tkr_s->bronze_trophy : 0;
            $olympus_tkr = !empty($tkr_s->olympus_plays) ? $tkr_s->olympus_plays : 0;
            $junglerush_tkr = !empty($tkr_s->junglerush_plays) ? $tkr_s->junglerush_plays : 0;
            $hypixelgp_tkr = !empty($tkr_s->hypixelgp_plays) ? $tkr_s->hypixelgp_plays : 0;
            $retro_tkr = !empty($tkr_s->retro_plays) ? $tkr_s->retro_plays : 0;
            $canyon_tkr = !empty($tkr_s->canyon_plays) ? $tkr_s->canyon_plays : 0;
        }

        // Define VampireZ endpoints.
        if ($vz_s == "No Stats") {
            $coins_vz = 0;
            $human_deaths_vz = 0;
            $human_kills_vz = 0;
            $vampire_kills_vz = 0;
            $vampire_deaths_vz = 0;
            $zombie_kills_vz = 0;
            $most_vampire_kills_vz = 0;
            $human_wins_vz = 0;
            $gold_bought_vz = 0;
            $vampire_wins_vz = 0;
        } else {
            $coins_vz = !empty($vz_s->coins) ? $vz_s->coins : 0;
            $human_deaths_vz = !empty($vz_s->human_deaths) ? $vz_s->human_deaths : 0;
            $human_kills_vz = !empty($vz_s->human_kills) ? $vz_s->human_kills : 0;
            $vampire_kills_vz = !empty($vz_s->vampire_kills) ? $vz_s->vampire_kills : 0;
            $vampire_deaths_vz = !empty($vz_s->vampire_deaths) ? $vz_s->vampire_deaths : 0;
            $zombie_kills_vz = !empty($vz_s->zombie_kills) ? $vz_s->zombie_kills : 0;
            $most_vampire_kills_vz = !empty($vz_s->most_vampire_kills_new) ? $vz_s->most_vampire_kills_new : 0;
            $human_wins_vz = !empty($vz_s->human_wins) ? $vz_s->human_wins : 0;
            $gold_bought_vz = !empty($vz_s->gold_bought) ? $vz_s->gold_bought : 0;
            $vampire_wins_vz = !empty($vz_s->vampire_wins) ? $vz_s->vampire_wins : 0;
        }

        // Define Walls endpoints.
        if ($walls_s == "No Stats") {
            $coins_walls = 0;
            $deaths_walls = 0;
            $kills_walls = 0;
            $losses_walls = 0;
            $wins_walls = 0;
            $assists_walls = 0;
        } else {
            $coins_walls = !empty($walls_s->coins) ? $walls_s->coins : 0;
            $deaths_walls = !empty($walls_s->deaths) ? $walls_s->deaths : 0;
            $kills_walls = !empty($walls_s->kills) ? $walls_s->kills : 0;
            $losses_walls = !empty($walls_s->losses) ? $walls_s->losses : 0;
            $wins_walls = !empty($walls_s->wins) ? $walls_s->wins : 0;
            $assists_walls = !empty($walls_s->assists) ? $walls_s->assists : 0;
        }

        // Define Bedwars endpoints.
        if ($bw_s == "No Stats") {
            $experience_bw = 0;
            $coins_bw = 0;
            $deaths_bw = 0;
            $diamond_collected_bw = 0;
            $iron_collected_bw = 0;
            $gold_collected_bw = 0;
            $emerald_collected_bw = 0;
            $final_deaths_bw = 0;
            $games_played_bw = 0;
            $losses_bw = 0;
            $kills_bw = 0;
            $items_purchased_bw = 0;
            $resources_collected_bw = 0;
            $void_kills_bw = 0;
            $void_deaths_bw = 0;
            $beds_broken_bw = 0;
            $winstreak_bw = 0;
            $final_kills_bw = 0;
            $wins_bw = 0;
        } else {
            $experience_bw = !empty($bw_s->Experience) ? $bw_s->Experience : 0;
            $coins_bw = !empty($bw_s->coins) ? $bw_s->coins : 0;
            $deaths_bw = !empty($bw_s->deaths_bedwars) ? $bw_s->deaths_bedwars : 0;
            $diamond_collected_bw = !empty($bw_s->diamond_resources_collected_bedwars) ? $bw_s->diamond_resources_collected_bedwars : 0;
            $iron_collected_bw = !empty($bw_s->iron_resources_collected_bedwars) ? $bw_s->iron_resources_collected_bedwars : 0;
            $gold_collected_bw = !empty($bw_s->gold_resources_collected_bedwars) ? $bw_s->gold_resources_collected_bedwars : 0;
            $emerald_collected_bw = !empty($bw_s->emerald_resources_collected_bedwars) ? $bw_s->emerald_resources_collected_bedwars : 0;
            $final_deaths_bw = !empty($bw_s->final_deaths_bedwars) ? $bw_s->final_deaths_bedwars : 0;
            $games_played_bw = !empty($bw_s->games_played_bedwars) ? $bw_s->games_played_bedwars : 0;
            $losses_bw = !empty($bw_s->losses_bedwars) ? $bw_s->losses_bedwars : 0;
            $kills_bw = !empty($bw_s->kills_bedwars) ? $bw_s->kills_bedwars : 0;
            $items_purchased_bw = !empty($bw_s->items_purchased) ? $bw_s->items_purchased : 0;
            $resources_collected_bw = !empty($bw_s->resources_collected_bedwars) ? $bw_s->resources_collected_bedwars : 0;
            $void_kills_bw = !empty($bw_s->void_kills_bedwars) ? $bw_s->void_kills_bedwars : 0;
            $void_deaths_bw = !empty($bw_s->void_deaths_bedwars) ? $bw_s->void_deaths_bedwars : 0;
            $beds_broken_bw = !empty($bw_s->beds_broken_bedwars) ? $bw_s->beds_broken_bedwars : 0;
            $winstreak_bw = !empty($bw_s->winstreak) ? $bw_s->winstreak : 0;
            $final_kills_bw = !empty($bw_s->final_kills_bedwars) ? $bw_s->final_kills_bedwars : 0;
            $wins_bw = !empty($bw_s->wins_bedwars) ? $bw_s->wins_bedwars : 0;
        }
    

        // Define TNTGames endpoints.
        if ($tnt_s == "No Stats") {
            $deaths_bowspleef_tnt = 0;
            $coins_tnt = 0;
            $deaths_wizards_tnt = 0;
            $kills_wizards_tnt = 0;
            $wins_bowspleef_tnt = 0;
            $wins_wizards_tnt = 0;
            $wins_tntrun_tnt = 0;
            $record_tntrun_tnt = 0;
            $selected_hat_tnt = 0;
            $assists_wizards_tnt = 0;
            $deaths_tntrun_tnt = 0;
            $winstreak_tnt = 0;
            $wins_tnt = 0;
            $kills_tnttag_tnt = 0;
            $wins_tnttag_tnt = 0;
            $points_wizards_tnt = 0;
            $kills_pvprun_tnt = 0;
            $wins_pvprun_tnt = 0;
            $deaths_pvprun_tnt = 0;
            $record_pvprun_tnt = 0;
        } else {
            $deaths_bowspleef_tnt = !empty($tnt_s->deaths_bowspleef) ? $tnt_s->deaths_bowspleef : 0;
            $coins_tnt = !empty($tnt_s->coins) ? $tnt_s->coins : 0;
            $deaths_wizards_tnt = !empty($tnt_s->deaths_capture) ? $tnt_s->deaths_capture : 0;
            $kills_wizards_tnt = !empty($tnt_s->kills_capture) ? $tnt_s->kills_capture : 0;
            $wins_bowspleef_tnt = !empty($tnt_s->wins_bowspleef) ? $tnt_s->wins_bowspleef : 0;
            $wins_wizards_tnt = !empty($tnt_s->wins_capture) ? $tnt_s->wins_capture : 0;
            $wins_tntrun_tnt = !empty($tnt_s->wins_tntrun) ? $tnt_s->wins_tntrun : 0;
            $record_tntrun_tnt = !empty($tnt_s->record_tntrun) ? $tnt_s->record_tntrun : 0;
            $selected_hat_tnt = !empty($tnt_s->new_selected_hat) ? $tnt_s->new_selected_hat : 0;
            $assists_wizards_tnt = !empty($tnt_s->assists_capture) ? $tnt_s->assists_capture : 0;
            $deaths_tntrun_tnt = !empty($tnt_s->deaths_tntrun) ? $tnt_s->deaths_tntrun : 0;
            $winstreak_tnt = !empty($tnt_s->winstreak) ? $tnt_s->winstreak : 0;
            $wins_tnt = !empty($tnt_s->wins) ? $tnt_s->wins : 0;
            $kills_tnttag_tnt = !empty($tnt_s->kills_tntag) ? $tnt_s->kills_tntag : 0;
            $wins_tnttag_tnt = !empty($tnt_s->wins_tntag) ? $tnt_s->wins_tntag : 0;
            $points_wizards_tnt = !empty($tnt_s->points_capture) ? $tnt_s->points_capture : 0;
            $kills_pvprun_tnt = !empty($tnt_s->kills_pvprun) ? $tnt_s->kills_pvprun : 0;
            $wins_pvprun_tnt = !empty($tnt_s->wins_pvprun) ? $tnt_s->wins_pvprun : 0;
            $deaths_pvprun_tnt = !empty($tnt_s->deaths_pvprun) ? $tnt_s->deaths_pvprun : 0;
            $record_pvprun_tnt = !empty($tnt_s->record_pvprun) ? $tnt_s->record_pvprun : 0;
        }

        if (alreadyInPlayerTable($connection, $uuid)) {
        	$query = "UPDATE player SET name = ?, kills_paintball = ?, wins_paintball = ?, kill_prefix_paintball = ?, coins_paintball = ?, deaths_paintball = ?, forcefield_time_paintball = ?, killstreaks_paintball = ?, shots_fired_paintball = ?, hat_paintball = ?, adrenaline_paintball = ?, endurance_paintball = ?, fortune_paintball = ?, godfather_paintball = ?, superluck_paintball = ?, transfusion_paintball = ?, karma = ?, most_recent_game = ?, achievement_points = ?, rank_colour = ?, coins_quake = ?, deaths_quake = ?, kills_quake = ?, killstreaks_quake = ?, wins_quake = ?, kills_teams_quake = ?, deaths_teams_quake = ?, wins_teams_quake = ?, killstreaks_teams_quake = ?, highest_killstreak_quake = ?, shots_fired_teams_quake = ?, headshots_teams_quake = ?, headshots_quake = ?, shots_fired_quake = ?, distance_travelled_teams_quake = ?, distance_travelled_quake = ?, coins_arena = ?, coins_spent_arena = ?, keys_arena = ?, rating_arena = ?, damage_2v2_arena = ?, damage_4v4_arena = ?, damage_1v1_arena = ?, deaths_2v2_arena = ?, deaths_4v4_arena = ?, deaths_1v1_arena = ?, games_2v2_arena = ?, games_4v4_arena = ?, games_1v1_arena = ?, healed_2v2_arena = ?, healed_4v4_arena = ?, healed_1v1_arena = ?, kills_2v2_arena = ?, kills_4v4_arena = ?, kills_1v1_arena = ?, losses_2v2_arena = ?, losses_4v4_arena = ?, losses_1v1_arena = ?, wins_2v2_arena = ?, wins_4v4_arena = ?, wins_1v1_arena = ?, rank = ?, coins_tkr = ?, box_pickups_tkr = ?, coins_picked_up_tkr = ?, silver_trophy_tkr = ?, wins_tkr = ?, laps_completed_tkr = ?, gold_trophy_tkr = ?, bronze_trophy_tkr = ?, olympus_tkr = ?, junglerush_tkr = ?, hypixelgp_tkr = ?, retro_tkr = ?, canyon_tkr = ?, coins_vz = ?, human_deaths_vz = ?, human_kills_vz = ?, vampire_kills_vz = ?, vampire_deaths_vz = ?, zombie_kills_vz = ?, most_vampire_kills_vz = ?, human_wins_vz = ?, gold_bought_vz = ?, vampire_wins_vz = ?, coins_walls = ?, deaths_walls = ?, kills_walls = ?, losses_walls = ?, wins_walls = ?, assists_walls = ?, experience_bw = ?, coins_bw = ?, deaths_bw = ?, diamond_collected_bw = ?, iron_collected_bw = ?, gold_collected_bw = ?, emerald_collected_bw = ?, final_deaths_bw = ?, games_played_bw = ?, losses_bw = ?, kills_bw = ?, items_purchased_bw = ?, resources_collected_bw = ?, void_kills_bw = ?, void_deaths_bw = ?, beds_broken_bw = ?, winstreak_bw = ?, final_kills_bw = ?, wins_bw = ?, time_played = ?, network_exp = ?, deaths_bowspleef_tnt = ?, coins_tnt = ?, deaths_wizards_tnt = ?, kills_wizards_tnt = ?, wins_bowspleef_tnt = ?, wins_wizards_tnt = ?, wins_tntrun_tnt = ?, record_tntrun_tnt = ?, selected_hat_tnt = ?, assists_wizards_tnt = ?, deaths_tntrun_tnt = ?, winstreak_tnt = ?, wins_tnt = ?, kills_tnttag_tnt = ?, wins_tnttag_tnt = ?, points_wizards_tnt = ?, kills_pvprun_tnt = ?, wins_pvprun_tnt = ?, deaths_pvprun_tnt = ?, record_pvprun_tnt = ?, first_login = ?, last_login = ?, last_updated = now() WHERE UUID = '" . $uuid . "'";

	        if ($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "siisiiiiisiiiiiiisisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiiiii", $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $superluck_paintball, $transfusion_paintball, $karma, $most_recent_game, $achievement_points, $rank_colour, $coins_quake, $deaths_quake, $kills_quake, $killstreaks_quake, $wins_quake, $kills_teams_quake, $deaths_teams_quake, $wins_teams_quake, $killstreaks_teams_quake, $highest_killstreak_quake, $shots_fired_teams_quake, $headshots_teams_quake, $headshots_quake, $shots_fired_quake, $distance_travelled_teams_quake, $distance_travelled_quake, $coins_arena, $coins_spent_arena, $keys_arena, $rating_arena, $damage_2v2_arena, $damage_4v4_arena, $damage_1v1_arena, $deaths_2v2_arena, $deaths_4v4_arena, $deaths_1v1_arena, $games_2v2_arena, $games_4v4_arena, $games_1v1_arena, $healed_2v2_arena, $healed_4v4_arena, $healed_1v1_arena, $kills_2v2_arena, $kills_4v4_arena, $kills_1v1_arena, $losses_2v2_arena, $losses_4v4_arena, $losses_1v1_arena, $wins_2v2_arena, $wins_4v4_arena, $wins_1v1_arena, $rank, $coins_tkr, $box_pickups_tkr, $coins_picked_up_tkr, $silver_trophy_tkr, $wins_tkr, $laps_completed_tkr, $gold_trophy_tkr, $bronze_trophy_tkr, $olympus_tkr, $junglerush_tkr, $hypixelgp_tkr, $retro_tkr, $canyon_tkr, $coins_vz, $human_deaths_vz, $human_kills_vz, $vampire_kills_vz, $vampire_deaths_vz, $zombie_kills_vz, $most_vampire_kills_vz, $human_wins_vz, $gold_bought_vz, $vampire_wins_vz, $coins_walls, $deaths_walls, $kills_walls, $losses_walls, $wins_walls, $assists_walls, $experience_bw, $coins_bw, $deaths_bw, $diamond_collected_bw, $iron_collected_bw, $gold_collected_bw, $emerald_collected_bw, $final_deaths_bw, $losses_bw, $kills_bw, $items_purchased_bw, $resources_collected_bw, $games_played_bw, $void_kills_bw, $void_deaths_bw, $beds_broken_bw, $winstreak_bw, $final_kills_bw, $wins_bw, $time_played, $network_exp, $deaths_bowspleef_tnt, $coins_tnt, $deaths_wizards_tnt, $kills_wizards_tnt, $wins_bowspleef_tnt, $wins_wizards_tnt, $wins_tntrun_tnt, $record_tntrun_tnt, $selected_hat_tnt, $assists_wizards_tnt, $deaths_tntrun_tnt, $winstreak_tnt, $wins_tnt, $kills_tnttag_tnt, $wins_tnttag_tnt, $points_wizards_tnt, $kills_pvprun_tnt, $wins_pvprun_tnt, $deaths_pvprun_tnt, $record_pvprun_tnt, $first_login, $last_login);
	            mysqli_stmt_execute($statement);
                updateStatsLog($connection, $name, $_SERVER['REMOTE_ADDR']);
	            return true;
	        } else {
	            echo '<b>[ERROR:1] ' . $name . ' </b>An Error Occured!<br>'; 
	            return false;
	        }
        } else {
			$query = "INSERT INTO player (UUID, name, kills_paintball, wins_paintball, kill_prefix_paintball, coins_paintball, deaths_paintball, forcefield_time_paintball, killstreaks_paintball, shots_fired_paintball, hat_paintball, adrenaline_paintball, endurance_paintball, fortune_paintball, godfather_paintball, superluck_paintball, transfusion_paintball, karma, most_recent_game, achievement_points, rank_colour, coins_quake, deaths_quake, kills_quake, killstreaks_quake, wins_quake, kills_teams_quake, deaths_teams_quake, wins_teams_quake, killstreaks_teams_quake, highest_killstreak_quake, shots_fired_teams_quake, headshots_teams_quake, headshots_quake, shots_fired_quake, distance_travelled_teams_quake, distance_travelled_quake, coins_arena, coins_spent_arena, keys_arena, rating_arena, damage_2v2_arena, damage_4v4_arena, damage_1v1_arena, deaths_2v2_arena, deaths_4v4_arena, deaths_1v1_arena, games_2v2_arena, games_4v4_arena, games_1v1_arena, healed_2v2_arena, healed_4v4_arena, healed_1v1_arena, kills_2v2_arena, kills_4v4_arena, kills_1v1_arena, losses_2v2_arena, losses_4v4_arena, losses_1v1_arena, wins_2v2_arena, wins_4v4_arena, wins_1v1_arena, rank, coins_tkr, box_pickups_tkr, coins_picked_up_tkr, silver_trophy_tkr, wins_tkr, laps_completed_tkr, gold_trophy_tkr, bronze_trophy_tkr, olympus_tkr, junglerush_tkr, hypixelgp_tkr, retro_tkr, canyon_tkr, coins_vz, human_deaths_vz, human_kills_vz, vampire_kills_vz, vampire_deaths_vz, zombie_kills_vz, most_vampire_kills_vz, human_wins_vz, gold_bought_vz, vampire_wins_vz, coins_walls, deaths_walls, kills_walls, losses_walls, wins_walls, assists_walls, experience_bw, coins_bw, deaths_bw, diamond_collected_bw, iron_collected_bw, gold_collected_bw, emerald_collected_bw, final_deaths_bw, games_played_bw, losses_bw, kills_bw, items_purchased_bw, resources_collected_bw, void_kills_bw, void_deaths_bw, beds_broken_bw, winstreak_bw, final_kills_bw, wins_bw, time_played, network_exp, deaths_bowspleef_tnt, coins_tnt, deaths_wizards_tnt, kills_wizards_tnt, wins_bowspleef_tnt, wins_wizards_tnt, wins_tntrun_tnt, record_tntrun_tnt, selected_hat_tnt, assists_wizards_tnt, deaths_tntrun_tnt, winstreak_tnt, wins_tnt, kills_tnttag_tnt, wins_tnttag_tnt, points_wizards_tnt, kills_pvprun_tnt, wins_pvprun_tnt, deaths_pvprun_tnt, record_pvprun_tnt, last_updated)
	                    		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";

	        if ($statement = mysqli_prepare($connection, $query)) {
	            mysqli_stmt_bind_param($statement, "ssiisiiiiisiiiiiiisisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiiiii", $uuid, $name, $kills_paintball, $wins_paintball, $kill_prefix_paintball, $coins_paintball, $deaths_paintball, $forcefield_time_paintball, $killstreaks_paintball, $shots_fired_paintball, $hat_paintball, $adrenaline_paintball, $endurance_paintball, $fortune_paintball, $godfather_paintball, $superluck_paintball, $transfusion_paintball, $karma, $most_recent_game, $achievement_points, $rank_colour, $coins_quake, $deaths_quake, $kills_quake, $killstreaks_quake, $wins_quake, $kills_teams_quake, $deaths_teams_quake, $wins_teams_quake, $killstreaks_teams_quake, $highest_killstreak_quake, $shots_fired_teams_quake, $headshots_teams_quake, $headshots_quake, $shots_fired_quake, $distance_travelled_teams_quake, $distance_travelled_quake, $coins_arena, $coins_spent_arena, $keys_arena, $rating_arena, $damage_2v2_arena, $damage_4v4_arena, $damage_1v1_arena, $deaths_2v2_arena, $deaths_4v4_arena, $deaths_1v1_arena, $games_2v2_arena, $games_4v4_arena, $games_1v1_arena, $healed_2v2_arena, $healed_4v4_arena, $healed_1v1_arena, $kills_2v2_arena, $kills_4v4_arena, $kills_1v1_arena, $losses_2v2_arena, $losses_4v4_arena, $losses_1v1_arena, $wins_2v2_arena, $wins_4v4_arena, $wins_1v1_arena, $rank, $coins_tkr, $box_pickups_tkr, $coins_picked_up_tkr, $silver_trophy_tkr, $wins_tkr, $laps_completed_tkr, $gold_trophy_tkr, $bronze_trophy_tkr, $olympus_tkr, $junglerush_tkr, $hypixelgp_tkr, $retro_tkr, $canyon_tkr, $coins_vz, $human_deaths_vz, $human_kills_vz, $vampire_kills_vz, $vampire_deaths_vz, $zombie_kills_vz, $most_vampire_kills_vz, $human_wins_vz, $gold_bought_vz, $vampire_wins_vz, $coins_walls, $deaths_walls, $kills_walls, $losses_walls, $wins_walls, $assists_walls, $experience_bw, $coins_bw, $deaths_bw, $diamond_collected_bw, $iron_collected_bw, $gold_collected_bw, $emerald_collected_bw, $final_deaths_bw, $games_played_bw, $losses_bw, $kills_bw, $items_purchased_bw, $resources_collected_bw, $void_kills_bw, $void_deaths_bw, $beds_broken_bw, $winstreak_bw, $final_kills_bw, $wins_bw, $time_played, $network_exp, $deaths_bowspleef_tnt, $coins_tnt, $deaths_wizards_tnt, $kills_wizards_tnt, $wins_bowspleef_tnt, $wins_wizards_tnt, $wins_tntrun_tnt, $record_tntrun_tnt, $selected_hat_tnt, $assists_wizards_tnt, $deaths_tntrun_tnt, $winstreak_tnt, $wins_tnt, $kills_tnttag_tnt, $wins_tnttag_tnt, $points_wizards_tnt, $kills_pvprun_tnt, $wins_pvprun_tnt, $deaths_pvprun_tnt, $record_pvprun_tnt);
	            mysqli_stmt_execute($statement);
                updateStatsLog($connection, $name, $_SERVER['REMOTE_ADDR']);
	            return true;
	        } else {
	            echo '<b>[ERROR:2] ' . $name . ' </b>An Error Occured!<br>'; 
	            return false;
	        }
	    }

	}

    /**
     * Checks if the user is already in the main statistic table.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to check.
     *
     * @return boolean - whether check was successful.
     * @author ExKay <exkay61@hotmail.com>
     */
	function alreadyInPlayerTable($connection, $uuid) 
    {
		$query = "SELECT * FROM player WHERE UUID = '$uuid'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
	}

    /**
     * Gets player data specific to a UUID.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to check.
     *
     * @return result - the row of data associated with the player.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getPlayerInformation($connection, $uuid) 
    {
        $query = "SELECT * FROM player WHERE UUID = '" . $uuid . "'";
        $result = $connection->query($query);
        return $result;
	}

    /**
     * Gets the guild of the player using a UUID.
     *
     * @param $connection Connection to the database.
     * @param $uuid       UUID of the player to check.
     * @param $API_KEY    API key to the Hypixel API.
     *
     * @return decoded_url URL of the JSON data with guild information.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getPlayersGuild($connection, $uuid, $API_KEY) 
    {
		$api_guild_url = file_get_contents("https://api.hypixel.net/guild?key=" . $API_KEY . "&player=" . $uuid);
		$decoded_url  = json_decode($api_guild_url);
		return $decoded_url;
	}

    /**
     * Gets correct formatting of a players rank with their name.
     *
     * @param $name        Name of the player.
     * @param $rank        Rank of the player.
     * @param $rank_colour Colour of the rank (if MVP+ colour used).
     *
     * @return rank_with_name Formatting of the rank with the players name included.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getRankFormatting($name, $rank, $rank_colour) 
    {
		if ($rank_colour == "BLACK") {
			$plus_colour = '<span style="color:#000000;">+</span>';
		} else if ($rank_colour == "RED") {
			$plus_colour = '<span style="color:#e72323;">+</span>';
		} else if ($rank_colour == "DARK_GREEN") {
			$plus_colour = '<span style="color:#13850f;">+</span>';
		} else if ($rank_colour == "None") {
			$plus_colour = '<span style="color:#ed5a64;">+</span>';
		} else if ($rank_colour == "WHITE") {
			$plus_colour = '<span style="color:#ffffff;">+</span>';
		} else if ($rank_colour == "BLUE") {
			$plus_colour = '<span style="color:#5a97ed;">+</span>';
		} else if ($rank_colour == "GREEN") {
			$plus_colour = '<span style="color:#19e657;">+</span>';
		} else if ($rank_colour == "DARK_RED") {
			$plus_colour = '<span style="color:#8a0f19;">+</span>';
		} else if ($rank_colour == "DARK_PURPLE") {
			$plus_colour = '<span style="color:#510f8a;">+</span>';
        } else if ($rank_colour == "YELLOW") {
            $plus_colour = '<span style="color:#fee125;">+</span>';
        } else if ($rank_colour == "GOLD") {
            $plus_colour = '<span style="color:#d1aa0a;">+</span>';
        } else if ($rank_colour == "DARK_AQUA") {
            $plus_colour = '<span style="color:#0a85d1;">+</span>';
        } else if ($rank_colour == "DARK_GRAY") {
            $plus_colour = '<span style="color:#4c5052;">+</span>';
        } else if ($rank_colour == "LIGHT_PURPLE") {
            $plus_colour = '<span style="color:#a75de5;">+</span>';
		} else {
            $plus_colour = '<span style="color:#e72323;">+</span>';
        }

		if ($rank == "MVP_PLUS") {
			$rank_with_name = '<span style="color:#50e0e7;">' . '[MVP' . $plus_colour . '] ' . $name . '</span>';
		} else if ($rank == "DEFAULT" || $rank == "NONE") {
			$rank_with_name = '<span style="color:#a7aaa1;">' . $name . '</span>';
		} else if ($rank == "SUPERSTAR") {
			$rank_with_name = '<span style="color:#e6b400;">' . '[MVP' . $plus_colour . $plus_colour . '] ' . $name . '</span>';
		} else if ($rank == "MVP") {
			$rank_with_name = '<span style="color:#50e0e7;">' . '[MVP] ' . $name . '</span>';
		} else if ($rank == "VIP_PLUS") {
			$rank_with_name = '<span style="color:#7cc841;">' . '[VIP<span style="color:#e6b400;">+</span><span style="color:#7cc841;">]</span> ' . $name . '</span>';
        } else if ($rank == "VIP") {
            $rank_with_name = '<span style="color:#7cc841;">' . '[VIP] ' . $name . '</span>';
		} else if ($rank == "ADMIN") {
			$rank_with_name = '<span style="color:#ce1c1c;">' . '[ADMIN] ' . $name . '</span>';
		} else if ($rank == "YOUTUBER") {
			$rank_with_name = '<span style="color:#ce1c1c;">' . '[<span style="color:#ffffff;">YOUTUBE<span style="color:#ce1c1c;">] ' . $name . '</span>';
		} else if ($rank == "MODERATOR") {
			$rank_with_name = '<span style="color:#238212;">' . '[MOD] ' . $name . '</span>';
		} else if ($rank == "HELPER") {
			$rank_with_name = '<span style="color:#146594;">' . '[HELPER] ' . $name . '</span>';
		} else {
			$rank_with_name = '<span style="color:#a7aaa1;">' . $name . '</span>';
		}

		return $rank_with_name;
	}

    /**
     * Gets the leaderboard position of a player in a specific game.
     *
     * @param $connection Connection to the database.
     * @param $name       Name of the player to check.
     * @param $game       Game to check leaderboard data.
     *
     * @return result The position in the leaderboard of the player.
     * @author ExKay <exkay61@hotmail.com>
     */
	function getLeaderboardPosition($connection, $name, $game) 
    {
		if ($game == "bedwars") {
			$query = "SET @rank=0; SELECT @rank:=@rank+1 AS rank, name, COUNT(*) as countvar FROM player GROUP BY name ORDER BY wins_bw DESC; SELECT @rank;";
			$result = $connection->query($query);
			return $result;
		}
	}

    /**
     * Uses the experience value to calculate the network level.
     *
     * @param $exp The experience to convert.
     *
     * @return Network level value.
     * @author Plancke hypixel-php <https://github.com/Plancke/hypixel-php>
     */
    function getLevel(float $exp) 
    {
        $BASE = 10000;
        $GROWTH = 2500;
        $HALF_GROWTH = 0.5 * $GROWTH;
        $REVERSE_PQ_PREFIX = -($BASE - 0.5 * $GROWTH) / $GROWTH;
        $REVERSE_CONST = $REVERSE_PQ_PREFIX * $REVERSE_PQ_PREFIX;
        $GROWTH_DIVIDES_2 = 2 / $GROWTH;

        return $exp < 0 ? 1 : floor(1 + $REVERSE_PQ_PREFIX + sqrt($REVERSE_CONST + $GROWTH_DIVIDES_2 * $exp));
    }

    function updateStatsLog($connection, $name, $ip) {
        $query = "INSERT INTO stats_log (updated_time, action, IP) VALUES (now(), '$name', '$ip')";         
        mysqli_query($connection, $query);
    }

?>