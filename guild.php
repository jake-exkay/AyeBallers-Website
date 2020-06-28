<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Guild - AyeBallers</title>

        <?php

            include "includes/links.php";
            include "includes/connect.php";
            include "includes/constants.php";
            include "functions/functions.php";
            include "functions/display_functions.php";
            include "functions/text_constants.php";

            updatePageViews($connection, 'guild_page', $DEV_IP);

        ?>

    </head>

    <body class="sb-nav-fixed">

        <?php require "includes/navbar.php"; ?>

            <div id="layoutSidenav_content">

                <main> 

                    <br>

                    <center>
                        <h1 class="ayeballers_font">Guild Members</h1>
                    </center>   

                    <br><br>

                    <?php

                        echo '<center><b><h2>Guild Master</h2></b></center><br>';

                        $query_gm = "SELECT * FROM guild_members_current WHERE guild_rank = 'Guild Master'";
                        $result_gm = $connection->query($query_gm);

                        if ($result_gm->num_rows > 0) {
                            while($row = $result_gm->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                        echo '<br><center><b><h2>Co-Master</h2></b></center><br>';

                        $query_co = "SELECT * FROM guild_members_current WHERE guild_rank = 'CO Master'";
                        $result_co = $connection->query($query_co);

                        if ($result_co->num_rows > 0) {
                            while($row = $result_co->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                        echo '<br><center><b><h2>Officer</h2></b></center><br>';

                        $query_o = "SELECT * FROM guild_members_current WHERE guild_rank = 'Officer'";
                        $result_o = $connection->query($query_o);

                        if ($result_o->num_rows > 0) {
                            while($row = $result_o->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                        echo '<br><center><b><h2>Veteran</h2></b></center><br>';

                        $query_v = "SELECT * FROM guild_members_current WHERE guild_rank = 'Veteran'";
                        $result_v = $connection->query($query_v);

                        if ($result_v->num_rows > 0) {
                            while($row = $result_v->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                        echo '<br><center><b><h2>Elite</h2></b></center><br>';

                        $query_e = "SELECT * FROM guild_members_current WHERE guild_rank = 'Elite'";
                        $result_e = $connection->query($query_e);

                        if ($result_e->num_rows > 0) {
                            while($row = $result_e->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                        echo '<br><center><b><h2>Member</h2></b></center><br>';

                        $query_m = "SELECT * FROM guild_members_current WHERE guild_rank = 'Member'";
                        $result_m = $connection->query($query_m);

                        if ($result_m->num_rows > 0) {
                            while($row = $result_m->fetch_assoc()) {
                                echo '<center>' . $row["name"] . '</center><br>';
                            }
                        }

                    ?>
                    <br>

                </main>

            <?php include "includes/footer.php"; ?>

        </div>

    </body>
</html>
