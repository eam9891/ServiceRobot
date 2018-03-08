<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/25/2017
 * Time: 6:03 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    class InsertNewRecord {

        public function insert(User $User, string $tableName, array $data) {
            $dbColNames =[];
            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();
            $query = "DESCRIBE $tableName";
            try {
                $result = mysqli_query($dbConn,$query);
                while($column = $result->fetch_array()) {
                    $x = 0;

                    //echo $column['Field'] . " " .$column['Type'] . " " . $column['Null'] . " " . $column['Key'] . " " . $column['Default'] . " " . $column['Extra'] . "<br>";
                    $dbColNames[] = $column['Field'];
                    if ($column['Key'] == "PRI") {
                        array_splice($data, $x, 1);
                        array_splice($dbColNames, $x, 1);
                    }

                }
                $result->close();
            }
            catch(\Exception $e) {
                return "Here's what went wrong: " . $e->getMessage();
            }

            // prepare and bind
            $query = "INSERT INTO $tableName (";
            foreach ($dbColNames as $value) {
                $query .= $value . ", ";
            }
            $query = rtrim($query, ", ");

            $query .= ") VALUES (";
            foreach ($data as $key => $value) {
                if ($value == "NOW()" || $value == "now()" || $value == "Now()") {
                    $query .= "$value" . ", ";
                } else {
                    $query .= "'$value'" . ", ";
                }


            }
            $query = rtrim($query, ", ");
            $query .= ")";
            //echo $query;

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