<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Üzenőfal</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Üzenőfal</h1>
<?php
include 'db.php';
error_reporting(E_ALL ^ E_NOTICE); //Notice üzenetek kikapcsolása a GET miatt
$par=0;
$par=$_GET['p'];
switch ($par) {
  case 1:  //új elem
    $msg=$_POST['fmsg'];
	if (!empty($msg)) {
		db_connect($db_ip, $db_user, $db_pw, $db_name, $db_port);
		if ($db_conn) {
			db_newrecord($msg,$_SERVER['REMOTE_ADDR']);
			db_disconnect();
		}
		//echo "Felvett üzenet: ".$msg."<br>";
		header("Location: .");
	}
	break;
  case 2:  //selected elem törlés
    $items=$_POST['uzenetek'];
	db_connect($db_ip, $db_user, $db_pw, $db_name, $db_port);
	if ($db_conn) {
	  db_delete($items);
	  db_disconnect();
	}
    //echo "Minden üzenet törölve!<br>";
	header("Location: .");
    break;
}

db_connect($db_ip, $db_user, $db_pw, $db_name, $db_port);
if ($db_conn) {
?>
	<form action="index.php?p=2" method="post" class="uzenetek">
	<label for="uzenetek">Üzenetek:</label><br>
	<select id="uzenetek" name="uzenetek[]" size="20" multiple>
<?php
  db_getall();
  if ($db_datas->num_rows > 0) {
    // output data of each row
    while($row = $db_datas->fetch_assoc()) {
	  echo "\t<option value=".$row["id"].">".$row["datum"].": ".$row["uzenet"]."  (".$row["ip"].")</option>";
    }
  }	else {
    echo "\t<option>Üres az adatbázis, nincs üzenet!</option>";
  }
  db_disconnect();
?>
    </select>
	<input type="submit" value="Töröl">
	</form>
	
	<br>
	<form action="index.php?p=1" method="post">
	  <label for="fmsg">Új üzenet:</label><br>
	  <input type="text" id="fmsg" name="fmsg" size="80" maxlength="50">
	  <input type="submit" value="Küld">
	</form>
	
<?php
} else {
	echo "Az adatbázis elérhetetlen! ($db_ip:$db_port)<br>".mysqli_connect_error()."<br>";
}
  
?>	

	
</body>
</html>
