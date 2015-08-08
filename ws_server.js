var ws = require("nodejs-websocket");
var microtime = require("microtime");
var util = require("util");
var server = ws.createServer(function (connection) {
	connection.nickname = null;
	connection.timerout = setTimeout(connection.timeout,10000);
	connection.timeout = function(){ broadcast(connection.nickname + " ping time out"); connection.close(1011,"PING TIMEOUT"); }
	connection.on("text", function (str) {

			if(str == "PING"){
				broadcast("[" + connection.nickname + "] " + str);
				clearTimeout(connection.timerout);
				connection.timerout = setTimeout(connection.timeout,10000);
				broadcast("[SERVER] PONG "+connection.nickname);
				return;
			}

			if (connection.nickname === null) {
				connection.nickname = str;
				broadcast(str + " entered");
			} else {


					broadcast("[" + connection.nickname + "] " + str);
				
			}
		}
	)
	connection.on("close", function () {
		broadcast(connection.nickname + " left");
	})
}).listen(8000)

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str);
	})
}