<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/18/2017
 * Time: 10:19 PM
 */

namespace libs {

    class Encryption {

        /** Generates a salt for new users trying to register
         * @return string
         */
        public static function generateSalt() {
            // A salt is randomly generated here to protect again brute force attacks
            // and rainbow table attacks.  The following statement generates a hex
            // representation of an 8 byte salt.  Representing this in hex provides
            // no additional security, but makes it easier for humans to read.
            // For more information:
            // http://en.wikipedia.org/wiki/Salt_%28cryptography%29
            // http://en.wikipedia.org/wiki/Brute-force_attack
            // http://en.wikipedia.org/wiki/Rainbow_table
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            return $salt;
        }

        /** Encryption method
         * @param $notSecurePass (Looking for $_POST['password'])
         * @param $salt          (Looking for the salt generated from registration)
         * @return string        (Returns a securely encrypted password)
         */
        public static function eCrypt($notSecurePass, $salt) {

            // This hashes the password with the salt so that it can be stored securely
            // in your database.  The output of this next statement is a 64 byte hex
            // string representing the 32 byte sha256 hash of the password.  The original
            // password cannot be recovered from the hash.  For more information:
            // http://en.wikipedia.org/wiki/Cryptographic_hash_function
            $hashMe = hash('sha256', $notSecurePass . $salt);

            // Next we hash the hashed value 1000 more times.  The purpose of this is to
            // protect against brute force attacks.  Now an attacker must compute the hash 1000
            // times for each guess they make against a password, whereas if the password
            // were hashed only once the attacker would have been able to make 1000 different
            // guesses in the same amount of time instead of only one.
            for ($round = 0; $round < 65536; $round++) {
                $hashMe = hash('sha256', $hashMe . $salt);
            }
            $encryptedPass = $hashMe;
            return $encryptedPass;
        }

        public function hash($hashString) {
            $hashMe = hash('sha256', $hashString);
            return $hashMe;
        }
    }
}

