<?php
$counterid = isset($_GET['id']) ? intval($_GET['id']) : 0;

//if ($counterid>0)
//{
//}
if (isset($_GET['action']))
{
	$action = $_GET['action'];
	
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
			if (isset($_GET['name']) && isset($_GET['number']) && isset($_GET['flatid']))
			{
				$name=$dbconnect->real_escape_string($_GET['name']);
				$number=$dbconnect->real_escape_string($_GET['number']);
				$flatid=$dbconnect->real_escape_string($_GET['flatid']);
				dbExecuteQuery($dbconnect, "INSERT INTO counters (`name`,`number`,`flat_id`) VALUES('$name','$number','$flatid');");
			}
			break;
	}
}

$counter_values = dbSelect($dbconnect, "SELECT cv.id as id, cv.value as value FROM counter_values cv INNER JOIN counters c ON c.id=cv.counter_id INNER JOIN flats f ON f.id=c.flat_id WHERE f.user_id='".$userinfo['id']."' AND counter_id='".$counterid."' ORDER BY cv.date;");

?>

<div class="row">
    <div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Дата</th>
						<th>Показание</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php

foreach ($counter_values as $counter_value)
{
	echo "<tr><td>".$counter_value['date']."</td><td>".$counter_value['value']."</td><td><a href=\"index.php?page=counter&action=delete&id=".$counter_value['id']."\">Удалить</a></td></tr>";
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
                                                <label>Показание</label>
                                                <input class="form-control" name="value">
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Добавить">
                                            <input type="hidden" name="page" value="counter">
                                            <input type="hidden" name="id" value="<?php echo $counterid; ?>">
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>