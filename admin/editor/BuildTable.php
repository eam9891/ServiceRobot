<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/24/2017
 * Time: 10:07 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);


    class BuildTable {

        /**
         *
         *
         * @param \libs\User $User         The user object, needed for authentication (admin only)
         * @param string     $tableName    The name of the database table
         * @param bool       $addRecord    Parameter to add an empty line if adding a new record
         *
         * @return string
         */
        public function getDataTable(User $User, string $tableName, bool $addRecord) {

            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();
            $thValues   = "";
            $tdValues   = "";


            $dbColNames = [];
            $result = mysqli_query($dbConn, "SHOW COLUMNS FROM $tableName");
            while($column = $result->fetch_assoc()) {

                $dbColNames[] = $column['Field'];
            }

            foreach ($dbColNames as $key=>$value) {
                $thValues .= "<th class='db-data-head'>$value</th>";
            }


            $result = mysqli_query($dbConn, "SELECT * FROM $tableName");
            $numRows = mysqli_num_rows($result);
            $numRows = count($numRows);

            if($numRows) {
                $y = 1;
                while($row2 = mysqli_fetch_assoc($result)) {
                    $tdValues .= '<tr>';
                    for ($x = 0; $x < $numRows; $x++) {
                        foreach($row2 as $key => $value) {
                            $tdValues .= "<td class='db-data'><input type='text' name='data[$y][$key]' value='$value'></td>";
                        }
                    }
                    $tdValues .= '</tr>';
                    $y++;
                }
            }

            if ($addRecord) {
                $tdValues .= '<input type="hidden" name="insertNewRecord" value="InsertNewRecord">';
                $tdValues .= '<tr>';
                foreach($dbColNames as $key=>$value) {
                    $tdValues .= "<td class='db-data'><input type='text' name='new[$value]'></td>" ;
                }
                $tdValues .= '</tr>';
            }



            $dataTable = "
                
                <div style='overflow-x:auto;'>
                    <table>
                        <tr>
                            $thValues
                        </tr>
                        $tdValues
                    </table>
                </div>
                
            ";

            $result->close();
            $dbConn->close();
            unset($dbColNames);
            unset($column);
            unset($row2);
            unset($result); 

            //todo: limit the results
            //todo: add pagination so were not sending the entire table to be updated
            //todo: using ajax here will make this much more efficient, send only rows that are changed

            return $dataTable;
        }

        public function pagination() {

        }
    }
}