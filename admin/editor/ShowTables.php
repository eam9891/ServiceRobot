<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/21/2017
 * Time: 9:39 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    class ShowTables {
        private $dbConn;

        public function getNames(User $User) {
            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();
            $result = $dbConn->query("SHOW TABLES");
            $returnArr = $result->fetch_all();
            $result->close();
            $dbConn->close();
            return $returnArr;
        }

    }
}