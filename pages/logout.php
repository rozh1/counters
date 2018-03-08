<?php
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   
	setcookie("id", "", time() - 3600*24*30*12, "/");
	setcookie("hash", "", time() - 3600*24*30*12, "/");
	$hash = md5(generateCode(10));
	dbInsert($dbconnect, "UPDATE users SET cookie_hash='".$hash."', cookie_timestamp=NOW() WHERE id='".$userinfo['id']."'");
}

//перенаправляем на страницу логина
header("Location: index.php?page=login"); exit();
?>