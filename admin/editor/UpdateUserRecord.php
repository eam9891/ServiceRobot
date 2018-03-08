<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/4/2017
 * Time: 10:33 PM
 */

namespace admin\editor {

    use database\UniversalConnect;
    use libs\Authorize;
    use libs\Encryption;
    use libs\User;

    class UpdateUserRecord {
        public function update(User $User, array $userRow) {

            Authorize::AdminOnly($User);
            $dbConn = UniversalConnect::doConnect();

            $userID = $userRow['userID'];
            $username = $userRow['username'];
            $role = $userRow['role'];
            $salt = Encryption::generateSalt();
            $encryptedPassword = Encryption::eCrypt($userRow['password'], $salt);

            // prepare and bind
            $query = "UPDATE users SET username='$username', password='$encryptedPassword', salt='$salt', role='$role' WHERE userID ='$userID'";

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