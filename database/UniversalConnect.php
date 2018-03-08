<?php

namespace database {

    ini_set("display_errors","1");
    ERROR_REPORTING( E_ALL | E_STRICT );

    include_once('IConnectInfo.php');

    class UniversalConnect implements IConnectInfo {

        private static $server    = IConnectInfo::HOST;
        private static $currentDB = IConnectInfo::DBNAME;
        private static $user      = IConnectInfo::UNAME;
        private static $pass      = IConnectInfo::PW;
        private static $hookup;

        public static function doConnect() {
            // Procedural way
            //self::$hookup=mysqli_connect(self::$server, self::$user, self::$pass, self::$currentDB);

            // Object Oriented way
            self::$hookup = new \mysqli(self::$server, self::$user, self::$pass, self::$currentDB);

            try {
                self::$hookup;
            }
            catch (\Exception $e) {
                echo "There is a problem: " . $e->getMessage();
                exit();
            }
            return self::$hookup;
        }

        public static function disconnect() {
            self::$hookup = false;

        }
    }

}