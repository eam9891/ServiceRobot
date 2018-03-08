<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/5/2018
 * Time: 6:50 PM
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

    class SerialMonitorUI extends IAdminUI {

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

            /*
            echo <<<HTML
            
            $header
            
            $sideNav
            
            <div class="main">
            
                
                <div id="terminal">
                    <div class="terminal-logo">
<pre>
_________                __               __
___\_    __/__  __________ |__| ____ _____  |  |
_/ __ \|  |/ __ \/  __/     \|  |/    \\__   \ |  |
\  ___/|  |  ___/|  |/  Y Y  \  |   |  \/ __ \|  |____
\_____|__|\_____|__|\_|__|__/__|___|__(______|______/
</pre>
                    </div>
                    <div id="log"></div>
                    <section class="flexbox" id="command">
                        <div id="directory" class="normal"></div> &nbsp;
                        <div id="cursor"    class="normal">&gt;</div> &nbsp;
                        <div class="stretch" id="prompt">
                            <label for="msg"></label>
                            <input type="text" id="msg" onkeypress="onkey(event)" autofocus>
                        </div>
                    </section>
                </div>
                
                
            </div>

            
            <script type="text/javascript">
                var socket;
        
                function init() {
                    
                    
                    $(function() { $("#terminal").draggable().resizable(); });
                    
                    var host = "ws://192.168.0.157:1337";
                    try {
                        socket = new WebSocket(host);
                        log('Status ' + socket.readyState + ': Upgrading to WebSocket...');
                        
                        socket.onopen    = function() {
                            log("Status " + this.readyState + ': WebSocket Connected');
                        };
                        
                        socket.onmessage = function(msg) {
                            var message = JSON.parse(msg.data);
                            var data = buffer2str(message.data);
                            
                            log("Received: " + data);
                        };
                        
                        socket.onclose   = function() {
                            log("Disconnected - status "+this.readyState);
                        };
                    }
                    catch(ex){
                        log(ex);
                    }
                    $("msg").focus();
                }
        
                function send(){
                    var txt, msg;
                    txt = $("msg");
                    msg = txt.value;
                    if(!msg) {
                        alert("Message can not be empty");
                        return;
                    }
                    txt.value="";
                    txt.focus();
                    try {
                        socket.send(msg);
                        log('Sent: '+msg);
                    } catch(ex) {
                        log(ex);
                    }
                }
                function quit(){
                    if (socket !== null) {
                        log("Goodbye!");
                        socket.close();
                        socket=null;
                    }
                }
                function reconnect() {
                    quit();
                    init();
                }
        
                // Utilities
                function $(id){
                    return document.getElementById(id);
                }
                function log(msg){
                    $("log").innerHTML+="<br>"+msg;
                }
                function onkey(event){
                    if(event.keyCode === 13){
                        send();
                    }
                }
                
                function buffer2str(buf) {
                    return String.fromCharCode.apply(null, new Uint8Array(buf));
                }
                
                window.addEventListener("load", init, false);
            
            </script>
            
            <!--<script src="buttonGPIO.js"></script>
            <script src="MotorController.js"></script>-->
            <!--<script src="ReadMessages.js"></script>-->
            $footer

HTML;*/
            echo <<< HTML
<!DOCTYPE html>
<html>
    <head>
        <title>SCSR</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Font Awesome CSS Library, Icons and Fonts -->
        <link href="../css/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
        
        <!-- Latest Bootstrap 4.0 compiled and minified Font-Awesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
        <!-- Latest Bootstrap 4.0 compiled and minified CSS / Bootstrap Dark Theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.0.0-beta.3/cyborg/bootstrap.min.css">
    
        <!-- jQuery library -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous">
        </script>
        
        <!-- Popper JS Custom Tooltips Library-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    
        <!-- Latest compiled Bootstrap 4.0 JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
        
        <!-- JQuery UI Javascript Library -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        
        <!-- Custom Stylesheets -->
        <link href="../css/console.css" rel="stylesheet">
        <link href="../css/sidebar2.css" rel="stylesheet">
        
        <script>
                
        </script>
        
    </head>
    
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark" style="padding-left: 0;">
        <!-- Header Name -->
        <a class="navbar-brand" href="index.php" style="width: 250px; text-align: center;">ServiceRobot</a>
    
        <!-- Toggler / collapsable Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar, #menu-content">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
    
                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="Logout.php">
                        Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                -->
    
            </ul>
        </div>
    </nav>
    <div class="nav-side-menu">
    
        <div class="menu-list">
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                    <a href="" id="dashboard">
                        <i class="fa fa-dashboard fa-lg"></i>&nbsp; Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user fa-lg"></i>&nbsp; Profile
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fa fa-keyboard-o fa-lg"></i>&nbsp; Remote Control
                    </a>
                </li>
                <li class="active">
                    <a href="" id="serialMonitor">
                        <i class="fa fa-usb fa-lg"></i>&nbsp; Serial Monitor
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-users fa-lg"></i>&nbsp; Users
                    </a>
                </li>
                <li data-toggle="collapse" data-target="#products" class="collapsed">
                    <a href="#"><i class="fa fa-database fa-lg"></i>&nbsp; Database <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <!--<li class="active"><a href="#">Active Example</a></li>-->
                    <li><a href="#">Create Table</a></li>
                    <li><a href="#">View DB Structure</a></li>
                </ul>
            </ul>
        </div>
    </div>
    <div id="main" class="viewport" style="height: calc(100vh - 70px);">
        
        
            <div id="eTerminal" class="eTerminal ui-widget-content">
                <div id="eTerminal-header">
                            <div style="display: inline; text-align: left;">
                                Serial Console v1.0
                            </div>
                            <button id="eTerminal-close"    class="btn btn-sm btn-secondary fa fa-window-close pull-right"></button>
                            <button id="eTerminal-maximize" class="btn btn-sm btn-secondary fa fa-window-maximize pull-right"></button>
                            <button id="eTerminal-minimize" class="btn btn-sm btn-secondary fa fa-window-minimize pull-right"></button>
                            
                            
                </div>
                <div id="log" style="width: 100%; height: calc(100% - 90px); color: white; text-align: left; overflow-y: scroll"></div>
                <div id="eTerminal-footer position-absolute fixed-bottom" style="margin: 5px;">
                    <div class="form-group">
                        <div class="input-group" style="margin: 0;">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" id="msg" class="form-control" autofocus style="color: white;" aria-label="Console Input">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
       
        
        
        
        
    </div>
    
        
        <script>
        
        
        
            var socket;
            var logDiv = $("#log");
            var eTerminal = $(".eTerminal");
            var host = "ws://192.168.0.136:1337";
            
            
            function init() {
                
                // Set eTerminal div to draggable and resizeable
                eTerminal.draggable({
                    handle : "#eTerminal-header",
                    containment: "parent",
                    stop: function(){}
                }).resizable({
                    containment: "parent"
                });
                eTerminal.on("dragstop", function() {
                    $("#msg").focus();
                });
                /*
                eTerminal.dialog({
                    draggable: true,
                    height: 200,
                    buttons: [
                    {
                        text: "minimize",
                        click: function() {
                            $(this).parents('.ui-dialog').animate({
                                height: '40px',
                                top: $(window).height() - 50
                            }, 200);            
                        }
                    }]
                   
                    
                });*/
                
                $('#eTerminal-close').click(function() {
                    
                });
                $('#eTerminal-maximize').click(function() {
                    
                });
                $('#eTerminal-minimize').click(function() {
                    
                });
                $('#serialMonitor').click(function() {
                    
                });

                
                
                
                // Try WebSocket connection, catch and log error
                try {
                    socket = new WebSocket(host);
                    log('<span class="text-info"> Status ' + socket.readyState + ': Upgrading to WebSocket...</span>');
                    
                    socket.onopen    = function() {
                        log("<span class='text-success'>Status " + this.readyState + ': WebSocket Connected</span>');
                    };
                    
                    socket.onmessage = function(msg) {
                        var message;
                        var data;
                        
                        log("Received: " + msg.data);
                        
                        if(msg.hasOwnProperty("users")) {
                            data = JSON.parse(msg.data);
                            data = data.users;
                        } else {
                            message = JSON.parse(msg.data);
                            data = buffer2str(message.data);
                        }
                        
                        
                        
                        
                        
                        log("Received: " + data);
                    };
                    
                    socket.onclose   = function() {
                        log("<span class='text-info'>Status " + this.readyState + ': WebSocket Disconnected</span>');
                    };
                }
                catch(ex){
                    log(ex);
                }
                
                // Console Input Handler
                $("#msg").on('keypress', function(e) {
                    
                    // Enter Key Handler - Send Data
                    if(e.which === 13){
                    
                        // Disable input to prevent multiple submit attempts
                        $(this).attr("disabled", "disabled");
                        
                        // Don't allow empty message to be sent, can handle multiple ways
                        if(!this.value) {
                            log('<span class="text-danger"> Error: Message can not be empty! </span>');
                            //alert("Message can not be empty");
                            return;
                        }
                        
                        // Try sending message across socket, catch and log error
                        try {
                            socket.send(this.value);
                            log('Sent: ' + this.value);
                            
                        } catch(ex) {
                            log('<span class="text-danger bg-danger"> Error: ' + ex + "</span>");
                        }
                        
                        // Enable the input again
                        $(this).removeAttr("disabled");
                        
                        // Clear the input value, and regain focus
                        this.value = "";
                        $("#msg").focus();
                    }
                    
                    
                });
                
                
                
            }
             
            
            function quit(){
                if (socket !== null) {
                    log("Goodbye!");
                    socket.close();
                    socket=null;
                }
            }
            function reconnect() {
                quit();
                init();
            }
            
            function log(msg){
                logDiv.append(msg + "<br>");
                console.log(msg);
                logDiv.animate({scrollTop: logDiv.get(0).scrollHeight}, 2000);
            }
            
            function buffer2str(buf) {
                return String.fromCharCode.apply(null, new Uint8Array(buf));
            }
            
            
            window.addEventListener("load", init, false);
            
            
        </script>
    
    
</html>

HTML;

            unset($header);
            unset($footer);

            unset($ShowTables);
            unset($TableLinks);
            unset($AdminPanel);
            unset($sideNav);

        }

    }
    $worker = new SerialMonitorUI();
}