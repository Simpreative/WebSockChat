<!DOCTYPE html>
<title>WebSocket Test Page</title>
<script src="http://zerglinggo.net/include/jquery-2.1.4.min.js"></script>
<script>
 
    var log = function(s) {
        console.log(s);
        if (document.readyState !== "complete") {
            log.buffer.push(s);
        } else {
            document.getElementById("output").innerHTML += (s + "\n")
        }
    }
    log.buffer = [];
 
    url = "ws://chat.pe1.me:8000";
    w = new WebSocket(url);
 
    w.onopen = function() {
        log("open");
        w.send("thank you for accepting this Web Socket request");
    }
 
    w.onmessage = function(e) {
        console.log(e.data);
        log(e.data);
    }
 
    w.onclose = function(e) {
        log("closed");
    }
 
    window.onload = function() {
        log(log.buffer.join("\n"));
 
        document.getElementById("sendButton").onclick = function() {
            console.log(document.getElementById("inputMessage").value);
            w.send(document.getElementById("inputMessage").value);
        }
              // 간지나게 엔터키 누르면 메시지 날림
            jQuery('#inputMessage').keydown(function(event) {
            if (event.keyCode == '13') {
                value = document.getElementById("inputMessage").value
                w.send(value);
                document.getElementById("inputMessage").value = "";
            }
        });
    }
</script>
 
<input type="text" id="inputMessage">
<button id="sendButton">Send</button>
<pre id="output"></pre>