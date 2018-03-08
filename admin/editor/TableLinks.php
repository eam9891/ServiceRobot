<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/21/2017
 * Time: 10:10 PM
 */

namespace admin\editor {

    use libs\Authorize;
    use libs\User;

    include_once "ShowTables.php";

    class TableLinks {

        public function createLinks(User $User, array $tableNames) {
            Authorize::AdminOnly($User);
            $links = "";

            foreach ($tableNames as $key => $value) {
                $links .= <<<HTML

<button type="submit" class="link" name="editTable" value="$value[0]"> 
    <i class="fa fa-table" aria-hidden="true"></i>&nbsp;
    $value[0]
</button>
HTML;

            }

            $html = <<<HTML

<form action="AdminClient.php" method="post">
    <div class="text-center">DB Tables</div>
    $links
    
</form>

HTML;

            return $html;
        }

    }
}