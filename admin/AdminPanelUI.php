<?php

/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/22/2017
 * Time: 1:02 AM
 */

namespace admin {

    use admin\editor\ShowTables;
    use admin\editor\TableLinks;
    use libs\Authorize;
    use libs\User;

    class AdminPanelUI {

        public function returnUI(User $User, TableLinks $TableLinks, ShowTables $ShowTables) {
            Authorize::AdminOnly($User);
            $tableNames = $ShowTables->getNames($User);
            $links = $TableLinks->createLinks($User, $tableNames);

            $html = <<<HTML
<div class="admin-tools">
            
    <a href="index.php" class="link">
        <i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;&nbsp;
        Home
    </a>
    
    <a href="CreateTableUI.php" class="link">
        <i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp;
        Create Table
    </a>
    
    <a href="ShowTablesUI.php" class="link">
        <i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;
        View Database
    </a>
    
    <a href="RemoteControlUI.php" class="link">
        <i class="fa fa-keyboard-o" aria-hidden="true"></i>&nbsp;&nbsp;
        Remote Control
    </a>
    
    <a href="SerialMonitorUI.php" class="link">
        <i class="fa fa-usb" aria-hidden="true"></i>&nbsp;
        Serial Monitor
    </a>
   
    <div class="divider"></div>
    
    $links
    
</div>
HTML;


            return $html;

        }
    }
}