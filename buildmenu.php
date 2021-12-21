<?php

function buildMenu() {
    global $CFG;
    $R = $CFG->apphome . '/';
    $T = $CFG->wwwroot . '/';
    $adminmenu = isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true";
    $set = new \Tsugi\UI\MenuSet();
    $set->setHome($CFG->servicename, $CFG->apphome);

    if ( isset($CFG->lessons) ) {
        $set->addLeft('Lessons', $R.'lessons');
        if ( isset($CFG->tdiscus) && $CFG->tdiscus  ) $set->addLeft('Discussions', $R.'discussions');
        if ( isset($_SESSION['id']) ) {
            $set->addLeft('My Progress', $R.'assignments');
        }
    }

    if ( isset($_SESSION['id']) ) {
        $submenu = new \Tsugi\UI\Menu();
        $submenu->addLink('Profile', $R.'profile');
        if ( isset($CFG->google_map_api_key) ) {
            $submenu->addLink('Map', $R.'map');
        }
        if ( isset($CFG->badge_path)  ) {
            $submenu->addLink('Badges', $R.'badges');
        }
        if ( file_exists('materials.php') ) {
            $submenu->addLink('Materials', $R.'materials');
        }
        if ( file_exists('privacy.php') ) {
            $submenu->addLink('Privacy', $R.'privacy');
        }
        if ( $CFG->providekeys ) {
            $submenu->addLink('LMS Integration', $T . 'settings');
        }
        if ( isset($CFG->google_classroom_secret) ) {
            $submenu->addLink('Google Classroom', $T.'gclass/login');
        }
        $submenu->addLink('Free App Store', 'https://www.tsugicloud.org');
        if ( $CFG->DEVELOPER ) {
            $submenu->addLink('Test LTI Tools', $T . 'dev');
        }
        $submenu->addLink('Test Tools', $T.'store');
        if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true" ) {
            $submenu->addLink('Administer', $T . 'admin/');
        }
        $submenu->addLink('Logout', $R.'logout');
        if ( isset($_SESSION['avatar']) ) {
            $set->addRight('<img src="'.$_SESSION['avatar'].'" title="'.htmlentities(__('User Profile Menu - Includes logout')).'" style="height: 2em;"/>', $submenu);
            // htmlentities($_SESSION['displayname']), $submenu);
        } else {
            $set->addRight(htmlentities($_SESSION['displayname']), $submenu);
        }
    } else {
        // $set->addLeft('Autograder', $T.'store');
        if ( isset($CFG->google_client_id) && $CFG->google_client_id ) {
            $set->addRight('Login', $T.'login.php');
        }
    }
    $set->addRight('Instructor', 'https://www.pr4e.com');

    return $set;
}
