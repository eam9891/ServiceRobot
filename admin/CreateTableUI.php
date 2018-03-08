<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/18/2017
 * Time: 7:38 PM
 */

namespace admin {

    use admin\editor\ShowTables;
    use admin\editor\TableLinks;

    include_once "IAdminUI.php";

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);


    class CreateTableUI extends IAdminUI {

        public function __construct() {
            parent::__construct();
            self::showUI();
        }

        private function showUI() {
            $Header     = new Header();
            $Footer     = new Footer();
            $ShowTables = new ShowTables();
            $TableLinks = new TableLinks();
            $AdminPanel = new AdminPanelUI();

            $sideNav = $AdminPanel->returnUI($this->User, $TableLinks, $ShowTables);
            $header  = $Header->returnUI();
            $footer  = $Footer->returnUI();

            echo <<<HTML

        $header
        <div class="wrap">
            $sideNav
            
            <div class="main">
                <div class="e-row">
                    
                    <div class="e-col-12 e-col-m-12">
                        <div class="e-panel">
                            <form action="CreateTableColumnsUI.php" method="post">
                                <div class="e-panel-header text-center">
                                    Create Table
                                </div>
                                <div class="e-panel-body text-center">
                                    <input type="text" name="tableName" placeholder="Enter Table Name"><br><br>
                                    Number of Columns: 
                                    <select name="numCols">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select><br><br>
                                    <input type="submit" class="e-btn" name="createTable" value="Create Table">  
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        $footer

HTML;

            unset($Header);
            unset($Footer);
            unset($ShowTables);
            unset($TableLinks);
            unset($AdminPanel);
            unset($sideNav);
            unset($header);
            unset($footer);
        }
    }

    $worker = new CreateTableUI();

}