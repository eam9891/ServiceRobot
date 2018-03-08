<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 1/21/2018
 * Time: 6:21 PM
 */

namespace admin {

    include_once "IAdminUI.php";
    include_once "gpio/GPIO.php";
    include_once "gpio/SerialPort.php";

    use admin\gpio\PinInterface;
    use admin\editor\ShowTables;
    use admin\editor\TableLinks;
    use admin\gpio\GPIO;
    use admin\gpio\SerialPort;

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class RemoteControlUI extends IAdminUI {

        public function __construct() {
            parent::__construct();
            self::showUI();
        }

        public function showUI() {
            $header     = new Header();
            $footer     = new Footer();
            $header     = $header->returnUI();
            $footer     = $footer->returnUI();

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
                        <div class="e-col-12 e-col-m-12">
                            <div id="output"></div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            <script src="websocket.js"></script>
            <!--<script src="buttonGPIO.js"></script>
            <script src="MotorController.js"></script>-->
            <!--<script src="ReadMessages.js"></script>-->
            $footer

HTML;
            unset($header);
            unset($footer);

            unset($ShowTables);
            unset($TableLinks);
            unset($AdminPanel);
            unset($sideNav);

        }

    }
    $worker = new RemoteControlUI();
}