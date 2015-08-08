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
				console.log(util.inspect(os));
				if(os){
					console.log("is match");
					if(typeof os[0] == "number"){
						broadcast("[" + connection.nickname + "] 응답 : 0." + (microtime.nowDouble() - os[0]) + "초");
					} else {
						console.log("??");
					}
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