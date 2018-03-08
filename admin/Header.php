<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 4/22/2017
 * Time: 12:40 AM
 */

namespace admin {

    class Header {
        public function returnUI() {
            $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ePhp Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="system/sysinfo.css" rel="stylesheet">
    <link href="../css/console.css" rel="stylesheet">
    <link href="../css/mobile.css" rel="stylesheet">
    <link href="../css/tablet.css" rel="stylesheet" media="only screen and (min-width: 700px)">
    <link href="../css/desktop.css" rel="stylesheet" media="only screen and (min-width: 1024px)">
    <link href="../css/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    
    <!-- jQuery library -->
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous">

    </script>
</head>
<body>
<header>
    <a href="../admin" class="site-title">Service Robot</a>
    <div class="pull-right">
        <form action="Logout.php" method="post">
            <button type="submit" value="logout" class="link">Logout</button>
        </form>
    </div>
</header>
HTML;
            return $html;
        }
    }
}