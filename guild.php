<?php
/**
 * Guild stats page - Shows customised stats for guilds based on GET data.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/stats.php
 */

require "includes/links.php";
require "includes/connect.php";
require "includes/constants.php";
require "functions/functions.php";
require "functions/display_functions.php";
require "functions/player_functions.php";
require "error/error_messages.php";
include "admin/functions/login_functions.php";
   
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php 
            $guild_name = $_GET["guild"];

            $decoded_url = getGuildInformation($connection, $guild_name, $API_KEY);
            $date_created = $decoded_url->guild->created;
            $members = $decoded_url->guild->members;
            $description = $decoded_url->guild->description;
            $tag = $decoded_url->guild->tag;
            $exp = $decoded_url->guild->exp;
            $member_size = sizeof($members);

            $battleground_exp = $decoded_url->guild->guildExpByGameType->BATTLEGROUND;
            $uhc_exp = $decoded_url->guild->guildExpByGameType->UHC;
            $bsg_exp = $decoded_url->guild->guildExpByGameType->SURVIVAL_GAMES;
            $skywars_exp = $decoded_url->guild->guildExpByGameType->SKYWARS;
            $duels_exp = $decoded_url->guild->guildExpByGameType->DUELS;
            $paintball_exp = $decoded_url->guild->guildExpByGameType->PAINTBALL;
            $arena_exp = $decoded_url->guild->guildExpByGameType->ARENA;
            $tntgames_exp = $decoded_url->guild->guildExpByGameType->TNTGAMES;
            $mcgo_exp = $decoded_url->guild->guildExpByGameType->MCGO;
            $walls_exp = $decoded_url->guild->guildExpByGameType->WALLS;
            $vz_exp = $decoded_url->guild->guildExpByGameType->VAMPIREZ;
            $gingerbread_exp = $decoded_url->guild->guildExpByGameType->GINGERBREAD;
            $super_smash_exp = $decoded_url->guild->guildExpByGameType->SUPER_SMASH;
            $qc_exp = $decoded_url->guild->guildExpByGameType->QUAKECRAFT;
            $bb_exp = $decoded_url->guild->guildExpByGameType->BUILD_BATTLE;
            $arcade_exp = $decoded_url->guild->guildExpByGameType->ARCADE;
            $prototype_exp = $decoded_url->guild->guildExpByGameType->PROTOTYPE;
            $walls3_exp = $decoded_url->guild->guildExpByGameType->WALLS3;
            $housing_exp = $decoded_url->guild->guildExpByGameType->HOUSING;
            $mm_exp = $decoded_url->guild->guildExpByGameType->MURDER_MYSTERY;
            $bedwars_exp = $decoded_url->guild->guildExpByGameType->BEDWARS;

        ?>

        <title><?php echo $guild_name; ?> - AyeBallers</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main>
                    <?php 
                        if (true) {
                            echo "<center><h1 style='padding-top:200px'>Guild statistics are currently disabled</h1></center>";
                        } else {
                    ?>

                    <div class="card">

                        <div class="card-body">
                            <form style="margin-right: 10px;" action="<?= $previous ?>">
                                <button type="submit" class="btn btn-danger">< Back</button>
                            </form>

                            <h1><?php echo $guild_name; ?></h1>

                            <br>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild Statistics
                                        </div>
                                        <div class="card-body">
                                            <p><b>Guild Level:</b> <?php echo getGuildLevel($exp); ?> </p>
                                            <p><b>Members:</b> <?php echo $member_size; ?></p>
                                            <p><b>Description:</b> <?php echo $description; ?></p>
                                            <p><b>Date Created:</b> <?php echo $date_created; ?></p>
                                            <p><b>Guild Tag:</b> [<?php echo $tag; ?>]</p>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-table mr-1"></i>
                                            Guild EXP Earned By Game
                                        </div>
                                        <div class="card-body">
                                            <canvas id="expPie"></canvas>
                                        </div>
                                    </div>

                                </div>
                    

                                <div class="col-md-8">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <i class="fas fa-list mr-1"></i>
                                            Guild Members
                                        </div>
                                        <div class="card-body">
                                            <?php

                                                foreach ($members as $member) {
                                                    $uuid = $member->uuid;
                                                    $rank = $member->rank;
                                                    $joined = $member->joined;
                                                    $quests = $member->questParticipation;
                                                    $name = getRealName($connection, $uuid);

                                                    echo '<div class="card"><div class="card-body">';
                                                    echo "[" . $rank . "] " . $name . " - " . $quests . " quests participated in.<br>";
                                                    echo '</div></div>';
                                                }

                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </main>

                <?php } require "includes/footer.php"; ?>

                <script>
                    var ctxP = document.getElementById("expPie").getContext('2d');
                    var pbPie = new Chart(ctxP, {
                        type: 'horizontalBar',
                        data: {
                            labels: ["Warlords", "UHC", "Blitz Survival Games", "SkyWars", "Duels", "Paintball", "Arena Brawl", "TNT Games", "Cops and Crims", "The Walls", "VampireZ", "Turbo Kart Racers", "Smash Heroes", "Quakecraft", "Build Battle", "Arcade", "Prototype (Includes Skyblock)", "Mega Walls", "Housing", "Murder Mystery", "Bedwars"],
                            datasets: [{
                                label: "Guild EXP By Game",
                                data: ["<?php echo $battleground_exp; ?>", "<?php echo $uhc_exp; ?>", "<?php echo $bsg_exp; ?>", "<?php echo $skywars_exp; ?>", "<?php echo $duels_exp; ?>", "<?php echo $paintball_exp; ?>", "<?php echo $arena_exp; ?>", "<?php echo $tntgames_exp; ?>", "<?php echo $mcgo_exp; ?>", "<?php echo $walls_exp; ?>", "<?php echo $vz_exp; ?>", "<?php echo $gingerbread_exp; ?>", "<?php echo $super_smash_exp; ?>", "<?php echo $qc_exp; ?>", "<?php echo $bb_exp; ?>", "<?php echo $arcade_exp; ?>", "<?php echo $prototype_exp; ?>", "<?php echo $walls3_exp; ?>", "<?php echo $housing_exp; ?>", "<?php echo $mm_exp; ?>", "<?php echo $bedwars_exp; ?>"],
                                backgroundColor: ["#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A"],
                                borderColor: ["#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A", "#46BFBD", "#F7464A"]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                    });

                </script>

            </div>

    </body>
</html>
