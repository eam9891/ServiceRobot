<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/21/2017
 * Time: 4:55 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\User;

    spl_autoload_register(function($class) {
        include "../../" . str_replace('\\', '/', $class) . '.php';
    });

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class InsertNewTable {
        public static function insertTable() {
            session_start();
            $userID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
            $worker = new User();
            $User = $worker->getUser($userID);
            Authorize::AdminOnly($User);

            if (empty($_POST['tableName']) || empty($_POST['numCols'])) {
                session_abort();
                header("Location: ../");
                die("Redirecting to: ../");
            }


            $colsPreview = "";
            $cols = "";
            $numCols   = $_POST['numCols'];
            $tableName = $_POST['tableName'];
            unset($_POST['numCols']);
            unset($_POST['tableName']);



            for ($x = 1; $x <= $numCols; $x++) {
                $notNull = "";
                $autoInc = "";
                $unique  = "";
                $primary = "";
                $n = "notNull" . $x;
                $a = "autoInc" . $x;
                $u = "unique"  . $x;
                $p = "primary" . $x;

                $colName = $_POST['columnName' . $x];
                $colType = $_POST['columnType' . $x];

                if (isset($_POST[$n])) {
                    $notNull = " NOT NULL ";
                }
                if (isset($_POST[$a])) {
                    $autoInc = " AUTO_INCREMENT ";
                }
                if (isset($_POST[$u])) {
                    $unique = " UNIQUE ";
                }
                if (isset($_POST[$p])) {
                    $primary = " PRIMARY KEY";
                }
                $cols .= $colName. ' ' .$colType. ' ' .$notNull.$autoInc.$unique.$primary.',';

                $colsPreview .= <<<HTML

    &emsp;&emsp; $colName <i>$colType</i>$notNull$autoInc$unique$primary, <br>

HTML;

            }

            $cols = rtrim($cols, ',');
            $preview = <<<HTML
     
<p style="color: #9b9b9b">
    SQL Query = "<br>
        &emsp;CREATE TABLE $tableName (<br>
            $colsPreview
        &emsp;)<br>
    ";         
</p>

HTML;


            $dbConn = UniversalConnect::doConnect();
            $query = "CREATE TABLE $tableName (
                $cols
            )";
            $stmt = $dbConn->query($query);
            if ($stmt === true) {
                echo "Successfully created $tableName table. <br>";
            } else {
                echo "Error: " . $stmt . "<br>" . $dbConn->error;
            }

            echo $preview;
        }
    }

    InsertNewTable::insertTable();

}