<?php
$counterid = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($counterid<=0)
{
	die("Плохой номер счетчика");
}
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	
	switch($action)
	{
		case "delete":
				$usercounter = dbSelect($dbconnect, "SELECT cv.id as id, cv.value as value FROM counter_values cv INNER JOIN counters c ON c.id=cv.counter_id INNER JOIN flats f ON f.id=c.flat_id WHERE f.user_id='".$userinfo['id']."' AND counter_id='".$counterid."'");
	
				if (count($usercounter)>0 && isset($_POST['vaue_id']))
				{
					$value_id = $dbconnect->real_escape_string($_POST['vaue_id']);
					dbExecuteQuery($dbconnect, "DELETE FROM counter_values WHERE id='".$value_id."'");
				}
			break;
			
		case "add":
			if (isset($_POST['value']))
			{
				$value=floatval($_POST['value']);
				dbExecuteQuery($dbconnect, "INSERT INTO counter_values (`value`,`counter_id`, `date`) VALUES('$value','$counterid',NOW());");
			}
			break;
	}
}

$counter_values = dbSelect($dbconnect, "SELECT cv.id as id, cv.value as value, cv.date as date FROM counter_values cv INNER JOIN counters c ON c.id=cv.counter_id INNER JOIN flats f ON f.id=c.flat_id WHERE f.user_id='".$userinfo['id']."' AND counter_id='".$counterid."' ORDER BY cv.date DESC;");

?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Показания счетчика</h1>
	</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <form role="form" method="POST" action="index.php?page=counter&id=<?php echo $counterid; ?>" class="form-inline">
                                            <div class="form-group">
                                                <label>Показание</label>
                                                <input class="form-control" name="value">
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Добавить">
                                            <input type="hidden" name="page" value="counter">
                                            <input type="hidden" name="action" value="add">
                                        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
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
	echo "<tr><td>".$counter_value['date']."</td><td>".$counter_value['value']."</td>
	<td>
		<form action=\"index.php?page=counter&id=".$counterid."\" method=\"POST\">
			<input type=\"hidden\" name=\"action\" value=\"delete\">
			<input type=\"hidden\" name=\"vaue_id\" value=\"".$counter_value['id']."\">
			<input class=\"btn btn-danger\" type=\"submit\" name=\"submit\" value=\"Удалить\">
		</form>
	</td></tr>";
}

?>
				</tbody>
			</table>
		</div>
    </div>
	
    <div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> График изменения расхода
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div id="counter-chart"></div>
			<script>
				Morris.Area({
        element: 'counter-chart',
        data: [
		<?php
		$chartdata = array();
		$counter_values_count = count($counter_values);
		if ($counter_values_count > 2)
		{
			for ($i=0;$i<$counter_values_count-1;$i++)
			{
				$counter_value = $counter_values[$i];
				$next_counter_value = $counter_values[$i+1];
				$chartdata[] = "\n{date:'".$counter_value['date']."',value:".($counter_value['value'] - $next_counter_value['value'])."}";
			}
			echo implode ( "," ,  $chartdata);
		}
		?>
		],
        xkey: 'date',
        ykeys: ['value'],
        labels: ['Расход'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
			</script>
		</div>
		<!-- /.panel-body -->
	</div>
	</div>
</div>

