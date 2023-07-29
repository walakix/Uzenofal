<?php
$db_ip=getenv('MYSQL_SERVER_IP');
if ($db_ip=='') { $db_ip="127.0.0.1"; }
$db_port=intval(getenv('MYSQL_SERVER_PORT'));
if ($db_port==0) { $db_port=3306; }
$db_name="uzenofal";
$db_user="uzenofal_user";
$db_pw="Password123";
$db_conn=0;
$db_datas=0;

function db_connect($fserver, $fuser, $fpw, $fdb, $fport) {
  global $db_conn;
  $db_conn = mysqli_connect($fserver, $fuser, $fpw, $fdb, $fport);
}

function db_disconnect() {
  global $db_conn;
  if ($db_conn) {
	  mysqli_close($db_conn);
  }
}

function db_getall() {
  global $db_conn, $db_datas;
  if ($db_conn) {
    $sql = "SELECT * FROM uzenetek";
    $db_datas = $db_conn->query($sql);
  }

}

function db_newrecord($fmsg, $fip) {
  global $db_conn;
  $sql = "INSERT INTO uzenetek (datum, uzenet, ip) VALUES ('".date('Y-m-d H:i:s')."', '".$fmsg."', '".$fip."')";
  /*
  echo $sql."<br>";
  if ($db_conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $db_conn->error;
  }
  */
  $db_conn->query($sql);  
}


function db_delete($fitems) {
  global $db_conn;
  if (count($fitems)>0) {
    $sql="DELETE FROM uzenetek WHERE ";
	for($i=0;$i<count($fitems);$i++) {
	  if ($i==0) {
		$sql=$sql."id=".$fitems[$i];
	  } else {
		$sql=$sql." or id=".$fitems[$i];
	  }
	}
	//echo $sql."<br>";
	$db_conn->query($sql);
  }
}

?>
