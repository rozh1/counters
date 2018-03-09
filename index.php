<?php
require_once "config.php";
require_once "lib/db.php";
require_once "lib/auth.php";

$pageinfo = array(
	'title' => "Главная",
	'page' => "home",
	'file' => "home.php"
);

$dbconnect = dbConnect($dbhost,$dbname,$dbuser,$dbpass);

if (isset($_GET['page']))
{
	$pageinfo['page'] = $_GET['page'];
	switch($pageinfo['page'])
	{
		case "home":
			$pageinfo['title'] = "Главная";
			$pageinfo['page'] = "home";
			$pageinfo['file'] = "home.php";
			break;
			
		case "login":
			$pageinfo['title'] = "Вход";
			$pageinfo['page'] = "login";
			$pageinfo['file'] = "login.php";
			break;
			
		case "register":
			$pageinfo['title'] = "Регистрация";
			$pageinfo['page'] = "register";
			$pageinfo['file'] = "register.php";
			break;
			
		case "logout":
			$pageinfo['title'] = "Выход";
			$pageinfo['page'] = "logout";
			$pageinfo['file'] = "logout.php";
			break;
			
		case "settings":
			$pageinfo['title'] = "Настройки";
			$pageinfo['page'] = "settings";
			$pageinfo['file'] = "settings.php";
			break;
			
		default:
			$pageinfo['title'] = "Страница не найдена";
			$pageinfo['page'] = "error404";
			$pageinfo['file'] = "error404.php";
			break;
	}
}

if ($pageinfo['page']!="login" && 
	$pageinfo['page']!="register"&& 
	$pageinfo['page']!="logout")
{
	$userinfo = checkAuth($dbconnect, true);
	include "header.php";
	include "pages/".$pageinfo['file'];
	include "footer.php";
}
else
{
	$userinfo = checkAuth($dbconnect, false);
	include "pages/".$pageinfo['file'];
}

?>