<?php

$settingpage = "flats";
$includefile = "settings_flats.php";
if (isset($_GET['settingpage']))
{
	$settingpage = $_GET['settingpage'];
	switch($settingpage)
	{
		case "flats": $includefile = "settings_flats.php";
			break;
		case "counters": $includefile =  "settings_counters.php";
			break;
	}
}


?>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Настройки</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<a href="index.php?page=settings&settingpage=flats" class="btn btn-default <?php echo $settingpage=='flats'? "active" : "" ?>">Квартиры</a>
		<a href="index.php?page=settings&settingpage=counters" class="btn btn-default <?php echo $settingpage=='counters'? "active" : "" ?>">Счетчики</a>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php include $includefile; ?>
	</div>
</div>
