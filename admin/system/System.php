<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/2/2017
 * Time: 4:25 PM
 */

namespace admin\system {

    class System {
        public function returnUI(ISystem $obj) {
            return $obj->buildUI();
        }
    }
}