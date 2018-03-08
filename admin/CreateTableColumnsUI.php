<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/21/2017
 * Time: 4:16 PM
 */

namespace admin {

    use admin\editor\ShowTables;
    use admin\editor\TableLinks;
    use libs\Authorize;

    include_once "IAdminUI.php";

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    class CreateTableColumnsUI extends IAdminUI {

        public function __construct() {
            parent::__construct();
            self::showUI();
        }

        public function showUI() {

            if (empty($_POST['tableName']) || empty($_POST['numCols'])) {
                Authorize::escortOut();
            }

            $rows = "";
            $numCols   = $_POST['numCols'];
            $tableName = $_POST['tableName'];
            unset($_POST['numCols']);
            unset($_POST['tableName']);

            // Check if table exists

            // Create rows
            for ($x = 1; $x <= $numCols; $x++) {

                $rows .= <<<HTML
<tr>
    <td>
        <input type="text" name="columnName$x" placeholder="Enter Column $x Name">
    </td>
    <td>
        <input type="text" name="columnType$x" placeholder="Enter Data $x Type">
    </td>
    <td>
        <input type="checkbox" name="notNull$x"> Not Null
        <input type="checkbox" name="autoInc$x"> Auto Inc.
        <input type="checkbox" name="unique$x"> Unique
        <input type="checkbox" name="primary$x"> Primary Key
    </td>
    
    
</tr>


HTML;

            }

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
                            <form action="editor/InsertNewTable.php" method="post" target="display">
                                <div class="e-panel-header text-center">
                                    $tableName
                                    <input type="hidden" name="tableName" value="$tableName">
                                    <input type="hidden" name="numCols" value="$numCols">
                                </div>
                                <table>
                                    $rows
                                </table>
                                <input type="submit" class="e-btn" name="createTable" value="Create Table">  
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="e-row">
                    <div class="e-col-12 e-col-m-12">
                        <div class="e-panel">
                            <div class="e-panel-header">
                                SQL <i>Preview</i>
                            </div>
                            <div class="e-panel-body">
                                <iframe name="display"></iframe>
                            </div>
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
    $worker = new CreateTableColumnsUI();
}