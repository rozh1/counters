<?php
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	$counterid = isset($_POST['id']) ? intval($_POST['id']) : 0;
	
	switch($action)
	{
		case "delete":
				$usercounter = dbSelect($dbconnect, "SELECT c.id, c.name FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' AND c.id=$counterid;");
				if (count($usercounter)>0)
				{
					dbExecuteQuery($dbconnect, "DELETE FROM counters WHERE id='".$counterid."'");
				}
			break;
			
		case "add":
			if (isset($_POST['name']) && isset($_POST['number']) && isset($_POST['flatid']))
			{
				$name=$dbconnect->real_escape_string($_POST['name']);
				$number=$dbconnect->real_escape_string($_POST['number']);
				$flatid=$dbconnect->real_escape_string($_POST['flatid']);
				dbExecuteQuery($dbconnect, "INSERT INTO counters (`name`,`number`,`flat_id`) VALUES('$name','$number','$flatid');");
			}
			break;
	}
}

$counters = dbSelect($dbconnect, "SELECT c.id as id, f.name as flat_name, c.name as counter_name, number FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' ORDER BY flat_name, counter_name;");
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
	echo "<tr><td>".$counter['flat_name']."</td><td>".$counter['counter_name']."</td><td>".$counter['number']."</td>
	<td>
		<form action=\"index.php?page=settings&settingpage=counters\" method=\"POST\">
			<input type=\"hidden\" name=\"action\" value=\"delete\">
			<input type=\"hidden\" name=\"id\" value=\"".$counter['id']."\">
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
        <form role="form" method="POST" action="index.php?page=settings&settingpage=counters" class="form-inline">
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
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>