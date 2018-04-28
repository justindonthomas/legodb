<?php
/**
 * Help build the landing page.
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
        return '<div class="blueback outline">
                <span class="leftalign"> Logged in as: '.$this->userName.'</span>
                <span class="rightalign"><a href="pageScripts/logout.php">Log Out.</a></span> <br>
                </div>';
    }

    public function getSearchOptions() {
        $optionsString = '
                <option value = ""></option>
                <option value="minifig"> minifig </option>
                <option value="set"> set </option>
                <option value="set inventory"> set inventory </option>
                <option value="minifig inventory"> minifig inventory </option>
                <option value="my favorites"> my favorites </option>
                <option value="image"> image </option>';
        if($this->isAdmin) {
            $optionsString = $optionsString.'<option value="user"> user </option>';
        }
        return $optionsString;
    }
}