<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/13/2017
 * Time: 10:25 PM
 */

namespace libs {


    /*  This SessionManager starts starts the php session (regardless of which handler is set)
        and secures it by locking down the cookie,
        restricting the session to a specific host and browser,
        and regenerating the ID.
    */

    ini_set("display_errors","1");
    ERROR_REPORTING( E_ALL | E_STRICT );

    class SessionManager {

        /**
         * This function starts, validates and secures a session.
         *
         * @param string $name The name of the session.
         * @param int $limit Expiration date of the session cookie, 0 for session only
         * @param string $path Used to restrict where the browser sends the cookie
         * @param string $domain Used to allow subdomains access to the cookie
         * @param bool $secure If true the browser only sends the cookie over https
         */
        static function sessionStart($name, $limit = 0, $path = '/', $domain = null, $secure = null) {

            // Set the cookie name
            session_name($name . '_Session');

            // Set SSL level
            $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);

            // Set session cookie options
            session_set_cookie_params($limit, $path, $domain, $https, true);
            session_start();

            // Make sure the session hasn't expired, and destroy it if it has
            if(self::validateSession()) {

                // Check to see if the session is new or a hijacking attempt
                if(!self::preventHijacking()) {

                    // Reset session data and regenerate id
                    $_SESSION = array();
                    $_SESSION['ipAddress'] = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
                    $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                    self::regenerateSession();

                    // Give a 5% chance of the session id changing on any request
                } elseif (rand(1, 100) <= 5){
                    self::regenerateSession();
                }
            } else {
                $_SESSION = array();
                session_destroy();
                session_start();
            }
        }

        /**
         * This function sets a session variable.
         * @param string $key
         * @param string $value
         */
        static function sessionSet(string $key, $value) {
            $_SESSION[$key] = $value;
        }

        /**
         * This function un-sets a session variable
         * @param string $key
         */
        static function sessionUnset(string $key) {
            unset($_SESSION[$key]);
        }

        /**
         * This function gets a session variable if set
         *
         * @return mixed
         */
        static function getSessionID() {
            if (isset($_SESSION['id'])) {
                return $_SESSION['id'];
            }
            return false;
        }

        static function isLoggedIn() {
            if (self::validateSession())
                return true;

            return false;
        }

        /**
         * This function regenerates a new ID and invalidates the old session. This should be called whenever permission
         * levels for a user change.
         *
         */
        static function regenerateSession() {

            // If this session is obsolete it means there already is a new id
            if(isset($_SESSION['OBSOLETE']))
                return;

            // Set current session to expire in 10 seconds
            $_SESSION['OBSOLETE'] = true;
            $_SESSION['EXPIRES'] = time() + 10;

            // Create new session without destroying the old one
            session_regenerate_id(false);

            // Grab current session ID and close both sessions to allow other scripts to use them
            $newSession = session_id();
            session_write_close();

            // Set session ID to the new one, and start it back up again
            session_id($newSession);
            session_start();

            // Now we unset the obsolete and expiration values for the session we want to keep
            unset($_SESSION['OBSOLETE']);
            unset($_SESSION['EXPIRES']);
        }

        /**
         * This function is used to see if a session has expired or not.
         *
         * @return bool
         */
        static protected function validateSession() {

            if( isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) )
                return false;

            if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
                return false;

            return true;
        }

        /**
         * This function checks to make sure a session exists and is coming from the proper host. On new visits and hacking
         * attempts this function will return false.
         * For more info: https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet#Session_Hijacking_Prevention
         *
         * @return bool
         */
        static protected function preventHijacking() {

            if(!isset($_SESSION['ipAddress']) || !isset($_SESSION['userAgent']))
                return false;


            $remoteIpHeader = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
            if($_SESSION['ipAddress'] != $remoteIpHeader)
                return false;


            if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
                return false;

            return true;
        }
    }
}