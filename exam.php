<!DOCTYPE html>
<title>WebSocket Test Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
<script type="text/javascript" src="http://pe1.me/data/public/common/function.js"></script>
<script type="text/javascript">
var wSocket = new WebSocket("ws://chat.pe1.me:8000/");
wSocket.onmessage = function(e){ addOutput(e.data); }
wSocket.onopen = function(e){ alert("서버 연결 완료"); }
wSocket.onclose = function(e){ alert("서버 연결 종료"); }
function send(x){ wSocket.send(x); }

function addOutput(x){
$("#output")[0].innerHTML += htmlspecialchars(x,"ENT_QUOTES") + "\n";
}

$(document).ready(function(){ 
	$("#inputMessage").bind("keypress",function(event){ console.log(event); });
});
</script>
 
<input type="text" id="inputMessage">
<button id="sendButton">Send</button>
<pre id="output"></pre>