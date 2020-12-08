<?php
/**
 * Contains functions for displaying information.
 * PHP version 7.2.34
 *
 * @category Functions
 * @package  AyeBallers
 * @author   ExKay <exkay61@hotmail.com>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * @link     http://ayeballers.xyz/
 */

    /**
     * Displays a staff member with formatting, used on home page.
     *
     * @param $name Name of the staff member.
     * @param $rank Rank of the staff member.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function displayStaffMember($name, $rank) 
    {
        echo '<div class="row">';
        echo '<div class="col-md-10" style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 20px;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img alt="Player Icon" style="height: 50px; width: 50px;" src="assets/img/' . $name . '.png"/>';
        echo '<h5>' . $name . '</h5>';
        echo '<h6>' . $rank . '</h6>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Displays a guild member, used on the guild page.
     *
     * @param $name Name of the member.
     * @param $uuid UUID of the member.
     * @param $rank Rank of the member.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function displayGuildMember($name, $uuid, $rank) 
    {
        echo '<div class="col-md-2" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 20px;">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<center><img alt="Player Avatar" style="height: 50px; width: 50px;" src="https://crafatar.com/avatars/' . $uuid . '"/>';
        echo '<h5>' . $name . '</h5>';
        echo '<h6>' . $rank . '</h6></center>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    /**
     * Displays button for updating guild members.
     *
     * @param $API_KEY Key for the Hypixel API.
     *
     * @author ExKay <exkay61@hotmail.com>
     */
    function displayGuildMemberUpdateButton($API_KEY) 
    {
        echo '<div>';
        if (apiLimitReached($API_KEY)) {
            echo '<button type="submit" title="API limit reached, please refresh the page." class="btn btn-danger">Update</button>';
        } else { 
            echo '<form action="../../../functions/member_update.php">';
            echo '<button type="submit" title="Update guild members" class="btn btn-success">Update</button>';
            echo '</form>';
        }
        echo '</div>';
    }

?>