<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 2/13/2017
 * Time: 8:59 AM
 */

namespace admin\system {

    class SystemInfo extends ISystem {

        private function Uptime() {

            $str   = @file_get_contents("/proc/uptime"); // Read the contents of the uptime file
            $num   = floatval($str); // Converts the string to a float

            $secs  = $num % 60; // Returns the remainder(modulo) of $num / 60
            $num   = (int)($num / 60);
            $mins  = $num % 60;
            $num   = (int)($num / 60);
            $hours = $num % 24;
            $num   = (int)($num / 24);
            $days  = $num;

            return array(
                "days" => $days,
                "hours" => $hours,
                "mins" => $mins,
                "secs" => $secs
            );
        }

        public function buildUI() {
            $hostname   = gethostname();
            $ut         = $this->Uptime();
            $uptime     = "$ut[days] days, $ut[hours] hours, $ut[mins] mins";
            $os         = PHP_OS;
            $usage      = $this->formatBytes(memory_get_usage());
            $UI = <<<HTML

<div class="e-panel">
    <div class="e-panel-header">
        <div class="text-center">
            System Information
        </div>
        
    </div>
    <div class="e-panel-body">
   
        Hostname: <span class="green">$hostname</span>
        <div class="divider"></div><br>
        
        OS: <span class="green">$os</span>
        <div class="divider"></div><br>
        
        Uptime: <span class="sys-info">$uptime</span>
        <div class="divider"></div><br>
        
        Current Script Usage: <span class="sys-info">$usage</span>
        
    </div>
</div>

HTML;
            return $UI;
        }


    }

}





