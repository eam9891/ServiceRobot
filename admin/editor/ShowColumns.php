<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/25/2017
 * Time: 10:05 PM
 */

namespace admin\editor;


use database\UniversalConnect;
use libs\Authorize;
use libs\User;

class ShowColumns {

    public function getColumns(User $User, string $tableName) {
        Authorize::AdminOnly($User);
        $dbColNames = [];
        $dbConn = UniversalConnect::doConnect();
        $query = "SHOW COLUMNS FROM $tableName";
        try {
            $result = mysqli_query($dbConn,$query);
            while($column = $result->fetch_assoc()) {
                $dbColNames[] = $column['Field'];
            }
            $result->close();
        }
        catch(\Exception $e)
        {
            return "Here's what went wrong: " . $e->getMessage();
        }
        return $dbColNames;

    }

}