<?
$key=@$_GET['key'];
$key=intval($key);
if($key==null) {
	include("indexi.php");
	exit;
}
$suf="jpg";
if(file_exists ( "shots/current".$keys.".png" ) )
	$suf="png";
?>
<html>
<head>
<title>WEB-SCREEN-SHOT</title>
<script>
//Предзагрузка изображений
pic = new Image();
pic.src="images/plus.png";
pic.src="images/minus.png";
pic.src="images/full.png";
pic.src="images/plusV.png";
pic.src="images/minusV.png";
pic.src="images/fullV.png";

//Разрешение рабочей области
var wheight=(window.innerHeight)?window.innerHeight: 
((document.all)?document.body.offsetHeight:null); //Высота

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
window.onload = function() {
	setInterval('Main()', 1000);
	document.getElementById('screen').height=wheight-20;
}
function Inc() {
	document.getElementById('screen').height+=25;
}
function Dec() {
	document.getElementById('screen').height-=25;
}
function Full() {
	wheight=(window.innerHeight)?window.innerHeight: 
((document.all)?document.body.offsetHeight:null);
	document.getElementById('screen').height=wheight-20;
}

</script>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
</head>
<body>
<div id="tools" style="position: absolute; left: 0px; top: 0px; z-index: 1;">
<img src="images/plusV.png" onclick="Inc();" height="25px" onmouseover="this.src='images/plus.png';" onmouseout="this.src='images/plusV.png';">
<img src="images/minusV.png" onclick="Dec();" height="25px" onmouseover="this.src='images/minus.png';" onmouseout="this.src='images/minusV.png';">
<img src="images/fullV.png" onclick="Full();" height="25px" onmouseover="this.src='images/full.png';" onmouseout="this.src='images/fullV.png';">
</div>

<div id="display" style="position: absolute; left: 0px; top: 0px; z-index: 0;">
<img src="shots/current<?php print $key; ?>s.<?php print $suf; ?>" id="screen">
</div>

</body>
</html>
