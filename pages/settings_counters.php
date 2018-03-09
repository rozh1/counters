<?php
if (isset($_GET['action']))
{
	$action = $_GET['action'];
	$counterid = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	switch($action)
	{
		case "delete":
				$usercounter = dbSelect($dbconnect, "SELECT id, name, address FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' AND c.id=$counterid;");
				if (count($usercounter)>0)
				{
					dbInsert($dbconnect, "DELETE FROM counters WHERE id='".$counterid."'");
				}
			break;
			
		case "add":
			if (isset($_GET['name']) && isset($_GET['number']) && isset($_GET['flatid']))
			{
				$name=$dbconnect->real_escape_string($_GET['name']);
				$number=$dbconnect->real_escape_string($_GET['number']);
				$flatid=$dbconnect->real_escape_string($_GET['flatid']);
				dbInsert($dbconnect, "INSERT INTO counters (`name`,`number`,`flat_id`) VALUES('$name','$number','$flatid');");
			}
			break;
	}
}

$counters = dbSelect($dbconnect, "SELECT c.id as id, f.name as flat_name, c.name as counter_name, number FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' ORDER BY flat_name;");
$flats = dbSelect($dbconnect, "SELECT id, name, address FROM flats WHERE user_id='".$userinfo['id']."';");
?>

<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Квартира</th>
						<th>Счетчик</th>
						<th>Номер</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php

foreach ($counters as $counter)
{
	echo "<tr><td>".$counter['flat_name']."</td><td>".$counter['counter_name']."</td><td>".$counter['number']."</td><td><a href=\"index.php?page=settings&settingpage=counters&action=delete&id=".$counter['id']."\">Удалить</a></td></tr>";
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
                                                <label>Квартира</label>
												<select class="form-control" name="flatid">
												<?php
foreach ($flats as $flat)
{
	echo "<option value=\"".$flat['id']."\">".$flat['name']."</option>";

}
												?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Название</label>
                                                <input class="form-control" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label>Номер</label>
                                                <input class="form-control" name="number">
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Добавить">
                                            <input type="hidden" name="page" value="settings">
                                            <input type="hidden" name="settingpage" value="counters">
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>