<?php
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	$flatid = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	switch($action)
	{
		case "delete":
				$userflat = dbSelect($dbconnect, "SELECT id, name, address FROM flats WHERE user_id='".$userinfo['id']."' AND id=$flatid;");
				if (count($userflat)>0)
				{
					dbExecuteQuery($dbconnect, "DELETE FROM flats WHERE id='".$flatid."'");
				}
			break;
			
		case "add":
			if (isset($_POST['name']) && isset($_POST['address']))
			{
				$name=$dbconnect->real_escape_string($_POST['name']);
				$address=$dbconnect->real_escape_string($_POST['address']);
				dbExecuteQuery($dbconnect, "INSERT INTO flats (`name`,`address`,`user_id`) VALUES('$name','$address','".$userinfo['id']."');");
			}
			break;
	}
}

$flats = dbSelect($dbconnect, "SELECT id, name, address FROM flats WHERE user_id='".$userinfo['id']."';");

?>

<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Название</th>
						<th>Адрес</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php

foreach ($flats as $flat)
{
	echo "<tr><td>".$flat['name']."</td><td>".$flat['address']."</td>
	<td>
		<form action=\"index.php?page=settings&settingpage=flats\" method=\"POST\">
			<input type=\"hidden\" name=\"action\" value=\"delete\">
			<input type=\"hidden\" name=\"id\" value=\"".$flat['id']."\">
			<input class=\"btn btn-danger\" type=\"submit\" name=\"submit\" value=\"Удалить\">
		</form>
	</td></tr>";
}

?>
				</tbody>
			</table>
		</div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form role="form" method="POST" action="index.php?page=settings&settingpage=flats" class="form-inline">
                                            <div class="form-group">
                                                <label>Название квартиры</label>
                                                <input class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label>Адрес</label>
                                                <input class="form-control" name="address">
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Добавить">
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>