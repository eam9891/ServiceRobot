<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/22/2017
 * Time: 1:30 AM
 */

namespace admin {

    use libs\Authorize;
    use libs\User;

    spl_autoload_register(function($class) {
        include "../" . str_replace('\\', '/', $class) . '.php';
    });

    abstract class IAdminUI {
        protected $User;

        public function __construct() {
            if (session_status() === PHP_SESSION_NONE) session_start();
            $userID = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
            $worker = new User();
            $this->User = $worker->getUser($userID);
            Authorize::AdminOnly($this->User);
        }


    }
}