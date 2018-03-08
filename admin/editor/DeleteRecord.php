<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/3/2017
 * Time: 9:35 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    class DeleteRecord {
        public function deleteRecord(string $tableName, int $recordID, User $User) {
            Authorize::AdminOnly($User);
            $primaryKey = "";
            $dbConn = UniversalConnect::doConnect();
            $result = mysqli_query($dbConn, "SHOW COLUMNS FROM $tableName");
            while($column = $result->fetch_array()) {
                if ($column['Key'] == "PRI") {
                    $primaryKey = $column['Field'];
                }
            }
            $query = "DELETE from $tableName WHERE $primaryKey = $recordID";
            $dbConn->query($query);
            $dbConn->close();
            //echo $query;
        }
    }
}