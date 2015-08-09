var ws = require("nodejs-websocket");
var microtime = require("microtime");
var util = require("util");

function htmlspecialchars(string,quote_style,charset,double_encode){var optTemp=0,i=0,noquotes=false;if(typeof quote_style==='undefined'||quote_style===null){quote_style=2}string=string.toString();if(double_encode!==false){string=string.replace(/&/g,'&amp;')}string=string.replace(/</g,'&lt;').replace(/>/g,'&gt;');var OPTS={'ENT_NOQUOTES':0,'ENT_HTML_QUOTE_SINGLE':1,'ENT_HTML_QUOTE_DOUBLE':2,'ENT_COMPAT':2,'ENT_QUOTES':3,'ENT_IGNORE':4};if(quote_style===0){noquotes=true}if(typeof quote_style!=='number'){quote_style=[].concat(quote_style);for(i=0;i<quote_style.length;i++){if(OPTS[quote_style[i]]===0){noquotes=true}else if(OPTS[quote_style[i]]){optTemp=optTemp|OPTS[quote_style[i]]}}quote_style=optTemp}if(quote_style&OPTS.ENT_HTML_QUOTE_SINGLE){string=string.replace(/'/g,'&#039;')}if(!noquotes){string=string.replace(/"/g,'&quot;')}return string}

var server = ws.createServer(function (connection) {
	connection.nickname = null;
	connection.timerout = setTimeout(connection.timeout,10000);
	connection.timeout = function(){ broadcast(connection.nickname + " Ping timeout"); connection.close(1011,"Ping Timeout"); }
	connection.on("text", function (str) {
		regPacket = /([A-Z]{4})\s?(.*)/g;
		regMatch = regPacket.exec(str.trim());
		Protocol = regMatch[0];

		// No TEXT Part
		if(Protocol == "PING") {
			//broadcast("[" + connection.nickname + "] " + str);
			connection.sendText("PONG");
			clearTimeout(connection.timerout);
			connection.timerout = setTimeout(connection.timeout,10000);
			//broadcast("[SERVER] PONG " + connection.nickname);
			return;
		}

		// TEXT Part
		regText = htmlspecialchars(regMatch[1],"ENT_QUOTES");

		if(Protocol == "NICK") {
			connection.nickname = regText;
			broadcast("CHAT <span style='color: #CE5C00;'>" + regText + " 님이 입장하셨습니다</span>");
		} else if (Protocol == "CHAT") {
			broadcast("CHAT [" + connection.nickname + "] " + str);
		}

		if (connection.nickname === null) {
			connection.close(1012, "Not Authorized");
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