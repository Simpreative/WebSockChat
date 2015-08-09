<!DOCTYPE html>
<html>
<head>
<title>WebSocket Chatting</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=360px, user-scalable=no, initial-scale=1">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
<script src="http://zerglinggo.net/include/bootstrap.php?t=js"></script>
<link rel="stylesheet" href="http://zerglinggo.net/include/bootstrap.php?t=css">
<script type="text/javascript" src="http://pe1.me/data/public/common/function.js"></script>
<script type="text/javascript">
function microtime(get_as_float) {
	//  discuss at: http://phpjs.org/functions/microtime/
	// original by: Paulo Freitas
	//   example 1: timeStamp = microtime(true);
	//   example 1: timeStamp > 1000000000 && timeStamp < 2000000000
	//   returns 1: true

	var now = new Date().getTime() / 1000;
	var s = parseInt(now, 10);

	return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}
</script>
<script type="text/javascript">
var myNick;
var wSocket,status,pingtimer,temp1;
var audio = new Audio('alert.wav');
function openChat(addr,port){
wSocket = new WebSocket("ws://"+addr+":"+port+"/");
wSocket.onmessage = function(e){ 

		regPacket = /([A-Z]{4})\s?(.*)/g;
		regMatch = regPacket.exec(e.data.trim());
		if(regMatch === null) {
			addOutput("<span style='color:#FF0000;'>[경고]</span> 서버가 알수없는 패킷을 보냈습니다. \""+e.data+"\"");
			return;
		}
		Protocol = regMatch[1];

	if(Protocol == "PONG"){
		$("#output")[0].innerHTML += "핑 : "+(Math.round(microtime(true) - temp1),4)+"ms"+"<br />\n";
	} else if(Protocol == "CHAT"){
		addOutput(e.data);
	} else {
			addOutput("<span style='color:#FF0000;'>[경고]</span> 서버가 알수없는 패킷을 보냈습니다. \""+e.data+"\"");
	}
}
wSocket.onopen = function(e){ addOutput("서버 연결 완료"); pingtimer=setTimeout(sendping,5000); HandShakeWait(); }
wSocket.onclose = function(e){ addOutput("연결이 종료 되었습니다. "+e.reason); status=false; clearTimeout(pingtimer); HandShakeClose(); }
wSocket.onerror = function(e){ addOutput("Error"); status=false; }
}

	audio.volume=0.5;

	function sendping(){
		if(!status) return;
	temp1 = microtime(true);
	wSocket.send("PING");
	clearTimeout(pingtimer);
	pingtimer=setTimeout(sendping,5000);
	}

	function send(x){ 
		if(!status) return;
		wSocket.send(x); 
		$("#inputMessage").val(""); 
	}

	function addOutput(x){
		if(!status) return;
		$("#output")[0].innerHTML += getTime() + x + "<br />\n";
		audio.play();
		$('#output').stop().animate({
			scrollTop: $("#output")[0].scrollHeight
		}, 800);
	}

	function HandShakeWait(){
		status = false;
		$("#handshakestatus")[0].innerHTML = "서버 연결완료!";
		$("#handshakeform")[0].innerHTML = '닉네임 입력 : <input type="text" id="joinNICK" style="height: 5%; font-size: 4vh;" />';
		$("#joinNICK").bind("keypress",function(event){ 
			if(event.keyCode == 13){
				if($("#joinNICK").val() == "") {
					return false;
				} else {
					wSocket.send("NICK "+$("#joinNICK").val());
					HandShakeEnd();
				}
			}

		});
	}

	function HandShakeEnd(){
		status = true;
		$("#square").css("display","none");
		$("#joinNICK").unbind("keypress");
		$("#handshakeform")[0].innerHTML = "";
		$("#list").css("display","none");
	}

	function HandShakeClose(){
		status = false;
		$("#handshakestatus")[0].innerHTML = "서버와 연결이 끊어졌습니다.";
		$("#joinNICK").unbind("keypress");
		$("#handshakeform")[0].innerHTML = "";	
	}

	$(document).ready(function(){ 
		$("#inputMessage").bind("keypress",function(event){ 
			if(event.keyCode == 13){
				if($("#inputMessage").val() == "") {
					return false;
				} else {
					send($("#inputMessage").val());
				}
			}

		});
	});

function getTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    return "["+h+":"+m+":"+s+"]";
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
#list tr:hover {
    background: #fff !important;
	cursor:hand;
}
#list tr:hover td {
    background: #c7d4dd !important;
	cursor:hand;
}

#square {
	display:none;
    position: absolute;
    top:0;
    bottom:0;
    left:0;
    right:0;
    margin:0 auto;
    margin-top:50px;
    width:80%;
    height:70%;
    background-color:#333;
    z-index:10;
	color:#FFFFFF;
}
</style>
<script type="text/javascript">
function goChat(addr,port){
$("#square").css("display","block");
$("#handshakestatus")[0].innerHTML = "서버 연결중.";
openChat(addr,port);
}
</script>
</head>
<body>
<div id="list" style="position: relative; height: 100%;">
	<table style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;">
	<tr>
	<th>서버 제목</th>
	<th>관리자</th>
	<th>암호</th>
	<th>ADDRESS</th>
	<th>PORT</th>
	</tr>

	<tr onclick="goChat(this.getElementsByTagName('td')[3].textContent,this.getElementsByTagName('td')[4].textContent);">
	<td>Simpreative</td>
	<td>Ketpaku</td>
	<td>NO</td>
	<td>chat.pe1.me</td>
	<td>8000</td>
	</tr>

	<tr onclick="goChat(this.getElementsByTagName('td')[3].textContent,this.getElementsByTagName('td')[4].textContent);">
	<td>Simpreative2</td>
	<td>Ketpaku</td>
	<td>NO</td>
	<td>chat.pe1.me</td>
	<td>8001</td>
	</tr>

	</table>
</div>

<div id="square">
<div id="handshakestatus" style="font-size:6vh;"></div>
<div id="handshakeform"></div>
</div>

<div style="position: relative; height: 100%;">
	<div id="output" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;"></div>
	<input type="text" id="inputMessage" style="position: absolute; width: 100%; height: 5%; bottom: 0; font-size: 3vh;">
</div>
</body>
</html>