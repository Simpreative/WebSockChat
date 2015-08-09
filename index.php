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
	var audio = new Audio('alert/Argon.ogg');

	function openChat(addr, port) {
		openChat(addr + ":" + port);
	}

	function openChat(address) {
		wSocket = new WebSocket("ws://" + address);
		wSocket.onmessage = function(e){ 

			regPacket = /([A-Z]{4})\s?(.*)/g;
			regMatch = regPacket.exec(e.data.trim());
			if(regMatch === null) {
				addOutput("<span style='color:#FF0000;'>[경고]</span> 서버가 알 수 없는 패킷을 보냈습니다. \""+e.data+"\"");
				return;
			}
			Protocol = regMatch[1];

			if(Protocol == "PONG"){
				$("#output")[0].innerHTML += "핑 : "+(Math.round((microtime(true) - temp1)*1000))+"ms"+"<br />\n";
				return;
			} else if(Protocol == "HELO") {
				HandShakeEnd();
			}

			regText = regMatch[2];

			if(Protocol == "CHAT"){
				addOutput(regText);
			} else if(Protocol == "ERRO") {
				if(!status) {
					$("#alert").html("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span><span class='sr-only'>오류:</span> 존재하는 닉네임 입니다.</div>");
					$("#nickname").attr("disabled", false);
					$("#btn-connect").attr("disabled", false);
					wSocket.close();
				}
			} else {
				addOutput("<span style='color:#FF0000;'>[경고]</span> 서버가 알 수 없는 패킷을 보냈습니다. \""+e.data+"\"");
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
		regPacket = /^\/(.*)/g;
		regMatch = regPacket.exec(x.trim());	

		if(regMatch !== null){
			regText = regMatch[1];

			if(regText == "clear"){
				$("#output")[0].innerHTML = "";
			} else {
				addOutput("알 수 없는 명령어입니다.");
			}
			$("#inputMessage").val(""); 
		} else {
			wSocket.send("CHAT "+x); 
			$("#inputMessage").val(""); 
		}
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
		$("#alert").html("<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span><span class='sr-only'>성공:</span> 서버에 연결되었습니다</div>");
		wSocket.send("NICK " + $("#nickname").val());
	}

	function HandShakeEnd(){
		status = true;
		$("#alert").html("");
		$("#connmain").css("display", "none");
		$("#chatmain").css("display", "");
	}

	function HandShakeClose(){
		status = false;
		$("#alert").html("<div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span><span class='sr-only'>오류:</span> 서버와 연결이 끊어졌습니다</div>");	
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
</style>
<script>
	function goChat(addr,port) {
		goChat(addr + ":" + port);
	}

	function goChat(address) {
		$("#nickname").attr("disabled", true);
		$("#btn-connect").attr("disabled", true);
		$("#alert").html("<div class='alert alert-info' role='alert'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span><span class='sr-only'>정보:</span> 서버에 연결중입니다...</div>");
		openChat(address);
	}

	$("#btn-connect").click(function() {
		var selectedServer = $("#server option:selected").val();
		goChat(selectedServer);
	});
</script>
</head>
<body>
	<div id="connmain" style='padding-top: 90px;'>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-login">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<div id="alert"></div>
									</div>
									<div class="form-group">
										<select class="form-control"name="server">
											<option value="chat.pe1.me:8000">Simpreative #1</option>
											<option value="chat.pe1.me:8001">Simpreative #2</option>
										</select>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="nickname" id="nickname" tabindex="1" placeholder="닉네임" value="" required>
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="password" id="password" tabindex="2" placeholder="서버 암호" disabled>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="button" class="form-control" id="btn-connect" tabindex="3" class="btn btn-success" value="로그인">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="chatmain" style="position: relative; height: 100%; display: none;">
		<div id="output" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;"></div>
		<input type="text" id="inputMessage" style="position: absolute; width: 100%; height: 5%; bottom: 0; font-size: 3vh;">
	</div>
</body>
</html>