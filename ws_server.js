var ws = require("nodejs-websocket")

var server = ws.createServer(function (connection) {
	connection.nickname = null
	connection.on("text", function (str) {
			if (connection.nickname === null) {
				connection.nickname = str
				broadcast(str + " entered")
			} else {
				broadcast("[" + connection.nickname + "] " + str)
			}
		}
	})
	connection.on("close", function () {
		broadcast(connection.nickname + " left")
	})
}).listen(8000)

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str)
	})
}