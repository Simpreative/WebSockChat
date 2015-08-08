<!DOCTYPE html>
<title>WebSocket Test Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
<script type="text/javascript" src="http://pe1.me/data/public/common/function.js"></script>
<script type="text/javascript">
function microtime(get_as_float) {
  //  discuss at: http://phpjs.org/functions/microtime/
  // original by: Paulo Freitas
  //   example 1: timeStamp = microtime(true);
  //   example 1: timeStamp > 1000000000 && timeStamp < 2000000000
  //   returns 1: true

  var now = new Date()
    .getTime() / 1000;
  var s = parseInt(now, 10);

  return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}
</script>
<script type="text/javascript">
	var wSocket = new WebSocket("ws://chat.pe1.me:8000/");
	var audio = new Audio('alert.wav');
	wSocket.onmessage = function(e){ addOutput(e.data); }
	wSocket.onopen = function(e){ addOutput("서버 연결 완료"); }
	wSocket.onclose = function(e){ addOutput("서버 연결 종료"); }
	function send(x){ 

		if(x == "!핑"){
			wSocket.send("핑 요청 - " + microtime);
		}

		wSocket.send(x); 
		$("#inputMessage").val(""); 
	}

	function addOutput(x){
		$("#output")[0].innerHTML += htmlspecialchars(x,"ENT_QUOTES") + "\n";
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
</script>

<input type="text" id="inputMessage">
<button id="sendButton">Send</button>
<pre id="output" style="height: 800px;"></pre>