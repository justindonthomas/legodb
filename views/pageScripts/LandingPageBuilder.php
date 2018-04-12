<?php
/**
 * Created by PhpStorm.
 * User: jdt
 * Date: 4/12/18
 * Time: 2:42 PM
 */

class LandingPageBuilder
{
    private $userName;
    private $userId;
    private $isAdmin;

    public function __construct($sessionObject) {
        $this->userName = $sessionObject['s_user'];
        $this->userId = $sessionObject['s_id'];
        $this->isAdmin = $sessionObject['is_admin'];
    }

    public function getTopBar() {
        return '<span class="leftalign"> Logged in as: '.$this->userName.'</span>
                <span class="rightalign"><a href="pageScripts/logout.php">Log Out.</a></span> <br>';
    }
}