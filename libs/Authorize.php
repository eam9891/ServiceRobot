<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/13/2017
 * Time: 12:44 AM
 */

namespace libs {

    class Authorize {

        public static $auth;

        public static function AdminOnly(User $obj) {
            $role = $obj->getRole();
            if ($role !== "admin") {
                self::escortOut();
            }
        }

        public static function Contributor(User $obj) {
            $role = $obj->getRole();
            if ($role !== "admin" || $role !== "contributor") {
                self::escortOut();
            }
        }

        public static function User(User $obj) {
            $role = $obj->getRole();
            if ($role !== "admin" || $role !== "contributor" || $role !== "user") {
                self::escortOut();
            }
        }

        public static function escortOut() {
            $obj = null;
            session_abort();
            header("Location: ../");
            die("Redirecting to: ../");
        }
    }
}