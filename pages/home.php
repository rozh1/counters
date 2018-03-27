<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Главная</h1>
	</div>
</div>

<?php 

$counters = dbSelect($dbconnect, "SELECT c.id as id, f.name as flat_name, c.name as counter_name, number FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' ORDER BY flat_name, counter_name;");

foreach($counters as $counter)
{
	?>
	<div class="row">
		<div class="col-lg-12">
			<h3><?php echo $counter['flat_name']; ?>, счетчик <?php echo $counter['counter_name']; ?></h3>
			<hr>
		</div>
	</div>
	<div class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Расход по счетчику <?php echo $counter['counter_name']; ?> в <?php echo $counter['flat_name']; ?>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <a href="index.php?page=counter&id=<?php echo $counter['id']; ?>" class="btn btn-default btn-xs">
                                            Перейти к счетчику
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="counter-chart-<?php echo $counter['id']; ?>"></div>
								<script>
				Morris.Area({
        element: 'counter-chart-<?php echo $counter['id']; ?>',
        data: [
		<?php
		$chartdata = array();
		$counter_values = dbSelect($dbconnect, "SELECT cv.id as id, cv.value as value, cv.date as date FROM counter_values cv INNER JOIN counters c ON c.id=cv.counter_id INNER JOIN flats f ON f.id=c.flat_id WHERE f.user_id='".$userinfo['id']."' AND counter_id='".$counter['id']."' ORDER BY cv.date DESC;");
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
                        <!-- /.panel -->
					</div>
					
                    <div class="col-lg-4">
					<div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-dashboard fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo count($counter_values) > 0 ? $counter_values[0]['value'] : "-"; ?></div>
                                        <div>Последнее показание</div>
                                    </div>
                                </div>
                            </div>
                            <a href="index.php?page=counter&id=<?php echo $counter['id']; ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">Перейти к счетчику</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
					<form role="form" method="POST" action="index.php?page=counter&id=<?php echo $counter['id']; ?>" class="form">
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
	<?php
}

?>