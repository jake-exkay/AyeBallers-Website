<?php
/**
 * Guild page - Shows a list of guild members.
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/guild.php
 */

require "includes/links.php";
require "includes/connect.php";
require "includes/constants.php";
require "functions/functions.php";
require "functions/display_functions.php";

updatePageViews($connection, 'guild_page', $DEV_IP);

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Guild - AyeBallers</title>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main> 

                    <br>

                    <center>
                        <h1 class="ayeballers_font">Guild Members</h1>
                    </center>   

                    <div class="row">
                    <?php

                        $query_gm = "SELECT * FROM guild_members_current WHERE guild_rank = 'Guild Master'";
                        $result_gm = $connection->query($query_gm);

                        if ($result_gm->num_rows > 0) {
                            while ($row = $result_gm->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Guild Master");
                            }
                        }

                        $query_co = "SELECT * FROM guild_members_current WHERE guild_rank = 'CO Master'";
                        $result_co = $connection->query($query_co);

                        if ($result_co->num_rows > 0) {
                            while ($row = $result_co->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Co-Master");
                            }
                        }

                        $query_o = "SELECT * FROM guild_members_current WHERE guild_rank = 'Officer'";
                        $result_o = $connection->query($query_o);

                        if ($result_o->num_rows > 0) {
                            while ($row = $result_o->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Officer");
                            }
                        }

                        $query_v = "SELECT * FROM guild_members_current WHERE guild_rank = 'Veteran'";
                        $result_v = $connection->query($query_v);

                        if ($result_v->num_rows > 0) {
                            while ($row = $result_v->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Veteran");
                            }
                        }

                        $query_e = "SELECT * FROM guild_members_current WHERE guild_rank = 'Elite'";
                        $result_e = $connection->query($query_e);

                        if ($result_e->num_rows > 0) {
                            while ($row = $result_e->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Elite");
                            }
                        }

                        $query_m = "SELECT * FROM guild_members_current WHERE guild_rank = 'Member'";
                        $result_m = $connection->query($query_m);

                        if ($result_m->num_rows > 0) {
                            while ($row = $result_m->fetch_assoc()) {
                                displayGuildMember($row["name"], $row["UUID"], "Member");
                            }
                        }

                    ?>
                    </div>
                    
                    <br>

                </main>

            <?php require "includes/footer.php"; ?>

        </div>

    </body>
</html>
