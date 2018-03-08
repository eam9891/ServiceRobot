<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/1/2017
 * Time: 10:45 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\Encryption;
    use libs\User;

    class InsertNewUser {

        public function insertUser(User $User, array $data) {

            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();

            $username = $data['username'];
            $password = $data['password'];
            $role     = $data['role'];

            $salt = Encryption::generateSalt();
            $encryptedPassword = Encryption::eCrypt($password, $salt);

            $query = "
                INSERT INTO users (username, password, salt, role)
                VALUES ('$username', '$encryptedPassword', '$salt', '$role')
            ";

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