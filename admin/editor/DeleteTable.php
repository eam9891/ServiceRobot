<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/25/2017
 * Time: 4:27 PM
 */

namespace admin\editor {

    use admin\IAdminUI;
    use database\UniversalConnect;

    class DeleteTable extends IAdminUI {
        private $error;

        public function __construct(string $tableName) {
            parent::__construct();
            $dbConn = UniversalConnect::doConnect();
            $query = "
                DROP TABLE $tableName
            ";
            $stmt = $dbConn->query($query);
            if ($stmt === true) {
                $this->error = true;
            } else {
                $this->error = $dbConn->error;
            }
        }

        public function __toString() {
            return $this->error;
        }
    }
}