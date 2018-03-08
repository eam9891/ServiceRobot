<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/13/2017
 * Time: 11:50 PM
 */

namespace admin {

    include_once "IAdminUI.php";

    use admin\editor\ShowTables;
    use admin\editor\TableLinks;
    use admin\system\CpuInfo;
    use admin\system\DiskInfo;
    use admin\system\NetInfo;
    use admin\system\RamInfo;
    use admin\system\System;
    use admin\system\SystemInfo;

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class AdminUI extends IAdminUI {

        public function __construct() {
            parent::__construct();
            self::showUI();
        }

        public function showUI() {

            $header     = new Header();
            $footer     = new Footer();
            $header     = $header->returnUI();
            $footer     = $footer->returnUI();
            $SystemInfo = new SystemInfo();
            $CpuInfo    = new CpuInfo();
            $DiskInfo   = new DiskInfo();
            $NetInfo    = new NetInfo();
            $Memory     = new RamInfo();
            $System     = new System();
            $info       = $System->returnUI($SystemInfo);
            $cpu        = $System->returnUI($CpuInfo);
            $disk       = $System->returnUI($DiskInfo);
            $network    = $System->returnUI($NetInfo);
            $ram        = $System->returnUI($Memory);
            $ShowTables = new ShowTables();
            $TableLinks = new TableLinks();
            $AdminPanel = new AdminPanelUI();
            $sideNav    = $AdminPanel->returnUI($this->User, $TableLinks, $ShowTables);

            echo <<<HTML

            $header
            <div class="wrap">
                $sideNav
                
                <div class="main">
                
                    <div class="e-row">
                        <div class="e-col-4 e-col-m-4">
                            $info
                        </div>
                        <div class="e-col-8 e-col-m-4">
                            $cpu
                        </div>
                    </div>
                    
                    <div class="e-row">
                        <div class="e-col-8">
                            $network
                        </div>
                        <div class="e-col-4">
                            $ram
                        </div>
                    </div>
                    
                    <div class="e-row">
                        <div class="e-col-12">
                            $disk
                        </div>
                    </div>
                    
                </div>
                
            </div>
            $footer

HTML;

            unset($header);
            unset($footer);
            unset($SystemInfo);
            unset($CpuInfo);
            unset($DiskInfo);
            unset($NetInfo);
            unset($Memory);
            unset($System);
            unset($info);
            unset($cpu);
            unset($disk);
            unset($network);
            unset($ram);
            unset($ShowTables);
            unset($TableLinks);
            unset($AdminPanel);
            unset($sideNav);

        }

    }
    $worker = new AdminUI();
}