<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/29/2017
 * Time: 7:56 PM
 */

namespace admin\system {

    class CpuInfo extends ISystem {

        public function buildUI() {
            $load = sys_getloadavg();
            $cpu1 = 339.292 * (0.5 - ($load[0]/100));
            $cpu2 = 339.292 * (0.5 - ($load[1]/100));
            $cpu3 = 339.292 * (0.5 - ($load[2]/100));
            $UI = <<<HTML

<style>
    @-webkit-keyframes cpu-progress {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu1; }
    }
    @keyframes cpu-progress {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu1; }
    }
    @-webkit-keyframes cpu-progress-2 {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu2; }
    }
    @keyframes cpu-progress-2 {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu2; }
    }
    @-webkit-keyframes cpu-progress-3 {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu3; }
    }
    @keyframes cpu-progress-3 {
        from { stroke-dashoffset: 339.292; }
        to { stroke-dashoffset: $cpu3; }
    }
    
</style>

<div class="e-panel">
    <div class="e-panel-header">
        <div class="text-center">
            Load Averages
        </div>
    </div>
    <div class="e-panel-body">
        <div class="e-row">
            <div class="e-col-4">
                <!---->
                <p class="text-center"> 1 Min </p>
                <div class="cpu-meter">
                    
                    
                    <svg class="cpu-progress" width="120" height="60">
                        <circle class="cpu-progress-background" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                        <circle class="cpu-progress-value" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                    </svg>
                </div>
                <div class="cpu-progress-text"> $load[0] % </div>
                
            </div>
            <div class="e-col-4">
                <p class="text-center"> 5 Min </p>
                <div class="cpu-meter">
                    
                    
                    <svg class="cpu-progress-2" width="120" height="60">
                        <circle class="cpu-progress-background" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                        <circle class="cpu-progress-value" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                    </svg>
                </div>
                <div class="cpu-progress-text"> $load[1] % </div>
            </div>
            <div class="e-col-4">
                <p class="text-center"> 10 Min </p>
                <div class="cpu-meter">
                    
                    
                    <svg class="cpu-progress-3" width="120" height="60">
                        <circle class="cpu-progress-background" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                        <circle class="cpu-progress-value" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                    </svg>
                </div>
                <div class="cpu-progress-text"> $load[2] % </div>
            </div>
            
        </div>
        
    </div>
</div>

HTML;
            unset($load);
            unset($cpu1);
            unset($cpu2);
            unset($cpu3);
            return $UI;
        }
    }
}