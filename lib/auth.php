<?php

function checkAuth($conn, $redirect)
{
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{   
		$userid = $conn->real_escape_string($_COOKIE['id']);
		$usercookie = $conn->real_escape_string($_COOKIE['hash']);
		$result = dbSelect($conn, "SELECT id, login, cookie_timestamp FROM users WHERE id = '$userid' AND cookie_hash = '$usercookie' LIMIT 1");
		
		if (count($result)>0) 
		{
			$userdata = $result[0];
			if(strtotime($userdata['cookie_timestamp']) < time() - 3600*24*30*12)
			{
				setcookie("id", "", time() - 3600*24*30*12, "/");
				setcookie("hash", "", time() - 3600*24*30*12, "/");
				dbInsert($dbconnect, "UPDATE users SET cookie_hash='".$hash."', cookie_timestamp=NOW() WHERE id='".$result[0]['id']."'");
			}
			else
			{
				return array(
				'id' => $userdata['id'],
				'login' => $userdata['login'],
				);
			}
		}
	}

	if ($redirect)
	{
		//перенаправляем на страницу логина
		header("Location: index.php?page=login"); exit();
	}
}

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}


?>