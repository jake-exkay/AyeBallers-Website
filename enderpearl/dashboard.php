<?php
/**
 * Enderpearl dashboard page - Important notifications and links to other areas.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/admin/dashboard
 */

require "../includes/links.php";
require "../includes/constants.php";
require "../functions/backend_functions.php";
require "../includes/connect.php";
require "../functions/display_functions.php";
require "../functions/player_functions.php";
require "../functions/database/guild_member_functions.php";
require "../admin/functions/database_functions.php";
require "../admin/functions/login_functions.php";

if (isLoggedIn($connection)) {

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Enderpearl Guild Manager</title>
    </head>

    <body>

        <main>

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Notifications
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>Paintball God <b>ExKay</b> has been inactive for 2 months! However, they are a veteran with 11 months, 3 days of service. Kick only if necessary. <small><em>24 minutes ago</em></small></li>
                                        <li>Member <b>AyeCool</b> has been inactive for 2 months! They have never earned any GEXP. Kick if slots are needed. <small><em>2 hours ago</em></small></li>
                                        <li>Officer <b>Penderdrill</b> has been inactive for 2 weeks! <small><em>12 hours ago</em></small></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Guild Log
                                </div>
                                <div class="card-body">
                                    + <b>mmxw11</b> joined the guild <small><em>2 hours ago</em></small><br>
                                    + <b>MatthewRTP</b> joined the guild <small><em>5 hours ago</em></small><br>
                                    - <b>SonOfAtch</b> left the guild <small><em>12 hours ago</em></small><br>
                                    + <b>Plancke</b> joined the guild <small><em>1 day ago</em></small><br>
                                    - <b>Penderdrill</b> was demoted from Officer to Paintball God <small><em>1 day ago</em></small><br>
                                    - <b>PotAccuracy</b> left the guild <small><em>2 days ago</em></small><br>
                                    + <b>Emilyie</b> was promoted from Member to Elite <small><em>2 days ago</em></small>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    General Statistics
                                </div>
                                <div class="card-body">
                                    <b>115</b> Total Members<br>
                                    <b>12</b> Total Staff Members<br>
                                    <b>53</b> Active Members Today<br>
                                    <b>201,031</b> GEXP Earned Today<br>
                                    <b>1,023,432</b> GEXP Earned This Week
                                </div>
                            </div>

                        </div>

                        <div class="col-md-8">

                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table mr-1"></i>
                                    Member List
                                </div>
                                <div class="card-body">
                                    <table id="memberList" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Name</th>
                                                <th>Guild Rank</th>
                                                <th>GEXP Today</th>
                                                <th>Paintball Kills</th>
                                                <th>Length of Service</th>
                                                <th>Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $result = getGuildMembersInOrder($connection);

                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        $uuid = $row["UUID"];
                                                        $g_rank = $row["guild_rank"];
                                                        $exp = $row["daily_exp"];
                                                        $player = getLocalPlayer($mongo_mng, $uuid);
                                                        $rank = $player->rank;
                                                        $rank_colour = $player->rankColour;
                                                        $name = $player->name;
                                                        $rank_with_name = getRankFormatting($name, $rank, $rank_colour);
                                                        $kills = getPaintballKills($mongo_mng, $uuid);

                                                        echo '<tr>';
                                                            echo '<td><a href="../stats.php?player=' . $name . '">' . $rank_with_name . '</a></td>';
                                                            echo '<td>' . $g_rank . '</td>';

                                                            if ($exp > 5000) {
                                                                echo '<td class="table-success">' . number_format($exp) . '</td>';
                                                            } else if ($exp > 0 && $exp < 5000) {
                                                                echo '<td class="table-warning">' . number_format($exp) . '</td>';
                                                            } else {
                                                                echo '<td class="table-danger">' . number_format($exp) . '</td>';
                                                            }

                                                            if ($kills > 100000) {
                                                                echo '<td class="table-success">' . number_format($kills) . '</td>';
                                                            } else if ($kills > 20000 && $kills < 100000) {
                                                                echo '<td class="table-warning">' . number_format($kills) . '</td>';
                                                            } else {
                                                                echo '<td class="table-danger">' . number_format($kills) . '</td>';
                                                            }

                                                            echo '<td>2 months, 5 days</td>';
                                                            echo '<td>Yes</td>';
                                                        echo '</tr>'; 

                                                    }
                                                }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </main>

    </body>

</html>

<?php } else {
    header("Refresh:0.05; url=../../error/403.php");
} ?>
