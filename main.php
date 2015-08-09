
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
<style>
html, body {
	height: 100%;
	overflow: hidden;
}
</style>
</head>
<body>
<div style="position: relative; height: 100%;">
	<div id="output" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;"></div>
	<input type="text" id="inputMessage" style="position: absolute; width: 100%; height: 5%; bottom: 0; font-size: 3vh;">
</div>
</body>
</html>