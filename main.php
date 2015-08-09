
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
}
</style>
</head>
<body>
<div style="position: relative; height: 100%;">
	<table id="list" style="position: absolute; width: 100%; height: 95%; overflow: scroll; overflow-x: hidden;">
	<tr>
	<th>서버 제목</th>
	<th>관리자</th>
	<th>암호</th>
	<th>ADDR</th>
	</tr>
	<tr onclick="console.log(this.getElementsByTagName('td'));">
	<td>Simpreative</td>
	<td>Ketpaku</td>
	<td>NO</td>
	<td>chat.pe1.me:8000</td>
	</tr>

	</table>
</div>
</body>
</html>