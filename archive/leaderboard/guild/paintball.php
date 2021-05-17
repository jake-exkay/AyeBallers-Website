<?php
/**
 * Paintball Leaderboard - Guild
 * PHP version 7.2.34
 *
 * @category Page
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/leaderboard/overall/paintball.php
 */

require "../../includes/links.php";
include "../../includes/connect.php";
include "../../functions/backend_functions.php";
include "../../functions/player_functions.php";
include "../../functions/leaderboard_functions.php";
include "../../admin/functions/login_functions.php";

updatePageViews($connection, 'paintball_overall_leaderboard', $DEV_IP);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Guild Leaderboard - Paintball</title>
    </head>

    <body class="sb-nav-fixed">

        <?php require "../../includes/navbar.php"; ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <br>
                        <h1 class="event_font">Paintball Leaderboard</h1>
                        <hr>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Guild Leaderboard - Paintball
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="leaderboard" class="table table-striped table-bordered table-lg" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Position (Kills)</th>
                                                <th>Guild</th>
                                                <th>Kills</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $result = getGuildPaintballLeaderboard($mongo_mng);
                                            $i = 1;

                                            foreach ($result as $guild => $kills) {
                                                echo '<tr>';
                                                    echo '<td>' . $i . '</td>';
                                                    echo '<td>' . $guild . '</td>';
                                                    echo '<td>' . number_format($kills) . '</td>';
                                                echo '</tr>'; 
                                                $i = $i + 1;
                                            }

                                        ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>

                <?php include "../../includes/footer.php"; ?>
                <script>
                    $(document).ready(function () {
                    $('#leaderboard').DataTable({
                    });
                    $('.dataTables_length').addClass('bs-select');
                    });
                </script>
                
            </div>
        </div>

    </body>
</html>
