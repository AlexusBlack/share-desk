<?
$key=@$_GET['key'];
$key=intval($key);
$suf="jpg";
if(file_exists ( "current".$keys.".png" ) )
	$suf="png";
?>
<html>
<head>
<title>WEB-SCREEN-SHOT</title>
<script>
function reloadImg(id) {
   var obj = document.getElementById(id);
   var src = obj.src;
   var pos = src.indexOf('?');
   if (pos >= 0) {
      src = src.substr(0, pos);
   }
   var date = new Date();
   obj.src = src + '?v=' + date.getTime();
   return false;
}
function Main() {
	//document.location.reload(true);
	reloadImg("screen");
}
function Init() {
	setInterval('Main()', 1000);
}
function Inc() {
	document.getElementById('screen').width+=25;
}
function Dec() {
	document.getElementById('screen').width-=25;
}


</script>
</head>
<body onload="Init();">
<input type="button" value="+" onclick="Inc();"><input type="button" value="-" onclick="Dec();">
<!--&nbsp;Nick:<input type="text" id="mynickname" value="Anon" size="7"><input type="text" id="mymess" size="50">
<input type="button" value=">>">-->
<center>
<img src="current<?php print $key; ?>s.<?php print $suf; ?>" id="screen" width="500">
</center>
</body>
</html>
