<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>ShareDesk админка</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<style>
	.shot_table {
		width:250px;
		height:300px;
		background-color: #cccccc;
		float:left;
		margin: 5px;
	}
	#shot {
		width:250px;
	}
	img {
		border: 0px;
	}
	</style>
</head>

<body bgcolor="#ffffff">
	<center><table border=1 width="1080px" id="main">
		<tr><td>Вывести за: <a href="?time=0">Сегодня</a>, <a href="?time=2">Последний час</a>, <a href="?time=1">Месяц</a>, <a href="?time=3">всё время</a></td></tr>
		<tr><td>Фильтровать по:</td></tr>
		
		<tr><td>
<?php
$time=@$_GET['time'];
$time=intval($time);
if($time==null) {
	$time=0; //Если время не задано выведем всех за последние сегодня
}
include('config.php');
mysql_connect(null, $mysql_user, $mysql_password);
mysql_select_db($mysql_db) or die(mysql_error());


switch($time) {
	case 0://За этот день
		$query="SELECT * FROM `desks` WHERE `dd`=".date("d");
	break; 
	case 1://За этот месяц
		$query="SELECT * FROM `desks` WHERE `mm`=".date("m");
	break;
	case 2://За этот час
		$query="SELECT * FROM `desks` WHERE `hh`=".date("H");
	break;
	case 3://За всё время
		$query="SELECT * FROM `desks`";
	break;	
}
$res=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($res)) {
	print "<table class='shot_table' >
	<tr><td><a href='/?key=".$row[id]."' target='viewer'><img src='shots/current".$row[id]."s.jpg' id='shot'></a></td></tr>
	<tr><td>Запущено: ".$row[dd].".".$row[mm].".".$row[yyyy]." в ".$row[hh]." часа(ов)</td></tr>
	</table>";
}

mysql_close();
?>
</td></tr>
</table></center>
</body>
</html>
