<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 5/1/2017
 * Time: 4:28 PM
 */

namespace admin\system;


class RamInfo extends ISystem {

    function Memory(){
        $free = [];
        $total = [];

        $mem = file_get_contents("/proc/meminfo");
        if (preg_match('/MemTotal\:\s+(\d+) kB/', $mem, $matches)) {
            $total = $matches[1];
        }
        unset($matches);
        if (preg_match('/MemFree\:\s+(\d+) kB/', $mem, $matches)) {
            $free = $matches[1];
        }

        $usage = $total - $free;
        $percent = 100 * ($usage / $total);
        return array(
            $this->formatBytes($total*1024),
            $this->formatBytes($free*1024),
            $this->formatBytes($usage*1024),
            round($percent,1),
        );
    }

    public function buildUI() {
        $memory = $this->Memory();
        //$ramPercent = $memory[3];
        //$totalRam   = $memory[0];
        //$usedRam    = $memory[2];
        $UI = <<<HTML

<div class="e-panel">
    <div class="e-panel-header text-center">
        Memory
    </div>
    <div class="e-panel-body">
        <p class="sys-info text-center"> $memory[2] / $memory[0] </p>
        <p class="sys-info text-center"> $memory[1] Free </p>
        
        <div class="memory-progress" data-label="$memory[3] %">
            <span class="value" style="width:$memory[3]%;"></span>
        </div>
        
    </div>
</div>

HTML;
        unset($memory);
        return $UI;
    }

}