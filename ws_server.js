var ws = require("nodejs-websocket")
 
function broadcast(server, msg) {
    server.connections.forEach(function (conn) {
        conn.sendText(msg)
    })
}

var server = ws.createServer(function (conn) {
    console.log("New connection")
    conn.on("text", function (str) {
        console.log("Received " + str)
        broadcast(self, str)
    })
    conn.on("close", function (code, reason) {
        console.log("Connection closed")
    })
}).listen(8000)
