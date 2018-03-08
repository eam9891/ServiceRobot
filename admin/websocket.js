var wsUri = "ws://192.168.0.157:1337";
var output = document.getElementById("output");
var websocket;

function ab2str(buf) {
    return String.fromCharCode.apply(null, new Uint8Array(buf));
}

function openWebSocket() {
    websocket = new WebSocket(wsUri);

    websocket.onopen = function(evt) {
        writeToScreen("Websocket Connected");
    };

    websocket.onmessage = function(evt) {

        var message = JSON.parse(evt.data);
        var data = ab2str(message.data);

        console.log(data);
        if (data === "255") {
            writeToScreen('<span style = "color: red;">RECEIVE: ' + data + ' Error Incoming Collision Detected!</span>');
        } else {
            writeToScreen('<span style = "color: blue;">RECEIVE: ' + data + '</span>');
        }

    };

    websocket.onerror = function(evt) {
        writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
    };
}


function writeToScreen(message) {
    var pre = document.createElement("p");
    pre.style.wordWrap = "break-word";
    pre.innerHTML = message;
    output.appendChild(pre);
}

function movement(canMove) {
    return function(event) {
        if (!canMove) return false;
        canMove = false;
        setTimeout(function() { canMove = true; }, 1500);
        switch (event.keyCode) {
            case 68: return move("Right");
            case 83: return move("Backward");
            case 65: return move("Left");
            case 87: return move("Forward");
        }
    };
}

window.addEventListener("load", openWebSocket(), false);

// Movement Control
window.addEventListener("keydown", movement(true), false);

function move(data) {
    console.log(data);
    writeToScreen('<span style = "color: green;">TRANSMIT: ' + data + '</span>');
    websocket.send(data);
}