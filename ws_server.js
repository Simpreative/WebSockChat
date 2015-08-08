var ws = require("nodejs-websocket");
var microtime = require("microtime");
var util = require("util");
var server = ws.createServer(function (connection) {
	connection.nickname = null;
	connection.on("text", function (str) {
			if (connection.nickname === null) {
				connection.nickname = str;
				broadcast(str + " entered");
			} else {

				var or = /^핑\s요청\s\-\s(.*)/;
				var os = str.match(or);
				if(os){
						console.log(util.inspect(os));
						console.log(microtime.nowDouble());
						broadcast("[" + connection.nickname + "] 응답 : 0." + (microtime.nowDouble() - os[1]) + "초");
				} else {
					broadcast("[" + connection.nickname + "] " + str);
				}
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