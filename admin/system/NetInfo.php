<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/29/2017
 * Time: 7:29 PM
 */

namespace admin\system {


    class NetInfo extends ISystem {

        public function Network(string $adapter = "eth0") {

            if(!$adapter){ $adapter="eth0";}
            $upload = @file_get_contents("/sys/class/net/$adapter/statistics/rx_bytes");
            $download = @file_get_contents("/sys/class/net/$adapter/statistics/tx_bytes");
            $networkTotal = floatval($upload) + floatval($download);
            return array(
                "uploadBytes" => $this->formatBytes($upload),
                "downloadBytes" =>  $this->formatBytes($download),
                "totalBytes" => $this->formatBytes($networkTotal)
            );
        }

        public function buildUI() {

            $eth0        = $this->Network();
            $eth0Sent    = $eth0['uploadBytes'];
            $eth0Receive = $eth0['downloadBytes'];
            $eth0Total   = $eth0['totalBytes'];
            $lo          = $this->Network("lo");
            $loSent      = $lo['uploadBytes'];
            $loReceive   = $lo['downloadBytes'];
            $loTotal     = $lo['totalBytes'];
            $ip          = $_SERVER['SERVER_ADDR'];

            $UI = <<<HTML

<div class="e-panel">
    <div class="e-panel-header">
        <div class="text-center">
            Network
        </div>
    </div>
    <div class="e-panel-body">
        <table id="net-info">
            <tr>
                <th>Interface</th>
                <th>IP Address</th>
                <th>Upload</th>
                <th>Download</th>
                <th>Total</th>
            </tr>
            <tr class="net-info">
                <td>eth0</td>
                <td>$ip</td>
                <td>$eth0Sent</td>
                <td>$eth0Receive</td>
                <td>$eth0Total</td>
            </tr>
            <tr class="net-info">
                <td>lo</td>
                <td>127.0.0.1</td>
                <td>$loSent</td>
                <td>$loReceive</td>
                <td>$loTotal</td>
            </tr>
        </table>
        
        
    </div>
</div>

HTML;
            return $UI;
        }
    }
}