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
var wSocket,status,pingtimer;
var audio = new Audio('alert.wav');
function openChat(addr,port){
wSocket = new WebSocket("ws://"+addr+":"+port+"/");
}

	audio.volume=0.5;
	wSocket.onmessage = function(e){ addOutput(e.data); }
	wSocket.onopen = function(e){ addOutput("서버 연결 완료"); status=true; pingtimer=setTimeout(sendping,5000); }
	wSocket.onclose = function(e){ addOutput("서버 연결 종료"); status=false; clearTimeout(pingtimer); }

	function sendping(){
	wSocket.send("PING");
	clearTimeout(pingtimer);
	pingtimer=setTimeout(sendping,5000);
	}

	function send(x){ 
		wSocket.send(x); 
		$("#inputMessage").val(""); 
	}

	function addOutput(x){
		$("#output")[0].innerHTML += getTime() + x + "<br />\n";
		audio.play();
		$('#output').stop().animate({
			scrollTop: $("#output")[0].scrollHeight
		}, 800);
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
</style>
<script type="text/javascript">
function goChat(addr,port){
	openChat(addr,port);
	$("#list").css("display","none");
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

<div style="position: relative; height: 100%;">
	<div id="output" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;"></div>
	<input type="text" id="inputMessage" style="position: absolute; width: 100%; height: 5%; bottom: 0; font-size: 3vh;">
</div>
</body>
</html>