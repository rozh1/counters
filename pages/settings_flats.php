<?php
if (isset($_GET['action']))
{
	$action = $_GET['action'];
	$flatid = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	switch($action)
	{
		case "delete":
				$userflat = dbSelect($dbconnect, "SELECT id, name, address FROM flats WHERE user_id='".$userinfo['id']."' AND id=$flatid;");
				if (count($userflat)>0)
				{
					dbInsert($dbconnect, "DELETE FROM flats WHERE id='".$flatid."'");
				}
			break;
			
		case "add":
			if (isset($_GET['name']) && isset($_GET['address']))
			{
				$name=$dbconnect->real_escape_string($_GET['name']);
				$address=$dbconnect->real_escape_string($_GET['address']);
				dbInsert($dbconnect, "INSERT INTO flats (`name`,`address`,`user_id`) VALUES('$name','$address','".$userinfo['id']."');");
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
	echo "<tr><td>".$flat['name']."</td><td>".$flat['address']."</td><td><a href=\"index.php?page=settings&settingpage=flats&action=delete&id=".$flat['id']."\">Удалить</a></td></tr>";
}

?>
				</tbody>
			</table>
		</div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <form role="form" method="GET" action="index.php" class="form-inline">
                                            <div class="form-group">
                                                <label>Название квартиры</label>
                                                <input class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label>Адрес</label>
                                                <input class="form-control" name="address">
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Добавить">
                                            <input type="hidden" name="page" value="settings">
                                            <input type="hidden" name="settingpage" value="flats">
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>