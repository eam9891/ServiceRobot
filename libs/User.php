<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/10/2017
 * Time: 11:40 PM
 */


namespace libs {

    use database\UniversalConnect;

    class User {

        private $user;
        private $userID;
        private $username;
        private $role;

        public function getUserID() {
            return $this->userID;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getRole() {
            return $this->role;
        }

        public function setUsername($username) {
            $this->username = $username;
        }

        public function setUserID($userID) {
            $this->userID = $userID;
        }

        public function setRole($role) {
            $this->role = $role;
        }


        /**
         * Returns the User Object provided the id of the user.
         *
         * @param string  $userID
         *
         * @return \libs\User
         */
        public function getUser(string $userID) : User {
            if ($userID == 0) {
                Authorize::escortOut();
            }

            $dbConn = UniversalConnect::doConnect();
            $row = [];

            $query = "
                SELECT
                    userID, username, role
                FROM users
                WHERE
                    userID = ?
            ";

            if ($stmt = $dbConn->prepare($query)) {
                $stmt->bind_param("s",$userID);
                $stmt->execute();
                $stmt->bind_result($uid, $un, $ro);

                while ($stmt->fetch()) {
                    $row['userID'] = $uid;
                    $row['username'] = $un;
                    $row['role'] = $ro;
                }

            } else {
                $error = $dbConn->errno . ' ' . $dbConn->error;
                echo $error;
            }


            $this->user = new User();
            $this->user->arrToUser($row);
            return $this->user;
        }

        /**
         * Set's the user details returned from the query into the current object.
         *
         * @param array $userRow
         */
        public function arrToUser($userRow) {
            if (!empty($userRow)) {
                isset($userRow['userID'])   ? $this->setUserId($userRow['userID'])     : '';
                isset($userRow['username']) ? $this->setUsername($userRow['username']) : '';
                isset($userRow['role'])     ? $this->setRole($userRow['role'])         : '';
            }
        }
    }
}