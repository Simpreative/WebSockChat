var ws = require("nodejs-websocket")

var server = ws.createServer(onConnect).listen(8000)

function onConnect(connection) {
	connection.nickname = null
	connection.on("text", onText)
	connection.on("close", onClose)
}

function onText(str) {
	if (connection.nickname === null) {
		connection.nickname = str
		broadcast(str+" entered")
	} else {
		broadcast("["+connection.nickname+"] "+str)
	}
}

function onClose() {
	broadcast(connection.nickname + " left")
}

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str)
	})
}