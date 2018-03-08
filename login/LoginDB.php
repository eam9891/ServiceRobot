<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/14/2017
 * Time: 1:00 PM
 */

namespace login {

    include "../database/UniversalConnect.php";
    use database\UniversalConnect;

    class LoginDB {
        private $dbConn;

        public function __construct() {
            $this->dbConn = UniversalConnect::doConnect();
        }

        public function getUsername(string $username) {

        }

        public function getPassword(string $encryptedPassword) {

        }

    }
}