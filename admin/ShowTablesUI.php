<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/18/2017
 * Time: 5:20 PM
 */

namespace admin {

    include_once "IAdminUI.php";

    use admin\editor\ShowTables;
    use admin\editor\TableLinks;
    use database\UniversalConnect;

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class ShowTablesUI extends IAdminUI {
        private $dbConn;

        public function __construct() {
            parent::__construct();
            $this->dbConn = UniversalConnect::doConnect();
            echo $this->showUI();
        }

        private function getTables() {
            $returnTables = "";
            $result = mysqli_query($this->dbConn,"SHOW TABLES");
            while($tableName = mysqli_fetch_row($result)) {

                $table = $tableName[0];

                $values = "" ;
                $result2 = mysqli_query($this->dbConn,'SHOW COLUMNS FROM '.$table) or die('Error: Cannot show columns from '.$table);
                if(mysqli_num_rows($result2)) {

                    while($row2 = mysqli_fetch_row($result2)) {
                        $values .= '<tr class="db-table-row">';
                        foreach($row2 as $key=>$value) {
                            $values .= "<td class='db-data'>$value</td>" ;
                        }
                        $values .= '</tr>';
                    }

                }

                $returnTables .= $this->createTableUI($table, $values);
            }
            return $returnTables;
        }

        private function createTableUI(string $tableName, string $values) {

            $htmlString = <<<HTML
<div class="e-col-6">        
    <div class="e-panel">
        <div class="e-panel-header text-center">
            $tableName     
        </div>
        <div class="e-panel-body">
            <table class="db-table">
                <tr>
                    <th class="db-data-head"> Field   </th>
                    <th class="db-data-head"> Type    </th>
                    <th class="db-data-head"> Null    </th>
                    <th class="db-data-head"> Key     </th>
                    <th class="db-data-head"> Default </th>
                    <th class="db-data-head"> Extra   </th>
                </tr>
                
                $values
                
            </table>
        </div>
        
    </div>
</div>
HTML;

            return $htmlString;
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
            $dbTables   = $this->getTables();
            echo <<<HTML

            $header
            <div class="wrap">
                $sideNav
                
                <div class="main">
                
                    <div class="e-row">
                        $dbTables
                    </div>
                    
                </div>
                
            </div>
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
    $worker = new ShowTablesUI();


}