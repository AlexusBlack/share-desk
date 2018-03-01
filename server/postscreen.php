<?php
ini_set('display_errors', 0);
$key=@$_GET['key'];
$key=intval($key);
print "Name: ".$_FILES['file']['name']."\n";
print "TMPName: ".$_FILES['file']['tmp_name']."\n";
print "Size: ".$_FILES['file']['size']."\n";
print "UKey: ".$key."s\n";
move_uploaded_file($_FILES['file']['tmp_name'], "/var/www/POLIGON/current".$_GET['key'].".png")
?>
