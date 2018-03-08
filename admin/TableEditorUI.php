<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/22/2017
 * Time: 3:07 AM
 */

namespace admin {

    use admin\editor\BuildTable;
    use admin\editor\ShowTables;
    use admin\editor\TableLinks;

    include_once "IAdminUI.php";

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class TableEditorUI extends IAdminUI {

        public function __construct() {
            parent::__construct();
        }

        public function showUI(string $tableName, bool $addRecord) {

            $Header     = new Header();
            $Footer     = new Footer();
            $ShowTables = new ShowTables();
            $TableLinks = new TableLinks();
            $AdminPanel = new AdminPanelUI();
            $BuildTable = new BuildTable();
            $header     = $Header->returnUI();
            $footer     = $Footer->returnUI();
            $sideNav    = $AdminPanel->returnUI($this->User, $TableLinks, $ShowTables);
            $table      = $BuildTable->getDataTable($this->User, $tableName, $addRecord);
            if ($tableName == "users") {
                $topButtons = <<<HTML
                <input type="number" name="userID" placeholder="Enter User ID">
                <button type="submit" class="e-panel-header-btn" name="editAction" value="UpdateUser">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>&nbsp;
                    Update DB
                </button>
                <button type="submit" class="e-panel-header-btn" name="editAction" value="AddRecord">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                    Add Record
                </button>
HTML;

            } else {
                $topButtons = <<<HTML
                <button type='submit' class="e-panel-header-btn" name='editAction' value='UpdateDB'>
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>&nbsp;
                    Update DB
                </button>
                <button type="submit" class="e-panel-header-btn" name="editAction" value="DeleteTable">
                    <i class="fa fa-minus" aria-hidden="true"></i>&nbsp;
                    Delete Table
                </button>
                <button type="submit" class="e-panel-header-btn" name="editAction" value="AddRecord">
                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                    Add Record
                </button>  
HTML;
            }
            $UI = <<<HTML
            
                $header
                <div class="wrap">
                    $sideNav
                    <div class="main">
                        <form action="AdminClient.php" method="post">
                            <div class="e-row">
                                <div class="e-col-12 e-col-m-12">
                                    
                                        <div class="e-panel">
                                            <div class="e-panel-header">
                                                <i class="fa fa-table" aria-hidden="true"></i>&nbsp;
                                                $tableName  
                                                <div class="pull-right">
                                                    
                                                    <input type="hidden" name="editTable" value="$tableName">
                                                    $topButtons
                                                    
                                                </div>
                                            </div>
                                            <div class="e-panel-body">
                                                $table
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                            <div class="e-row">
                                <div class="e-col-12 text-center">
                                    <div class="e-panel">
                                        <div class="e-panel-header">
                                            Delete A Record
                                        </div>
                                        <div class="e-panel-body">
                                            <input type="number" name="recordNumber" placeholder="Enter Record ID">
                                            <button type="submit" name="editAction" value="DeleteRecord" class="e-btn">
                                                <i class="fa fa-minus" aria-hidden="true"></i>&nbsp;
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
                $footer
HTML;

            return $UI;

        }


    }
}