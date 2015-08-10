var ws = require("nodejs-websocket");
var Autolinker = require('autolinker');
var microtime = require("microtime");
var util = require("util");
var fs = require("fs");

function htmlspecialchars(string,quote_style,charset,double_encode){var optTemp=0,i=0,noquotes=false;if(typeof quote_style==='undefined'||quote_style===null){quote_style=2}string=string.toString();if(double_encode!==false){string=string.replace(/&/g,'&amp;')}string=string.replace(/</g,'&lt;').replace(/>/g,'&gt;');var OPTS={'ENT_NOQUOTES':0,'ENT_HTML_QUOTE_SINGLE':1,'ENT_HTML_QUOTE_DOUBLE':2,'ENT_COMPAT':2,'ENT_QUOTES':3,'ENT_IGNORE':4};if(quote_style===0){noquotes=true}if(typeof quote_style!=='number'){quote_style=[].concat(quote_style);for(i=0;i<quote_style.length;i++){if(OPTS[quote_style[i]]===0){noquotes=true}else if(OPTS[quote_style[i]]){optTemp=optTemp|OPTS[quote_style[i]]}}quote_style=optTemp}if(quote_style&OPTS.ENT_HTML_QUOTE_SINGLE){string=string.replace(/'/g,'&#039;')}if(!noquotes){string=string.replace(/"/g,'&quot;')}return string}

var server = ws.createServer(function (connection) {
	connection.nickname = null;
	connection.timerout = setTimeout(connection.timeout,10000);
	connection.timeout = function(){ connection.close(1011,"Ping Timeout"); }
	connection.on("text", function (str) {
		regPacket = /([A-Z]{4})\s?(.*)/g;
		regMatch = regPacket.exec(str.trim());
		if(regMatch === null) {
			connection.close(500, "Bad Request");
			return;
		}
		Protocol = regMatch[1];

		// No TEXT Part
		if(Protocol == "PING") {
			connection.sendText("PONG");
			clearTimeout(connection.timerout);
			connection.timerout = setTimeout(connection.timeout,10000);
			return;
		} else if(Protocol == "LIST") {
			server.connections.forEach(function (user) {
				if(user.nickname != null) {
					connection.sendText("CHAT <span style='color: #5C3566'>" + user.nickname + "</span>");
				}
			});
			return;
		}

		// TEXT Part
		regText = htmlspecialchars(regMatch[2], "ENT_QUOTES");

		if(Protocol == "NICK") {
			if (regText == "") {
				connection.sendText("ERRO 올바른 닉네임을 입력해주세요");
				return;
			}
			if (isDuplicateNick(regText)) {
				connection.sendText("ERRO 이미 존재하는 닉네임 입니다");
				return;
			} else {
				if (connection.nickname === null) {
					connection.nickname = regText;
					connection.sendText("HELO");
					broadcast("CHAT <span style='color: #CE5C00;'>" + regText + " 님이 입장하셨습니다</span>");
					console.log(getTime() + regText + " connected");
					return;
				} else {
					var oldNick = connection.nickname;
					connection.nickname = regText;
					broadcast("CHAT <span style='color: #CE5C00;'>" + oldNick + " 님이 닉네임을 " + regText + "로 변경하셨습니다");
					console.log(getTime() + oldNick + " changed to " + regText);
					return;
				}
			}
		}

		if (connection.nickname === null) {
			connection.close(401, "Unauthorized");
			return;
		}

		if (Protocol == "CHAT") {
			broadcast("CHAT [" + connection.nickname + "] " + Autolinker.link(regText));
			console.log(getTime() + "[" + connection.nickname + "] " + regText);
			return;
		} else {
			connection.close(500, "Bad Request");
			return;
		}
	});

	connection.on("close", function (code, reason) {
		if (connection.nickname !== null) {
			broadcast("CHAT <span style='color: #C4A000;'>" + connection.nickname + " 님이 퇴장하셨습니다 (" + reason + ")</span>");
			console.log(getTime() + connection.nickname + " disconnected (" + reason + ")");
		}
	});

	connection.on("error", function (e) {
		console.log(getTime() + "An error occurred: " + e);
		if(connection.nickname !== null) {
			broadcast("CHAT <span style='color: #C4A000;'>" + connection.nickname + " 님이 퇴장하셨습니다 (" + e + ")</span>");
		}
	});
}).listen(8000);

function isDuplicateNick(nickname) {
	var isDup = false;
	server.connections.forEach(function (connection) {
		if(connection.nickname != null) {
			if(nickname.toLowerCase() == connection.nickname.toLowerCase()) {
				isDup = true;
			}
		}
	})
	return isDup;
}

function broadcast(str) {
	server.connections.forEach(function (connection) {
		connection.sendText(str);
	})
}

function getTime() {
	var date = new Date();
	return dateFormat("y[yyy-mm-dd HH:MM:ss]");
}

eval(fs.readFileSync('date.format.js')+'');