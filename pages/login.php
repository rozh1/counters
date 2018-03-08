<?php

$err = array();

if(isset($_POST['submit']))
{
	$userlogin = $dbconnect->real_escape_string($_POST['login']);
	$userpass = md5($dbconnect->real_escape_string($_POST['password']));
	$result = dbSelect($dbconnect, "SELECT id, password FROM users WHERE login='$userlogin' LIMIT 1");
	if (count($result)>0)
	{
		if($result[0]['password'] === md5(md5($_POST['password'])))
		{
			$hash = md5(generateCode(10));
			dbInsert($dbconnect, "UPDATE users SET cookie_hash='".$hash."', cookie_timestamp=NOW() WHERE id='".$result[0]['id']."'");
			// Ставим куки
			setcookie("id", $result[0]['id'], time()+60*60*24*30);
			setcookie("hash", $hash, time()+60*60*24*30);
			header("Location: index.php"); exit();
		}
		else
		{
			$err[] = "Вы ввели неправильный логин/пароль";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $pageinfo['title']; ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Вход</h3>
                        </div>
                        <div class="panel-body">
						<?php
						
    if (count($err) != 0)
    {
        foreach($err AS $error)
        {
            print '<div class="alert alert-danger">'.$error."</div>";
        }
    }
						?>
							<form role="form" method="POST" action="index.php?page=login">
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="Логин" name="login" type="text" autofocus>
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Пароль" name="password" type="password" value="">
									</div>
									<!--<div class="checkbox">
										<label>
											<input name="remember" type="checkbox" value="Remember Me">Remember Me
										</label>
									</div>-->
									<input name="submit" type="submit" value="Войти" class="btn btn-lg btn-success btn-block">
									<a href="index.php?page=register" class="btn btn-lg btn-block">Регистрация</a>
								</fieldset>
							</form>
						</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>

    </body>
</html>