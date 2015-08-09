
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
tr:hover {
    background: #000 !important;
	cursor:hand;
}
tr:hover td {
    background: #c7d4dd !important;
	cursor:hand;
}
</style>
<script type="text/javascript">
function goChat(addr,port){
	alert(addr + port);
}
</script>
</head>
<body>
<div style="position: relative; height: 100%;">
	<table id="list" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;">
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
</body>
</html>