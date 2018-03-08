<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/29/2017
 * Time: 7:26 PM
 */

namespace admin\system {


    abstract class ISystem {

        abstract function buildUI();

        public function formatBytes($bytes, $precision = 2) {

            $prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
            for ($i = 0; $bytes >= 1024 && $i < (count($prefix) -1); $bytes /= 1024, $i++);
            return (round($bytes, $precision) . " " . $prefix[$i] );

        }
    }
}