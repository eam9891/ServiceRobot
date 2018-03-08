<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/11/2017
 * Time: 4:44 PM
 */

namespace database {

    include_once "../database/UniversalConnect.php";
    include_once "../libs/Encryption.php";
    use libs\Encryption;

    class SetupDB extends UniversalConnect {
        private $dbConn;

        public function __construct() {

            $this->dbConn = UniversalConnect::doConnect();

            if($this->dbConn) {
                //$this->dropUsersTable();
                //$this->createUsersTable();
                //$this->createAdmin();
                //$this->testTable();
                //$this->createTestTables();
            }

        }

        private function createTestTables() {
            $result = mysqli_query($this->dbConn, "CREATE TABLE test1 (t1id int not null AUTO_INCREMENT PRIMARY KEY, t1text text)");
        }

        private function dropUsersTable() {
            $query = "
                DROP TABLE users
            ";
            $stmt = $this->dbConn->query($query);
            if ($stmt === true) {
                echo "Successfully deleted users table. <br>";
            } else {
                echo $this->dbConn->error;
            }
        }

        private function createUsersTable() {
            $query = "
                CREATE TABLE IF NOT EXISTS users (
                    userID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(64) NOT NULL,
                    password VARCHAR(64) NOT NULL,
                    salt VARCHAR(64),
                    role VARCHAR(64)
                ) 
            ";


            $stmt = $this->dbConn->query($query);
            if ($stmt === true) {
                echo "Successfully created users table. <br>";
            } else {
                echo "Error: " . $stmt . "<br>" . $this->dbConn->error;
            }

        }

        private function createAdmin() {
            $username = "admin";
            $password = "password";
            $role = "admin";
            $salt = Encryption::generateSalt();
            $encryptedPassword = Encryption::eCrypt($password, $salt);

            $query = "
                INSERT INTO users (username, password, salt, role)
                VALUES ('$username', '$encryptedPassword', '$salt', '$role')
            ";

            $stmt = $this->dbConn->query($query);
            if ($stmt === true) {
                echo "Successfully created default admin. <br>";
            } else {
                echo "Error: " . $stmt . "<br>" . $this->dbConn->error;
            }


        }

        private function testTable() {
            $query = "
                SELECT userID, username, password, salt, role FROM users
            ";
            try {
                $stmt = $this->dbConn->query($query);

            }
            catch (\Exception $e) {
                echo "There is a problem: " . $e->getMessage();
                exit();
            }

            while ($row = $stmt->fetch_assoc()) {
                $id = $row['userID'];
                $un = $row['username'];
                $pw = $row['password'];
                $st = $row['salt'];
                $rl = $row['role'];

                echo <<< HTML
<style>
    .border {
        border: 1px solid black;
    }
</style>
<table>
    <tr>
        <th class="border">User ID</th>
        <th class="border">Username</th>
        <th class="border">Password</th>
        <th class="border">Salt</th>
        <th class="border">Role</th>
    </tr>
    <tr>
        <td class="border">$id</td>
        <td class="border">$un</td>
        <td class="border">$pw</td>
        <td class="border">$st</td>
        <td class="border">$rl</td>
    </tr>
    
</table>


HTML;

            }

        }


    }

    $worker = new SetupDB();

}