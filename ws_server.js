var ws = require("nodejs-websocket");
var microtime = require("microtime");
var util = require("util");
var server = ws.createServer(function (connection) {
	connection.nickname = null;
	connection.timerout = setTimeout(connection.timeout,10000);
	connection.timeout = function(){ broadcast(connection.nickname + " ping time out"); connection.close(1011,"PING TIMEOUT"); }
	connection.on("text", function (str) {

			if(str == "PING"){
				clearTimeout(connection.timerout);
				connection.timerout = setTimeout(connection.timeout,10000);
				broadcast("PONG");
				return;
			}
			
			str = htmlspecialchars(str,"ENT_QUOTES");

			if (connection.nickname === null) {
				connection.nickname = str;
				broadcast("<span style='color: #CE5C00;'>" + str + " 님이 입장하셨습니다</span>");
			} else {
				broadcast("[" + connection.nickname + "] " + str);
			}
		}
	)
	connection.on("close", function () {
		broadcast("<span style='color: #C4A000;'>" + connection.nickname + " 님이 퇴장하셨습니다</span>");
	})
}).listen(8000)

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str);
	})
}