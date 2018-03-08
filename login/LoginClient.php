<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/7/2017
 * Time: 1:13 PM
 */

namespace login {

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    spl_autoload_register(function($class) {
        include "../" . str_replace('\\', '/', $class) . '.php';
    });

    use database\UniversalConnect;
    use libs\Encryption;

    class LoginClient extends ILogin {

        public function __construct() {
            $this->MYSQLi = UniversalConnect::doConnect();
            $this->username = $_POST['username'];
            $this->password = $_POST['password'];
            unset ($_POST['username']);
            unset ($_POST['password']);
            $this->checkLogin($this->username, $this->password);
        }

        public function checkLogin($username, $password) {

            $this->username = $username;
            $this->password = $password;
            $dbUsername = "";
            $dbUserID = "";
            $dbPass = "";
            $dbSalt = "";

            $query = "SELECT userID, username, password, salt FROM users WHERE username = ?";
            if ($stmt = $this->MYSQLi->prepare($query)) {
                $stmt->bind_param("s",$this->username);
                $stmt->execute();
                $stmt->bind_result($uid, $un, $pw, $salt);
                while ($stmt->fetch()) {
                    $dbUsername = $un;
                    $dbUserID = $uid;
                    $dbPass = $pw;
                    $dbSalt = $salt;
                }
            } else {
                $error = $this->MYSQLi->errno . ' ' . $this->MYSQLi->error;
                echo $error;
            }


            // If the $result returns true here we know it is a registered username and can continue
            if ($dbUsername) {

                // Using the password submitted by the user and the salt stored in the database,
                // we can now check to see whether the passwords match by hashing the submitted password
                // and comparing it to the hashed version already stored in the database.
                $this->encryption = new Encryption();
                $this->encryptedPass = $this->encryption->eCrypt($this->password, $dbSalt);

                // If they match, then we can successfully log the user in.
                if ($this->encryptedPass == $dbPass) {

                    //SessionManager::sessionStart("eMorris");
                    //SessionManager::sessionSet("id", $dbUserID);
                    session_start();
                    $_SESSION['id'] = $dbUserID;

                    header("Location: ../admin/AdminUI.php");
                    die("Redirecting to: ../admin/AdminUI.php");

                } else {
                    $this->redirect();
                    //echo "error with password check";
                }
            } else {
                $this->redirect();
                //echo "error with username check";
            }
        }

        public function redirect() {
            header("Location: ../");
            die("Redirecting to: ../");
        }
    }

    $worker = new LoginClient();
}

