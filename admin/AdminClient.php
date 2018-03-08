<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/15/2017
 * Time: 3:14 PM
 */

namespace admin {

    spl_autoload_register(function($class) {
        include "../" . str_replace('\\', '/', $class) . '.php';
    });

    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);

    use admin\editor\DeleteRecord;
    use admin\editor\DeleteTable;
    use admin\editor\InsertNewRecord;
    use admin\editor\InsertNewUser;
    use admin\editor\UpdateRecord;
    use admin\editor\UpdateUserRecord;


    class AdminClient extends IAdminUI {
        public $worker;

        public function __construct() {
            parent::__construct();

            if (isset($_POST['editTable'])) {
                $tableName = $_POST['editTable'];
                $action = isset($_POST['editAction']) ? $_POST['editAction'] : null;
                unset($_POST['editAction']);
                unset($_POST['editTable']);

                switch ($action) {

                    case "AddRecord" :
                        $this->worker = new TableEditorUI();
                        echo $this->worker->showUI($tableName, true);
                        break;

                    case "DeleteTable" :
                        if ($tableName == "users") {
                            echo "Error: Can not delete users table";
                            break;
                        } else {
                            $this->worker = new DeleteTable($tableName);
                            header("Location: index.php");
                            die("Redirecting to: index.php");
                            break;
                        }

                    case "UpdateDB" :
                        if (isset($_POST['insertNewRecord'])) {
                            unset($_POST['insertNewRecord']);
                            $data = $_POST['new'];
                            if ($tableName == "users") {
                                $InsertNewUser = new InsertNewUser();
                                $InsertNewUser->insertUser($this->User, $data);
                            } else {
                                $InsertRecord = new InsertNewRecord();
                                $InsertRecord->insert($this->User, $tableName, $data);
                            }
                        }

                        if (isset($_POST['data'])) {
                            $data = $_POST['data'];
                            if ($tableName == "users") {
                                $this->showEditor($tableName);
                                break;
                            } else {
                                $UpdateRecord = new UpdateRecord();
                                foreach ($data as $key => $values) {
                                    $UpdateRecord->update($this->User, $tableName, $values, $key);
                                }
                            }
                        }

                        $this->showEditor($tableName);
                        break;

                    case "DeleteRecord" :
                        if (isset($_POST['recordNumber'])) {
                            $recordNumber = $_POST['recordNumber'];
                            unset($_POST['recordNumber']);
                            $this->worker = new DeleteRecord();
                            $this->worker->deleteRecord($tableName, $recordNumber, $this->User);
                        }
                        $this->showEditor($tableName);
                        break;

                    case "UpdateUser" :
                        if (isset($_POST['userID']) && isset($_POST['data'])) {
                            $data = $_POST['data'];
                            $userID = $_POST['userID'];
                            unset($_POST['data']);
                            unset($_POST['userID']);
                            $userRow = $data[$userID];
                            //var_dump($userRow);
                            $this->worker = new UpdateUserRecord();
                            $this->worker->update($this->User, $userRow);
                        }
                        $this->showEditor($tableName);
                        break;

                    default :
                        $this->showEditor($tableName);
                        break;

                }

            }
        }

        private function showEditor(string $tableName) {
            $this->worker = new TableEditorUI();
            echo $this->worker->showUI($tableName, false);
        }
    }

    $worker = new AdminClient();
}