<?php
include('config.php');
//API SERVER 1.1
//
mysql_connect(null, $mysql_user, $mysql_password);
mysql_select_db($mysql_db) or die(mysql_error());
$act=$_GET['act'];
function CheckKeyId($id, $key) {
	$cid=intval($id);
	$query="SELECT `key` FROM `desks` WHERE `id`='$cid'";
	$res=mysql_query($query) or die(mysql_error());
	$row=mysql_fetch_array($res);
	if( $key == $row['key'] ) {
		return true;
	} else {
		//print $key."\n<br>".$row['key'];
		return false;
	}
}
function GenKey() {
	$length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}
function AddKey($key) {
	$query="INSERT INTO `desks` (`key`, `yyyy`, `mm`, `dd`, `hh`) VALUES ('$key', '".date("Y")."', '".date("m")."', '".date("d")."', '".date("H")."')";
	$res=mysql_query($query) or die(mysql_error());
	$query="SELECT `id` FROM `desks` WHERE `key`='$key'";
	$res=mysql_query($query) or die(mysql_error());
	$row=mysql_fetch_array($res);
	if( $row['id'] ) {
		$id=$row['id'];
		return $id;
	}
	return null;
}
function RemoveId($id) {
	//Буде удалять вручную в админке
	//$query="DELETE FROM `desks` WHERE `id`='$id'";
	//$res=mysql_query($query) or die(mysql_error());
}
function SaveScreen($id,$type) {
	move_uploaded_file($_FILES['file']['tmp_name'], '/var/www/sharedesk/shots/current'.$id."s.".$type);
} 

/*------------------------------------------------*/

if($act=='getkey') {
	$tkey=GenKey();
	print 'id='.AddKey($tkey)."\nkey=".$tkey;
	//Генерация ключа длиной 8 символов A-Za-z0-9
	//присоединение к ключу даты в формате ГГГГММДДЧЧkey
	//Добавление ключа в бд с автоинкрементом id и записью даты
} else if( $act=='send') {
	$tid=$_GET['id'];
	$tkey=$_GET['key'];
	if( CheckKeyId($tid, $tkey) ) {
		SaveScreen($tid,"png");
		print "result=true\nreason=sended";
	} else {
		print "result=false\nreason=wrongidorkey";
	}
	//Дополнение API 1.1 поддержка сжатых jpg
} else if( $act=='send2') {
	$tid=$_GET['id'];
	$tkey=$_GET['key'];
	if( CheckKeyId($tid, $tkey) ) {
		SaveScreen($tid,"jpg");
		print "result=true\nreason=sended";
	} else {
		print "result=false\nreason=wrongidorkey";
	}
	//Получение из бд поля по id и ключу
	//Если 1 поле найдено то принять файл и сохранить под именем id_current.png
} else if( $act=='close') {
	$tid=$_GET['id'];
	$tkey=$_GET['key'];
	if( CheckKeyId($tid, $tkey) ) {
		RemoveId($tid);
		print "result=true\nreason=closed";
	} else {
		print "result=false\nreason=wrongidorkey";
	}
	//Если id и ключь верны, то удаляет из БД запись, а также удаляет файл
}
//id key yyyy mm dd hh
mysql_close();
?>
