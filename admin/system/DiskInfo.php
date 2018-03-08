<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/28/2017
 * Time: 8:31 PM
 */

namespace admin\system {


    class DiskInfo extends ISystem {

        public function Disk($disk = false) {

            if(!$disk){ $disk='/';}
            $free = disk_free_space($disk);
            $total = disk_total_space($disk);
            $usage = $total - $free;
            $percent = 100 * $usage / $total;
            return array(
                "total" => $this->formatBytes($total),
                "free" => $this->formatBytes($free),
                "usage" => $this->formatBytes($usage),
                "percent" => round($percent,1),
            );
        }

        public function buildUI() {

            $disk       = $this->Disk();
            $diskUsed   = $disk['usage'];
            $diskTotal  = $disk['total'];
            $diskFree   = $disk['free'];
            $diskPerc   = $disk['percent'];
            $disk = 339.292 * (1 - ($diskPerc/100));

            $UI = <<<HTML

<div class="e-panel">
    <div class="e-panel-header">
        <div class="text-center">
            Storage
        </div>
    </div>
    <div class="e-panel-body">
        <div class="e-row">
            <div class="e-col-6">
                
                <ul class="disk-legend">
                    <li><span class="percent"></span> Used space:&emsp;&emsp; $diskUsed </li>
                    <li><span class="background"></span> Free space:&emsp;&emsp;&nbsp; $diskFree </li>
                    <div class="divider"></div>
                    <p> Total Capacity:&emsp;&emsp; $diskTotal </p>
                </ul>

               
            </div>
            <div class="e-col-6">
                <style>
                    @-webkit-keyframes disk-progress {
                        from {
                            stroke-dashoffset: 339.292;
                        }
                        to {
                            stroke-dashoffset: $disk;
                        }
                    }
                    @keyframes disk-progress {
                        from {
                            stroke-dashoffset: 339.292;
                        }
                        to {
                            stroke-dashoffset: $disk;
                        }
                    }
                </style>
                
                <div class="disk-meter">
                    <!--  these units are relative to the viewport.
                          ((width = height) / 2) - ((stroke-width) / 2) = radius
                          
                    -->
                    <div class="disk-progress-text"> $diskPerc % </div>
                    <svg class="disk-progress" width="120" height="120">
                        <circle class="disk-progress-background" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                        <circle class="disk-progress-value" cx="60" cy="60" r="53" fill="none" stroke-width="14" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

HTML;
            return $UI;
        }

    }
}