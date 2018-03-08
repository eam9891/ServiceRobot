<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/4/2017
 * Time: 9:55 PM
 */

namespace admin {

    class Logout {
        public static function logout() {
            session_abort();
            header("Location: https://servicerobot.eserv.us");
            die("Redirecting to: https://servicerobot.eserv.us");
        }
    }
    Logout::logout();

}