<?php
include 'credentials.php';
$key =  mysqli_real_escape_string($conn,$_POST['txtVerifyCode']);

$sql = "SELECT * FROM `SystemUser` WHERE verification_key='$key'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
$r = mysqli_fetch_assoc($res);
$id = $r['ID'];
if($count == 1){
	$usql = "UPDATE `SystemUser` SET active=1 WHERE ID=$id";
	$ures = mysqli_query($conn, $usql);
	if($ures){
		echo "Account Activated";
	}else{
		echo "failed to activate account";
	}
}else{
	echo "Key not found in database";
}
?>