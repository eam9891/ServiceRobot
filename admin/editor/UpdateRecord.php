<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/1/2017
 * Time: 9:33 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    class UpdateRecord {

        public function update(User $User, string $tableName, array $data, int $id) {
            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();
            $tableID = 0;

            $result = mysqli_query($dbConn, "SHOW COLUMNS FROM $tableName");
            while($column = $result->fetch_array()) {
                if ($column['Key'] == "PRI") {
                    array_splice($data, 0, 1);
                    $tableID = $column['Field'];
                }
            }

            // prepare and bind
            $query = "UPDATE $tableName SET ";
            foreach ($data as $key => $value) {
                $query .= $key . "='$value', ";
            }
            $query = rtrim($query, ", ");
            $query .= " WHERE $tableID = $id";

            //echo $query . "<br>";

            /**/
            $stmt = $dbConn->query($query);
            if ($stmt === false) {
                $error = true;
            } else {
                $error = "Error: " . $stmt . "<br>" . $dbConn->error;
            }

            $dbConn->close();
            return $error;

        }

    }
}